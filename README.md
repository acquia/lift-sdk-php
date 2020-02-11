# Acquia Lift SDK for PHP

[![Build Status](https://travis-ci.org/baophan1/lift-sdk-php.svg?branch=Lift4)](https://travis-ci.org/acquia/lift-sdk-php) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/baophan1/lift-sdk-php/badges/quality-score.png?b=Lift4)](https://scrutinizer-ci.com/g/baophan1/lift-sdk-php/?branch=Lift4) [![Code Coverage](https://scrutinizer-ci.com/g/baophan1/lift-sdk-php/badges/coverage.png?b=Lift4)](https://scrutinizer-ci.com/g/baophan1/lift-sdk-php/?branch=Lift4)

  

A PHP Client library to consume the Acquia Lift 4 API's.

  

## Version Information
*  `Lift4` branch: Uses guzzle version `~6.0` and compatible with PHP 5.6, 7.1 and 7.2.


## Installation

  

Install the latest version with [Composer](https://getcomposer.org/):

  

```bash

$ composer require acquia/lift-sdk-php:dev-Lift4

```
Please note that the code base is pulled from **Lift4** branch which is currently not the default. 
  

## Usage

  

Examples of usage can be viewed in the examples folder and it is broken down to each Manager type. You can view our API documentation [here](http://docs.lift.acquia.com/decision/v2/) for a list of endpoints and examples of payloads and responses 

  

## Run tests

To run tests, you will need to run the following command in the same directory as the Lift PHP SDK was installed. It will run the unit tests that was compiled in this repository

```bash

vendor/bin/phpunit

```
Please note that the library is installed via composer
  

## Major Changes in Lift 4 PHP SDK compare to Lift 3

 - Introduction of Campaigns
 - Added more functionality
	 - Deploy Sites (ie. deploying from test site to production site)
	 - Search Content capabilities
	 - Customer Site management
	 - Dynamic Rules is now supported 
 - Updated new Lift 4 Slot and Rule data structure
 - Updated Capture and Decide managers

## Migrating from Lift 3 to Lift 4

**Important** - Upgrading from Acquia Lift 3 to Acquia Lift 4 is a one-time process handled from the central application screen.

  

If you plan on re-using Lift 3 data in Lift 4, you will require a migration over to Lift 4. Unfortunately the SDK does not support migration from Lift 3, however you will need migrate in the [Acquia Lift](https://app.lift.acquia.com) page.

  

Once you successfully logged in, there's a '**Migrate**' button available and will prompt you which assets you will want to migrate over. You can selectively migrate a subset of data before you migrate everything over.

  

For more information and details, you can refer to our [migration documentation](https://docs.acquia.com/lift/migration/).