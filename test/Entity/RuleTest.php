<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\ContentView;
use Acquia\LiftClient\Entity\Probability;
use Acquia\LiftClient\Entity\Rule;
use Acquia\LiftClient\Entity\TestConfigAb;
use Acquia\LiftClient\Entity\TestConfigTarget;
use Acquia\LiftClient\Entity\ViewMode;
use DateTime;

class RuleTest extends \PHPUnit_Framework_TestCase
{
    public function testId()
    {
        $entity = new Rule();
        $entity->setId('test-rule-id');
        $this->assertEquals($entity->getId(), 'test-rule-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIdNoString()
    {
        $entity = new Rule();
        $entity->setId(123);
    }

    public function testLabel()
    {
        $entity = new Rule();
        $entity->setLabel('test-rule-label');
        $this->assertEquals($entity->getLabel(), 'test-rule-label');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testLabelNoString()
    {
        $entity = new Rule();
        $entity->setLabel(123);
    }

    public function testSegmentId()
    {
        $entity = new Rule();
        $entity->setSegment('test-segment');
        $this->assertEquals($entity->getSegment(), 'test-segment');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testSegmentNoString()
    {
        $entity = new Rule();
        $entity->setSegment(123);
    }

    public function testPriority()
    {
        $entity = new Rule();
        $entity->setPriority(100);
        $this->assertEquals($entity->getPriority(), 100);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of integer.
     */
    public function testPriorityNoInteger()
    {
        $entity = new Rule();
        $entity->setPriority('string');
    }

    public function testStatus()
    {
        $entity = new Rule();
        $entity->setStatus("published");
        $this->assertEquals($entity->getStatus(), "published");

        $entity->setStatus("unpublished");
        $this->assertEquals($entity->getStatus(), "unpublished");

        $entity->setStatus("archived");
        $this->assertEquals($entity->getStatus(), "archived");

        $entity->setStatus("scheduled");
        $this->assertEquals($entity->getStatus(), "scheduled");

        $entity->setStatus("completed");
        $this->assertEquals($entity->getStatus(), "completed");
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testStatusNoString()
    {
        $entity = new Rule();
        $entity->setStatus(12342);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Status must one of the following value {published, unpublishedm, archived, scheduled, completed}
     */
    public function testStatusInvalidValue()
    {
        $entity = new Rule();
        $entity->setStatus("test");
    }

    public function testType()
    {
        $entity = new Rule();
        $entity->setType('target');
        $this->assertEquals($entity->getType(), 'target');

        $entity->setType('ab');
        $this->assertEquals($entity->getType(), 'ab');

        $entity->setType('dynamic');
        $this->assertEquals($entity->getType(), 'dynamic');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testTypeNoString()
    {
        $entity = new Rule();
        $entity->setType(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Type much be either target, ab or dynamic
     */
    public function testTypeInvalidValue()
    {
        $entity = new Rule();
        $entity->setType("test");
    }

    public function testDescription()
    {
        $entity = new Rule();
        $entity->setDescription('test-rule-description');
        $this->assertEquals($entity->getDescription(), 'test-rule-description');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDescriptionNoString()
    {
        $entity = new Rule();
        $entity->setDescription(123);
    }

    public function testCampaignId()
    {
        $entity = new Rule();
        $entity->setCampaignId('test-campaign-id');
        $this->assertEquals($entity->getCampaignId(), 'test-campaign-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testCampaignIdNoString()
    {
        $entity = new Rule();
        $entity->setCampaignId(123);
    }

    public function testCreated()
    {
        $date = DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z');
        $entity = new Rule(['created' => '2016-01-05T22:04:39Z']);
        $this->assertEquals($entity->getCreated(), $date);
    }

    public function testUpdated()
    {
        $date = DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z');
        $entity = new Rule(['updated' => '2016-01-05T22:04:39Z']);
        $this->assertEquals($entity->getUpdated(), $date);
    }

    public function testError()
    {
        $entity = new Rule(['error' => ['code' => 10, 'message' => 'Error in fetching content']]);
        $this->assertEquals($entity->getError()->getCode(), 10);
        $this->assertEquals($entity->getError()->getMessage(), 'Error in fetching content');
    }
}
