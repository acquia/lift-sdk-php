<?php

namespace Acquia\LiftClient\test;

use Acquia\LiftClient\Lift;
use Acquia\Hmac\Key;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class LiftTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Acquia\Hmac\KeyInterface
     *   A sample key.
     */
    protected $authKey;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $authId     = 'efdde334-fe7b-11e4-a322-1697f925ec7b';
        $authSecret = 'W5PeGMxSItNerkNFqQMfYiJvH14WzVJMy54CPoTAYoI=';

        $this->authKey   = new Key($authId, $authSecret);
    }

    /**
     * @param array $responses Responses
     *
     * @return \Acquia\LiftClient\Lift
     */
    private function getClient(array $responses = [])
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        return new Lift($this->authKey->getId(), $this->authKey->getId(), 'Decision', ['handler' => $stack, 'auth_middleware' => FALSE]);
    }

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
        $body = (string) $response->getBody();
        $this->assertEquals($data, json_decode($body, TRUE));
    }
}
