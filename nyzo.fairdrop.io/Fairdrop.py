#!/usr/bin/env python3
"""
Fairdrop

Tokens drop simulator and sender
"""

import json
import sqlite3
from contextlib import closing
from os import path
from time import sleep

import click
from nyzostrings.nyzostringencoder import NyzoStringEncoder
from pynyzo.clienthelpers import NyzoClient
from pynyzo.keyutil import KeyUtil
from requests import get

__version__ = '0.2'


VERBOSE = False


def init_db(ctx):
    with closing(ctx.obj["db"].cursor()) as cursor:
        cursor.execute("CREATE TABLE IF NOT EXISTS `values` (`key` TEXT NOT NULL PRIMARY KEY, `value` TEXT)")
        cursor.execute("CREATE TABLE IF NOT EXISTS `addresses` (`address` TEXT NOT NULL PRIMARY KEY, "
                       "`balance_nyzo` INTEGER DEFAULT 0, `in_cycle` BOOLEAN DEFAULT 0, `in_queue` INTEGER DEFAULT 0,"
                       "`drop_amount` INTEGER DEFAULT 0, `drop_rules` TEXT, `nickname` TEXT,"
                       "`dropped_amount` INTEGER DEFAULT 0, `trx_id` TEXT DEFAULT '', `height` INTEGER DEFAULT 0)")
        ctx.obj["db"].commit()


def reset_db(ctx):
    with closing(ctx.obj["db"].cursor()) as cursor:
        cursor.execute("DROP TABLE IF EXISTS `addresses`")  # So extra balance columns will be removed
        ctx.obj["db"].commit()
    init_db(ctx)


def snapshot_nyzo(ctx):
    # Get da balance list, greetings Iyomisc
    res = get("https://nyzo.today/static/balancelist.json")
    blist = res.json()
    # https://stackoverflow.com/questions/48619517/call-a-click-command-from-code
    ctx.invoke(set, key='CaptureHeight', value=blist['height'])
    balances = [(k, v) for k, v in blist['balances'].items()]
    with closing(ctx.obj["db"].cursor()) as cursor:
        cursor.execute("DELETE FROM `addresses`")
        cursor.executemany("INSERT INTO `addresses` (`address`, `balance_nyzo`) VALUES (?, ?)", balances)
        ctx.obj["db"].commit()
    # Add cycle info
    res = get("https://nyzo.today/static/cycle.json")
    cycle = res.json()
    with closing(ctx.obj["db"].cursor()) as cursor:
        for address in cycle:
            if address in blist['balances']:
                # known address, update
                cursor.execute("UPDATE `addresses` SET `in_cycle`=1 WHERE `address`=?", (address,))
            else:
                cursor.execute("INSERT INTO `addresses` (`address`, `in_cycle`) VALUES (?, 1)", (address,))
                blist['balances'][address] = 0
        ctx.obj["db"].commit()
    # Add queue info
    res = get("https://nyzo.today/api/queuestatus")
    queue = res.json()
    with closing(ctx.obj["db"].cursor()) as cursor:
        for line in queue:
            address, nickname, mature = line[0], line[2], line[3]
            if mature:
                in_queue = 2
            else:
                in_queue = 1
            if address in blist['balances']:
                cursor.execute("UPDATE `addresses` SET `in_queue`=?, `nickname`= ? WHERE `address`=?",
                               (in_queue, nickname, address))
            else:
                cursor.execute("INSERT INTO `addresses` (`address`, `in_queue`, `nickname`) VALUES (?, ?, ?)",
                               (address, in_queue, nickname))
                blist['balances'][address] = 0
        ctx.obj["db"].commit()

    # Update stats
    with closing(ctx.obj["db"].cursor()) as cursor:
        res = cursor.execute("SELECT COUNT(*) FROM `addresses`").fetchone()[0]
    print(f"{res} known addresses")
    ctx.invoke(set, key='KnownAddresses', value=res)
    ctx.invoke(status)


def update_status(ctx):
    with closing(ctx.obj["db"].cursor()) as cursor:
        rows = cursor.execute("SELECT * FROM `values` ORDER BY `key` ASC").fetchall()
        for row in rows:
            ctx.obj['status'][row[0]] = row[1]


def print_rules(ctx):
    i = 0
    print("Rules:")
    for item in ctx.obj['rules']:
        print(f"{i}: Amount {item[0]} - Select '{item[1]}'")
        i += 1


def save_rules(ctx):
    with open("data/rules.json", "w") as fp:
        json.dump(ctx.obj['rules'], fp)


def int_to_str(amount: int, decimals: int) -> str:
    result = str(amount).zfill(decimals + 1)
    if decimals:
        return result[:-decimals] + "." + result[-decimals:]
    return result


