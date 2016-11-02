<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Content;
use Acquia\LiftClient\Entity\Probability;
use Acquia\LiftClient\Entity\Rule;
use Acquia\LiftClient\Entity\Segment;
use Acquia\LiftClient\Entity\TestConfigAb;
use Acquia\LiftClient\Entity\TestConfigMab;
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

    public function testSlotId()
    {
        $entity = new Rule();
        $entity->setSlotId('test-rule-slot-id');
        $this->assertEquals($entity->getSlotId(), 'test-rule-slot-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testSlotIdNoString()
    {
        $entity = new Rule();
        $entity->setSlotId(123);
    }

    public function testWeight()
    {
        $entity = new Rule();
        $entity->setWeight(100);
        $this->assertEquals($entity->getWeight(), 100);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of integer.
     */
    public function testWeightNoInteger()
    {
        $entity = new Rule();
        $entity->setWeight('string');
    }

    public function testContent()
    {
        $content = new Content();
        $content->setId('content-id');
        $viewMode = new ViewMode();
        $viewMode->setId('view-mode-id');
        $content->setViewMode($viewMode);
        $entity = new Rule();
        $entity->setContentList([$content]);
        $this->assertEquals($entity->getContentList()[0]->getId(), 'content-id');
        $this->assertEquals($entity->getContentList()[0]->getContentConnectorId(), 'content_hub');
        $this->assertEquals($entity->getContentList()[0]->getViewMode()->getId(), 'view-mode-id');
    }

    public function testSegmentId()
    {
        $entity = new Rule();
        $entity->setSegmentId('test-rule-segment-id');
        $this->assertEquals($entity->getSegmentId(), 'test-rule-segment-id');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testSegmentIdNoString()
    {
        $entity = new Rule();
        $entity->setSegmentId(123);
    }

    public function testStatus()
    {
        $entity = new Rule();
        $entity->setStatus('published');
        $this->assertEquals($entity->getStatus(), 'published');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testStatusNoString()
    {
        $entity = new Rule();
        $entity->setStatus(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Status much be either published, unpublished or archived.
     */
    public function testStatusNoValidStatus()
    {
        $entity = new Rule();
        $entity->setStatus('non-existing-status');
    }

    public function testUpdated()
    {
        $date = DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z');
        $entity = new Rule(['updated' => '2016-01-05T22:04:39Z']);
        $this->assertEquals($entity->getUpdated(), $date);
    }

    public function testCreated()
    {
        $date = DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z');
        $entity = new Rule(['created' => '2016-01-05T22:04:39Z']);
        $this->assertEquals($entity->getCreated(), $date);
    }

    public function testTestConfig()
    {
        $testConfigAb = new TestConfigAb();
        $probability1 = new Probability();
        $probability1->setContentId('test-content-id-1');
        $probability1->setContentViewId('test-view-mode-id-1');
        $probability1->setFraction(0.5);

        $probability2 = new Probability();
        $probability2->setContentId('test-content-id-2');
        $probability2->setContentViewId('test-view-mode-id-2');
        $probability2->setFraction(0.5);

        $testConfigAb->setProbabilities([$probability1, $probability2]);
        $entity = new Rule();
        $entity->setTestConfig($testConfigAb);

        /** @var TestConfigAb $testConfigToVerify */
        $testConfigToVerify = $entity->getTestConfig();

        $this->assertEquals($testConfigToVerify->getProbabilities()[0]->getContentId(), 'test-content-id-1');
        $this->assertEquals($testConfigToVerify->getProbabilities()[1]->getContentId(), 'test-content-id-2');

        $this->assertEquals($testConfigToVerify->getProbabilities()[0]->getContentViewId(), 'test-view-mode-id-1');
        $this->assertEquals($testConfigToVerify->getProbabilities()[1]->getContentViewId(), 'test-view-mode-id-2');

        $this->assertEquals($testConfigToVerify->getProbabilities()[0]->getFraction(), 0.5);
        $this->assertEquals($testConfigToVerify->getProbabilities()[1]->getFraction(), 0.5);

        $this->assertEquals($entity->json(), '{"testconfig":{"ab":{"probabilities":[{"id":"test-content-id-1","content_view_id":"test-view-mode-id-1","fraction":0.5},{"id":"test-content-id-2","content_view_id":"test-view-mode-id-2","fraction":0.5}]}}}');

        $entity = new Rule();
        $testConfigMab = new TestConfigMab();
        $entity->setTestConfig($testConfigMab);
        $this->assertEquals($entity->json(), '{"testconfig":{"mab":[]}}');

        $entity = new Rule();
        $testConfigTarget = new TestConfigTarget();
        $entity->setTestConfig($testConfigTarget);
        $this->assertEquals($entity->json(), '{"testconfig":{"target":[]}}');
    }
}
