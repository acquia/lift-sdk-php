<?php

namespace Acquia\LiftClient\Test;

use Acquia\LiftClient\Lift;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;

abstract class TestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string The account we are using
     */
    protected $accountId;

    /**
     * @var string The site identifier we are using
     */
    protected $siteId;

    /**
     * @var string The public key we are using
     */
    protected $publicKey;

    /**
     * @var string The secret key we are using
     */
    protected $secretKey;

    /**
     * @var \GuzzleHttp\Handler\MockHandler The mock handler
     */
    protected $mockHandler;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->accountId = 'TESTACCOUNTID';
        $this->siteId = 'TESTSITEID';
        $this->publicKey = 'efdde334-fe7b-11e4-a322-1697f925ec7b';
        $this->secretKey = 'W5PeGMxSItNerkNFqQMfYiJvH14WzVJMy54CPoTAYoI=';
    }

    /**
     * @param array $responses Responses
     *
     * @return \Acquia\LiftClient\Lift
     */
    public function getClient(array $responses = [])
    {
        $this->mockHandler = new MockHandler($responses);
        $stack = HandlerStack::create($this->mockHandler);

        return new Lift(
          $this->accountId,
          $this->siteId,
          $this->publicKey,
          $this->secretKey,
          ['handler' => $stack, 'auth_middleware' => $this->getDummyAuthMiddleware()]
        );
    }

    /**
     * Get a dummy auth middleware.
     */
    protected function getDummyAuthMiddleware()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                return $handler($request, $options);
            };
        };
    }

}
