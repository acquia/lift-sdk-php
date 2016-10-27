<?php

namespace Acquia\LiftClient\Test;

use Acquia\LiftClient\Entity\Slot;
use Acquia\LiftClient\Entity\Visibility;
use DateTime;
use GuzzleHttp\Psr7\Response;

class SlotTest extends TestBase
{
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
        $this->assertEquals($slotResponse->getId(), 'test-id');
        // Check if the description is equal.
        $this->assertEquals($slotResponse->getDescription(), 'test-description');
        // Check if the label is equal.
        $this->assertEquals($slotResponse->getLabel(), 'test-label');

        // Check if the timestamp for created is as expected.
        $this->assertEquals($slotResponse->getCreated(), DateTime::createFromFormat(DateTime::ISO8601, '2016-08-19T15:15:41Z'));

        // Check if the timestamp for updated is as expected.
        $this->assertEquals($slotResponse->getUpdated(), DateTime::createFromFormat(DateTime::ISO8601, '2016-08-19T15:15:41Z'));

        // Check if the visibility was set correctly.
        $this->assertEquals($slotResponse->getVisibility()->getCondition(), 'show');
        $this->assertEquals($slotResponse->getVisibility()->getPages(), ['localhost/blog/*']);

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
          ],
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
            $this->assertEquals($slotResponse->getCreated(), DateTime::createFromFormat(DateTime::ISO8601, '2016-08-19T15:15:41Z'));
            // Check if the timestamp for updated is as expected.
            $this->assertEquals($slotResponse->getUpdated(), DateTime::createFromFormat(DateTime::ISO8601, '2016-08-19T15:15:41Z'));

            // Check if the visibility was set correctly.
            $this->assertEquals($slotResponse->getVisibility()->getCondition(), 'show');
            $this->assertEquals($slotResponse->getVisibility()->getPages(), ['localhost/blog/*']);

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
        $this->assertEquals($slotResponse->getCreated(), DateTime::createFromFormat(DateTime::ISO8601, '2016-08-19T15:15:41Z'));
        // Check if the timestamp for updated is as expected.
        $this->assertEquals($slotResponse->getUpdated(), DateTime::createFromFormat(DateTime::ISO8601, '2016-08-19T15:15:41Z'));

        // Check if the visibility was set correctly.
        $this->assertEquals($slotResponse->getVisibility()->getCondition(), 'show');
        $this->assertEquals($slotResponse->getVisibility()->getPages(), ['localhost/blog/*']);

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
