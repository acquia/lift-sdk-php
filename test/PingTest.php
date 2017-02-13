<?php

namespace Acquia\LiftClient\Test;

use GuzzleHttp\Psr7\Response;

class PingTest extends TestBase
{
    public function testPing()
    {
        // Setup
        $data = [
          'success' => true,
        ];
        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Ping the service
        $response = $client->ping();
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/ping?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($data, $response);
    }
}
