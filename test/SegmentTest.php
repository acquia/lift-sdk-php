<?php

namespace Acquia\LiftClient\Test;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;

class SegmentTest extends TestBase
{
    public function testSegmentQuery()
    {
        $data = [
          [
            'id' => 'test-id',
            'name' => 'test-name',
            'description' => 'test-description',
          ],
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get manager
        $manager = $client->getSegmentManager();
        $responses = $manager->query();
        foreach ($responses as $response) {
            // Check if the identifier is equal.
          $this->assertEquals($response->getId(), 'test-id');

          // Check if the label is equal.
          $this->assertEquals($response->getName(), 'test-name');

          // Check if the description is equal.
          $this->assertEquals($response->getDescription(), 'test-description');
        }
    }

    public function testSegmentQueryFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Manager
        $manager = $client->getSegmentManager();
        try {
            $manager->query();
        } catch (RequestException $e) {
            $this->assertEquals($e->getResponse()->getStatusCode(), 400);
        }
    }
}
