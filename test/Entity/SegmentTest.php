<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Segment;
use PHPUnit\Framework\TestCase;

class SegmentTest extends TestCase
{
    public function testSegmentGet()
    {
        $entity = new Segment(['id' => 'segment-id', 'name' => 'segment-name', 'description' => 'segment-description']);
        $this->assertEquals($entity->getId(), 'segment-id');
        $this->assertEquals($entity->getName(), 'segment-name');
        $this->assertEquals($entity->getDescription(), 'segment-description');
    }
}
