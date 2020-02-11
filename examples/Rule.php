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

// Creating a rule assuming you have valid campaign id, slot id and content id
$manager = $client->getRuleManager();

// Get all existing rules.
$options = [
    'visible_on_page' => 'node/1/*',
    'prefetch' => true,
    'sort' => 'asc',
    'start' => 0,
    'rows' => 10,
    'sort_field' => 'updated',
    'status' => 'published',
];
$rules = $manager->query($options);

foreach ($rules as $rule) {
    echo $rule->getId();
}

////////////////////////////////////////////////////////
//// Targer Rule example
////////////////////////////////////////////////////////

// Create a rule to insert into the API.
$viewMode1 = new ViewMode();
$viewMode1->setId('banner-wide-1');

$contentPiece1 = new ContentView();
$contentPiece1
    ->setId('front-banner')
    ->setTitle('Front Banner')
    ->setBaseUrl('http://mysite.dev')
    ->setViewMode($viewMode1);

$viewMode2 = new ViewMode();
$viewMode2->setId('banner-wide-2');

$contentPiece2 = new ContentView();
$contentPiece2
    ->setId('front-banner-2')
    ->setTitle('Front Banner 2')
    ->setBaseUrl('http://mysite.dev')
    ->setViewMode($viewMode2);

$testConfigTarget1 = new TestConfigTarget();
$testConfigTarget1
    ->setSlotId($slot->getId())
    ->setContentList(array($contentPiece1));

$testConfigTarget2 = new TestConfigTarget();
$testConfigTarget2
    ->setSlotId($slot->getId())
    ->setContentList(array($contentPiece2));

$targetRule = new Rule();
$targetRule
    ->setId('rule-1')
    ->setLabel('Banner for Belgians')
    ->setDescription('Front page banner personalization for Belgians')
    ->setStatus('published')
    ->setPriority(10) // Higher number means the rule display / apply first.
    ->setType('target')
    ->setCampaignId('test-campaign-1')
    ->setTestConfig(array($testConfigTarget1));

// Add the rule to the system
$rule1 = $manager->add($targetRule);

// Get the slot again from the system.
$rule1 = $manager->get($rule1->getId());
$manager->deleteById($rule1->getId());

////////////////////////////////////////////////////////
//// AB Rule example
////////////////////////////////////////////////////////

$testConfigAb1 = new TestConfigAB();
$testConfigAb1
    ->setVariationId('test-variation-A')
    ->setVariationLabel('Using variation A banner')
    ->setProbability(0.35)
    ->setSlots(array($testConfigTarget1));

$testConfigAb2 = new TestConfigAB();
$testConfigAb2
    ->setVariationId('test-variation-A')
    ->setVariationLabel('Using variation A banner')
    ->setProbability(0.35)
    ->setSlots(array($testConfigTarget1));

// AB Rule
$abRule = new Rule();
$abRule
    ->setId('rule-2')
    ->setLabel('Banner for Belgians')
    ->setDescription('Front page banner personalization for Belgians')
    ->setStatus('published')
    ->setSegment('chrome_users')
    ->setPriority(10) // Higher number means the rule display / apply first.
    ->setType('ab')
    ->setCampaignId('test-campaign-2')
    ->setTestConfig(array($testConfigAb1, $testConfigAb2));

// Add the rule to the system
$rule2 = $manager->add($abRule);

// Get the slot again from the system.
$rule2 = $manager->get($rule2->getId());
$manager->deleteById($rule2->getId());

////////////////////////////////////////////////////////
//// Dynamic Rule example
////////////////////////////////////////////////////////

$testConfigDynamic = new TestConfigDynamic();
$testConfigDynamic
->setSlotId('test-slot-id-3')
->setFilterId('test-filter-id')
->setAlgorithm('most_viewed')
->setViewModeId('banner-wide-3')
->setCount(1)
->setExcludeViewedContent(true)
->setContentList(array($contentPiece3));

$dynamicRule = new Rule();
$dynamicRule
  ->setId('test-dynamic-rule-3')
  ->setLabel('Banner for Firefox users')
  ->setSegment('firefox_users')
  ->setDescription('Front page banner personalization for Firefox users')
  ->setStatus('published')
  ->setPriority(10)
  ->setType('dynamic')
  ->setCampaignId('test-campaign-3')
  ->setTestConfig(array($testConfigDynamic));

// Add the rule to the system
$rule3 = $manager->add($dynamicRule);

// Get the slot again from the system.
$rule3 = $manager->get($rule3->getId());
$manager->deleteById($rule3->getId());

?>
