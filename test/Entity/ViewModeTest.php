<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Slot;
use Acquia\LiftClient\Entity\ViewMode;

class ViewModeTest extends \PHPUnit_Framework_TestCase
{
    public function testId()
    {
        $entity = new ViewMode();
        $entity->setId('test-slot-id');
        $this->assertEquals($entity->getId(), 'test-slot-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIdNoString()
    {
        $entity = new ViewMode();
        $entity->setId(123);
    }

    public function testLabel()
    {
        $entity = new ViewMode(['label' => 'test-view-mode-label']);
        $this->assertEquals($entity->getLabel(), 'test-view-mode-label');
    }

    public function testHtml()
    {
        $entity = new ViewMode(['html' => 'test-view-mode-html']);
        $this->assertEquals($entity->getHtml(), 'test-view-mode-html');
    }

    public function testPreviewImage()
    {
        $entity = new ViewMode(['preview_image' => 'test-view-mode-preview-image']);
        $this->assertEquals($entity->getPreviewImage(), 'test-view-mode-preview-image');
    }
}
