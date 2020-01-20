<?php

namespace Acquia\LiftClient\Test;

use Acquia\LiftClient\Entity\Content;
use Acquia\LiftClient\Entity\Rule;
use Acquia\LiftClient\Entity\TestConfigTarget;
use Acquia\LiftClient\Entity\TestConfigAb;
use Acquia\LiftClient\Entity\TestConfigDynamic;
use Acquia\LiftClient\Entity\ViewMode;
use DateTime;
use GuzzleHttp\Psr7\Response;

class RuleTest extends TestBase
{
    /**
     * @var Rule
     */
    private $ruleTarget;
    private $ruleAb;
    private $ruleDynamic;

    /**
     * @var array
     */
    private $ruleTargetResponseData;
    private $ruleAbResponseData;
    private $ruleDynamicResponseData;

    public function setUp()
    {
        parent::setUp();
        $this->setTestRules();
        $this->setTestRuleResponseData();
    }

    /**
     * Sets the rule object we are testing with.
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     */
    private function setTestRules()
    {

      // Setting up Target Rule
      $viewMode1 = new ViewMode();
      $viewMode1->setId('banner-wide-1');

      $contentPiece1 = new Content();
      $contentPiece1
        ->setId('front-banner-1')
        ->setTitle('front-banner-title-1')
        ->setBaseUrl('http://mysite.dev')
        ->setViewMode($viewMode1);

      $testConfigTarget1 = new TestConfigTarget();
      $testConfigTarget1
        ->setSlotId('test-slot-id-1')
        ->setContentList(array($contentPiece1));
      
      $ruleTarget = new Rule();
      $ruleTarget
        ->setId('test-target-rule-1')
        ->setLabel('test-label-1')
        ->setSegment('chrome_users')
        ->setDescription('Running test target rules in test')
        ->setPriority(10)
        ->setStatus('published')
        ->setType('target')
        ->setCampaignId('test-campaign-1')
        ->setTestConfig(array($testConfigTarget1));

      $this->ruleTarget = $ruleTarget;

      // Setting up AB Rule. We need to create two TestConfigAb objects first (re-using TestConfigTarget1 to create a new variation) 
      // Then we link the 2 TestConfigAb to the rule

      // 1st Variation
      $testConfigAb1 = new TestConfigAb();
      $testConfigAb1
        ->setVariationId('variation_A')
        ->setVariationLabel('Variation \'A\' for customer')
        ->setProbability(0.35)
        ->setSlotList(array($testConfigTarget1));

      // 2nd Variation
      $viewMode2 = new ViewMode();
      $viewMode2->setId('banner-wide-2');

      $contentPiece2 = new Content();
      $contentPiece2
        ->setId('front-banner-2')
        ->setTitle('front-banner-title-2')
        ->setBaseUrl('http://mysite2.dev')
        ->setViewMode($viewMode2);

      $testConfigTarget2 = new TestConfigTarget();
      $testConfigTarget2
        ->setSlotId('test-slot-id-1')
        ->setContentList(array($contentPiece2));

      $testConfigAb2 = new TestConfigAb();
      $testConfigAb2
      ->setVariationId('variation_B')
      ->setVariationLabel('variation \'B\' for customer')
      ->setProbability(0.65)
      ->setSlotList(array($testConfigTarget2));

      $ruleAb = new Rule();
      $ruleAb
        ->setId('test-ab-rule-2')
        ->setLabel('test-label-2')
        ->setSegment('mac_os_users')
        ->setDescription('Front page banner personalization for Mac OS')
        ->setStatus('published')
        ->setPriority(10)
        ->setType('ab')
        ->setCampaignId('test-campaign-2')
        ->setTestConfig(array($testConfigAb1, $testConfigAb2));

      $this->ruleAb = $ruleAb;

      // Creating Dynamic rule
      $viewMode3 = new ViewMode();
      $viewMode3->setId('banner-wide-3');

      $contentPiece3 = new Content();
      $contentPiece3
        ->setId('front-banner-3')
        ->setTitle('front-banner-title-3')
        ->setBaseUrl('http://mysite3.dev')
        ->setViewMode($viewMode3);

      $testConfigDynamic = new TestConfigDynamic();
      $testConfigDynamic
      ->setSlotId('test-slot-id-3')
      ->setFilterId('test-filter-id')
      ->setAlgorithm('most_viewed')
      ->setViewModeId('banner-wide-3')
      ->setCount(1)
      ->setExcludeViewedContent(true)
      ->setContentList(array($contentPiece3));

      $ruleDynamic = new Rule();
      $ruleDynamic
        ->setId('test-dynamic-rule-3')
        ->setLabel('Banner for Firefox users')
        ->setSegment('firefox_users')
        ->setDescription('Front page banner personalization for Firefox users')
        ->setStatus('published')
        ->setPriority(10)
        ->setType('dynamic')
        ->setCampaignId('test-campaign-3')
        ->setTestConfig(array($testConfigDynamic));

        $this->ruleDynamic = $ruleDynamic;
    }

