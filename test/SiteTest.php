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

        // Get Segment Manager
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
