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

// Get all existing slots.
$manager = $client->getSlotManager();

// Create a new slot object.
$slot = new Slot();
$slot
    ->setDescription('test-description')
    ->setId('test-id')
    ->setLabel('test-label')
    ->setStatus(true);

// Add the visibility to the slot.
$visibility = new Visibility();
$visibility->setCondition('show');
$visibility->setPages(['localhost/blog/*']);
$slot->setVisibility($visibility);

// Add the slot to the system
$slot = $manager->add($slot);
echo $slot->getId()."<br>";
echo $slot->getLabel()."<br>";
echo $slot->getDescription()."<br>";
echo $slot->getStatus()."<br>";
echo $slot->getVisibility()->getCondition()."<br>";
print_r($slot->getVisibility()->getPages());
echo "<br>";

// Get the slot again from the system.
$slot = $manager->get($slot->getId());
echo $slot->getId()."<br>";
echo $slot->getLabel()."<br>";
echo $slot->getDescription()."<br>";
echo $slot->getStatus()."<br>";
echo $slot->getVisibility()->getCondition()."<br>";
print_r($slot->getVisibility()->getPages());
echo "<br>";

// This now includes the created and updated date
$slot->getCreated()->getTimestamp();

// Delete the slot from the system.
$delResult = $manager->delete($slot->getId());
if ($delResult == true){
    echo "Delete slot was successful.<br>";
}else{
    echo "Delete slot was not successful.<br>";
}

?>
