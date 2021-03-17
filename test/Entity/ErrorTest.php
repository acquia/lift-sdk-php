<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Error;
use PHPUnit\Framework\TestCase;

class ErrorTest extends TestCase
{
    public function testCodeAndMessage()
    {
        $entity = new Error(['code' => 200, 'message' => 'something went wrong']);
        $this->assertEquals($entity->getCode(), 200);
        $this->assertEquals($entity->getMessage(), 'something went wrong');
    }
}
