<?php

$autoloadFile = __DIR__.'/../vendor/autoload.php';
require_once $autoloadFile;

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

$manager = $client->getSiteManager();

// Get all existing sites associated with account id
$sites = $manager->getSites();

// Iterate and print all site ids
foreach ($sites as $s) {
    echo $s->getId()."<br>";
}

// Get specific site information based on site id
$site = $manager->getSite($siteId);
echo $site.getId()."<br>";
echo $site.getName()."<br>";
echo $site.GetUrl()."<br>";