G.L.S.R.
=======

![Tests](https://github.com/Dev-Int/tests/workflows/Glsr/badge.svg) 
[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/Dev-Int/tests/blob/master/LICENSE)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/de223fd6-2d6b-4433-a70a-08e09fa68510/mini.png)](https://insight.sensiolabs.com/projects/de223fd6-2d6b-4433-a70a-08e09fa68510)
[![Build Status](https://travis-ci.org/Dev-Int/glsr.svg?branch=master)](https://travis-ci.org/Dev-Int/glsr)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Dev-Int/glsr/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Dev-Int/glsr/?branch=master)

Open-source solution to manage a restaurant, GLSR is a Full Web application to manage all your management issues: the
 inventory of items to Factsheets products sold through orders items needed to manufacture of your products.
 
### Features

To restart in the right direction, I start by preparing my [use cases](https://github.com/Dev-Int/tests/labels/use%20case),
 and adding the resulting tests after this list:

- [x] rewrite Domain model to check and correct my previous choices

- [ ] install [Behat](https://docs.behat.org/en/latest/quick_start.html)

## Installation

clone the repo at first
```
git clone https://github.com/Dev-Int/glsr.git
```

Update your database configuration in `.env` file with your `db_user`, `db_password` and `db_name` entries. Be careful to
 also change your database version, if necessary.
```dotenv
###> doctrine/doctrine-bundle ###
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# For an SQLite database, use: "sqlite:///%kernel.project_dir%/var/data.db"
# For a PostgreSQL database, use: "postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=11&charset=utf8"
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
###< doctrine/doctrine-bundle ###
```

Then install dependencies
```
composer install
```

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
