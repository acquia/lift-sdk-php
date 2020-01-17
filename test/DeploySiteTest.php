<?php

namespace Acquia\LiftClient\Test;

use GuzzleHttp\Psr7\Response;

class DeploySiteTest extends TestBase
{
    public function testHandlerStack() {
        $response = new Response(200, [], json_encode([]));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getDeploySiteManager();

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
    public function testPostDeploySite()
    {
      $data = [
        "Successfully deployed source_site_id to dest_site_id"
      ];

      $response = new Response(200, [], json_encode($data));
      $responses = [
        $response,
      ];

      $client = $this->getClient($responses);

      $options = [
        'dest_site_id' => 'test-site-prod',
        'source_site_id' => 'test-site-qa',
      ];

      // Get Deploy-Site Manager
      $manager = $client->getDeploySiteManager();
      $response = $manager->post($options);
      $request = $this->mockHandler->getLastRequest();

      // Check for request configuration
      $this->assertEquals($request->getMethod(), 'POST');
      $this->assertEquals((string) $request->getUri(), '/v2/deploy-site?source_site_id=test-site-qa&account_id=TESTACCOUNTID&site_id=TESTSITEID');

      $requestHeaders = $request->getHeaders();
      $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

      $this->assertEquals($response->getError(), null);
      $this->assertEquals($response[0], "Successfully deployed source_site_id to dest_site_id");
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testPostDeploySitesError()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Deploy-Site Manager
        $manager = $client->getDeploySiteManager();
        $manager->post();
    }
}
