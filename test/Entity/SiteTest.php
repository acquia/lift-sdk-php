<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Site;

class SiteTest extends \PHPUnit_Framework_TestCase
{

    public function testSiteProperties()
    {
        $site = new Site(['id' => 'test-site-id-1', 'name' => 'Test Site Name 1', 'url' => 'http://testsiteurl1']);

        $this->assertEquals($site->getId(), 'test-site-id-1');
        $this->assertEquals($site->getName(), 'Test Site Name 1');
        $this->assertEquals($site->getUrl(), 'http://testsiteurl1');

    }
}
