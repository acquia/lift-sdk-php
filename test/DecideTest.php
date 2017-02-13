<?php

namespace Acquia\LiftClient\Test;

use Acquia\LiftClient\Entity\Capture;
use Acquia\LiftClient\Entity\Decide;
use Acquia\LiftClient\Entity\Segment;
use GuzzleHttp\Psr7\Response;

class DecideTest extends TestBase
{
    /**
     * @var array
     */
    private $decideResponseData;

    public function setUp()
    {
        parent::setUp();
        $this->setTestDecideResponseData();
    }

    private function setTestDecideResponseData()
    {
        // Setup
        $this->decideResponseData = [
            'lift_web_response' => [
                'identity' => 'my-custom-identity-string',
                'identity_expiry' => 'php-unit-test',
                'touch_identifier' => 'my-custom-touch-identifier',
                'segments' => [
                    [
                        'id' => 'segment-1',
                        'name' => 'Segment 1',
                        'description' => 'First Segment for the unit test',
                    ],
                    [
                        'id' => 'segment-2',
                        'name' => 'Segment 2',
                        'description' => 'Second Segment for the unit test',
                    ],
                ],
            ],
            'decisions' => [
                'slot_id' => 'slot-1',
                'slot_name' => 'my slot',
                'content' => [
                    'id' => 'front-banner-2',
                    'title' => 'Front Banner 2',
                    'content_connector_id' => 'nicks_content_hub_identifier',
                    'view_mode' => [
                        'id' => 'banner-wide',
                        'preview_image' => 'http://nickveenhof.be/sites/all/default/files/preview-banner-wide-2.png',
                        'url' => 'http://nickveenhof.be/liftv3/render/front-banner-2/banner-wide',
                        'html' => '<img src=\"nickveenhof.be/sites/all/files/banner-something-something-2.png\"/>',
                    ],
                ],
                'policy' => 'explore',
                'rule_id' => 'rule-1',
                'rule_name' => 'My Rule',
            ],
        ];
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Middleware not found: acquia_lift_hmac_auth
     */
    public function testHandlerStack() {
        $response = new Response(200, [], json_encode([]));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Decide Manager
        $manager = $client->getDecideManager();

        // Check if the client has already have expected handlers.
        // To check, to insert a dummy function after the expected handler, and
        // hope it finds the expected handler (or throw Exception when don't).
        $handler = $manager->getClient()->getConfig('handler');
        $testFunction = function () {};
        $handler->after('acquia_lift_account_and_site_ids', $testFunction);
        // Throws Exception because this handler is unauthenticated.
        $handler->after('acquia_lift_hmac_auth', $testFunction);
    }

    public function testMakeDecision()
    {
        $response = new Response(200, [], json_encode($this->decideResponseData));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        $decide = new Decide();
        $decide->setIdentity('my-custom-identity-string');
        $decide->setIdentitySource('source');
        $decide->setTouchIdentifier('my-custom-touch-identifier');
        $decide->setUrl('node/1');
        $decide->setDoNotTrack(false);

        $capture = new Capture();
        $capture->setIpAddress('127.0.0.1');
        $decide->setCaptures([$capture]);

        // Get Decide Manager
        $manager = $client->getDecideManager();
        $response = $manager->decide($decide);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/decide?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getSetDoNotTrack(), false);
        $this->assertEquals($response->getTouchIdentifier(), 'my-custom-touch-identifier');
        $this->assertEquals($response->getIdentity(), 'my-custom-identity-string');

        $this->assertEquals($response->getMatchedSegments()[0]->getId(), 'segment-1');
        $this->assertEquals($response->getMatchedSegments()[0]->getName(), 'Segment 1');
        $this->assertEquals($response->getMatchedSegments()[0]->getDescription(), 'First Segment for the unit test');

        $this->assertEquals($response->getMatchedSegments()[1]->getId(), 'segment-2');
        $this->assertEquals($response->getMatchedSegments()[1]->getName(), 'Segment 2');
        $this->assertEquals($response->getMatchedSegments()[1]->getDescription(), 'Second Segment for the unit test');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testDecideMakeDecisionDecisionAPIError()
    {
        $response = new Response(400, []);
        $responses = [
            $response,
        ];

        $client = $this->getClient($responses);

        // Get Decide Manager
        $manager = $client->getDecideManager();
        $decide = new Decide();
        $manager->decide($decide);
    }
}
