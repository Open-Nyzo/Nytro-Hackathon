# Fairdrop Usage

## Process Overview:

1. Define various settings
2. Snapshot Nyzo balances
3. Define or adjust rules, simulate
4. Do the Airdrop
5. Export the data
6. Verify and auto-resend potentially missed transactions

## Commands overview

You can run Fairdrop with no command to get the auto help: `./Fairdrop.py`

```
Usage: Fairdrop.py [OPTIONS] COMMAND [ARGS]...

Options:
  -v, --verbose  Be verbose! (default false)
  --help         Show this message and exit.

Commands:
  export    Save partial db - only selected addresses -...
  reset     Clear the current DB
  rule
  send      Batch send to selected addresses from privkey
  set       Set a status variable
  snapshot  Store a snapshot of Nyzo chain in current...
  stats     Print stats about current drop after...
  status    Print status about current vars and state
  verify    Makes sure all sent tx have gone through.
  version   Print version
```

You can get help on a specific command, for instance "rule" by using --help: `./Fairdrop.py rule --help`

```
Usage: Fairdrop.py rule [OPTIONS] COMMAND [ARGS]...

Options:
  --help  Show this message and exit.

Commands:
  add     add the given rule
  amount  Edit the given rule amount
  del     Delete the given rule
  list    List current rule(s) with index
  select  Edit the given rule select criteria

```

See step by step below to learn about the commands and the order you should run them

## A drop, step by step

## 1 - Settings

`status` shows the current settings:   
F.i. `./Fairdrop.py status`

```
Fairdrop status
Sender: 
Token: 
Decimals: 0
State: Init
MaxBalance: 500000000000
Batch: 50
KnownAddresses: 0
status: 
Rules:
0: Amount 1 - Select '`balance_nyzo` > 100000000'
Current frozen edge: 12970046
```

You can define settings via `set` command. Settings names are case sensitive.    
Things you have to define for a drop are:

### 1.1 Token and Decimals

The token you want to send, and its decimal setting. You need to make sure you use the same decimal as when defining your token, or amounts will be wrong.    
All amount in Fairdrop are integers, in the smallest unit. So nyzo balances are in micronyzos: 1 means 0.000001 Nyzo.  
If your token has 2 decimals, then 1 means 0.01, aso.

Set your token and decimals with (for instance the TEST2 Token)  
`./Fairdrop.py set Token TEST2`  
`./Fairdrop.py set Decimals 2` 

You can redo a status thereafter to check. These settings are saved in the sqlite DB.

### 1.2 Other vars

You can also set:
- Batch (number of transactions to send in a single batch. Max 50)
- MaxBalance (in micro nyzos. Addresses with balance above that will be excluded)

## 2. Snapshot

Will capture the current balance list of all Nyzo addresses, as well as in-cycle and in-queue info.

`./Fairdrop.py snapshot`

Simulation and sending will occur on this stored list.  
Once snapshoted, the status will reflect something like "CaptureHeight: 12966798".  

## 3.1 Define the drop rules

Rule is a list, with 2 parts for each rule:  
- Amount (in smallest token unit): How much to drop for an address matching that rule
- Select: the select condition to match addresses

Get the current rules by `./Fairdrop.py rule list`  
```
Rules:
0: Amount 1 - Select '`balance_nyzo` > 100000000'
```

Since we defined token TEST2 with 2 decimals, this means sending 0.01 TEST2 to every wallet with at least 100000000 micro nyzo, that is 100 Nyzos.

You can edit that rule (number 0) amount:  
`./Fairdrop.py rule amount 0 2`  
```
Rules:
0: Amount 2 - Select '`balance_nyzo` > 100000000'  
```

or edit that rule (number 0) select condition:  
```./Fairdrop.py rule select 0 '`balance_nyzo` > 100000000 AND `balance_nyzo` < 200000000'```  
  
```
Rules:
0: Amount 2 - Select '`balance_nyzo` > 100000000 AND `balance_nyzo` < 200000000'  
```

That one matches wallets with > 100 and < 200 Nyzos.

You can add a rule with `rule add`  
`./Fairdrop.py rule add 10 'in_cycle=1'`

```
Rules:
0: Amount 1 - Select '`balance_nyzo` > 100000000'
1: Amount 10 - Select 'in_cycle=1'
```

This second rule will send 10 to every in-cycle verifier.  
**See [Rules.md](Rules.md) for example rules** 

You can remove a rule by its id:

`./Fairdrop.py rule del 1`

```
Rules:
0: Amount 1 - Select '`balance_nyzo` > 100000000'
```

## 3.2 Simulate and adjust the rules

`stats` command will tell how many addresses are selected with current rules

`./Fairdrop.py stats`

```
Rules:
0: Amount 1 - Select '`balance_nyzo` > 100000000'
Fairdrop stats
Computing with MaxBalance 500000000000 and Blacklist ('0000000000000000000000000000000000000000000000000000000000000002','12d454a69523f739eb5eb71c7deb87011804df336ae0e2c19e0b24a636683e31','ff0e597aa28012f4cfba7ef9f1c25bf64ebd9bc209dfaff8b60110f1854aa540','1419b9d57f3da984f66b595dbd15455c5ed9679a1dee156f6149a63357ee038d','15fa0cd9b161953858d097090621a4de24063449b66d4dac2af90543389a9f89').
Rule 0: 2106 Addresses, total amount 2106
-------------
2106 Total Drop Amount
2106 Total Drop transactions
-- Among them:
0 Total Dropped Amount
0 Total dropped transactions
```

From this, we can see the airdrop would send 21.06 TEST2 tokens (2106 with 2 decimals) and require 2106 transactions.  
Since one transaction is 1 µNyzo, this would mean 0.002106 Nyzo :D


## 4. Send the airdrop

Once you are happy with the simulation stats, you can send the tokens.

- Make sure your sending address has enough tokens
- Make sure your sending address has enough Nyzo to cover transactions fees

Use "send" with the proper key_ (private key of the address that has the token)

`./Fairdrop.py send key_000000000000000000000`

The script will ask for confirmation, enter "y" if you double-checked and want to proceed.

The drop will take place by batches. You can **not** stop it while it sends, or you risk sending twice.  
But you can stop it by ctrl-c when it says so. You can then re-run a "stats" command and see how many it processed already, via 
"Total Dropped Amount" and "Total dropped transactions".

You can then "send" again, it will not send to the same address twice unless you reset.

 
## 5. Export the data

Export command saves the DB as a CSV file

`./Fairdrop.py export`

`fairdrop.csv` will be saved in the "data" directory.

You can read the file via your usual spreadsheet.

Sample from a partial send:

```
address, balance_nyzo, in_cycle, in_queue, drop_rules, drop_amount, dropped_amount, trx_id
0050a667fa52f0e8272a4a35197aed2cefd898d75f14d50fef519c41248483ae,4313056902,1,0,0+,1,0,None
007d1e8c9668a1078ce0691b0b6901739d9e02ba9484d23781abf57cf72ca619,658981079,0,0,0+,1,0,None 
...
```

## 6. Check All sent transactions

Once you sent the drop, wait for 10 blocks to pass, then you can check all sent transactions for inclusion in the chain.

This is the "verify" command.

`./Fairdrop.py verify`

If some transactions can not be found, the script will ask if it should delete their id from the db, so they can be re-issued.  
If you delete them, then you can redo a "send" that will send the remainings, then verify again after 10 blocks.

**Hint:** We advise to export before verify, and rename the .csv file so you have a backup. Then verify and export again.  
You can then sample some transactions and make sure all is fine before re-sending.  
Checking your balance as a safety could help, before you send again what could be left over. 
