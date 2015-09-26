Glsr
====

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/de223fd6-2d6b-4433-a70a-08e09fa68510/big.png)](https://insight.sensiolabs.com/projects/de223fd6-2d6b-4433-a70a-08e09fa68510)
[![Build Status](https://travis-ci.org/GLSR/glsr.svg?branch=master)](https://travis-ci.org/GLSR/glsr)
[![Build Status](https://travis-ci.org/GLSR/glsr.svg?branch=sf2.7)](https://travis-ci.org/GLSR/glsr)

Open-source solution to manage a restaurant, GLSR is a Full Web application to manage all your management issues: the inventory of items to Factsheets products sold through orders items needed to manufacture of your products.

# Installation
--------------

## 1) Get the code

You have two ways to do so:

1) Via Git, cloning deposit;

2) Via downloading the source code in a ZIP archive, at this address: https://github.com/GLSR/glsr/archive/master.zip

## 2) Define your application settings

To not share all our passwords, file `app/config/parameters.yml` is ignored in this deposit. Instead, you have the file `parameters.yml.dist` that you must rename (remove the `.dist`) and modify.

## 3) Download vendors

With Composer, of course:

    php composer.phar install

## And enjoy!

- See more at: http://wiki.glsr.fr/
