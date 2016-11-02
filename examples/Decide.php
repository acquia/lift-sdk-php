<?php

use Acquia\LiftClient\Entity\Decide;
use Acquia\LiftClient\Lift;

$autoloadFile = __DIR__.'/../vendor/autoload.php';
require_once $autoloadFile;

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

// Make a decision for a slot
$decide = new Decide();
$decide
    ->setDoNotTrack(false)
    ->setIdentity('my-unique-identity')
    ->setTouchIdentifier('php-example-unique-id')
    ->setIdentitySource('php-sdk')
    ->setSlots(['slot-1']);

$manager = $client->getDecideManager();
$response = $manager->decide($decide);

// This now includes the decisions
foreach ($response->getDecisions() as $decision) {
    // Show the policy that was used for this decision
    echo $decision->getPolicy();
    // Show the content that was decided
    echo $decision->getContent()->getId();
    // Get the raw HTML for this viewMode
    echo $decision->getContent()->getViewMode()->getHtml();
}
