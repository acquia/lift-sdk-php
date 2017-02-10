<?php

namespace Acquia\LiftClient\Test;

use Acquia\LiftClient\Entity\Goal;
use GuzzleHttp\Psr7\Response;

class GoalTest extends TestBase
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

    public function testGoalAdd()
    {
        // Setup
        $data = [
          'status' => 'SUCCESS',
        ];
        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Create a new Goal object.
        $goal = new Goal();
        $goal->setName('test-name');
        $goal->setId('test-id');
        $goal->setDescription('test-description');
        $goal->setRuleIds(array('rule-id-1'));
        $goal->setSiteIds(array('site-id-1'));
        $goal->setEventNames(array('Click-Through'));

        // Get Goal Manager
        $manager = $client->getGoalManager();
        $response = $manager->add($goal);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/goals?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getStatus(), 'SUCCESS');
    }

    public function testGoalAddLiftWebFailed()
    {

        // Setup
        $data = [
            'status' => 'FAILURE',
            'errors' => [
                [
                    'code' => '400',
                    'message' => 'Resource had an internal error.',
                ],
            ],
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
            $response,
        ];

        $client = $this->getClient($responses);

        // Create a new Goal object.
        $goal = new Goal();
        $goal->setName('test-name');
        $goal->setId('test-id');
        $goal->setDescription('test-description');
        $goal->setRuleIds(array('rule-id-1'));
        $goal->setSiteIds(array('site-id-1'));
        $goal->setEventNames(array('Click-Through'));

        // Get Goal Manager
        $manager = $client->getGoalManager();
        $response = $manager->add($goal);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/goals?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getStatus(), 'FAILURE');
        $this->assertEquals($response->getErrors()[0]->getCode(), '400');
        $this->assertEquals($response->getErrors()[0]->getMessage(), 'Resource had an internal error.');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testGoalAddDecisionAPIFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Create a new Goal object.
        $goal = new Goal();
        $goal->setName('test-name');
        $goal->setId('test-id');
        $goal->setDescription('test-description');
        $goal->setRuleIds(array('rule-id-1'));
        $goal->setSiteIds(array('site-id-1'));
        $goal->setEventNames(array('Click-Through'));

        // Get Goal Manager
        $manager = $client->getGoalManager();
        $manager->add($goal);
    }

    public function testGoalDelete()
    {
        $response = new Response(200, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Goal Manager
        $manager = $client->getGoalManager();
        $response = $manager->delete('goal-to-delete');
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'DELETE');
        $this->assertEquals((string) $request->getUri(), '/goals/goal-to-delete?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertTrue($response, 'Goal Deletion succeeded');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testGoalDeleteFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Goal Manager
        $manager = $client->getGoalManager();
        $manager->delete('goal-to-delete');
    }

    public function testGoalQuery()
    {
        $data = [
          [
            'id' => 'test-id',
            'name' => 'test-name',
            'description' => 'test-description',
            'rule_ids' => [
              'rule-id-1',
            ],
            'site_ids' => [
              'site-id-1',
            ],
            'event_names' => [
              'Click-Through',
            ],
            'global' => false,
            'value' => 100,
          ],
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Goal Manager
        $manager = $client->getGoalManager();
        $option = [
            'limit_by_site' => 'my_site',
            'unrelated_option_name' => 'unrelated_option_value',
        ];
        $responses = $manager->query($option);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/goals?limit_by_site=my_site&account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        foreach ($responses as $response) {
            // Check if the identifier is equal.
          $this->assertEquals($response->getId(), 'test-id');

          // Check if the label is equal.
          $this->assertEquals($response->getName(), 'test-name');

          // Check if the description is equal.
          $this->assertEquals($response->getDescription(), 'test-description');

          // Check if the rule_ids is equal.
          $this->assertEquals($response->getRuleIds(), ['rule-id-1']);

          // Check if the site_ids is equal.
          $this->assertEquals($response->getSiteIds(),  ['site-id-1']);

          // Check if the event_names is equal.
          $this->assertEquals($response->getEventNames(),  ['Click-Through']);

          // Check if the value is equal.
          $this->assertEquals($response->getValue(),  100);

          // Check if the global was set correctly.
          $this->assertEquals($response->getGlobal(), false);
        }
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testGoalQueryFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Goal Manager
        $manager = $client->getGoalManager();
        $manager->query();
    }

    public function testGoalGet()
    {
        // Setup
        $data = [
          'id' => 'test-id',
          'name' => 'test-name',
          'description' => 'test-description',
          'rule_ids' => [
            'rule-id-1',
          ],
          'site_ids' => [
            'site-id-1',
          ],
          'event_names' => [
            'Click-Through',
          ],
          'global' => false,
          'value' => 100,
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Goal Manager
        $manager = $client->getGoalManager();
        $response = $manager->get('test-id');
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/goals/test-id?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        // Check if the identifier is equal.
        $this->assertEquals($response->getId(), 'test-id');

        // Check if the label is equal.
        $this->assertEquals($response->getName(), 'test-name');

        // Check if the description is equal.
        $this->assertEquals($response->getDescription(), 'test-description');

        // Check if the rule_ids is equal.
        $this->assertEquals($response->getRuleIds(), ['rule-id-1']);

        // Check if the site_ids is equal.
        $this->assertEquals($response->getSiteIds(),  ['site-id-1']);

        // Check if the event_names is equal.
        $this->assertEquals($response->getEventNames(),  ['Click-Through']);

        // Check if the value is equal.
        $this->assertEquals($response->getValue(),  100);

        // Check if the global was set correctly.
        $this->assertEquals($response->getGlobal(), false);
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testGoalGetFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Goal Manager
        $manager = $client->getGoalManager();
        $manager->get('non-existing-slot');
    }
}
