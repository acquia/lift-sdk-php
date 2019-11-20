<?php

namespace Acquia\LiftClient\Test;

use GuzzleHttp\Psr7\Response;

class CampaignTest extends TestBase
{
    public function testHandlerStack() {
        $response = new Response(200, [], json_encode([]));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getCampaignManager();

        // Check if the client has already have expected handlers.
        // To check, to insert a dummy function after the expected handler, and
        // hope it finds the expected handler without throwing an Exception.
        $handler = $manager->getClient()->getConfig('handler');
        $testFunction = function () {};
        $handler->after('acquia_lift_account_and_site_ids', $testFunction);
        // Does not throw Exception because this handler is authenticated.
        $handler->after('acquia_lift_hmac_auth', $testFunction);
    }

    /**
     * Testing get list of campaigns associated with account id
     */
    public function testGetCampaigns()
    {
        $data = [
          [
            'id' => 'test-campaign-id-1',
            'site_id' => 'test-site-id-1',
            'label' => 'campaign_target',
            'description' => 'Target campaign for everyone',
            'type' => 'target',
            'created' => '2019-11-19T16:44:09Z',
            'updated' => '2019-11-19T16:44:09Z',
            'start_at' => null,
            'end_at' => null,
            'status' => 'unpublished',
            'etag' => 'test-etag-1',
            'rule_ids' => [
                'test-rule-id-1',
                'test-rule-id-2'
            ],
            'goal_ids' => ['test-goal-id-1']
          ],
          [
            'id' => 'test-campaign-id-2',
            'site_id' => 'test-site-id-1',
            'label' => 'campaign_target',
            'description' => 'Target campaign for everyone',
            'type' => 'target',
            'created' => '2019-11-19T16:44:09Z',
            'updated' => '2019-11-19T16:44:09Z',
            'start_at' => null,
            'end_at' => null,
            'status' => 'unpublished',
            'etag' => 'test-etag-2',
            'rule_ids' => [
                'test-rule-id-3'
            ],
            'goal_ids' => ['test-goal-id-2']
          ],
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Segment Manager
        $manager = $client->getCampaignManager();
        $responses = $manager->GetCampaigns();
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/v2/campaigns?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Test Responses
        $this->assertEquals($responses[0]->getId(), 'test-site-id-1');
        $this->assertEquals($responses[0]->getName(), 'Test Site Name 1');
        $this->assertEquals($responses[0]->getUrl(), 'https://url-1');

        $this->assertEquals($responses[1]->getId(), 'test-site-id-2');
        $this->assertEquals($responses[1]->getName(), 'Test Site Name 2');
        $this->assertEquals($responses[1]->getUrl(), 'https://url-2');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testGetSitesError()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Segment Manager
        $manager = $client->getSiteManager();
        $manager->GetSites();
    }


    /**
     * Testing Get Site by Id endpoints
     */
    public function testGetSite()
    {
        $siteId = 'test-site-id-1';
        $data = [
          'id' =>  'test-site-id-1',
          'name' => 'Test Site Name 1',
          'url' => 'https://url-1',
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Segment Manager
        $manager = $client->getSiteManager();
        $response = $manager->GetSite($siteId);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/v2/sites/'. $siteId .'?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Test Responses
        $this->assertEquals($response->getId(), $siteId);
        $this->assertEquals($response->getName(), 'Test Site Name 1');
        $this->assertEquals($response->getUrl(), 'https://url-1');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testGetSiteError()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Segment Manager
        $manager = $client->getSiteManager();
        $manager->GetSite('Test-site-id');
    }
}
