<?php

namespace Acquia\LiftClient\test;

use Acquia\LiftClient\Lift;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class LiftTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $responses Responses
     *
     * @return \Acquia\LiftClient\Lift
     */
    private function getClient(array $responses = [])
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        return new Lift('public', 'secret', 'origin', ['handler' => $stack]);
    }

    public function testPing()
    {
        // Setup
        $data = [
            'success' => 1,
        ];
        $responses = [
            new Response('200', [], json_encode($data)),
        ];
        $client = $this->getClient($responses);

        // Ping the service
        $response = $client->ping();
        $body = (string) $response->getBody();
        $this->assertEquals($data, json_decode($body, TRUE));
    }
}
