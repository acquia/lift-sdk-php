<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Content;
use Acquia\LiftClient\Entity\ViewMode;

class ContentTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultContentHub()
    {
        $entity = new Content();
        $this->assertEquals($entity->getContentConnectorId(), 'content_hub');
    }

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

    public function testContentConnectorId()
    {
        $entity = new Content();
        $entity->setContentConnectorId('test-cc-id');
        $this->assertEquals($entity->getContentConnectorId(), 'test-cc-id');
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

    public function testViewMode()
    {
        $viewMode = new ViewMode();
        $viewMode->setId('test-view-mode-id');
        $entity = new Content();
        $entity->setViewMode($viewMode);
        $this->assertEquals($entity->getViewMode()->getId(), 'test-view-mode-id');
    }

    public function testError()
    {
        $entity = new Content(['error' => ['code' => 10, 'message' => 'Error in fetching content']]);
        $this->assertEquals($entity->getError()->getCode(), 10);
        $this->assertEquals($entity->getError()->getMessage(), 'Error in fetching content');
    }
}
