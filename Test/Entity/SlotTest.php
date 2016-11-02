<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Slot;
use Acquia\LiftClient\Entity\Visibility;
use DateTime;

class SlotTest extends \PHPUnit_Framework_TestCase
{
    public function testId()
    {
        $entity = new Slot();
        $entity->setId('test-slot-id');
        $this->assertEquals($entity->getId(), 'test-slot-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIdNoString()
    {
        $entity = new Slot();
        $entity->setId(123);
    }

    public function testLabel()
    {
        $entity = new Slot();
        $entity->setLabel('test-slot-label');
        $this->assertEquals($entity->getLabel(), 'test-slot-label');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testLabelNoString()
    {
        $entity = new Slot();
        $entity->setLabel(123);
    }

    public function testDescription()
    {
        $entity = new Slot();
        $entity->setDescription('test-slot-description');
        $this->assertEquals($entity->getDescription(), 'test-slot-description');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDescriptionNoString()
    {
        $entity = new Slot();
        $entity->setDescription(123);
    }

    public function testStatus()
    {
        $entity = new Slot();
        $entity->setStatus(true);
        $this->assertEquals($entity->getStatus(), true);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of boolean.
     */
    public function testStatusNoBoolean()
    {
        $entity = new Slot();
        $entity->setStatus(123);
    }

    public function testVisibility()
    {
        $entity = new Slot();
        $visibility = new Visibility();
        $visibility->setCondition('show');
        $visibility->setPages(['node/1']);
        $entity->setVisibility($visibility);
        $this->assertEquals($entity->getVisibility()->getCondition(), 'show');
        $this->assertEquals($entity->getVisibility()->getPages(), ['node/1']);
    }

    public function testUpdated()
    {
        $date = DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z');
        $entity = new Slot(['updated' => '2016-01-05T22:04:39Z']);
        $this->assertEquals($entity->getUpdated(), $date);
    }

    public function testCreated()
    {
        $date = DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z');
        $entity = new Slot(['created' => '2016-01-05T22:04:39Z']);
        $this->assertEquals($entity->getCreated(), $date);
    }
}
