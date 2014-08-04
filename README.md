Glsr
====

[![Build Status](https://travis-ci.org/GLSR/glsr.svg?branch=developp)](https://travis-ci.org/GLSR/glsr)

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

- See more at: http://glsr.developpement-interessant.com/wiki/