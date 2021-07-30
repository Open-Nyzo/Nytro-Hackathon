# Rules

Example "select" rules for Fairdrop.

## DB Structure

The addresses table is defined by

```
CREATE TABLE IF NOT EXISTS `addresses` 
  (`address` TEXT NOT NULL PRIMARY KEY,
   `balance_nyzo` INTEGER DEFAULT 0, `in_cycle` BOOLEAN DEFAULT 0, `in_queue` INTEGER DEFAULT 0,
   `drop_amount` INTEGER DEFAULT 0, `drop_rules` TEXT, `nickname` TEXT,
   `dropped_amount` INTEGER DEFAULT 0, `trx_id` TEXT
  )
```

Fields to be used for select are generally 
- balance_nyzo (balance in micro nyzo)
- in_cycle (0 for out of cycle, 1 for in-cycle)
- in_queue (0 not in queue, 1 in-queue immature, 2 in-queue mature) 
- drop_amount (> 0 means it matched a previous rule)

The other ones are exported but not used for selects.

## Examples

(showing the result of the "rule list" command)

### Send 1 to in-cycles

```
0 1 "in_cycle=1"
```


### Send 1 to in-cycles and 1 to not in-cycle with more than 500 Nyzo

```
0 1 "in_cycle=1"
1 1 "in_cycle=0 and balance_nyzo>500000000"
```
 
### Send 1 to mature in_queue (> 30 days)
 
```
0 1 "in_queue=2"
```

### Send 1 to immature in_queue and 5 to mature in-queue
 
```
0 1 "in_queue=1"
1 5 "in_queue=2"
```

## More

You can combine these rules by stacking rules or with proper OR and AND operators in a single rule.  
Then use "stats" command to see what that gives, and "export" for a detailed listing. 

Just ask us if your use requires a rule you don't know how to write. 
