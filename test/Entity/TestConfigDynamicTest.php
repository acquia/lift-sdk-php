<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\ContentView;
use Acquia\LiftClient\Entity\TestConfigDynamic;
use Acquia\LiftClient\Entity\ViewMode;
use PHPUnit\Framework\TestCase;

class TestConfigDynamicTest extends TestCase
{
    public function testSlotId()
    {
        $entity = new TestConfigDynamic();
        $entity->setSlotId('test-slot-id');
        $this->assertEquals($entity->getSlotId(), 'test-slot-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testSlotIdNoString()
    {
        $entity = new TestConfigDynamic();
        $entity->setSlotId(123);
    }

    public function testFilterId()
    {
        $entity = new TestConfigDynamic();
        $entity->setFilterId('test-filter-id');
        $this->assertEquals($entity->getFilterId(), 'test-filter-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testFilterIdNoString()
    {
        $entity = new TestConfigDynamic();
        $entity->setFilterId(123);
    }

    public function testAlgorithm()
    {
        $entity = new TestConfigDynamic();
        $entity->setAlgorithm('most_viewed');
        $this->assertEquals($entity->getAlgorithm(), 'most_viewed');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testAlgorithmNoString()
    {
        $entity = new TestConfigDynamic();
        $entity->setAlgorithm(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Algorithm (most_common) is not supported for dynamic rules.
     */
    public function testAlgorithmInvalid()
    {
        $entity = new TestConfigDynamic();
        $entity->setAlgorithm('most_common');
    }

    public function testViewModeId()
    {
        $entity = new TestConfigDynamic();
        $entity->setViewModeId('test-view-mode-id');
        $this->assertEquals($entity->getViewModeId(), 'test-view-mode-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testViewModeIdNoString()
    {
        $entity = new TestConfigDynamic();
        $entity->setViewModeId(123);
    }

    public function testCount()
    {
        $entity = new TestConfigDynamic();
        $entity->setCount(14);
        $this->assertEquals($entity->getCount(), 14);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of integer.
     */
    public function testCountNoInteger()
    {
        $entity = new TestConfigDynamic();
        $entity->setCount("test");
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Value must be a positive integer
     */
    public function testCountNegativeInteger()
    {
        $entity = new TestConfigDynamic();
        $entity->setCount(-1);
    }

    public function testExcludeViewedContent()
    {
        $entity = new TestConfigDynamic();
        $entity->setExcludeViewedContent(true);
        $this->assertEquals($entity->getExcludeViewedContent(), true);

        $entity->setExcludeViewedContent(false);
        $this->assertEquals($entity->getExcludeViewedContent(), false);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of boolean.
     */
    public function testExcludeViewedContentNoBoolean()
    {
        $entity = new TestConfigDynamic();
        $entity->setExcludeViewedContent("test");
    }

    public function testContentList(){
        $content = new ContentView();
        $content->setId('content-id');
        $content->setTitle('content-title');
        $content->setBaseUrl('https://www.baseurl.com');
        
        $viewMode = new ViewMode(['label' => 'test-view-mode-label', 'url' => 'test-view-mode-url', 'html' => 'test-view-mode-html', 'preview_image' => 'test-view-mode-preview-image']);
        $viewMode->setId('view-mode-id');
        $content->setViewMode($viewMode);

        $entity = new TestConfigDynamic();
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