def send_batch(ctx, privkey, token, decimals, to_send, frozen):
    """Sends the batch and fills db once transactions passed.
    Not to be interrupted or would send twice"""
    # to_send is a list of (recipient, amount)
    # token is the token name to send
    # decimals is the token decimals. Could be auto-filled by api
    print(f"send_batch({privkey}, {token} decimals {decimals} len {len(to_send)})")
    last_height = frozen.get("height", 0)
    for recipient, amount in to_send:
        # Convert amount to proper string
        amount_str = int_to_str(int(amount), int(decimals))
        data = f"TT:{token}:{amount_str}"
        data = data[:32]
        # print(data)
        res = ctx.obj["client"].send(recipient, 0.000001, data, privkey, frozen)
        # res= {}
        # print(res)
        if str(res.get("forwarded", "false")).lower() == "false":
            print(f"! Not forwarded: {recipient}: {amount}")
            print(res)
        else:
            last_height = res.get('block height', last_height)
            trx_id = res['tx__']
            print(f"Forwarded: {recipient}: {amount}\n trx {trx_id}")
            try:
                with closing(ctx.obj["db"].cursor()) as cursor:
                    # Reset results
                    cursor.execute("UPDATE `addresses` SET `dropped_amount` = ?, `trx_id` = ? WHERE address = ?",
                                   (amount, trx_id, recipient))
                    ctx.obj["db"].commit()
            except Exception as e:
                print(f"Error saving db: {e}")
    print(f"Batch Done, check height {last_height}")
    return last_height


@click.group()
@click.option('--verbose', '-v', is_flag=True, default=False,
              help='Be verbose! (default false)')
@click.pass_context
def cli(ctx, verbose):
    global VERBOSE
    ctx.obj['verbose'] = verbose
    VERBOSE = verbose
    if VERBOSE:
        print("Verbose Mode")
    ctx.obj["client"] = NyzoClient()
    ctx.obj["db"] = sqlite3.connect("data/fairdrop.db")
    init_db(ctx)
    # Sender: Address to send with (owner of the token to drop)
    # Token: Token to drop
    # Decimals: Decimals for the token
    # MaxBalance: Addresses with more will not be selected. In smaller unit, micronyzo.
    # CaptureHeight: height of the balance list
    # KnownAddresses: known addresses, in base
    # Batch: batch size for sending. 50 recommended until further tests.
    ctx.obj['status'] = {"Sender": "", "Token": "", "Decimals": 0, "State": "Init", "MaxBalance": 500000 * 1000000,
                         "Batch": 50}
    update_status(ctx)
    ctx.obj['rules'] = [[1, "`balance_nyzo` > 100000000"]]  # Default rule if empty - 1 to everyone above 100n
    if path.isfile("data/rules.json"):
        with open("data/rules.json") as fp:
            ctx.obj['rules'] = json.load(fp)
    else:
        # Init rules file at first run
        save_rules(ctx)
    ctx.obj['blacklist'] = ['0000000000000000000000000000000000000000000000000000000000000002',
                            '12d454a69523f739eb5eb71c7deb87011804df336ae0e2c19e0b24a636683e31',
                            'ff0e597aa28012f4cfba7ef9f1c25bf64ebd9bc209dfaff8b60110f1854aa540',
                            '1419b9d57f3da984f66b595dbd15455c5ed9679a1dee156f6149a63357ee038d',
                            '15fa0cd9b161953858d097090621a4de24063449b66d4dac2af90543389a9f89']
    # Load or init blacklist file at first run
    if path.isfile("data/blacklist.json"):
        with open("data/blacklist.json") as fp:
            ctx.obj['blacklist'] = json.load(fp)
    else:
        with open("data/blacklist.json", "w") as fp:
            json.dump(ctx.obj['blacklist'], fp)


@cli.command()
@click.pass_context
def version(ctx):
    """Print version"""
    print(f"Fairdrop version {__version__}")


