<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Probability;

class ProbabilityTest extends \PHPUnit_Framework_TestCase
{
    public function testContentId()
    {
        $entity = new Probability();
        $entity->setContentId('test-content-id');
        $this->assertEquals($entity->getContentId(), 'test-content-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentIdNoString()
    {
        $entity = new Probability();
        $entity->setContentId(123);
    }

    public function testContentConnectorId()
    {
        $entity = new Probability();
        $entity->setContentConnectorId('test-cc-id');
        $this->assertEquals($entity->getContentConnectorId(), 'test-cc-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentConnectorIdNoString()
    {
        $entity = new Probability();
        $entity->setContentConnectorId(123);
    }

    public function testContentViewId()
    {
        $entity = new Probability();
        $entity->setContentViewId('test-content-view-id');
        $this->assertEquals($entity->getContentViewId(), 'test-content-view-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentViewIdNoString()
    {
        $entity = new Probability();
        $entity->setContentViewId(123);
    }

    public function testFraction()
    {
        $entity = new Probability();
        $entity->setFraction(0.7);
        $this->assertEquals($entity->getFraction(), 0.7);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of any numeric type (int|float).
     */
    public function testFractionNoString()
    {
        $entity = new Probability();
        $entity->setFraction('string');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be between 0 and 1 or those values themselves.
     */
    public function testFractionBetween0And1()
    {
        $entity = new Probability();
        $entity->setFraction(2);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be between 0 and 1 or those values themselves.
     */
    public function testFractionNotNegative()
    {
        $entity = new Probability();
        $entity->setFraction(-1);
    }
}
