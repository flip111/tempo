Tempo[![Build Status](https://secure.travis-ci.org/tempo-project/tempo.png?branch=master)](http://travis-ci.org/tempo-project/tempo)
=============

Tempo is **Project Management Software**, based on the [**Symfony2**](http://symfony.com) framework.

Installation
------------

``` bash
$ wget http://getcomposer.org/composer.phar
$ php composer.phar create-project tempo-project/tempo -s dev
$ cd tempo
$ composer install
```

Then configure your project and create database.

``` bash
$ cd tempo

# Only if the composer install didn't ask you:
$ cp app/config/parameters.yml.dist app/config/parameters.yml
$ vi app/config/parameters.yml # And put your values!

# To create the database:
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create

# If you want to load sample data, use the following command
$ php app/console doctrine:fixtures:load

$ php app/console tempo:js-configuration:dump

# Instant messaging
$ node bin/server.js


```

You probably need to setting up rights for apache, uses the following commands:

```bash
$ mkdir -p app/cache app/logs app/data web/uploads
$ setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs app/data web/uploads
$ setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs app/data web/uploads
```

[Behat](http://behat.org) scenarios
-----------------------------------

You need to copy Behat default configuration file and enter your specific ``base_url``
option there.

```bash
$ cp behat.yml.dist behat.yml
$ vi behat.yml
```

Then download [Selenium Server](http://seleniumhq.org/download/), and run it.

```bash
$ java -jar selenium-server-standalone-2.11.0.jar
```

You can run Behat using the following command.

``` bash
$ bin/behat
```

Troubleshooting
---------------

If something goes wrong, errors & exceptions are logged at the application level.

````
tail -f app/logs/prod.log
tail -f app/logs/dev.log
````