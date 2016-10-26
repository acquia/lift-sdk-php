<?php

namespace Acquia\LiftClient\Test;

use GuzzleHttp\Psr7\Response;

class PingTest extends TestBase
{
    public function testPing()
    {
        // Setup
        $data = [
          'success' => 1,
        ];
        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Ping the service
        $response = $client->ping();
        $this->assertEquals($data, $response);
    }
}
