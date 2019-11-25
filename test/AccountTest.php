<?php

namespace Acquia\LiftClient\Test;

use GuzzleHttp\Psr7\Response;

class AccountTest extends TestBase
{
    public function testHandlerStack() {
        $response = new Response(200, [], json_encode([]));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getSiteManager();

        // Check if the client has already have expected handlers.
        // To check, to insert a dummy function after the expected handler, and
        // hope it finds the expected handler without throwing an Exception.
        $handler = $manager->getClient()->getConfig('handler');
        $testFunction = function () {};
        $handler->after('acquia_lift_account_and_site_ids', $testFunction);
        // Does not throw Exception because this handler is authenticated.
        $handler->after('acquia_lift_hmac_auth', $testFunction);
    }

    /**
     * Testing get list of accounts
     */
    public function testGetAccounts()
    {
        $data = [
          [
            'id' => 'test-account-1-admin',
            'name' => 'Admin Lift Account 1',
            'description' => 'This is an admin test account',
            'license_id' => 1
          ],
          [
            'id' => 'test-account-1-user',
            'name' => 'User Lift Account 1',
            'description' => 'This is a user test account',
            'license_id' => 1
          ],
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Segment Manager
        $manager = $client->getAccountManager();
        $responses = $manager->get();
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/v2/accounts?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Test Responses
        $this->assertEquals($responses[0]->getId(), 'test-account-1-admin');
        $this->assertEquals($responses[0]->getName(), 'Admin Lift Account 1');
        $this->assertEquals($responses[0]->getDescription(), 'This is an admin test account');
        $this->assertEquals($responses[0]->getLicenseId(), 1);

        $this->assertEquals($responses[1]->getId(), 'test-account-1-user');
        $this->assertEquals($responses[1]->getName(), 'User Lift Account 1');
        $this->assertEquals($responses[1]->getDescription(), 'This is a user test account');
        $this->assertEquals($responses[1]->getLicenseId(), 1);
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testGetAccountsError()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Account Manager
        $manager = $client->getAccountManager();
        $manager->get();
    }
}
