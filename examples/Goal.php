<?php

$autoloadFile = __DIR__.'/../vendor/autoload.php';
require_once $autoloadFile;

use Acquia\LiftClient\Entity\Goal;
use Acquia\LiftClient\Lift;

// The URL to the Lift instance, provided by Acquia. Note that us-east-1
// might be replaced by a region that is within your geographic proximity.
$url = 'https://us-east-1-decisionapi.lift.acquia.com';
// The API key and secret key from your Acquia Lift User that are used to authenticate requests to Acquia Lift.
$publicKey = 'XXXXX';
$secretKey = 'YYYYYY';

// The Lift Web Account Identifier
$accountId = 'NICKD8TEST';

// The Lift Web Site Identifier
$siteId = 'nickdev';

$client = new Lift($accountId, $siteId, $publicKey, $secretKey, ['base_url' => $url]);

// Check if the server is functional
$pong = $client->ping();

// Get all existing goals.
$manager = $client->getGoalManager();
// Note 'global' and 'limit_by_site' parameters determines what goals are coming
// back. Please see the manager class query() function's comments.
$options = ['global' => 'true', 'limit_by_site' => 'true'];
$segments = $manager->query($options);

// Create a new goal object.
$goal = new Goal();
$goal
    ->setDescription('test-description')
    ->setId('test-id')
    ->setEventNames(['Click-Through'])
    ->setGlobal(true)
    ->setRuleIds(['my-example-rule-id'])
    ->setSiteIds(['my-site-id'])
    ->setValue(10);

$goalResponse = $manager->add($goal);

// Get errors from the goalresponse
$errors = $goalResponse->getErrors();

// Get the goal again from the system.
$goal = $manager->get($goal->getId());

// Delete the goal from the system.
$slotManager->delete($goal->getId());
