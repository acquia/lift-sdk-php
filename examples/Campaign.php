<?php 
use Acquia\LiftClient\Lift;
use Acquia\LiftClient\Entity\Campaign;

$autoloadFile = __DIR__.'/vendor/autoload.php';
require_once $autoloadFile;

// The URL to the Lift instance, provided by Acquia. Note that us-east-1
// might be replaced by a region that is within your geographic proximity.
$url = 'https://us-east-1-decisionapi.lift.acquia.com';

// The API key and secret key from your Acquia Lift User that are used to authenticate requests to Acquia Lift.
$publicKey = 'XXXXX';
$secretKey = 'YYYYY';
// The Lift Web Account Identifier
$accountId = 'test-account-id';
// The Lift Web Site Identifier
$siteId = 'test-site-id';
$client = new Lift($accountId, $siteId, $publicKey, $secretKey, ['base_url' => $url]);
// Check if the server is functional
$pong = $client->ping();
echo "Pong Result: ".implode(" ", $pong)."<br>";

$queryParameters = [
    'sort' => "desc"
];

// Declare Campaign Manager
$manager = $client->getCampaignManager();

$campaignId = 'test-campaign-id-1';
$data = [
    'id' => $campaignId,
    'site_id' => $siteId,
    'label' => 'campaign_target_1',
    'description' => 'Target campaign for everyone',
    'type' => 'target',
    'created' => '2019-11-19T16:44:09Z',
    'updated' => '2019-11-19T16:44:09Z',
    'start_at' => '2019-11-20T00:00:00Z',
    'end_at' => '2019-12-20T00:00:00Z',
    'status' => 'unpublished'
];

// Push new campaign (Note: if updating an existing campaign, the etag must be the same)
$campaign = new Campaign($data);
$campaign = $manager->post($campaign);

if (isset($campaign)){
    echo $campaign->getId()."<br>";
    echo $campaign->getLabel()."<br>";
    echo $campaign->getStatus()."<br>";
    echo $campaign->getDescription()."<br>";
    echo $campaign->getType()."<br>";
    echo $campaign->getEtag()."<br>";
    echo $campaign->getCreated()."<br>";
    echo $campaign->getUpdated()."<br>";
    echo $campaign->getStartAt()."<br>";
    echo $campaign->getEndAt()."<br>";
    echo "Rule Ids: ".implode(",",$campaign->getRuleIds())."<br>";
    echo "Goal Ids: ".implode(",",$campaign->getGoalIds())."<br>";
    echo "<br>";
}else{
    echo "Campaign is null<br>";
}

// Getting list of all campaigns
$campaigns = $manager->getCampaigns($queryParameters);

// List all campaigns
foreach ($campaigns as $c) {
    echo $c->getId()."<br>";
    echo $c->getLabel()."<br>";
    echo $c->getStatus()."<br>";
    echo $c->getDescription()."<br>";
    echo $c->getType()."<br>";
    echo $c->getEtag()."<br>";
    echo $c->getCreated()."<br>";
    echo $c->getUpdated()."<br>";
    echo $c->getStartAt()."<br>";
    echo $c->getEndAt()."<br>";
    echo "Rule Ids: ".implode(",",$c->getRuleIds())."<br>";
    echo "Goal Ids: ".implode(",",$c->getGoalIds())."<br>";
    echo "<br>";
}

// Retrieve Campaign by id
$campaignRes = $manager->getById($campaignId);
if (isset($campaignRes)){
    echo $campaignRes->getId()."<br>";
    echo $campaignRes->getLabel()."<br>";
    echo $campaignRes->getStatus()."<br>";
    echo $campaignRes->getDescription()."<br>";
    echo $campaignRes->getType()."<br>";
    echo $campaignRes->getEtag()."<br>";
    echo $campaignRes->getCreated()."<br>";
    echo $campaignRes->getUpdated()."<br>";
    echo $campaignRes->getStartAt()."<br>";
    echo $campaignRes->getEndAt()."<br>";
    echo "Rule Ids: ".implode(",",$campaignRes->getRuleIds())."<br>";
    echo "Goal Ids: ".implode(",",$campaignRes->getGoalIds())."<br>";
    echo "<br>";
}else{
    echo "Campaign is null<br>";
}

// Delete campaign by Id
$delResult = $manager->deleteById($campaignId);
if ($delResult == true){
    echo "Delete campaign was successful.<br>";
}else{
    echo "Delete campaign was not successful.<br>";
}

?>