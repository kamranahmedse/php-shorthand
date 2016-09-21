# php-shorthand

[![Build Status](https://travis-ci.org/kamranahmedse/php-shorthand.svg?branch=master)](https://travis-ci.org/kamranahmedse/php-shorthand)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/kamranahmedse/php-shorthand.svg?maxAge=2592000)](https://scrutinizer-ci.com/g/kamranahmedse/php-shorthand/?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/kamranahmedse/php-shorthand.svg?maxAge=2592000)](https://packagist.org/packages/kamranahmedse/php-shorthand)

> Calculate unique shorthands for a given set of strings

Inspired by [ruby's abbrev](http://apidock.com/ruby/Abbrev) module, it let's you calculate the unique set of shorthands for the given set of words.

## Installation

Use the following command to install via composer

```
composer require kamranahmedse/php-shorthand
```
For further details you can find the package at <a href="https://packagist.org/packages/kamranahmedse/php-shorthand">Packagist</a>.


## Usage

Instantiate the `Shorthand` class while passing the words for which you want the shorthands

```php
// Introduce the class into your scope
use KamranAhmed\Shorthand\Shorthand;

$shorthand = new Shorthand([
    'crore',
    'create',
]);

$shorthands = $shorthand->generate();
```
It will return an associative array with the key set to the shorthand keyword and value set to the actual word that it refers to
```php
// Shorthands for the above example
[
    'cre'    => 'create',
    'crea'   => 'create',
    'creat'  => 'create',
    'create' => 'create',
    'cro'    => 'crore',
    'cror'   => 'crore',
    'crore'  => 'crore',
],
```

## Usage Scenarios

It can come quite handy when writing command line script that takes a number of options and the user may enter the options shorthand or maybe other cases where you want to be able to accept shorthands.

For example, in a script that accepts the options `['delete', 'create', 'update']`, in your script, it can let you infer from the option that user wanted even when they typed a shorthand as long as it is unambiguous


```shell
$ shorthand cr   # create
$ shorthand d    # delete
$ shorthand upd  # update
```

## Contribution

Feel free to fork, enhance, open issues, create pull requests or spread the word.

## License

MIT &copy; [Kamran Ahmed](http://kamranahmed.info)
