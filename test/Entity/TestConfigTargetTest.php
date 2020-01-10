<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Content;
use Acquia\LiftClient\Entity\ViewMode;
use Acquia\LiftClient\Entity\TestConfigTarget;

class TestConfigTargetTest extends \PHPUnit_Framework_TestCase
{
    public function testSlotId()
    {
        $entity = new TestConfigTarget();
        $entity->setSlotId('test-slot-id');
        $this->assertEquals($entity->getSlotId(), 'test-slot-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testSlotIdNoString()
    {
        $entity = new TestConfigTarget();
        $entity->setSlotId(123);
    }

    public function testContent()
    {
        $content = new Content();
        $content->setId('content-id');
        $content->setTitle('content-title');
        $content->setBaseUrl('https://www.baseurl.com');
        
        $viewMode = new ViewMode(['label' => 'test-view-mode-label', 'url' => 'test-view-mode-url', 'html' => 'test-view-mode-html', 'preview_image' => 'test-view-mode-preview-image']);
        $viewMode->setId('view-mode-id');
        $content->setViewMode($viewMode);

        $entity = new TestConfigTarget();
        $entity->setContentList([$content]);

        $this->assertEquals($entity->getContentList()[0]->getId(), 'content-id');
        $this->assertEquals($entity->getContentList()[0]->getTitle(), 'content-title');
        $this->assertEquals($entity->getContentList()[0]->getBaseUrl(), 'https://www.baseurl.com');

        $this->assertEquals($entity->getContentList()[0]->getViewMode()->getId(), 'view-mode-id');
        $this->assertEquals($entity->getContentList()[0]->getViewMode()->getLabel(), 'test-view-mode-label');
        $this->assertEquals($entity->getContentList()[0]->getViewMode()->getHtml(), 'test-view-mode-html');
        $this->assertEquals($entity->getContentList()[0]->getViewMode()->getPreviewImage(), 'test-view-mode-preview-image');
    }
}
