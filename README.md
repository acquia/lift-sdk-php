# Acquia Lift SDK for PHP

[![Build Status](https://travis-ci.org/acquia/lift-sdk-php.svg)](https://travis-ci.org/acquia/lift-sdk-php) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/acquia/lift-sdk-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/acquia/lift-sdk-php/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/acquia/lift-sdk-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/acquia/lift-sdk-php/?branch=master)

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
$publicKey    = 'XXXXX';
$secretKey = 'YYYYYY';

// The Lift Web Account Identifier
$accountId = 'NICKD8TEST';

// The Lift Web Site Identifier
$siteId = 'nickdev';

$client = new Lift($accountId, $siteId, $publicKey, $secretKey, ['base_url' => $url]);

// Check if the server is functional
$pong = $client->ping();

// Get all existing slots.
$slotManager = $client->getSlotManager();
$slots = $slotManager->query();

// Create a new slot object.
$slot = new \Acquia\LiftClient\Entity\Slot();
$slot->setDescription('test-description');
$slot->setId('test-id');
$slot->setLabel('test-label');
$slot->setStatus(TRUE);

// Add the visibility to the slot.
$visibility = new \Acquia\LiftClient\Entity\Visibility();
$visibility->setCondition('show');
$visibility->setPages(['localhost/blog/*']);
$slot->setVisibility($visibility);
$slot = $slotManager->add($slot);

// Get the slot again from the system.
$slot = $slotManager->get($slot->getId());

// This now includes the created and updated date
//print $slot->getCreated()->getTimestamp();

// Delete the slot from the system.
$slotManager->delete($slot->getId());
```

## Run tests

```bash
vendor/bin/phpunit
```
