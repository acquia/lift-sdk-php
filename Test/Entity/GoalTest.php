<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Goal;

class GoalTest extends \PHPUnit_Framework_TestCase
{
    public function testId()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setId('test-id');
        // Check if the identifier is equal.
        $this->assertEquals($goal->getId(), 'test-id');
    }

    public function testName()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setName('test-name');
        // Check if the identifier is equal.
        $this->assertEquals($goal->getName(), 'test-name');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testNameNoString()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setName(123);
        $goal->getName();
    }

    public function testDescription()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setDescription('test-description');
        // Check if the identifier is equal.
        $this->assertEquals($goal->getDescription(), 'test-description');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDescriptionNoString()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setDescription(123);
        $goal->getDescription();
    }

    public function testRuleIds()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setRuleIds(['test-rule-id']);
        // Check if the identifier is equal.
        $this->assertEquals($goal->getRuleIds(), ['test-rule-id']);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Rule Ids argument is more than 1 level deep.
     */
    public function testRuleIdsArrayTwoLevels()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setRuleIds(['test-rule-id' => ['another-level']]);
        $goal->getRuleIds();
    }

    public function testSiteIds()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setSiteIds(['test-site-id']);
        // Check if the identifier is equal.
        $this->assertEquals($goal->getSiteIds(), ['test-site-id']);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Site Ids argument is more than 1 level deep.
     */
    public function testSiteIdsArrayTwoLevels()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setSiteIds(['test-site-id' => ['another-level']]);
        $goal->getSiteIds();
    }

    public function testEventNames()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setEventNames(['test-event-id']);
        // Check if the identifier is equal.
        $this->assertEquals($goal->getEventNames(), ['test-event-id']);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Event Names argument is more than 1 level deep.
     */
    public function testEventNamesArrayTwoLevels()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setEventNames(['test-event-id' => ['another-level']]);
        $goal->getEventNames();
    }

    public function testGlobal()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setGlobal(true);
        // Check if the identifier is equal.
        $this->assertEquals($goal->getGlobal(), true);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of boolean.
     */
    public function testGlobalNoBoolean()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setGlobal('string');
        $goal->getGlobal();
    }

    public function testValue()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setValue(10);
        // Check if the identifier is equal.
        $this->assertEquals($goal->getValue(), 10);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of float or int.
     */
    public function testValueNoNumeric()
    {
        // Create a new Goal object.
        $goal = new Goal();
        $goal->setValue('string');
        $goal->getValue();
    }
}
