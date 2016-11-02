<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Segment;

class SegmentTest extends \PHPUnit_Framework_TestCase
{
    public function testSegmentGet()
    {
        $entity = new Segment(['id' => 'segment-id', 'name' => 'segment-name', 'description' => 'segment-description']);
        $this->assertEquals($entity->getId(), 'segment-id');
        $this->assertEquals($entity->getName(), 'segment-name');
        $this->assertEquals($entity->getDescription(), 'segment-description');
    }
}
