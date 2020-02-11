<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\ContentView;
use Acquia\LiftClient\Entity\ViewMode;
use Acquia\LiftClient\Entity\TestConfigTarget;
use Acquia\LiftClient\Entity\TestConfigAb;

class TestConfigAbTest extends \PHPUnit_Framework_TestCase
{

    public function testVariationId()
    {
        $entity = new TestConfigAb();
        $entity->setVariationId('test-variation-id');
        $this->assertEquals($entity->getVariationId(), 'test-variation-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testVariationIdNoString()
    {
        $entity = new TestConfigAb();
        $entity->setVariationId(123);
    }

    public function testVariationLabel()
    {
        $entity = new TestConfigAb();
        $entity->setVariationLabel('test-variation-label');
        $this->assertEquals($entity->getVariationLabel(), 'test-variation-label');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testVariationLabelNoString()
    {
        $entity = new TestConfigAb();
        $entity->setVariationLabel(123);
    }

    public function testProbability()
    {
        $entity = new TestConfigAb();
        $entity->setProbability(0.55);
        $this->assertEquals($entity->getProbability(), 0.55);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be numeric
     */
    public function testProbabilityNoString()
    {
        $entity = new TestConfigAb();
        $entity->setProbability("test");
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Invalid value of probabiity
     */
    public function testProbabilityInvalidValue()
    {
        $entity = new TestConfigAb();
        $entity->setProbability(2.00);
    }

    public function testSlotList()
    {
        $content1 = new ContentView();
        $content1->setId('content-id-1');
        $content1->setTitle('content-title-1');
        $content1->setBaseUrl('https://www.baseurl.com');
        
        $viewMode1 = new ViewMode(['label' => 'test-view-mode-label', 'url' => 'test-view-mode-url', 'html' => 'test-view-mode-html', 'preview_image' => 'test-view-mode-preview-image']);
        $viewMode1->setId('view-mode-id-1');
        $content1->setViewMode($viewMode1);

        $slot1 = new TestConfigTarget();
        $slot1->setContentList([$content1]);

        $content2 = new ContentView();
        $content2->setId('content-id-2');
        $content2->setTitle('content-title-2');
        $content2->setBaseUrl('https://www.baseurl.com');
        
        $viewMode2 = new ViewMode(['label' => 'test-view-mode-label', 'url' => 'test-view-mode-url', 'html' => 'test-view-mode-html', 'preview_image' => 'test-view-mode-preview-image']);
        $viewMode2->setId('view-mode-id-2');
        $content2->setViewMode($viewMode2);

        $slot2 = new TestConfigTarget();
        $slot2->setContentList([$content2]);

        $slots = array($slot1, $slot2);

        $entity = new TestConfigAb();
        $entity->setProbability(0.5);
        $entity->setSlotList($slots);
        $this->assertEquals($entity->getProbability(), 0.5);
        $this->assertEquals(sizeof($slots), 2);
        $this->assertEquals(sizeof($entity->getSlotList()), 2);

        $ret_slots = $entity->getSlotList();
        $this->assertEquals($ret_slots[0]->getContentList()[0]->getId(), 'content-id-1');
        $this->assertEquals($ret_slots[0]->getContentList()[0]->getTitle(), 'content-title-1');
        $this->assertEquals($ret_slots[0]->getContentList()[0]->getViewMode()->getId(), 'view-mode-id-1');

        $this->assertEquals($ret_slots[1]->getContentList()[0]->getId(), 'content-id-2');
        $this->assertEquals($ret_slots[1]->getContentList()[0]->getTitle(), 'content-title-2');
        $this->assertEquals($ret_slots[1]->getContentList()[0]->getViewMode()->getId(), 'view-mode-id-2');
    }

}
