# Acquia Lift SDK for PHP

[![Build Status](https://travis-ci.org/acquia/lift-sdk-php.svg)](https://travis-ci.org/acquia/lift-sdk-php)

A PHP Client library to consume the Acquia Lift API's.

## Version Information

* `master` branch: Uses guzzle version `~6.0`. Drupal 8 lift work, that is in progress at the moment, depends upon builds against this branch.

## Installation

Install the latest version with [Composer](https://getcomposer.org/):

```bash
$ composer require acquia/lift-sdk-php
```

## Usage

```php
<?php

use Acquia\LiftClient\Lift;

// The URL to the Lift instance, provided by Acquia. Note that us-east-1
// might be replaced by a region that is within your geographic proximity.
$url = 'https://us-east-1-decisionapi.lift.acquia.com';

// The API key and secret key from your Acquia Lift User that are used to authenticate requests to Acquia Lift.
$apiKey    = 'AAAAAAAAAAAAAAAAAAAA';
$secretKey = 'BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';

$client = new Lift($apiKey, $secretKey, '', ['base_url' => $url]);

```