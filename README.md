<img src="./client/projects/common/assets/img/featured_work_GLSR.png" alt="GLSR logo" align="right" />

G.L.S.R.
=======

![Glsr_server](https://github.com/Dev-Int/glsr/workflows/Glsr_server/badge.svg) 
![Glsr_client](https://github.com/Dev-Int/glsr/workflows/Glsr_client/badge.svg) 
[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/Dev-Int/tests/blob/master/LICENSE)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Dev-Int/glsr/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Dev-Int/glsr/?branch=develop)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/de223fd6-2d6b-4433-a70a-08e09fa68510/mini.png)](https://insight.sensiolabs.com/projects/de223fd6-2d6b-4433-a70a-08e09fa68510)

Open-source solution to manage a restaurant, GLSR (in french: "_**G**estion **L**ibre des **S**tocks d'un **R**estaurant_")
 is a Full Web application to manage all your management issues: from the inventory of items, to datasheets products sold,
 through orders items needed to manufacture of your products.
 
### Features

- Settings the application
- Inventory management
- Create datasheets recipes  
- Order management

## Installation

clone the repo at first
```
git clone https://github.com/Dev-Int/glsr.git
```

The project use [docker](https://docs.docker.com/get-docker/) (install it, if you don't have it), and with the `Makefile`
 enter this command in your terminal:
```bash
$ make start
```

## Roadmap

To restart in the right direction, I start by preparing my use cases, and adding the resulting tests after this list:

- [x] rewrite [Domain model](docs/index.md) to check and correct my previous choices

- [x] install [Behat](https://docs.behat.org/en/latest/quick_start.html)

To follow the progress, visit the [use cases](https://github.com/Dev-Int/tests/labels/use%20case) page
- Settings the application (back ✅) (front `in progress...`)
- Register a user (back ✅) (front `in progress...`)
- Authentication (back ✅) (front `in progress...`)

## Licence

[MIT](https://choosealicense.com/licenses/mit/)

## History

In 2020, I found myself stuck on dependency updates, after several months of abandonment. There was a branch for recipes,
 a new branch for Symfony4, and nothing was progressing. At the same time, a friend of mine needed help with unit testing.
 
So I started on [Test](https://github.com/Dev-Int/tests) repository, with unit tests, then, along the way, I resumed the
 desire to develop my project. This one starts from scratch, only the entities will not change, to begin with. The domain
 is there. 😉

To train and create skills, I want to develop according to the DDD vision, and the different testing approaches
 (ATDD, TDD, BDD ...)
