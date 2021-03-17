<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Visibility;
use PHPUnit\Framework\TestCase;

class VisibilityTest extends TestCase
{
    public function testCondition()
    {
        $entity = new Visibility();
        $entity->setCondition('show');
        $this->assertEquals($entity->getCondition(), 'show');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testConditionNoString()
    {
        $entity = new Visibility();
        $entity->setCondition(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Status much be either show or hide.
     */
    public function testConditionNotValid()
    {
        $entity = new Visibility();
        $entity->setCondition('not-valid');
    }

    public function testPages()
    {
        $entity = new Visibility();
        $entity->setPages(['node/1']);
        $this->assertEquals($entity->getPages(), ['node/1']);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Pages argument is more than 1 level deep.
     */
    public function testPagesInvalidDeth()
    {
        $entity = new Visibility();
        $entity->setPages(['node/1' => ['too-deep']]);
    }
}
