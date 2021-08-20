# Fairdrop.Io - Nytro Hackathon submission

This is the code and doc for our submission to the Nyzo hackathon.

## About Fairdrop.io

We at Fairdrop believe in a long term mission: make airdrops fair.

Airdrops are a nice way to ensure initial distribution of tokens and raise awareness for newborn tokens, but they are also abused by organized and automated airdrop catchers. Our end goal is to leverage technological tools to make airdrops finally fair!

We emerged last year as one of the winners of the Idena Hackathon and plan to keep on adding more blockchains and features to our offer, until it becomes The platform of reference for fair airdrops.

## Nyzo

Nyzo describes itself as a next-gen blockchain, with fast and reliable transactions.  
Their recent "NYTRO" projects adds support for very fast and very cheap tokens transactions.

We believe Nyzo has all the needed features to become the next Hype, and surpass ETH or SOL as tokens platform.

## Our submission

We developed and released a tool to facilitate the distribution of Nyzo tokens to specific classes of Nyzo users.  
Such a tool proved to be instrumental in the last wave of Solana airdrops for instance.

Although not a totally new idea, this tool is a pre-requisite for Nyzo to be used for airdrops, and ease up the initial distribution for new projects.
 
### Current features

- Get a snapshot of Nyzo balance at a given time
- Simulate distribution by specifying criterions, like specific balances of Nyzo
- Support Nyzo specific properties: differentiate in-cycle, in-queue - Mature or immature
- Provide estimates of airdrop cost, average tokens dropped and wallets count
- Once happy with the simulation, drop the tokens to the selected recipients
- Provide a csv export of the drop with transaction ids

### Extra planned features 

- Get a snapshot of specific Nyzo tokens balance as well (like, distribute your tokens to FAIRDROP Holders)
- More criterions
- Likely include some random lottery when you want to drop a limited amount of tokens
- Maybe support drop of NFTs
- Need a specific feature? Open a github issue to explain your use case, we'll do our best.

### Operational plan

- (check) Read doc and check Nyzo features in depth
- (check) Test selected data sources
- (check) First tests
- (check) Beta release
- Official release

### Future options (not part of the hackathon)

- More fine grained criterions
- Integration as part of Fairdrop V2


## Installation and usage

- Installation: see [Installation.md](Installation.md)
- Usage: see [Usage.md](Usage.md)

**Drop as a service:** If you don't want to bother with the tech, we can help you or do the airdrop for you, just ask!

## Changelog

- v0.2: small tweaks to the db and verify procedure optimization

## Thanks

- To Nyzo core devs for the awesome and fast block chain
- To Iyomisc who helped a lot in PMs and by providing and extending his API so we could gather all needed data
- To EggPool for nyzocli and pynyzo python projects we took inspiration from
