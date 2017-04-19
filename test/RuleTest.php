<?php

namespace Acquia\LiftClient\Test;

use Acquia\LiftClient\Entity\Content;
use Acquia\LiftClient\Entity\Probability;
use Acquia\LiftClient\Entity\Rule;
use Acquia\LiftClient\Entity\TestConfigAb;
use Acquia\LiftClient\Entity\ViewMode;
use DateTime;
use GuzzleHttp\Psr7\Response;

class RuleTest extends TestBase
{
    /**
     * @var Rule
     */
    private $rule;

    /**
     * @var array
     */
    private $ruleResponseData;

    public function setUp()
    {
        parent::setUp();
        $this->setTestRule();
        $this->setTestRuleResponseData();
    }

    /**
     * Sets the rule object we are testing with.
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     */
    private function setTestRule()
    {
        $viewMode1 = new ViewMode();
        $viewMode1->setId('banner-wide-1');

        $contentPiece1 = new Content();
        $contentPiece1
          ->setId('front-banner')
          ->setContentConnectorId('content_hub')
          ->setBaseUrl('http://mysite.dev')
          ->setViewMode($viewMode1);

        $viewMode2 = new ViewMode();
        $viewMode2->setId('banner-wide-2');

        $contentPiece2 = new Content();
        $contentPiece2
          ->setId('front-banner')
          ->setContentConnectorId('content_hub')
          ->setBaseUrl('http://mysite.dev')
          ->setViewMode($viewMode2);

        $probabilityContentPiece1 = new Probability();
        $probabilityContentPiece1
          ->setContentConnectorId('content_hub')
          ->setContentId('front-banner')
          ->setContentViewId('banner-wide-1')
          ->setFraction(0.3);

        $probabilityContentPiece2 = new Probability();
        $probabilityContentPiece2
          ->setContentConnectorId('content_hub')
          ->setContentId('front-banner')
          ->setContentViewId('banner-wide-2')
          ->setFraction(0.7);

        $testConfig = new TestConfigAb();
        $testConfig->setProbabilities([$probabilityContentPiece1, $probabilityContentPiece2]);

        // Create a new Rule object.
        $rule = new Rule();
        $rule
          ->setId('rule-1')
          ->setLabel('Banner for Belgians')
          ->setDescription('Front page banner personalization for Belgians')
          ->setSlotId('slot-1')
          ->setStatus('published')
          ->setSegmentId('belgians')
          ->setPriority(10)
          ->setContentList([$contentPiece1, $contentPiece2])
          ->setTestConfig($testConfig);

        $this->rule = $rule;
    }

    private function setTestRuleResponseData()
    {
        $contentList = [
          [
            'id' => 'front-banner',
            'content_connector_id' => 'content_hub',
            'base_url' => 'http://mysite.dev',
            'view_mode' => [
              'id' => 'banner-wide-1',
              'label' => 'Wide Banner Version 1',
              'preview_image' => 'http://mysite.dev/preview-image-1.png',
              'url' => 'http://mysite.dev/render/front-banner/banner-wide-1',
              'html' => '<img src="http://mysite.dev/preview-image-1.png"/>',
            ],
          ],
          [
            'id' => 'front-banner',
            'content_connector_id' => 'content_hub',
            'base_url' => 'http://mysite.dev',
            'view_mode' => [
              'id' => 'banner-wide-2',
              'label' => 'Wide Banner Version 2',
              'preview_image' => 'http://mysite.dev/preview-image-2.png',
              'url' => 'http://mysite.dev/render/front-banner/banner-wide-2',
              'html' => '<img src="http://mysite.dev/preview-image-2.png"/>',
            ],
          ],
        ];
        // Setup
        $this->ruleResponseData = [
          'id' => 'rule-1',
          'label' => 'Banner for Belgians',
          'description' => 'Front page banner personalization for Belgians',
          'slot_id' => 'slot-1',
          'updated' => '2016-01-05T22:04:39Z',
          'created' => '2016-01-05T22:04:39Z',
          'status' => 'published',
          'segment' => 'belgians',
          'priority' => 10,
          'content' => $contentList,
          'testconfig' => [
            'ab' => [
              'probabilities' => [
                [
                  'id' => 'front-banner',
                  'content_connector_id' => 'content_hub',
                  'content_view_id' => 'banner-wide-1',
                  'fraction' => 0.3,
                ],
                [
                  'id' => 'front-banner',
                  'content_connector_id' => 'content_hub',
                  'content_view_id' => 'banner-wide-2',
                  'fraction' => 0.7,
                ],
              ],
            ],
          ],
        ];
    }

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

