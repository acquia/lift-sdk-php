<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Content;
use Acquia\LiftClient\Entity\ViewMode;
use DateTime;
use PHPUnit\Framework\TestCase;

class ContentTest extends TestCase
{
    public function testId()
    {
        $entity = new Content();
        $entity->setId('test-id');
        $this->assertEquals($entity->getId(), 'test-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIdNoString()
    {
        $entity = new Content();
        $entity->setId(123);
    }

    public function testTitle()
    {
        $entity = new Content();
        $entity->setTitle('content-title');
        $this->assertEquals($entity->getTitle(), 'content-title');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testTitleNoString()
    {
        $entity = new Content();
        $entity->setTitle(123);
    }

    public function testContentConnectorId()
    {
        $entity = new Content();
        $entity->setContentConnectorId('test-content-connector-id');
        $this->assertEquals($entity->getContentConnectorId(), 'test-content-connector-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentConnectorIdNoString()
    {
        $entity = new Content();
        $entity->setContentConnectorId(123);
    }

    public function testCreated()
    {
        $date = DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z');
        $entity = new Content(['created' => '2016-01-05T22:04:39Z']);
        $this->assertEquals($entity->getCreated(), $date);
    }

    public function testUpdated()
    {
        $date = DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z');
        $entity = new Content(['updated' => '2016-01-05T22:04:39Z']);
        $this->assertEquals($entity->getUpdated(), $date);
    }

    public function testBaseUrl()
    {
        $entity = new Content();
        $entity->setBaseUrl('test-base-url');
        $this->assertEquals($entity->getBaseUrl(), 'test-base-url');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testBaseUrlNoString()
    {
        $entity = new Content();
        $entity->setBaseUrl(123);
    }

    public function testViewModes()
    {
        $viewMode1 = new ViewMode();
        $viewMode1->setId('test-view-mode-1');

        $viewMode2 = new ViewMode();
        $viewMode2->setId('test-view-mode-2');

        $viewModes = [$viewMode1, $viewMode2];

        $entity = new Content();
        $entity->setViewModes($viewModes);
        $this->assertEquals(sizeof($entity->getViewModes()), 2);
        $this->assertEquals($entity->getViewModes()[0]->getId(), 'test-view-mode-1');
        $this->assertEquals($entity->getViewModes()[1]->getId(), 'test-view-mode-2');

    }
}
