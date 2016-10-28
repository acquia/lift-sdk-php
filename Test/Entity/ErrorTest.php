<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Error;

class ErrorTest extends \PHPUnit_Framework_TestCase
{
    public function testCodeAndMessage()
    {
        $entity = new Error(['code' => 200, 'message' => 'something went wrong']);
        $this->assertEquals($entity->getCode(), 200);
        $this->assertEquals($entity->getMessage(), 'something went wrong');
    }
}
