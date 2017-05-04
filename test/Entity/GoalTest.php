<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Goal;

class GoalTest extends \PHPUnit_Framework_TestCase
{
    public function testId()
    {
        $entity = new Goal();
        $entity->setId('test-id');
        $this->assertEquals($entity->getId(), 'test-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIdNoString()
    {
        $entity = new Goal();
        $entity->setId(123);
    }

    public function testName()
    {
        $entity = new Goal();
        $entity->setName('test-name');
        $this->assertEquals($entity->getName(), 'test-name');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testNameNoString()
    {
        $entity = new Goal();
        $entity->setName(123);
    }

    public function testDescription()
    {
        $entity = new Goal();
        $entity->setDescription('test-description');
        $this->assertEquals($entity->getDescription(), 'test-description');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDescriptionNoString()
    {
        $entity = new Goal();
        $entity->setDescription(123);
    }

    public function testRuleIds()
    {
        $entity = new Goal();
        $entity->setRuleIds(['test-rule-id']);
        $this->assertEquals($entity->getRuleIds(), ['test-rule-id']);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Rule Ids argument is more than 1 level deep.
     */
    public function testRuleIdsArrayTwoLevels()
    {
        $entity = new Goal();
        $entity->setRuleIds(['test-rule-id' => ['another-level']]);
    }

    public function testSiteIds()
    {
        $entity = new Goal();
        $entity->setSiteIds(['test-site-id']);
        $this->assertEquals($entity->getSiteIds(), ['test-site-id']);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Site Ids argument is more than 1 level deep.
     */
    public function testSiteIdsArrayTwoLevels()
    {
        $entity = new Goal();
        $entity->setSiteIds(['test-site-id' => ['another-level']]);
    }

    public function testEventNames()
    {
        $entity = new Goal();
        $entity->setEventNames(['test-event-id']);
        $this->assertEquals($entity->getEventNames(), ['test-event-id']);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Event Names argument is more than 1 level deep.
     */
    public function testEventNamesArrayTwoLevels()
    {
        $entity = new Goal();
        $entity->setEventNames(['test-event-id' => ['another-level']]);
    }

    public function testGlobal()
    {
        $entity = new Goal();
        // Default to false.
        $this->assertFalse($entity->getGlobal());

        $entity->setGlobal(true);
        $this->assertTrue($entity->getGlobal());

        $entity->setGlobal(false);
        $this->assertFalse($entity->getGlobal());
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of boolean.
     */
    public function testGlobalNoBoolean()
    {
        $entity = new Goal();
        $entity->setGlobal('string');
    }

    public function testValue()
    {
        $entity = new Goal();
        $entity->setValue(10);
        $this->assertEquals($entity->getValue(), 10);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of float or int.
     */
    public function testValueNoNumeric()
    {
        $entity = new Goal();
        $entity->setValue('string');
    }
}
