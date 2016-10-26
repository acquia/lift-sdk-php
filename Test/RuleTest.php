<?php

namespace Acquia\LiftClient\Test;

use Acquia\LiftClient\Entity\Content;
use Acquia\LiftClient\Entity\Probability;
use Acquia\LiftClient\Entity\Rule;
use Acquia\LiftClient\Entity\TestConfigAb;
use Acquia\LiftClient\Entity\ViewMode;
use DateTime;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;

class RuleTest extends TestBase
{

    public function getRuleTestObject() {
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
          ->setSegment('belgians')
          ->setWeight(10)
          ->setContent([$contentPiece1, $contentPiece2])
          ->setTestConfig($testConfig);

        return $rule;
    }

    public function testRuleAdd()
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
              'url' => 'http://mysite.dev/render/front-banner-1/banner-wide-1',
              'html'=> '<img src="http://mysite.dev/preview-image-1.png"/>',
            ]
          ],
          [
            'id' => 'front-banner',
            'content_connector_id' => 'content_hub',
            'base_url' => 'http://mysite.dev',
            'view_mode' => [
              'id' => 'banner-wide-2',
              'label' => 'Wide Banner Version 2',
              'preview_image' => 'http://mysite.dev/preview-image-2.png',
              'url' => 'http://mysite.dev/render/front-banner-1/banner-wide-2',
              'html'=> '<img src="http://mysite.dev/preview-image-2.png"/>',
            ]
          ],
        ];
        // Setup
        $data = [
            'id' => 'rule-1',
            'label' => 'Banner for Belgians',
            'description' => 'Front page banner personalization for Belgians',
            'slot_id' => 'slot-1',
            'updated' => '2016-01-05T22:04:39Z',
            'created' => '2016-01-05T22:04:39Z',
            'status' => 'published',
            'segment' => 'belgians',
            'weight' => 10,
            'content' => $contentList,
            'testconfig' => [
                'ab' => [
                    'probabilities' => [
                        [
                            'id' => 'front-banner',
                            'content_connector_id' => 'content_hub',
                            'content_view_id' => 'banner-wide-1',
                            'fraction' => 0.3
                        ],
                        [
                            'id' => 'front-banner',
                            'content_connector_id' => 'content_hub',
                            'content_view_id' => 'banner-wide-2',
                            'fraction' => 0.7
                        ]
                    ]
                ]
            ]
        ];

        $response = new Response(200, [], json_encode($data));
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);



        // Get Slot Manager
        $rule = $this->getRuleTestObject();
        $manager = $client->getRuleManager();
        $response = $manager->add($rule);

        // Do the validation
        $this->assertEquals($response->getId(), $rule->getId());
        $this->assertEquals($response->getLabel(), $rule->getLabel());
        $this->assertEquals($response->getDescription(), $rule->getDescription());
        $this->assertEquals($response->getSlotId(), $rule->getSlotId());
        $this->assertEquals($response->getStatus(), $rule->getStatus());
        $this->assertEquals($response->getSegment(), $rule->getSegment());
        $this->assertEquals($response->getWeight(), $rule->getWeight());

        // Verify if the Rule that we added came back from the response
        $responseContent = $response->getContent();
        $this->assertEquals($responseContent[0]->getId(), $contentPiece1->getId());
        $this->assertEquals($responseContent[0]->getBaseUrl(), $contentPiece1->getBaseUrl());
        $this->assertEquals($responseContent[0]->getContentConnectorId(), $contentPiece1->getContentConnectorId());
        $this->assertEquals($responseContent[0]->getViewMode()->getId(), $viewMode1->getId());

        $this->assertEquals($responseContent[1]->getId(), $contentPiece2->getId());
        $this->assertEquals($responseContent[1]->getBaseUrl(), $contentPiece2->getBaseUrl());
        $this->assertEquals($responseContent[1]->getContentConnectorId(), $contentPiece2->getContentConnectorId());
        $this->assertEquals($responseContent[1]->getViewMode()->getId(), $viewMode2->getId());

        // Verify if the TestConfig was stored correctly
        $this->assertEquals($response->getTestConfig(), $rule->getTestConfig());

        // Check if the timestamp for created is as expected.
        $this->assertEquals(
          $response->getCreated(),
          DateTime::createFromFormat(DateTime::ISO8601, '2016-01-05T22:04:39Z')
        );

        // Check if the timestamp for updated is as expected.
        $this->assertEquals(
          $response->getUpdated(),
          DateTime::createFromFormat(DateTime::ISO8601, '2016-01-05T22:04:39Z')
        );


    }

    public function testRuleAddFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        $rule = $this->getRuleTestObject();

        // Get Rule Manager
        $manager = $client->getRuleManager();
        try {
            $manager->add($rule);
        } catch (RequestException $e) {
            $this->assertEquals($e->getResponse()->getStatusCode(), 400);
        }
    }

    /*public function testRuleDelete()
    {
        $response = new Response(200, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Manager
        $manager = $client->getGoalManager();
        $response = $manager->delete('goal-to-delete');
        $this->assertTrue($response, 'Goal Deletion succeeded');
    }

    public function testRuleDeleteFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Manager
        $manager = $client->getGoalManager();
        try {
            $manager->delete('goal-to-delete');
        } catch (RequestException $e) {
            $this->assertEquals($e->getResponse()->getStatusCode(), 400);
        }
    }

    public function testRuleQuery()
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

        // Get manager
        $manager = $client->getGoalManager();
        $responses = $manager->query();
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

    public function testRuleQueryFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $manager = $client->getGoalManager();
        try {
            $manager->query();
        } catch (RequestException $e) {
            $this->assertEquals($e->getResponse()->getStatusCode(), 400);
        }
    }

    public function testRuleGet()
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

        // Get Manager
        $manager = $client->getGoalManager();
        $response = $manager->get('test-id');

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

    public function testRuleGetFailed()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get Slot Manager
        $manager = $client->getGoalManager();
        try {
            $manager->get('non-existing-slot');
        } catch (RequestException $e) {
            $this->assertEquals($e->getResponse()->getStatusCode(), 400);
        }
    }*/
}
