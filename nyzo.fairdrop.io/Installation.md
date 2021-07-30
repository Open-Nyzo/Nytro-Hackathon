# Fairdrop Installation
 
Fairdrop.py is a command line client using the "click" python module.  
You need python3 and a shell.  

## Installation

- Clone the repo
- cd into the directory
- `python3 -m pip install -r requirements.txt`
- `chmod +x Fairdrop.py` so it can be run directly without python3 prefix

## File structure

- One single py file, Fairdrop.py
- One "data" directory, that contains... well, the data for current drop.  
  You can rename that directory to keep an archive of several drops or simulations.

In the data directory:

- `fairdrop.db` Will be auto-created by the tool. This is a sqlite3 database. It contains settings and balances once snapshoted.
- `blackist.json` Json, a list of addresses to avoid. Pre-filled at first run with cycle and exchange wallets.   
   You can add more addresses there, just take care of proper json format.
- `rules.json` Drop rules are not in the DB but in that json file, so you can easily try pre-made rules on a given snapshot and keep several versions at hand.  
  Just rename that file, Fairdrop will always read `rules.json` at start. A default rule is added if empty.

# Usage

See [Usage.md](Usage.md)
