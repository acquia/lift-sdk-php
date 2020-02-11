<?php

namespace Acquia\LiftClient\Test;

use GuzzleHttp\Psr7\Response;

class SiteTest extends TestBase
{
    public function testHandlerStack() {
        $response = new Response(200, [], json_encode([]));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getSiteManager();

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
     * Testing get list of sites associated on account id
     */
    public function testGetSites()
    {
        $data = [
          [
            'id' => 'test-site-id-1',
            'name' => 'Test Site Name 1',
            'url' => 'https://url-1',
          ],
          [
            'id' => 'test-site-id-2',
            'name' => 'Test Site Name 2',
            'url' => 'https://url-2',
          ],
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Sites Manager
        $manager = $client->getSiteManager();
        $responses = $manager->GetSites();
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/v2/sites?account_id=TESTACCOUNTID&site_id=TESTSITEID');

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

        // Get Site Manager
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

    /**
     * Testing Creating and Updating Customer Sites
     */
    public function testCustomerSitePost()
    {
      $siteId = 'test-site-id-1';
      $data = [
        [
          'status' => 'SUCCESS',
          'item' => [
            'id' =>  'test-site-id-1',
            'name' => 'Test Site Name 1',
            'url' => 'https://url-1',
          ]
        ],
        [
          'status' => 'FAILURE',
          'errors' => [
              [
                'code' => 'INVALID_NAME',
                'message' => 'Customer site name cannot be empty'
              ]
          ],
          'item' => [
            'id' =>  'test-site-id-2',
            'name' => '',
          ]
        ]
      ];

      $response = new Response(200, [], json_encode($data));
      $responses = [
        $response,
      ];

        $client = $this->getClient($responses);

        $site1 = [
          "id" => 'test-site-id-1',
          'name' => 'Test Site Name 1',
          'url' => 'https://url-1'
        ];

        $site2 = [
          "id" => 'test-site-id-2',
          'name' => ''
        ];

        // Get Site Manager
        $manager = $client->getSiteManager();
        $response = $manager->post([$site1, $site2]);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/v2/sites?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        $this->assertEquals(sizeof($response), 2);
        $custResp = $response[0];
        $this->assertEquals($custResp->getStatus(), "SUCCESS");
        $this->assertEquals($custResp->getItem()->getId(), "test-site-id-1");
        $this->assertEquals($custResp->getItem()->getName(), "Test Site Name 1");
        $this->assertEquals($custResp->getItem()->getUrl(), "https://url-1");

        $custResp = $response[1];
        $this->assertEquals($custResp->getStatus(), "FAILURE");
        $this->assertEquals(sizeof($custResp->getErrors()), 1);
        $this->assertEquals($custResp->getErrors()[0]->getCode(), "INVALID_NAME");
        $this->assertEquals($custResp->getErrors()[0]->getMessage(), "Customer site name cannot be empty");
        $this->assertEquals($custResp->getItem()->getId(), "test-site-id-2");
        $this->assertEquals($custResp->getItem()->getName(), "");
    }

    /**
     * Testing Customer Site Delete
     */
    public function testCustomerSiteDelete()
    {
        $response = new Response(200, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);
        $siteId = "TESTSITEID";

        // Get Site Manager
        $manager = $client->getSiteManager();
        $response = $manager->delete($siteId);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'DELETE');
        $this->assertEquals((string) $request->getUri(), '/v2/sites/TESTSITEID?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');
        $this->assertTrue($response, 'Site Deletion succeeded');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testSiteDeleteError()
    {
      $response = new Response(400, []);
      $responses = [
        $response,
      ];

      $client = $this->getClient($responses);

      // Get Campaign Manager
      $manager = $client->getSiteManager();
      $campaign = $manager->delete("TESTSITEID");
    }
}