@cli.command()
@click.pass_context
def stats(ctx):
    """Print stats about current drop after (re)computing it"""
    print_rules(ctx)
    print(f"Fairdrop stats")
    # Some sanity checks may be required here
    max_balance = ctx.obj['status']["MaxBalance"]
    blacklist = "('" + "','".join(ctx.obj['blacklist']) + "')"
    print(f"Computing with MaxBalance {max_balance} and Blacklist {blacklist}.")
    with closing(ctx.obj["db"].cursor()) as cursor:
        # Reset results
        cursor.execute("UPDATE `addresses` SET `drop_amount`=0, `drop_rules`=''")
        # Compute rules
        for i, (amount, select) in enumerate(ctx.obj['rules']):
            # Get stats for display
            res = cursor.execute("SELECT COUNT(*) FROM  `addresses` WHERE `balance_nyzo`< ? AND `address` NOT IN "
                                 + blacklist + " AND "
                                 + select,
                                 (max_balance,)).fetchone()[0]
            print(f"Rule {i}: {res} Addresses, total amount {res * amount}")
            # Execute
            cursor.execute("UPDATE `addresses` SET `drop_amount` = `drop_amount` + ?, `drop_rules`=`drop_rules` || ?  || '+' "
                           "WHERE `balance_nyzo`<? AND `address` NOT IN "
                           + blacklist + " AND "
                           + select,
                           (amount, str(i), max_balance))

        ctx.obj["db"].commit()
    print(f"-------------")
    # STATS_TotalDropAmount: total drop amount - in lowest unit
    # STATS_TotalDropTrx: total drop transactions needed - 1 µn each
    with closing(ctx.obj["db"].cursor()) as cursor:
        # Total amount
        res = cursor.execute("SELECT SUM(`drop_amount`) FROM `addresses`").fetchone()[0]
        print(f"{res} Total Drop Amount")
        ctx.invoke(set, key='STATS_TotalDropAmount', value=res)
        # Total transactions
        res = cursor.execute("SELECT COUNT(*) FROM `addresses` WHERE `drop_amount`>0 ").fetchone()[0]
        print(f"{res} Total Drop transactions")
        ctx.invoke(set, key='STATS_TotalDropTrx', value=res)
    print(f"-- Among them:")
    with closing(ctx.obj["db"].cursor()) as cursor:
        # Total amount
        res = cursor.execute("SELECT SUM(`dropped_amount`) FROM `addresses`").fetchone()[0]
        print(f"{res} Total Dropped Amount")
        ctx.invoke(set, key='STATS_TotalDroppedAmount', value=res)
        # Total transactions
        res = cursor.execute("SELECT COUNT(*) FROM `addresses` WHERE `dropped_amount`>0 ").fetchone()[0]
        print(f"{res} Total dropped transactions")
        ctx.invoke(set, key='STATS_TotalDroppedTrx', value=res)


@cli.command()
@click.pass_context
def export(ctx):
    """Save partial db - only selected addresses - as data/fairdrop.csv"""
    with closing(ctx.obj["db"].cursor()) as cursor:
        selected = cursor.execute("SELECT address, balance_nyzo, in_cycle, in_queue, drop_rules, "
                                  "drop_amount, dropped_amount, trx_id, height "
                                  "FROM `addresses` WHERE `drop_amount` > 0").fetchall()
        with open("data/fairdrop.csv", "w") as fp:
            fp.write("address, balance_nyzo, in_cycle, in_queue, drop_rules, drop_amount, dropped_amount, trx_id, height\n")
            for line in selected:
                line = (str(i) for i in line)
                fp.write(",".join(line) + "\n")
    print("data/fairdrop.csv saved.")


@cli.command()
@click.argument('privkey',  default='', type=str)
@click.pass_context
def send(ctx, privkey: str=''):
    """Batch send to selected addresses from privkey"""
    # confirm token to send and amount in lowest unit is correct, total amount is enough
    # confirm there are enough Nyzos in the account to pay the fees
    #
    seed = NyzoStringEncoder.decode(privkey).get_bytes()
    # convert key to address - From pynyzo
    address = KeyUtil.private_to_public(seed.hex())
    print(f"Sending token '{ctx.obj['status']['Token']}'")
    print(f"Sending using address '{address}'")
    print(f"Batch size {ctx.obj['status']['Batch']}")
    res = input("Confirm? (y/N): ")
    if res.lower() != 'y':
        print("Aborted")
        return
    to_send = [('', 0)]  # Try once
    frozen = ctx.obj["client"].get_frozen()
    check_height = frozen["height"] + 10
    while len(to_send) > 0:
        # Try to send a batch
        print("Do not interrupt until further notice...")
        with closing(ctx.obj["db"].cursor()) as cursor:
            # Get a random batch of "Batch" len to send
            to_send = cursor.execute("SELECT address, drop_amount "
                                     "FROM `addresses` WHERE `drop_amount` > 0 AND `dropped_amount`=0 "
                                     "ORDER BY RANDOM() LIMIT ?", (ctx.obj['status']['Batch'],)).fetchall()
        if len(to_send) > 0:
            # Safe send it-. Do not interrupt while doing it
            check_height = max(check_height, send_batch(ctx, privkey, ctx.obj['status']['Token'], ctx.obj['status']['Decimals'], to_send, frozen))
        print("Batch sent. You have 5 sec to safely interrupt.")
        sleep(5)
    print("Drop done.")
    print("Use 'export' to save the csv report.")
    ctx.invoke(set, key='CheckHeight', value=check_height)


