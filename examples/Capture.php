<?php

use Acquia\LiftClient\Entity\Capture;
use Acquia\LiftClient\Entity\CapturePayload;
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
$capturePayload = new CapturePayload();
$capturePayload
    ->setDoNotTrack(false)
    ->setIdentity('my-unique-identity')
    ->setTouchIdentifier('php-example-unique-id')
    ->setIdentitySource('php-sdk')
    ->setReturnSegments(true);

$capture = new Capture();
$capture
    ->setAuthor('nick')
    ->setPersona('internal-api-user')
    ->setPersonUdf(5, 'custom-field-for-person-data')
    ->setTouchUdf(5, 'custom-field-for-touch-data')
    ->setEventUdf(5, 'custom-field-for-touch-data');

$capturePayload->setCaptures([$capture]);

$manager = $client->getCaptureManager();
$response = $manager->add($capturePayload);

// Get the matched segments
$segments = $response->getMatchedSegments();
foreach ($segments as $segment) {
    echo $segment->getId();
}
