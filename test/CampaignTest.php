<?php

namespace Acquia\LiftClient\Test;

use GuzzleHttp\Psr7\Response;
use Acquia\LiftClient\Entity\Campaign;
use Acquia\LiftClient\Entity\CampaignPatchPayload;


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
          'total_count' => 2,
          'campaigns' => [
            [
              'id' => 'test-campaign-id-1',
              'site_id' => 'TESTSITEID',
              'label' => 'campaign_target_1',
              'description' => 'Target campaign for everyone',
              'type' => 'target',
              'created' => '2019-11-19T16:44:09Z',
              'updated' => '2019-11-19T16:44:09Z',
              'start_at' => '2019-11-20T00:00:00Z',
              'end_at' => '2019-12-20T00:00:00Z',
              'status' => 'unpublished',
              'etag' => 'test-etag-1',
              'rule_ids' => [
                  'test-rule-id-1',
                  'test-rule-id-2'
              ],
              'goal_ids' => [
                  'test-goal-id-1'
              ],
            ],
            [
              'id' => 'test-campaign-id-2',
              'site_id' => 'TESTSITEID',
              'label' => 'campaign_target_2',
              'description' => 'Target campaign for new users',
              'type' => 'target',
              'created' => '2019-11-19T16:44:09Z',
              'updated' => '2019-11-19T16:44:09Z',
              'start_at' => '2019-11-20T00:00:00Z',
              'end_at' => '2019-12-20T00:00:00Z',
              'status' => 'unpublished',
              'etag' => 'test-etag-2',
              'rule_ids' => [
                  'test-rule-id-3'
              ],
              'goal_ids' => ['test-goal-id-2'],
            ],
          ],
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Campaign Manager
        $manager = $client->getCampaignManager();
        $responses = $manager->GetCampaigns();
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/v2/campaigns?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Test Responses
        $this->assertEquals($responses[0]->getId(), 'test-campaign-id-1');
        $this->assertEquals($responses[0]->getLabel(), 'campaign_target_1');
        $this->assertEquals($responses[0]->getDescription(), 'Target campaign for everyone');
        $this->assertEquals($responses[0]->getType(), 'target');


        $this->assertEquals($responses[1]->getId(), 'test-campaign-id-2');
        $this->assertEquals($responses[1]->getLabel(), 'campaign_target_2');
        $this->assertEquals($responses[1]->getDescription(), 'Target campaign for new users');
        $this->assertEquals($responses[1]->getType(), 'target');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testGetCampaignsError()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Campaign Manager
        $manager = $client->getCampaignManager();
        $manager->getCampaigns();
    }


    /**
     * Testing get campaign by id
     */
    public function testGetCampaignById()
    {
        $data = [
              'id' => 'test-campaign-id-1',
              'site_id' => 'TESTSITEID',
              'label' => 'campaign_target_1',
              'description' => 'Target campaign for everyone',
              'type' => 'target',
              'created' => '2019-11-19T16:44:09Z',
              'updated' => '2019-11-19T16:44:09Z',
              'start_at' => '2019-11-20T00:00:00Z',
              'end_at' => '2019-12-20T00:00:00Z',
              'status' => 'unpublished',
              'etag' => 'test-etag-1',
              'rule_ids' => [
                  'test-rule-id-1',
                  'test-rule-id-2'
              ],
              'goal_ids' => [
                  'test-goal-id-1'
              ],
            ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Campaign Manager
        $manager = $client->getCampaignManager();
        $campaignId = "test-campaign-id-1";
        $campaign = $manager->getById($campaignId);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/v2/campaigns/test-campaign-id-1?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Test Responses
        $this->assertEquals($campaign->getId(), 'test-campaign-id-1');
        $this->assertEquals($campaign->getLabel(), 'campaign_target_1');
        $this->assertEquals($campaign->getDescription(), 'Target campaign for everyone');
        $this->assertEquals($campaign->getType(), 'target');
    }

    /**
     * Testing Error handling for getCampaignById
     */
    public function testGetCampaignByIdError()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Campaign Manager
        $manager = $client->getCampaignManager();
        $campaignId = "invalid-id";
        $campaign = $manager->getById($campaignId);
        $this->assertTrue(!isset($campaign));
    }

    /**
     * Testing Campaign Delete
     */
    public function testCampaignDelete()
    {
        $response = new Response(200, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Campaign Manager
        $manager = $client->getCampaignManager();
        $response = $manager->delete();
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'DELETE');
        $this->assertEquals((string) $request->getUri(), '/v2/campaigns?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testCampaignDeleteError()
    {
      $response = new Response(400, []);
      $responses = [
        $response,
      ];

      $client = $this->getClient($responses);

      // Get Campaign Manager
      $manager = $client->getCampaignManager();
      $campaign = $manager->delete();
    }

    /**
     * Testing Campaign Delete by Campaign Id
     */
    public function testCampaignDeleteById()
    {
        $response = new Response(200, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Campaign Manager
        $manager = $client->getCampaignManager();
        $campaignId = "test-campaign-id-1";
        $result = $manager->deleteById($campaignId);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'DELETE');
        $this->assertTrue($result);
        $this->assertEquals((string) $request->getUri(), '/v2/campaigns/test-campaign-id-1?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');
    }

    /**
     * Testing Campaign Post by Campaign Id
     */
    public function testCampaignPostPatch()
    {
        $data = [
          'id' => 'test-campaign-id-1',
          'site_id' => 'TESTSITEID',
          'label' => 'campaign_target_1',
          'description' => 'Target campaign for everyone',
          'type' => 'target',
          'created' => '2019-11-19T16:44:09Z',
          'updated' => '2019-11-19T16:44:09Z',
          'start_at' => '2019-11-20T00:00:00Z',
          'end_at' => '2019-12-20T00:00:00Z',
          'status' => 'unpublished',
          'etag' => 'test-etag-1',
          'rule_ids' => [
              'test-rule-id-1',
              'test-rule-id-2'
          ],
          'goal_ids' => [
              'test-goal-id-1'
          ],
        ];

        $campaign = new Campaign($data);

        $response = new Response(200, [], json_encode($campaign));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Campaign Manager
        $manager = $client->getCampaignManager();
        $resCampaign = $manager->post($campaign);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/v2/campaigns?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        $this->assertEquals($resCampaign->getId(), 'test-campaign-id-1');
        $this->assertEquals($resCampaign->getSiteId(), 'TESTSITEID');
        $this->assertEquals($resCampaign->getLabel(), 'campaign_target_1');
        $this->assertEquals($resCampaign->getDescription(), 'Target campaign for everyone');
        $this->assertEquals($resCampaign->getType(), 'target');
        $this->assertEquals($resCampaign->getCreated(), '2019-11-19T16:44:09Z');
        $this->assertEquals($resCampaign->getUpdated(), '2019-11-19T16:44:09Z');
        $this->assertEquals($resCampaign->getStartAt(), '2019-11-20T00:00:00Z');
        $this->assertEquals($resCampaign->getEndAt(), '2019-12-20T00:00:00Z');
        $this->assertEquals($resCampaign->getStatus(), 'unpublished');
        $this->assertEquals($resCampaign->getEtag(), 'test-etag-1');
        $this->assertEquals($resCampaign->getRuleIds(), ['test-rule-id-1','test-rule-id-2']);
        $this->assertEquals($resCampaign->getGoalIds(), ['test-goal-id-1']);

        // Testing patching

        $patchData = [
          'label' => 'campaign_target_patch_1',
        ];
        $patchResp = [
          'id' => 'test-campaign-id-1',
          'site_id' => 'TESTSITEID',
          'label' => 'campaign_target_patch_1',
          'description' => 'Target campaign for everyone',
          'type' => 'target',
          'created' => '2019-11-19T16:44:09Z',
          'updated' => '2019-11-19T16:44:09Z',
          'start_at' => '2019-11-20T00:00:00Z',
          'end_at' => '2019-12-20T00:00:00Z',
          'status' => 'unpublished',
          'etag' => 'test-etag-1',
          'rule_ids' => [
              'test-rule-id-1',
              'test-rule-id-2',
          ],
          'goal_ids' => [
              'test-goal-id-1',
          ],
        ];

        $patchPayload = new CampaignPatchPayload($patchData);

        $response_patch = new Response(200, [], json_encode($patchResp));
        $responses = [
          $response_patch,
        ];

        $client_patch = $this->getClient($responses);
        $manager = $client_patch->getCampaignManager();
        $resCampaign = $manager->patch($campaign->getId(),$patchPayload);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'PATCH');
        $this->assertEquals((string) $request->getUri(), '/v2/campaigns/test-campaign-id-1?account_id=TESTACCOUNTID&site_id=TESTSITEID');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testCampaignPostError()
    {
      $response = new Response(400, []);
      $responses = [
        $response,
      ];

      $client = $this->getClient($responses);

      $data = [
        'id' => 'test-campaign-id-1',
        'site_id' => 'test-site-id-1',
        'label' => 'campaign_target_1',
        'description' => 'Target campaign for everyone',
        'type' => 'target',
        'created' => '2019-11-19T16:44:09Z',
        'updated' => '2019-11-19T16:44:09Z',
        'start_at' => '2019-11-20T00:00:00Z',
        'end_at' => '2019-12-20T00:00:00Z',
        'status' => 'unpublished',
        'etag' => 'test-etag-1',
        'rule_ids' => [
            'test-rule-id-1',
            'test-rule-id-2'
        ],
        'goal_ids' => [
            'test-goal-id-1'
        ],
      ];

      $campaign = new Campaign($data);

      // Get Campaign Manager
      $manager = $client->getCampaignManager();
      $rescampaign = $manager->post($campaign);
    }
}
