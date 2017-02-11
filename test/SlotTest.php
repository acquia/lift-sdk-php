<?php

namespace Acquia\LiftClient\Test;

use Acquia\LiftClient\Entity\Slot;
use Acquia\LiftClient\Entity\Visibility;
use DateTime;
use GuzzleHttp\Psr7\Response;

class SlotTest extends TestBase
{
    public function testHandlerStack() {
        $response = new Response(200, [], json_encode([]));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();

        // Check if the client has already have expected handlers.
        // To check, to insert a dummy function after the expected handler, and
        // hope it finds the expected handler without throwing an Exception.
        $handler = $manager->getClient()->getConfig('handler');
        $testFunction = function () {};
        $handler->after('acquia_lift_account_and_site_ids', $testFunction);
        // Does not throw Exception because this handler is authenticated.
        $handler->after('acquia_lift_hmac_auth', $testFunction);
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
        $manager = $client->getSlotManager();
        $response = $manager->add($slot);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/slots?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        // Check if the identifier is equal.
        $this->assertEquals($response->getId(), 'test-id');
        // Check if the description is equal.
        $this->assertEquals($response->getDescription(), 'test-description');
        // Check if the label is equal.
        $this->assertEquals($response->getLabel(), 'test-label');

        // Check if the timestamp for created is as expected.
        $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2016-08-19T15:15:41Z'));

        // Check if the timestamp for updated is as expected.
        $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2016-08-19T15:15:41Z'));

        // Check if the visibility was set correctly.
        $this->assertEquals($response->getVisibility()->getCondition(), 'show');
        $this->assertEquals($response->getVisibility()->getPages(), ['localhost/blog/*']);

        // Check if the status was set correctly.
        $this->assertEquals($response->getStatus(), $slot->getStatus());
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
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
        $manager = $client->getSlotManager();
        $response = $manager->add($slot);
    }

    public function testSlotDelete()
    {
        $response = new Response(200, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $manager = $client->getSlotManager();
        $response = $manager->delete('slot-to-delete');
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'DELETE');
        $this->assertEquals((string) $request->getUri(), '/slots/slot-to-delete?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertTrue($response, 'Slot Deletion succeeded');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testSlotDeleteFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $manager = $client->getSlotManager();
        $response = $manager->delete('slot-to-delete');
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
        $manager = $client->getSlotManager();
        $option = [
            'visible_on_page' => 'my_&&_special_page_!',
            'status' => 'disabled',
            'unrelated_option_name' => 'unrelated_option_value',
        ];
        $slotsResponse = $manager->query($option);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/slots?visible_on_page=my_%26%26_special_page_%21&status=disabled&account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        foreach ($slotsResponse as $response) {
            // Check if the identifier is equal.
            $this->assertEquals($response->getId(), 'test-id');
            // Check if the description is equal.
            $this->assertEquals(
              $response->getDescription(),
              'test-description'
            );
            // Check if the label is equal.
            $this->assertEquals($response->getLabel(), 'test-label');
            // Check if the timestamp for created is as expected.
            $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2016-08-19T15:15:41Z'));
            // Check if the timestamp for updated is as expected.
            $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2016-08-19T15:15:41Z'));

            // Check if the visibility was set correctly.
            $this->assertEquals($response->getVisibility()->getCondition(), 'show');
            $this->assertEquals($response->getVisibility()->getPages(), ['localhost/blog/*']);

            // Check if the status was set correctly.
            $this->assertEquals($response->getStatus(), true);
        }
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testSlotQueryFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $manager = $client->getSlotManager();
        $response = $manager->query();
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
        $manager = $client->getSlotManager();
        $response = $manager->get('test-id');
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/slots/test-id?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        // Check if the identifier is equal.
        $this->assertEquals($response->getId(), 'test-id');
        // Check if the description is equal.
        $this->assertEquals(
          $response->getDescription(),
          'test-description'
        );
        // Check if the label is equal.
        $this->assertEquals($response->getLabel(), 'test-label');
        // Check if the timestamp for created is as expected.
        $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2016-08-19T15:15:41Z'));
        // Check if the timestamp for updated is as expected.
        $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2016-08-19T15:15:41Z'));

        // Check if the visibility was set correctly.
        $this->assertEquals($response->getVisibility()->getCondition(), 'show');
        $this->assertEquals($response->getVisibility()->getPages(), ['localhost/blog/*']);

        // Check if the status was set correctly.
        $this->assertEquals($response->getStatus(), true);
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testSlotGetFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $manager = $client->getSlotManager();
        $response = $manager->get('non-existing-slot');
    }
}