    public function testRuleAdd()
    {
        $response = new Response(200, [], json_encode($this->ruleResponseData));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $response = $manager->add($this->rule);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/rules?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getId(), 'rule-1');
        $this->assertEquals($response->getLabel(), 'Banner for Belgians');
        $this->assertEquals($response->getDescription(), 'Front page banner personalization for Belgians');
        $this->assertEquals($response->getSlotId(), 'slot-1');
        $this->assertEquals($response->getStatus(), 'published');
        $this->assertEquals($response->getSegmentId(), 'belgians');
        $this->assertEquals($response->getPriority(), 10);
        $this->assertEquals($response->getWeight(), 10);

        // Check if the timestamp for created is as expected.
        $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z'));

        // Check if the timestamp for updated is as expected.
        $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z'));

        // Check for the response content
        $responseContent = $response->getContentList();
        $this->assertEquals($responseContent[0]->getId(), 'front-banner');
        $this->assertEquals($responseContent[0]->getBaseUrl(), 'http://mysite.dev');
        $this->assertEquals($responseContent[0]->getContentConnectorId(), 'content_hub');
        $this->assertEquals($responseContent[0]->getViewMode()->getId(), 'banner-wide-1');
        $this->assertEquals($responseContent[0]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-1.png"/>');
        $this->assertEquals($responseContent[0]->getViewMode()->getLabel(), 'Wide Banner Version 1');
        $this->assertEquals($responseContent[0]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-1.png');
        $this->assertEquals($responseContent[0]->getViewMode()->getUrl(), 'http://mysite.dev/render/front-banner/banner-wide-1');

        $this->assertEquals($responseContent[1]->getId(), 'front-banner');
        $this->assertEquals($responseContent[1]->getBaseUrl(), 'http://mysite.dev');
        $this->assertEquals($responseContent[1]->getContentConnectorId(), 'content_hub');
        $this->assertEquals($responseContent[1]->getViewMode()->getId(), 'banner-wide-2');
        $this->assertEquals($responseContent[1]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-2.png"/>');
        $this->assertEquals($responseContent[1]->getViewMode()->getLabel(), 'Wide Banner Version 2');
        $this->assertEquals($responseContent[1]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-2.png');
        $this->assertEquals($responseContent[1]->getViewMode()->getUrl(), 'http://mysite.dev/render/front-banner/banner-wide-2');

        // Verify if the TestConfig was stored correctly. We know it was an ab
        // test so we help our typehinting system here.
        /** @var \Acquia\LiftClient\Entity\TestConfigAb $testConfig */
        $testConfig = $response->getTestConfig();
        $this->assertEquals($testConfig->getProbabilities()[0]->getContentConnectorId(), 'content_hub');
        $this->assertEquals($testConfig->getProbabilities()[0]->getContentId(), 'front-banner');
        $this->assertEquals($testConfig->getProbabilities()[0]->getContentViewId(), 'banner-wide-1');
        $this->assertEquals($testConfig->getProbabilities()[0]->getFraction(), 0.3);

        $this->assertEquals($testConfig->getProbabilities()[1]->getContentConnectorId(), 'content_hub');
        $this->assertEquals($testConfig->getProbabilities()[1]->getContentId(), 'front-banner');
        $this->assertEquals($testConfig->getProbabilities()[1]->getContentViewId(), 'banner-wide-2');
        $this->assertEquals($testConfig->getProbabilities()[1]->getFraction(), 0.7);
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testRuleAddFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $manager->add($this->rule);
    }

    public function testRuleDelete()
    {
        $response = new Response(200, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $response = $manager->delete('rule-to-delete');
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'DELETE');
        $this->assertEquals((string) $request->getUri(), '/rules/rule-to-delete?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertTrue($response, 'Rule Deletion succeeded');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testRuleDeleteFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $manager->delete('rule-to-delete');
    }

    public function testRuleQuery()
    {
        $data = [
          $this->ruleResponseData,
        ];
        $response = new Response(200, [], json_encode($data));

        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $option = [
            'visible_on_page' => 'my_page',
            'prefetch' => 'true',
            'sort' => 'desc',
            'start' => '4',
            'rows' => '20',
            'sort_field' => 'updated',
            'status' => 'unpublished',
            'unrelated_option_name' => 'unrelated_option_value',
        ];
        $responses = $manager->query($option);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/rules?visible_on_page=my_page&prefetch=true&sort=desc&start=4&rows=20&sort_field=updated&status=unpublished&account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        foreach ($responses as $response) {
            // Check for basic fields
            $this->assertEquals($response->getId(), 'rule-1');
            $this->assertEquals($response->getLabel(), 'Banner for Belgians');
            $this->assertEquals($response->getDescription(), 'Front page banner personalization for Belgians');
            $this->assertEquals($response->getSlotId(), 'slot-1');
            $this->assertEquals($response->getStatus(), 'published');
            $this->assertEquals($response->getSegmentId(), 'belgians');
            $this->assertEquals($response->getPriority(), 10);
            $this->assertEquals($response->getWeight(), 10);

            // Check if the timestamp for created is as expected.
            $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z'));

            // Check if the timestamp for updated is as expected.
            $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z'));

            // Check for the response content
            $responseContent = $response->getContentList();
            $this->assertEquals($responseContent[0]->getId(), 'front-banner');
            $this->assertEquals($responseContent[0]->getBaseUrl(), 'http://mysite.dev');
            $this->assertEquals($responseContent[0]->getContentConnectorId(), 'content_hub');
            $this->assertEquals($responseContent[0]->getViewMode()->getId(), 'banner-wide-1');
            $this->assertEquals($responseContent[0]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-1.png"/>');
            $this->assertEquals($responseContent[0]->getViewMode()->getLabel(), 'Wide Banner Version 1');
            $this->assertEquals($responseContent[0]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-1.png');
            $this->assertEquals($responseContent[0]->getViewMode()->getUrl(), 'http://mysite.dev/render/front-banner/banner-wide-1');

            $this->assertEquals($responseContent[1]->getId(), 'front-banner');
            $this->assertEquals($responseContent[1]->getBaseUrl(), 'http://mysite.dev');
            $this->assertEquals($responseContent[1]->getContentConnectorId(), 'content_hub');
            $this->assertEquals($responseContent[1]->getViewMode()->getId(), 'banner-wide-2');
            $this->assertEquals($responseContent[1]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-2.png"/>');
            $this->assertEquals($responseContent[1]->getViewMode()->getLabel(), 'Wide Banner Version 2');
            $this->assertEquals($responseContent[1]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-2.png');
            $this->assertEquals($responseContent[1]->getViewMode()->getUrl(), 'http://mysite.dev/render/front-banner/banner-wide-2');

            // Verify if the TestConfig was stored correctly. We know it was an ab
            // test so we help our typehinting system here.
            /** @var \Acquia\LiftClient\Entity\TestConfigAb $testConfig */
            $testConfig = $response->getTestConfig();
            $this->assertEquals($testConfig->getProbabilities()[0]->getContentConnectorId(), 'content_hub');
            $this->assertEquals($testConfig->getProbabilities()[0]->getContentId(), 'front-banner');
            $this->assertEquals($testConfig->getProbabilities()[0]->getContentViewId(), 'banner-wide-1');
            $this->assertEquals($testConfig->getProbabilities()[0]->getFraction(), 0.3);

            $this->assertEquals($testConfig->getProbabilities()[1]->getContentConnectorId(), 'content_hub');
            $this->assertEquals($testConfig->getProbabilities()[1]->getContentId(), 'front-banner');
            $this->assertEquals($testConfig->getProbabilities()[1]->getContentViewId(), 'banner-wide-2');
            $this->assertEquals($testConfig->getProbabilities()[1]->getFraction(), 0.7);
        }
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testRuleQueryFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $manager->query();
    }

    public function testRuleGet()
    {
        $response = new Response(200, [], json_encode($this->ruleResponseData));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $response = $manager->get('rule-1');
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/rules/rule-1?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getId(), 'rule-1');
        $this->assertEquals($response->getLabel(), 'Banner for Belgians');
        $this->assertEquals($response->getDescription(), 'Front page banner personalization for Belgians');
        $this->assertEquals($response->getSlotId(), 'slot-1');
        $this->assertEquals($response->getStatus(), 'published');
        $this->assertEquals($response->getSegmentId(), 'belgians');
        $this->assertEquals($response->getPriority(), 10);
        $this->assertEquals($response->getWeight(), 10);

        // Check if the timestamp for created is as expected.
        $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z'));

        // Check if the timestamp for updated is as expected.
        $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z'));

        // Check for the response content
        $responseContent = $response->getContentList();
        $this->assertEquals($responseContent[0]->getId(), 'front-banner');
        $this->assertEquals($responseContent[0]->getBaseUrl(), 'http://mysite.dev');
        $this->assertEquals($responseContent[0]->getContentConnectorId(), 'content_hub');
        $this->assertEquals($responseContent[0]->getViewMode()->getId(), 'banner-wide-1');
        $this->assertEquals($responseContent[0]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-1.png"/>');
        $this->assertEquals($responseContent[0]->getViewMode()->getLabel(), 'Wide Banner Version 1');
        $this->assertEquals($responseContent[0]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-1.png');
        $this->assertEquals($responseContent[0]->getViewMode()->getUrl(), 'http://mysite.dev/render/front-banner/banner-wide-1');

        $this->assertEquals($responseContent[1]->getId(), 'front-banner');
        $this->assertEquals($responseContent[1]->getBaseUrl(), 'http://mysite.dev');
        $this->assertEquals($responseContent[1]->getContentConnectorId(), 'content_hub');
        $this->assertEquals($responseContent[1]->getViewMode()->getId(), 'banner-wide-2');
        $this->assertEquals($responseContent[1]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-2.png"/>');
        $this->assertEquals($responseContent[1]->getViewMode()->getLabel(), 'Wide Banner Version 2');
        $this->assertEquals($responseContent[1]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-2.png');
        $this->assertEquals($responseContent[1]->getViewMode()->getUrl(), 'http://mysite.dev/render/front-banner/banner-wide-2');

        // Verify if the TestConfig was stored correctly. We know it was an ab
        // test so we help our typehinting system here.
        /** @var \Acquia\LiftClient\Entity\TestConfigAb $testConfig */
        $testConfig = $response->getTestConfig();
        $this->assertEquals($testConfig->getProbabilities()[0]->getContentConnectorId(), 'content_hub');
        $this->assertEquals($testConfig->getProbabilities()[0]->getContentId(), 'front-banner');
        $this->assertEquals($testConfig->getProbabilities()[0]->getContentViewId(), 'banner-wide-1');
        $this->assertEquals($testConfig->getProbabilities()[0]->getFraction(), 0.3);

        $this->assertEquals($testConfig->getProbabilities()[1]->getContentConnectorId(), 'content_hub');
        $this->assertEquals($testConfig->getProbabilities()[1]->getContentId(), 'front-banner');
        $this->assertEquals($testConfig->getProbabilities()[1]->getContentViewId(), 'banner-wide-2');
        $this->assertEquals($testConfig->getProbabilities()[1]->getFraction(), 0.7);
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testRuleGetFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $manager->get('non-existing-rule');
    }
}
