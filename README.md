tempo-sandbox
=============

Tempo[![Build Status](https://secure.travis-ci.org/tempo-project/tempo.png?branch=master)](http://travis-ci.org/tempo-project/tempo)

Tempo - Symfony2 Project Management Software

======

Tempo is **Symfony2 Project Management Software for PHP**, based on the [**Symfony2**](http://symfony.com) framework.

Installation
------------

``` bash
$ git clone https://github.com/tempo-project/tempo-sandbox.git tempo
$ composer install
```

Then configure your project and create database.

``` bash
$ cd tempo
$ cp app/config/parameters.yml.dist app/config/parameters.yml
$ vi app/config/parameters.yml # And put your values!
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
$ php app/console doctrine:fixtures:load # If you want to load sample data.
```