    private function setTestRuleResponseData()
    {
        $contentList1 = 
          [
            'id' => 'front-banner-1',
            'title' => 'front-banner-title-1',
            'base_url' => 'http://mysite.dev',
            'view_mode' => [
              'id' => 'banner-wide-1',
              'label' => 'Wide Banner Version 1',
              'preview_image' => 'http://mysite.dev/preview-image-1.png',
              'html' => '<img src="http://mysite.dev/preview-image-1.png"/>',
            ],
          ];

        $contentList2 = 
          [
            'id' => 'front-banner-2',
            'title' => 'front-banner-title-2',
            'base_url' => 'http://mysite2.dev',
            'view_mode' => [
              'id' => 'banner-wide-2',
              'label' => 'Wide Banner Version 2',
              'preview_image' => 'http://mysite.dev/preview-image-2.png',
              'html' => '<img src="http://mysite.dev/preview-image-2.png"/>',
            ],
          ];

        $contentList3 = 
          [
            'id' => 'front-banner-3',
            'title' => 'front-banner-title-3',
            'base_url' => 'http://mysite3.dev',
            'view_mode' => [
              'id' => 'banner-wide-3',
              'label' => 'Wide Banner Version 3',
              'preview_image' => 'http://mysite.dev/preview-image-3.png',
              'html' => '<img src="http://mysite.dev/preview-image-3.png"/>',
            ],
          ];

        // Setup
        $this->ruleQueryResponseData = [
          'id' => 'test-target-rule-1',
          'label' => 'test-label-1',
          'segment' => 'chrome_users',
          'description' => 'Running test target rules in test',
          'updated' => '2020-01-13T22:04:39Z',
          'created' => '2020-01-13T22:04:39Z',
          'status' => 'published',
          'priority' => 10,
          'type' => 'target',
          'campaign_id' => 'test-campaign-1',
          'testconfig' => [
            'target' => [
              [
                'slot_id' => 'test-slot-id-1',
                'contents' => [$contentList1, $contentList2],
              ]
            ],
          ],
        ];

        $this->ruleTargetResponseData = [
          'id' => 'test-target-rule-1',
          'label' => 'test-label-1',
          'segment' => 'chrome_users',
          'description' => 'Running test target rules in test',
          'updated' => '2020-01-13T22:04:39Z',
          'created' => '2020-01-13T22:04:39Z',
          'status' => 'published',
          'priority' => 10,
          'type' => 'target',
          'campaign_id' => 'test-campaign-1',
          'testconfig' => [
            'target' => [
              [
                'slot_id' => 'test-slot-id-1',
                'contents' => [$contentList1],
              ]
            ],
          ],
        ];

        $this->ruleAbResponseData = [
          'id' => 'test-ab-rule-2',
          'label' => 'test-label-2',
          'segment' => 'mac_os_users',
          'description' => 'Front page banner personalization for Mac OS',
          'updated' => '2020-01-13T22:04:39Z',
          'created' => '2020-01-13T22:04:39Z',
          'status' => 'published',
          'priority' => 10,
          'type' => 'ab',
          'campaign_id' => 'test-campaign-2',
          'testconfig' => [
            'ab' => [
              [
                'variation_id' => 'variation_A',
                'variation_label' => 'Variation \'A\' for customer',
                'probability' => 0.35,
                'slots' => [
                  [
                    'slot_id' => 'test-slot-id-2',
                    'contents' => [$contentList1]
                  ]
                ]
              ],
              [
                'variation_id' => 'variation_B',
                'variation_label' => 'Variation \'B\' for customer',
                'probability' => 0.65,
                'slots' => [
                  [
                    'slot_id' => 'test-slot-id-2',
                    'contents' => [$contentList2]
                  ]
                ]
              ]
            ]
          ],
        ];

        $this->ruleDynamicResponseData = [
          'id' => 'test-dynamic-rule-3',
          'label' => 'Banner for Firefox users',
          'segment' => 'firefox_users',
          'description' => 'Front page banner personalization for Firefox users',
          'updated' => '2020-01-13T22:04:39Z',
          'created' => '2020-01-13T22:04:39Z',
          'status' => 'published',
          'priority' => 10,
          'type' => 'dynamic',
          'campaign_id' => 'test-campaign-3',
          'testconfig' => [
            'dynamic' => [
              [
                'slot_id' => 'test-slot-id-3',
                'filter_id' => 'test-filter-id-3',
                'algorithm' => 'most_viewed',
                'view_mode_id' => 'banner-wide-3',
                'count' => 1,
                'exclude_viewed_content' => true,
                'contents' => [$contentList3]
              ]
            ]
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

    public function testTargetRuleAdd()
    {
        $response = new Response(200, [], json_encode($this->ruleTargetResponseData));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $response = $manager->add($this->ruleTarget);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/v2/rules?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getId(), 'test-target-rule-1');
        $this->assertEquals($response->getLabel(), 'test-label-1');
        $this->assertEquals($response->getSegment(), 'chrome_users');
        $this->assertEquals($response->getDescription(), 'Running test target rules in test');
        $this->assertEquals($response->getPriority(), 10);
        $this->assertEquals($response->getStatus(), 'published');
        $this->assertEquals($response->getType(), 'target');
        $this->assertEquals($response->getCampaignId(), 'test-campaign-1');

        // Check if the timestamp for created is as expected.
        $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

        // Check if the timestamp for updated is as expected.
        $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

        // Check for the response content
        $testConfig = $response->getTestConfig();
        $this->assertEquals(sizeof($testConfig), 1);

        $type = get_class($testConfig[0]);
        $this->assertEquals($type, 'Acquia\LiftClient\Entity\TestConfigTarget');
        $this->assertEquals($testConfig[0]->getSlotId(), 'test-slot-id-1');

        $content = $testConfig[0]->getContentList();
        $this->assertEquals($content[0]->getId(), 'front-banner-1');
        $this->assertEquals($content[0]->getTitle(), 'front-banner-title-1');
        $this->assertEquals($content[0]->getBaseUrl(), 'http://mysite.dev');
        $this->assertEquals($content[0]->getViewMode()->getId(), 'banner-wide-1');
        $this->assertEquals($content[0]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-1.png"/>');
        $this->assertEquals($content[0]->getViewMode()->getLabel(), 'Wide Banner Version 1');
        $this->assertEquals($content[0]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-1.png');
    }

    public function testAbRuleAdd()
    {
        $response = new Response(200, [], json_encode($this->ruleAbResponseData));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $response = $manager->add($this->ruleAb);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/v2/rules?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getId(), 'test-ab-rule-2');
        $this->assertEquals($response->getLabel(), 'test-label-2');
        $this->assertEquals($response->getSegment(), 'mac_os_users');
        $this->assertEquals($response->getDescription(), 'Front page banner personalization for Mac OS');
        $this->assertEquals($response->getPriority(), 10);
        $this->assertEquals($response->getStatus(), 'published');
        $this->assertEquals($response->getType(), 'ab');
        $this->assertEquals($response->getCampaignId(), 'test-campaign-2');

        // Check if the timestamp for created is as expected.
        $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

        // Check if the timestamp for updated is as expected.
        $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

        // Check for the response content
        $testConfig = $response->getTestConfig();
        $this->assertEquals(sizeof($testConfig), 2);

        $type = get_class($testConfig[0]);
        $this->assertEquals($type, 'Acquia\LiftClient\Entity\TestConfigAb');
        $this->assertEquals($testConfig[0]->getVariationId(), 'variation_A');
        $this->assertEquals($testConfig[0]->getVariationLabel(), 'Variation \'A\' for customer');
        $this->assertEquals($testConfig[0]->getProbability(), 0.35);

        $slotList = $testConfig[0]->getSlotList();
        $this->assertEquals($slotList[0]->getSlotId(), 'test-slot-id-2');

        $content1 = $slotList[0]->getContentList();
        $this->assertEquals($content1[0]->getId(), 'front-banner-1');
        $this->assertEquals($content1[0]->getTitle(), 'front-banner-title-1');
        $this->assertEquals($content1[0]->getBaseUrl(), 'http://mysite.dev');
        $this->assertEquals($content1[0]->getViewMode()->getId(), 'banner-wide-1');
        $this->assertEquals($content1[0]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-1.png"/>');
        $this->assertEquals($content1[0]->getViewMode()->getLabel(), 'Wide Banner Version 1');
        $this->assertEquals($content1[0]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-1.png');

        $type = get_class($testConfig[1]);
        $this->assertEquals($type, 'Acquia\LiftClient\Entity\TestConfigAb');
        $this->assertEquals($testConfig[1]->getVariationId(), 'variation_B');
        $this->assertEquals($testConfig[1]->getVariationLabel(), 'Variation \'B\' for customer');
        $this->assertEquals($testConfig[1]->getProbability(), 0.65);

        $slotList = $testConfig[1]->getSlotList();
        $this->assertEquals($slotList[0]->getSlotId(), 'test-slot-id-2');

        $content2 = $slotList[0]->getContentList();
        $this->assertEquals($content2[0]->getId(), 'front-banner-2');
        $this->assertEquals($content2[0]->getTitle(), 'front-banner-title-2');
        $this->assertEquals($content2[0]->getBaseUrl(), 'http://mysite2.dev');
        $this->assertEquals($content2[0]->getViewMode()->getId(), 'banner-wide-2');
        $this->assertEquals($content2[0]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-2.png"/>');
        $this->assertEquals($content2[0]->getViewMode()->getLabel(), 'Wide Banner Version 2');
        $this->assertEquals($content2[0]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-2.png');
    }

    public function testDynamicRuleAdd()
    {
        $response = new Response(200, [], json_encode($this->ruleDynamicResponseData));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $response = $manager->add($this->ruleDynamic);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals((string) $request->getUri(), '/v2/rules?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getId(), 'test-dynamic-rule-3');
        $this->assertEquals($response->getLabel(), 'Banner for Firefox users');
        $this->assertEquals($response->getSegment(), 'firefox_users');
        $this->assertEquals($response->getDescription(), 'Front page banner personalization for Firefox users');
        $this->assertEquals($response->getPriority(), 10);
        $this->assertEquals($response->getStatus(), 'published');
        $this->assertEquals($response->getType(), 'dynamic');
        $this->assertEquals($response->getCampaignId(), 'test-campaign-3');

        // Check if the timestamp for created is as expected.
        $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

        // Check if the timestamp for updated is as expected.
        $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

        // Check for the response content
        $testConfig = $response->getTestConfig();
        $this->assertEquals(sizeof($testConfig), 1);

        $type = get_class($testConfig[0]);
        $this->assertEquals($type, 'Acquia\LiftClient\Entity\TestConfigDynamic');
        $this->assertEquals($testConfig[0]->getSlotId(), 'test-slot-id-3');
        $this->assertEquals($testConfig[0]->getFilterId(), 'test-filter-id-3');
        $this->assertEquals($testConfig[0]->getAlgorithm(), 'most_viewed');
        $this->assertEquals($testConfig[0]->getViewModeId(), 'banner-wide-3');
        $this->assertEquals($testConfig[0]->getCount(), 1);
        $this->assertEquals($testConfig[0]->getExcludeViewedContent(), true);

        $content = $testConfig[0]->getContentList();
        $this->assertEquals($content[0]->getId(), 'front-banner-3');
        $this->assertEquals($content[0]->getTitle(), 'front-banner-title-3');
        $this->assertEquals($content[0]->getBaseUrl(), 'http://mysite3.dev');
        $this->assertEquals($content[0]->getViewMode()->getId(), 'banner-wide-3');
        $this->assertEquals($content[0]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-3.png"/>');
        $this->assertEquals($content[0]->getViewMode()->getLabel(), 'Wide Banner Version 3');
        $this->assertEquals($content[0]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-3.png');
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
        $manager->add($this->ruleTarget, []);
    }

    public function testRulePatch()
    {
        $response = new Response(200, [], json_encode($this->ruleTargetResponseData));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        $option = [
          'context_language' => 'en',
          'cdf_version' => '2'
      ];

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $response = $manager->patch($this->ruleTarget, $option);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'PATCH');
        $this->assertEquals((string) $request->getUri(), '/v2/rules/test-target-rule-1?context_language=en&cdf_version=2&account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getId(), 'test-target-rule-1');
        $this->assertEquals($response->getLabel(), 'test-label-1');
        $this->assertEquals($response->getSegment(), 'chrome_users');
        $this->assertEquals($response->getDescription(), 'Running test target rules in test');
        $this->assertEquals($response->getPriority(), 10);
        $this->assertEquals($response->getStatus(), 'published');
        $this->assertEquals($response->getType(), 'target');
        $this->assertEquals($response->getCampaignId(), 'test-campaign-1');

        // Check if the timestamp for created is as expected.
        $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

        // Check if the timestamp for updated is as expected.
        $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

        // Check for the response content
        $testConfig = $response->getTestConfig();
        $this->assertEquals(sizeof($testConfig), 1);

        $type = get_class($testConfig[0]);
        $this->assertEquals($type, 'Acquia\LiftClient\Entity\TestConfigTarget');
        $this->assertEquals($testConfig[0]->getSlotId(), 'test-slot-id-1');

        $content = $testConfig[0]->getContentList();
        $this->assertEquals($content[0]->getId(), 'front-banner-1');
        $this->assertEquals($content[0]->getTitle(), 'front-banner-title-1');
        $this->assertEquals($content[0]->getBaseUrl(), 'http://mysite.dev');
        $this->assertEquals($content[0]->getViewMode()->getId(), 'banner-wide-1');
        $this->assertEquals($content[0]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-1.png"/>');
        $this->assertEquals($content[0]->getViewMode()->getLabel(), 'Wide Banner Version 1');
        $this->assertEquals($content[0]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-1.png');
    }

    public function testRuleDeleteById()
    {
        $response = new Response(200, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $response = $manager->deleteById('rule-to-delete');
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'DELETE');
        $this->assertEquals((string) $request->getUri(), '/v2/rules/rule-to-delete?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertTrue($response, 'Rule Deletion succeeded');
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
        $response = $manager->delete();
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'DELETE');
        $this->assertEquals((string) $request->getUri(), '/v2/rules?account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertTrue($response, 'Rule Deletion succeeded');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testRuleDeleteByIdFailed()
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
        $manager->delete();
    }

    public function testRuleQuery()
    {
        $data = [
          $this->ruleQueryResponseData,
        ];
        $response = new Response(200, [], json_encode($data));

        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $option = [
            'context_language' => 'en',
            'cdf_version' => '2',
            'visible_on_page' => 'my_page',
            'prefetch' => 'true',
            'sort' => 'desc',
            'start' => '4',
            'rows' => '20',
            'sort_field' => 'updated',
            'status' => 'unpublished',
            'slot_id' => 'test-slot-id-1',
            'unrelated_option_name' => 'unrelated_option_value',
        ];

        $responses = $manager->query($option);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/v2/rules?context_language=en&cdf_version=2&prefetch=true&sort=desc&start=4&rows=20&sort_field=updated&status=unpublished&slot_id=test-slot-id-1&account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        foreach ($responses as $response) {
            // Check for basic fields
            $this->assertEquals($response->getId(), 'test-target-rule-1');
            $this->assertEquals($response->getLabel(), 'test-label-1');
            $this->assertEquals($response->getSegment(), 'chrome_users');
            $this->assertEquals($response->getDescription(), 'Running test target rules in test');
            $this->assertEquals($response->getPriority(), 10);
            $this->assertEquals($response->getStatus(), 'published');
            $this->assertEquals($response->getType(), 'target');
            $this->assertEquals($response->getCampaignId(), 'test-campaign-1');

            // Check if the timestamp for created is as expected.
            $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

            // Check if the timestamp for updated is as expected.
            $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

            // Check for the response content
            $testConfig = $response->getTestConfig();
            $this->assertEquals(sizeof($testConfig), 1);

            $type = get_class($testConfig[0]);
            $this->assertEquals($type, 'Acquia\LiftClient\Entity\TestConfigTarget');
            $this->assertEquals($testConfig[0]->getSlotId(), 'test-slot-id-1');

            $content = $testConfig[0]->getContentList();
            $this->assertEquals(sizeof($content), 2);

            $this->assertEquals($content[0]->getId(), 'front-banner-1');
            $this->assertEquals($content[0]->getTitle(), 'front-banner-title-1');
            $this->assertEquals($content[0]->getBaseUrl(), 'http://mysite.dev');
            $this->assertEquals($content[0]->getViewMode()->getId(), 'banner-wide-1');
            $this->assertEquals($content[0]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-1.png"/>');
            $this->assertEquals($content[0]->getViewMode()->getLabel(), 'Wide Banner Version 1');
            $this->assertEquals($content[0]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-1.png');            
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
        $response = new Response(200, [], json_encode($this->ruleTargetResponseData));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        $option = [
          'context_language' => 'en',
          'cdf_version' => '2'
      ];

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $response = $manager->get('test-target-rule-1', $option);
        $request = $this->mockHandler->getLastRequest();

        // Check for request configuration
        $this->assertEquals($request->getMethod(), 'GET');
        $this->assertEquals((string) $request->getUri(), '/v2/rules/test-target-rule-1?context_language=en&cdf_version=2&account_id=TESTACCOUNTID&site_id=TESTSITEID');

        $requestHeaders = $request->getHeaders();
        $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

        // Check for response basic fields
        $this->assertEquals($response->getId(), 'test-target-rule-1');
        $this->assertEquals($response->getLabel(), 'test-label-1');
        $this->assertEquals($response->getSegment(), 'chrome_users');
        $this->assertEquals($response->getDescription(), 'Running test target rules in test');
        $this->assertEquals($response->getPriority(), 10);
        $this->assertEquals($response->getStatus(), 'published');
        $this->assertEquals($response->getType(), 'target');
        $this->assertEquals($response->getCampaignId(), 'test-campaign-1');

        // Check if the timestamp for created is as expected.
        $this->assertEquals($response->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

        // Check if the timestamp for updated is as expected.
        $this->assertEquals($response->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-13T22:04:39Z'));

        // Check for the response content
        $testConfig = $response->getTestConfig();
        $this->assertEquals(sizeof($testConfig), 1);

        $type = get_class($testConfig[0]);
        $this->assertEquals($type, 'Acquia\LiftClient\Entity\TestConfigTarget');
        $this->assertEquals($testConfig[0]->getSlotId(), 'test-slot-id-1');

        $content = $testConfig[0]->getContentList();
        $this->assertEquals($content[0]->getId(), 'front-banner-1');
        $this->assertEquals($content[0]->getTitle(), 'front-banner-title-1');
        $this->assertEquals($content[0]->getBaseUrl(), 'http://mysite.dev');
        $this->assertEquals($content[0]->getViewMode()->getId(), 'banner-wide-1');
        $this->assertEquals($content[0]->getViewMode()->getHtml(), '<img src="http://mysite.dev/preview-image-1.png"/>');
        $this->assertEquals($content[0]->getViewMode()->getLabel(), 'Wide Banner Version 1');
        $this->assertEquals($content[0]->getViewMode()->getPreviewImage(), 'http://mysite.dev/preview-image-1.png');
    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 404
     */
    public function testRuleGetFailed()
    {
        $response = new Response(404, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Rule Manager
        $manager = $client->getRuleManager();
        $manager->get('non-existing-rule');
    }
}
