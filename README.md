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

$autoloadFile = __DIR__.'/vendor/autoload.php';
require_once $autoloadFile;

// The URL to the Lift instance, provided by Acquia. Note that us-east-1
// might be replaced by a region that is within your geographic proximity.
$url = 'https://us-east-1-decisionapi.lift.acquia.com';
// The API key and secret key from your Acquia Lift User that are used to authenticate requests to Acquia Lift.
$public_key    = 'XXXXXX';
$secret_key = 'YYYYY';

// The Lift Web Account Identifier
$account_id = 'NICKD8TEST';

// The Lift Web Site Identifier
$site_id = 'nickdev';

$client = new Lift($account_id, $site_id, $public_key, $secret_key, ['base_url' => $url]);

// Check if the server is functional
$pong = $client->ping();

// Get all existing slots.
$slots = $client->slots()->query();

// Create a new slot object.
$slot = new \Acquia\LiftClient\DataObject\Slot();
$slot->setDescription('test-description');
$slot->setId('test-id');
$slot->setLabel('test-label');
$slot->setStatus(TRUE);

// Add the visibility to the slot.
$visibility = new \Acquia\LiftClient\DataObject\Visibility();
$visibility->setCondition('show');
$visibility->setPages(['localhost/blog/*']);
$slot->setVisibility($visibility);
$slot = $client->slots()->add($slot);

// Get the slot again from the system.
$slot = $client->slots()->get($slot->getId());

// This now includes the created and updated date
//print $slot->getCreated()->getTimestamp();

// Delete the slot from the system.
$client->slots()->delete($slot->getId());
```

## Run tests

```bash
vendor/bin/phpunit
```