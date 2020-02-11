<?php

namespace Acquia\LiftClient\Test;

use GuzzleHttp\Psr7\Response;
use DateTime;

class SearchTest extends TestBase
{
    public function testHandlerStack() {
        $response = new Response(200, [], json_encode([]));

        $responses = [
          $response,
        ];
        $client = $this->getClient($responses);

        // Get Search Manager
        $manager = $client->getSearchManager();

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
     * Testing get list of sites associated on account id
     */
    public function testGetSearch()
    {
      $data = [
        [
          "id" => "front-banner-1",
          "title" => "Front Banner 1",
          "content_connector_id" => "nicks_content_hub_identifier",
          "updated" => "2020-01-28T22:04:39Z",
          "created" => "2020-01-28T22:04:39Z",
          "base_url" => "http://nickveenhof.be",
          "view_modes" => [
            [
              "id" => "banner-wide",
              "label" => "Banner Wide",
              "preview_image" => "http://nickveenhof.be/sites/all/default/files/preview-banner-wide-1.png",
              "html" => "<img src=\"nickveenhof.be/sites/all/files/banner-wide-something-something-1.png\"/>"
            ],
            [
              "id" => "banner-small",
              "label" => "Banner Small",
              "preview_image" => "http://nickveenhof.be/sites/all/default/files/preview-banner-small-1.png",
              "html" => "<img src=\"nickveenhof.be/sites/all/files/banner-small-something-something-1.png\"/>"
            ]
          ]
        ],
        [
          "id" => "some-banner",
          "title" => "some banner",
          "content_connector_id" => "nicks_local_file_identifier",
          "updated" => "2020-01-28T22:04:39Z",
          "created" => "2020-01-28T22:04:39Z",
          "base_url" => "http://localhost",
          "view_modes" => [
            [
              "id" => "banner-random",
              "label" => "Banner Random",
              "preview_image" => "localhost/banner-random.png",
              "html" => "<img src=\"localhost/banner-random.png\"/>"
            ]
          ]
        ]
      ];

      $response = new Response(200, [], json_encode($data));
      $responses = [
        $response,
      ];

      $client = $this->getClient($responses);

      $options = [
        'cdf_version' => '2',
        'context_language' => 'en',
        'prefetch' => true,
        'sort' => false,
        'start' => 0,
        'rows' => 10,
        'q' => 'test',
        'view_mode' => 'teaser',
        'content_type' => 'text',
        'origins' => 'home',
        'tags' => 'drupal_8',
        'date_start' => '2019-10-28',
        'date_end' => '2020-02-01',
        'date_timezone' => '-05:00'
      ];

      // Get Search Manager
      $manager = $client->getSearchManager();
      $responses = $manager->get($options);
      $request = $this->mockHandler->getLastRequest();

      // Check for request configuration
      $this->assertEquals($request->getMethod(), 'GET');
      $this->assertEquals((string) $request->getUri(), '/v2/search?context_language=en&cdf_version=2&prefetch=1&sort=&start=0&rows=10&q=test&view_mode=teaser&content_type=text&origins=home&tags=drupal_8&date_start=2019-10-28&date_end=2020-02-01&date_timezone=-05%3A00&account_id=TESTACCOUNTID&site_id=TESTSITEID');

      $requestHeaders = $request->getHeaders();
      $this->assertEquals($requestHeaders['Content-Type'][0], 'application/json');

      $this->assertEquals(sizeof($responses), 2);
      $this->assertEquals($responses[0]->getId(), "front-banner-1");
      $this->assertEquals($responses[0]->getTitle(), "Front Banner 1");
      $this->assertEquals($responses[0]->getContentConnectorId(), "nicks_content_hub_identifier");
      $this->assertEquals($responses[0]->getCreated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-28T22:04:39Z'));
      $this->assertEquals($responses[0]->getUpdated(), DateTime::createFromFormat(DateTime::ATOM, '2020-01-28T22:04:39Z'));
      $this->assertEquals($responses[0]->getBaseUrl(), "http://nickveenhof.be");
      $this->assertEquals(sizeof($responses[0]->getViewModes()), 2);

      $viewMode = $responses[0]->getViewModes()[0];
      $this->assertEquals($viewMode->getId(), "banner-wide");
      $this->assertEquals($viewMode->getLabel(), "Banner Wide");
      $this->assertEquals($viewMode->getPreviewImage(), "http://nickveenhof.be/sites/all/default/files/preview-banner-wide-1.png");
      $this->assertEquals($viewMode->getHtml(), "<img src=\"nickveenhof.be/sites/all/files/banner-wide-something-something-1.png\"/>");

      $viewMode = $responses[0]->getViewModes()[1];
      $this->assertEquals($viewMode->getId(), "banner-small");
      $this->assertEquals($viewMode->getLabel(), "Banner Small");
      $this->assertEquals($viewMode->getPreviewImage(), "http://nickveenhof.be/sites/all/default/files/preview-banner-small-1.png");
      $this->assertEquals($viewMode->getHtml(), "<img src=\"nickveenhof.be/sites/all/files/banner-small-something-something-1.png\"/>");

      $this->assertEquals(sizeof($responses[1]->getViewModes()), 1);
      $viewMode = $responses[1]->getViewModes()[0];
      $this->assertEquals($viewMode->getId(), "banner-random");
      $this->assertEquals($viewMode->getLabel(), "Banner Random");
      $this->assertEquals($viewMode->getPreviewImage(), "localhost/banner-random.png");
      $this->assertEquals($viewMode->getHtml(), "<img src=\"localhost/banner-random.png\"/>");


    }

    /**
     * @expectedException     \GuzzleHttp\Exception\RequestException
     * @expectedExceptionCode 400
     */
    public function testGetSearchError()
    {
        $response = new Response(400, []);
        $responses = [
          $response,
        ];

        $client = $this->getClient($responses);

        // Get ViewMode Manager
        $manager = $client->getSearchManager();
        $manager->get();
    }
}
