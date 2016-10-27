<?php

namespace Acquia\LiftClient\Test;

use Acquia\LiftClient\Lift;
use NickVeenhof\Hmac\Key;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

abstract class TestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \NickVeenhof\Hmac\KeyInterface A sample key
     */
    protected $authKey;

    /**
     * @var string The account we are using
     */
    protected $accountId;

    /**
     * @var string The site identifier we are using
     */
    protected $siteId;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $authId = 'efdde334-fe7b-11e4-a322-1697f925ec7b';
        $authSecret = 'W5PeGMxSItNerkNFqQMfYiJvH14WzVJMy54CPoTAYoI=';

        $this->authKey = new Key($authId, $authSecret);
        $this->accountId = 'TESTACCOUNTID';
        $this->siteId = 'TESTSITEID';
    }

    /**
     * @param array $responses Responses
     *
     * @return \Acquia\LiftClient\Lift
     */
    public function getClient(array $responses = [])
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);

        return new Lift(
          $this->accountId,
          $this->siteId,
          $this->authKey->getId(),
          $this->authKey->getSecret(),
          ['handler' => $stack, 'auth_middleware' => false]
        );
    }
}
