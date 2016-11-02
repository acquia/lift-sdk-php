<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Probability;
use Acquia\LiftClient\Entity\TestConfigAb;

class TestConfigAbTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigAb()
    {
        $entity = new TestConfigAb();

        $probability1 = new Probability();
        $probability1->setContentId('test-content-id-1');
        $probability1->setContentViewId('test-view-mode-id-1');
        $probability1->setFraction(0.5);

        $probability2 = new Probability();
        $probability2->setContentId('test-content-id-2');
        $probability2->setContentViewId('test-view-mode-id-2');
        $probability2->setFraction(0.5);

        $entity->setProbabilities([$probability1, $probability2]);

        $this->assertEquals($entity->getProbabilities()[0]->getContentId(), 'test-content-id-1');
        $this->assertEquals($entity->getProbabilities()[1]->getContentId(), 'test-content-id-2');

        $this->assertEquals($entity->getProbabilities()[0]->getContentViewId(), 'test-view-mode-id-1');
        $this->assertEquals($entity->getProbabilities()[1]->getContentViewId(), 'test-view-mode-id-2');

        $this->assertEquals($entity->getProbabilities()[0]->getFraction(), 0.5);
        $this->assertEquals($entity->getProbabilities()[1]->getFraction(), 0.5);

        $this->assertEquals($entity->json(), '{"probabilities":[{"id":"test-content-id-1","content_view_id":"test-view-mode-id-1","fraction":0.5},{"id":"test-content-id-2","content_view_id":"test-view-mode-id-2","fraction":0.5}]}');
    }
}
