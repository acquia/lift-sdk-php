<?php

namespace Acquia\LiftClient\test;

use Acquia\LiftClient\Entity\Slot;
use Acquia\LiftClient\Entity\Visibility;
use Acquia\LiftClient\Lift;
use NickVeenhof\Hmac\Key;
use DateTime;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class LiftTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \NickVeenhof\Hmac\KeyInterface
     *   A sample key.
     */
    protected $authKey;

    /**
     * @var string
     *   The account we are using.
     */
    protected $accountId;

    /**
     * @var string
     *   The site identifier we are using.
     */
    protected $siteId;

    /**
     * {@inheritDoc}
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
    private function getClient(array $responses = [])
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

    public function testSlotAdd()
    {
        // Setup
        $data = [
          'id' => 'test-id',
          'label' => 'test-label',
          'description' => 'test-description',
          'html' => '',
          'created' => '2016-08-19T15:15:41Z',
          'updated' => '2016-08-19T15:15:41Z',
          'status' => 'enabled',
          'visibility' => array(
            'pages' => ['localhost/blog/*'],
            'condition' => 'show',
          ),
        ];
        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Create a new slot object.
        $slot = new Slot();
        $slot->setDescription('test-description');
        $slot->setId('test-id');
        $slot->setLabel('test-label');
        $slot->setStatus(true);

        // Add the visibility to the slot.
        $visibility = new Visibility();
        $visibility->setCondition('show');
        $visibility->setPages(['localhost/blog/*']);
        $slot->setVisibility($visibility);

        // Get Slot Manager
        $slotManager = $client->getSlotManager();
        $slotResponse = $slotManager->add($slot);

        // Check if the identifier is equal.
        $this->assertEquals($slotResponse->getId(), $slot->getId());
        // Check if the description is equal.
        $this->assertEquals(
          $slotResponse->getDescription(),
          $slot->getDescription()
        );
        // Check if the label is equal.
        $this->assertEquals($slotResponse->getLabel(), $slot->getLabel());
        // Check if the timestamp for created is as expected.
        $this->assertEquals(
          $slotResponse->getCreated(),
          DateTime::createFromFormat(DateTime::ISO8601, '2016-08-19T15:15:41Z')
        );
        // Check if the timestamp for updated is as expected.
        $this->assertEquals(
          $slotResponse->getUpdated(),
          DateTime::createFromFormat(DateTime::ISO8601, '2016-08-19T15:15:41Z')
        );
        // Check if the visibility was set correctly.
        $this->assertEquals(
          $slotResponse->getVisibility(),
          $slot->getVisibility()
        );
        // Check if the status was set correctly.
        $this->assertEquals($slotResponse->getStatus(), $slot->getStatus());
    }

    public function testSlotAddFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Create a new slot object.
        $slot = new Slot();
        $slot->setDescription('test-description');
        $slot->setId('test-id');
        $slot->setLabel('test-label');
        $slot->setStatus(true);

        // Add the visibility to the slot.
        $visibility = new Visibility();
        $visibility->setCondition('show');
        $visibility->setPages(['localhost/blog/*']);
        $slot->setVisibility($visibility);

        // Get Slot Manager
        $slotManager = $client->getSlotManager();
        try {
            $slotResponse = $slotManager->add($slot);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->assertEquals($e->getResponse()->getStatusCode(), 400);
        }
    }

    public function testSlotDelete()
    {
        $response = new Response(200, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $slotManager = $client->getSlotManager();
        $slotResponse = $slotManager->delete('slot-to-delete');
        $this->assertTrue($slotResponse, 'Slot Deletion succeeded');
    }

    public function testSlotDeleteFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $slotManager = $client->getSlotManager();
        try {
            $slotResponse = $slotManager->delete('slot-to-delete');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->assertEquals($e->getResponse()->getStatusCode(), 400);
        }
    }

    public function testSlotQuery()
    {
        // Setup
        $data = [
          [
            'id' => 'test-id',
            'label' => 'test-label',
            'description' => 'test-description',
            'html' => '',
            'created' => '2016-08-19T15:15:41Z',
            'updated' => '2016-08-19T15:15:41Z',
            'status' => 'enabled',
            'visibility' => array(
              'pages' => ['localhost/blog/*'],
              'condition' => 'show',
            ),
          ]
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $slotManager = $client->getSlotManager();
        $slotsResponse = $slotManager->query();
        foreach ($slotsResponse as $slotResponse) {
            // Check if the identifier is equal.
            $this->assertEquals($slotResponse->getId(), 'test-id');
            // Check if the description is equal.
            $this->assertEquals(
              $slotResponse->getDescription(),
              'test-description'
            );
            // Check if the label is equal.
            $this->assertEquals($slotResponse->getLabel(), 'test-label');
            // Check if the timestamp for created is as expected.
            $this->assertEquals(
              $slotResponse->getCreated(),
              DateTime::createFromFormat(
                DateTime::ISO8601,
                '2016-08-19T15:15:41Z'
              )
            );
            // Check if the timestamp for updated is as expected.
            $this->assertEquals(
              $slotResponse->getUpdated(),
              DateTime::createFromFormat(
                DateTime::ISO8601,
                '2016-08-19T15:15:41Z'
              )
            );
            // Check if the visibility was set correctly.
            // Add the visibility to the slot.
            $visibility = new Visibility();
            $visibility->setCondition('show');
            $visibility->setPages(['localhost/blog/*']);

            $this->assertEquals(
              $slotResponse->getVisibility(),
              $visibility
            );
            // Check if the status was set correctly.
            $this->assertEquals($slotResponse->getStatus(), true);
        }
    }

    public function testSlotQueryFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $slotManager = $client->getSlotManager();
        try {
            $slotResponse = $slotManager->query();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->assertEquals($e->getResponse()->getStatusCode(), 400);
        }
    }

    public function testSlotGet()
    {
        // Setup
        $data = [
          'id' => 'test-id',
          'label' => 'test-label',
          'description' => 'test-description',
          'html' => '',
          'created' => '2016-08-19T15:15:41Z',
          'updated' => '2016-08-19T15:15:41Z',
          'status' => 'enabled',
          'visibility' => array(
            'pages' => ['localhost/blog/*'],
            'condition' => 'show',
          ),
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $slotManager = $client->getSlotManager();
        $slotResponse = $slotManager->get('test-id');
        // Check if the identifier is equal.
        $this->assertEquals($slotResponse->getId(), 'test-id');
        // Check if the description is equal.
        $this->assertEquals(
          $slotResponse->getDescription(),
          'test-description'
        );
        // Check if the label is equal.
        $this->assertEquals($slotResponse->getLabel(), 'test-label');
        // Check if the timestamp for created is as expected.
        $this->assertEquals(
          $slotResponse->getCreated(),
          DateTime::createFromFormat(
            DateTime::ISO8601,
            '2016-08-19T15:15:41Z'
          )
        );
        // Check if the timestamp for updated is as expected.
        $this->assertEquals(
          $slotResponse->getUpdated(),
          DateTime::createFromFormat(
            DateTime::ISO8601,
            '2016-08-19T15:15:41Z'
          )
        );
        // Check if the visibility was set correctly.
        // Add the visibility to the slot.
        $visibility = new Visibility();
        $visibility->setCondition('show');
        $visibility->setPages(['localhost/blog/*']);

        $this->assertEquals(
          $slotResponse->getVisibility(),
          $visibility
        );
        // Check if the status was set correctly.
        $this->assertEquals($slotResponse->getStatus(), true);
    }

    public function testSlotGetFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $slotManager = $client->getSlotManager();
        try {
            $slotResponse = $slotManager->get('non-existing-slot');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->assertEquals($e->getResponse()->getStatusCode(), 400);
        }
    }
}
