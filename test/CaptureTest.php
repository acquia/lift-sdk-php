<?php

namespace Acquia\LiftClient\Test;

use Acquia\LiftClient\Entity\Capture;
use Acquia\LiftClient\Entity\CapturePayload;
use DateTime;
use GuzzleHttp\Psr7\Response;

class CaptureTest extends TestBase
{
    /**
     * @var CapturePayload
     */
    private $capturePayload;

    /**
     * @var array
     */
    private $capturesResponseData;

    public function setUp()
    {
        parent::setUp();
        $this->setTestCaptures();
        $this->setTestCapturesResponseData();
    }

    /**
     * Sets the captures object we are testing with.
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     */
    private function setTestCaptures()
    {
        $capture = new Capture();
        // Set Person and Event UDF Fields.
        for ($i = 1; $i <= 50; ++$i) {
            $capture
                ->setPersonUdf($i, 'person_udf'.$i)
                ->setEventUdf($i, 'event_udf'.$i);
        }
        // Set Touch fields
        for ($i = 1; $i <= 20; ++$i) {
            $capture->setTouchUdf($i, 'touch_udf'.$i);
        }

        $eventDate = DateTime::createFromFormat(DateTime::ATOM, '2016-08-19T15:15:41Z');
        $publishedDate = DateTime::createFromFormat(DateTime::ATOM, '2016-07-19T15:15:41Z');

        $capture
            ->setEventName('event-name')
            ->setEventSource('event-source')
            ->setEventDate($eventDate)
            ->setIdentities(['myemail@acquia.dev' => 'email'])
            ->setUrl('http://localhost.dev')
            ->setReferralUrl('referral-url')
            ->setContentTitle('content-title')
            ->setUserAgent('user-agent')
            ->setPlatform('platform')
            ->setIpAddress('127.0.0.1')
            ->setPersona('persona')
            ->setEngagementScore(1)
            ->setPersonalizationName('name')
            ->setPersonalizationMachineName('machine-name')
            ->setPersonalizationChosenVariation('chosen-variation')
            ->setPersonalizationAudienceName('audience-name')
            ->setPersonalizationDecisionPolicy('explore')
            ->setPersonalizationGoalName('goal-name')
            ->setPersonalizationGoalValue('goal-value')
            ->setDecisionSlotId('slot-id')
            ->setDecisionSlotName('slot-name')
            ->setDecisionRuleId('rule-id')
            ->setDecisionRuleName('rule-name')
            ->setDecisionContentId('content-id')
            ->setDecisionContentName('content-name')
            ->setDecisionGoalId('goal-id')
            ->setDecisionGoalName('goal-name')
            ->setDecisionGoalValue('goal-value')
            ->setDecisionViewMode('view-mode')
            ->setDecisionPolicy('explore')
            ->setDecisionCampaignId('test-campaign-id')
            ->setDecisionCampaignName('test-campaign-name')
            ->setDecisionCampaignType('target')
            ->setDecisionABVariationId('test-ab-variation-id')
            ->setDecisionABVariationLabel('test-ab-variation-label')
            ->setCaptureIdentifier('capture-identifier')
            ->setClientTimezone('America/Anguilla')
            ->setJavascriptVersion('3')
            ->setPostId('post-id')
            ->setContentId('content-id')
            ->setContentUuid('ecf826eb-3ef0-4aa6-aae2-9f6e5886bbb6')
            ->setContentType('content-type')
            ->setContentSection('content-section')
            ->setContentKeywords('keyword1, keyword2')
            ->setAuthor('author')
            ->setPageType('page-type')
            ->setPublishedDate($publishedDate)
            ->setContextLanguage("en")
            ->setDecisionContextLanguage("en");

        $capturePayload = new CapturePayload();
        $capturePayload
            ->setCaptures([$capture])
            ->setDoNotTrack(false)
            ->setIdentity('my-custom-identity-string')
            ->setIdentitySource('php-unit-test')
            ->setReturnSegments(true)
            ->setTouchIdentifier('my-custom-touch-identifier');

        $this->capturePayload = $capturePayload;
    }

    private function setTestCapturesResponseData()
    {
        // Setup
        $this->capturesResponseData = [
            'errors' => null,
            'touch_identifier' => 'my-custom-touch-identifier',
            'identity' => 'my-custom-identity-string',
            'identity_source' => 'php-unit-test',
            'matched_segments' => [
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

        // Get Capture Manager
        $manager = $client->getCaptureManager();

        // Check if the client has already have expected handlers.
        // To check, to insert a dummy function after the expected handler, and
        // hope it finds the expected handler (or throw Exception when don't).
        $handler = $manager->getClient()->getConfig('handler');
        $testFunction = function () {};
        $handler->after('acquia_lift_account_and_site_ids', $testFunction);
        // Throws Exception because this handler is unauthenticated.
        $handler->after('acquia_lift_hmac_auth', $testFunction);
    }

    public function testCaptureAdd()
    {
        $response = new Response(200, [], json_encode($this->capturesResponseData));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Capture Manager
        $manager = $client->getCaptureManager();
        $response = $manager->add($this->capturePayload);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/capture?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getErrors(), null);
        $this->assertEquals($response->getTouchIdentifier(), 'my-custom-touch-identifier');
        $this->assertEquals($response->getIdentity(), 'my-custom-identity-string');
        $this->assertEquals($response->getIdentitySource(), 'php-unit-test');

        $this->assertEquals($response->getMatchedSegments()[0]->getId(), 'segment-1');
        $this->assertEquals($response->getMatchedSegments()[0]->getName(), 'Segment 1');
        $this->assertEquals($response->getMatchedSegments()[0]->getDescription(), 'First Segment for the unit test');

        $this->assertEquals($response->getMatchedSegments()[1]->getId(), 'segment-2');
        $this->assertEquals($response->getMatchedSegments()[1]->getName(), 'Segment 2');
        $this->assertEquals($response->getMatchedSegments()[1]->getDescription(), 'Second Segment for the unit test');
    }

    public function testCaptureAddLiftWebError()
    {

        // Setup
        $data = [
            'errors' => [
                [
                    'code' => '400',
                    'message' => 'Resource had an internal error.',
                ],
            ],
            'touch_identifier' => 'my-custom-touch-identifier',
            'identity' => 'my-custom-identity-string',
            'identity_source' => 'php-unit-test',
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Capture Manager
        $manager = $client->getCaptureManager();
        $response = $manager->add($this->capturePayload);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/capture?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getTouchIdentifier(), 'my-custom-touch-identifier');
        $this->assertEquals($response->getIdentity(), 'my-custom-identity-string');
        $this->assertEquals($response->getIdentitySource(), 'php-unit-test');
        $this->assertEquals($response->getErrors()[0]->getCode(), '400');
        $this->assertEquals($response->getErrors()[0]->getMessage(), 'Resource had an internal error.');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testCaptureAddDecisionAPIError()
    {
        $response = new Response(400, []);
        $responses = [
            $response,
        ];

        $client = $this->getClient($responses);

        // Get Capture Manager
        $manager = $client->getCaptureManager();
        $manager->add($this->capturePayload);
    }
}
