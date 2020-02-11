<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\ContentView;
use Acquia\LiftClient\Entity\ViewMode;
use DateTime;

class ContentViewTest extends \PHPUnit_Framework_TestCase
{
    public function testId()
    {
        $entity = new ContentView();
        $entity->setId('test-id');
        $this->assertEquals($entity->getId(), 'test-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIdNoString()
    {
        $entity = new ContentView();
        $entity->setId(123);
    }

    public function testTitle()
    {
        $entity = new ContentView();
        $entity->setTitle('content-title');
        $this->assertEquals($entity->getTitle(), 'content-title');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testTitleNoString()
    {
        $entity = new ContentView();
        $entity->setTitle(123);
    }

    public function testBaseUrl()
    {
        $entity = new ContentView();
        $entity->setBaseUrl('test-base-url');
        $this->assertEquals($entity->getBaseUrl(), 'test-base-url');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testBaseUrlNoString()
    {
        $entity = new ContentView();
        $entity->setBaseUrl(123);
    }

    public function testViewMode()
    {
        $viewMode = new ViewMode();
        $viewMode->setId('test-view-mode-id');
        $entity = new ContentView();
        $entity->setViewMode($viewMode);
        $this->assertEquals($entity->getViewMode()->getId(), 'test-view-mode-id');
    }
}