@cli.command()
@click.pass_context
def verify(ctx):
    """Makes sure all sent tx have gone through. Clears tx after user confirm when not."""
    # Make sure we are past the check height

    # check all processed drops
    errors = []
    with closing(ctx.obj["db"].cursor()) as cursor:
        # Get all sent drops that are not validated already
        to_verify = cursor.execute("SELECT address, trx_id FROM `addresses` "
                                   "WHERE trx_id != '' AND `height` = 0").fetchall()
    for address, trx_id in to_verify:
        res = ctx.obj["client"].query_tx(trx_id)
        height = int(res.get("height", 0))
        print(f"Address {address} height {height}")
        # print(res)
        if height < 1:
            errors.append(address)
            print(f"Unknown trx {trx_id} for address {address}")
        else:
            with closing(ctx.obj["db"].cursor()) as cursor:
                cursor.execute("UPDATE `addresses` SET `height` = ? WHERE trx_id = ?",
                               (height, trx_id))
                ctx.obj["db"].commit()
    if len(errors) > 0:
        res = input("Clear missing trx ids ? (y/N):")
        if res.lower() != 'y':
            print("Aborted")
            return
        else:
            with closing(ctx.obj["db"].cursor()) as cursor:
                for address in errors:
                    cursor.execute("UPDATE `addresses` SET trx_id='', dropped_amount=0 WHERE address= ? ", (address,))
                ctx.obj["db"].commit()
            print("Cleared")


@cli.command()
@click.pass_context
def status(ctx):
    """Print status about current vars and state"""
    print(f"Fairdrop status")
    update_status(ctx)
    for key, value in ctx.obj['status'].items():
        if "STATS_" not in key:
            print(f"{key}: {value}")
    print_rules(ctx)
    frozen = ctx.obj["client"].get_frozen()
    print(f"Current frozen edge: {frozen['height']}")


@cli.command()
@click.argument('key',  default='', type=str)
@click.argument('value',  default='', type=str)
@click.pass_context
def set(ctx, key: str='', value: str=''):
    """Set a status variable"""
    with closing(ctx.obj["db"].cursor()) as cursor:
        cursor.execute("REPLACE INTO `values` (`key`, `value`) VALUES (?, ?)", (key, value))
        ctx.obj["db"].commit()
    update_status(ctx)


@cli.command()
@click.pass_context
@click.argument('confirm',  default=False, type=bool)
def reset(ctx, confirm: bool=False):
    """Clear the current DB"""
    if confirm:
        print(f"Fairdrop reset")
    else:
        print(f"Fairdrop reset aborted, add True to command to force")
        init_db(ctx)


@cli.command()
@click.pass_context
@click.argument('tokens',  default='', type=str)
def snapshot(ctx, tokens: str=''):
    """Store a snapshot of Nyzo chain in current state.
    If tokens is not empty, but a token name or comma delimited list of tokens then
    balance of the given tokens is also captured."""
    print(f"Snapshoting with Tokens '{tokens}'...")
    # Nyzo snapshot
    snapshot_nyzo(ctx)
    if tokens != "":
        # Tokens snapshot
        print("WIP - The token capture feature is under work")


@cli.group()
@click.pass_context
def rule(ctx):
    pass


@rule.command("list")
@click.pass_context
def rule_list(ctx):
    """List current rule(s) with index"""
    print_rules(ctx)


@rule.command("del")
@click.argument('id',  default=0, type=int)
@click.pass_context
def rule_del(ctx, id: int=0):
    """Delete the given rule"""
    ctx.obj['rules'].pop(id)
    save_rules(ctx)
    print_rules(ctx)


@rule.command("add")
@click.argument('amount',  default=1, type=int)
@click.argument('select',  default='', type=str)
@click.pass_context
def rule_add(ctx, amount: int=1, select: str=''):
    """add the given rule"""
    ctx.obj['rules'].append([amount, select])
    save_rules(ctx)
    print_rules(ctx)


@rule.command("amount")
@click.argument('id',  default=0, type=int)
@click.argument('amount',  default=1, type=int)
@click.pass_context
def rule_amount(ctx, id: int=0, amount: int=1):
    """Edit the given rule amount"""
    ctx.obj['rules'][id][0] = amount
    save_rules(ctx)
    print_rules(ctx)


@rule.command("select")
@click.argument('id',  default=0, type=int)
@click.argument('select',  default="", type=str)
@click.pass_context
def rule_select(ctx, id: int=0, select: str=""):
    """Edit the given rule select criteria"""
    ctx.obj['rules'][id][1] = select
    save_rules(ctx)
    print_rules(ctx)


if __name__ == '__main__':
    cli(obj={})
