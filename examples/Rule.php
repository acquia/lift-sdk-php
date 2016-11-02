<?php

$autoloadFile = __DIR__.'/../vendor/autoload.php';
require_once $autoloadFile;

use Acquia\LiftClient\Entity\Content;
use Acquia\LiftClient\Entity\Probability;
use Acquia\LiftClient\Entity\Rule;
use Acquia\LiftClient\Entity\TestConfigAb;
use Acquia\LiftClient\Entity\ViewMode;
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

// Initialize the manager.
$manager = $client->getRuleManager();

// Get all existing rules.
$options = [
    'visible_on_page' => 'node/1/*',
    'prefetch' => true,
    'sort' => 'asc',
    'start' => 0,
    'rows' => 0,
    'sort_field' => 'updated',
    'status' => 'published',
];
$rules = $manager->query($options);

foreach ($rules as $rule) {
    echo $rule->getId();
}

// Create a rule to insert into the API.
$viewMode1 = new ViewMode();
$viewMode1->setId('banner-wide-1');

$contentPiece1 = new Content();
$contentPiece1
    ->setId('front-banner')
    ->setBaseUrl('http://mysite.dev')
    ->setViewMode($viewMode1);

$viewMode2 = new ViewMode();
$viewMode2->setId('banner-wide-2');

$contentPiece2 = new Content();
$contentPiece2
    ->setId('front-banner')
    ->setBaseUrl('http://mysite.dev')
    ->setViewMode($viewMode2);

$probabilityContentPiece1 = new Probability();
$probabilityContentPiece1
    ->setContentId('front-banner')
    ->setContentViewId('banner-wide-1')
    ->setFraction(0.3);

$probabilityContentPiece2 = new Probability();
$probabilityContentPiece2
    ->setContentId('front-banner')
    ->setContentViewId('banner-wide-2')
    ->setFraction(0.7);

$testConfig = new TestConfigAb();
$testConfig->setProbabilities([$probabilityContentPiece1, $probabilityContentPiece2]);

$rule = new Rule();
$rule
    ->setId('rule-1')
    ->setLabel('Banner for Belgians')
    ->setDescription('Front page banner personalization for Belgians')
    ->setSlotId('slot-1')
    ->setStatus('published')
    ->setSegmentId('belgians')
    ->setWeight(10)
    ->setContentList([$contentPiece1, $contentPiece2])
    ->setTestConfig($testConfig);

// Add the rule to the system
$rule = $manager->add($rule);

// Get the slot again from the system.
$rule = $manager->get($rule->getId());

// This now includes the created and updated date
$rule->getCreated()->getTimestamp();

// Delete the slot from the system.
$manager->delete($rule->getId());
