<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Goal;
use Acquia\LiftClient\Exception\LiftSdkException;
use PHPUnit\Framework\TestCase;

class GoalTest extends TestCase
{
    public function testId()
    {
        $entity = new Goal();
        $entity->setId('test-id');
        $this->assertEquals($entity->getId(), 'test-id');
    }

    public function testIdNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Goal();
        $entity->setId(123);
    }

    public function testName()
    {
        $entity = new Goal();
        $entity->setName('test-name');
        $this->assertEquals($entity->getName(), 'test-name');
    }

    public function testNameNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Goal();
        $entity->setName(123);
    }

    public function testDescription()
    {
        $entity = new Goal();
        $entity->setDescription('test-description');
        $this->assertEquals($entity->getDescription(), 'test-description');
    }

    public function testDescriptionNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Goal();
        $entity->setDescription(123);
    }

    public function testRuleIds()
    {
        $entity = new Goal();
        $entity->setRuleIds(['test-rule-id']);
        $this->assertEquals($entity->getRuleIds(), ['test-rule-id']);
    }

    public function testRuleIdsArrayTwoLevels()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Rule Ids argument is more than 1 level deep.");
        $entity = new Goal();
        $entity->setRuleIds(['test-rule-id' => ['another-level']]);
    }

    public function testSiteIds()
    {
        $entity = new Goal();
        $entity->setSiteIds(['test-site-id']);
        $this->assertEquals($entity->getSiteIds(), ['test-site-id']);
    }

    public function testSiteIdsArrayTwoLevels()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Site Ids argument is more than 1 level deep.");
        $entity = new Goal();
        $entity->setSiteIds(['test-site-id' => ['another-level']]);
    }

    public function testEventNames()
    {
        $entity = new Goal();
        $entity->setEventNames(['test-event-id']);
        $this->assertEquals($entity->getEventNames(), ['test-event-id']);
    }

    public function testEventNamesArrayTwoLevels()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Event Names argument is more than 1 level deep.");
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

    public function testGlobalNoBoolean()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of boolean.");
        $entity = new Goal();
        $entity->setGlobal('string');
    }

    public function testValue()
    {
        $entity = new Goal();
        $entity->setValue(10);
        $this->assertEquals($entity->getValue(), 10);
    }
    
    public function testValueNoNumeric()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of float or int.");
        $entity = new Goal();
        $entity->setValue('string');
    }
}
