<?php

namespace Acquia\LiftClient\Test;

use GuzzleHttp\Psr7\Response;

class ViewModeTest extends TestBase
{
    public function testHandlerStack() {
        $response = new Response(200, [], json_encode([]));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get ViewMode Manager
        $manager = $client->getViewModeManager();

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
    public function testGetViewModes()
    {
      $data = [
        [
          "id" => "teaser",
          "label" => "Teaser"
        ],
        [
          "id" => "full",
          "label" => "Full Content"
        ],
        [
          "id" => "rss",
          "label" => "RSS"
        ]
      ];

      $response = new Response(200, [], json_encode($data));
      $responses = [
        $response,
      ];

      $client = $this->getClient($responses);

      $options = [
        'cdf_version' => '2',
        'context_language' => 'en',
      ];

      // Get Deploy-Site Manager
      $manager = $client->getViewModeManager();
      $responses = $manager->get($options);
      $request = $this->mockHandler->getLastRequest();

      // Check for request configuration
      $this->assertEquals($request->getMethod(), 'GET');
      $this->assertEquals((string) $request->getUri(), '/v2/view_modes?context_language=en&cdf_version=2&account_id=TESTACCOUNTID&site_id=TESTSITEID');

      $requestHeaders = $request->getHeaders();
      $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

      $this->assertEquals(sizeof($responses), 3);
      $this->assertEquals($responses[0]->getId(), "teaser");
      $this->assertEquals($responses[0]->getLabel(), "Teaser");
      $this->assertEquals($responses[1]->getId(), "full");
      $this->assertEquals($responses[1]->getLabel(), "Full Content");
      $this->assertEquals($responses[2]->getId(), "rss");
      $this->assertEquals($responses[2]->getLabel(), "RSS");
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testGetViewModeError()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get ViewMode Manager
        $manager = $client->getViewModeManager();
        $manager->get();
    }
}
