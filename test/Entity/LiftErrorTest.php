<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\LiftError;
use PHPUnit\Framework\TestCase;

class LiftErrorTest extends TestCase
{
    public function testCodeAndMessage()
    {
        $entity = new LiftError(['code' => 'INVALID_UID', 'message' => 'something went wrong']);
        $this->assertEquals($entity->getCode(), 'INVALID_UID');
        $this->assertEquals($entity->getMessage(), 'something went wrong');

        $entity = new LiftError(['code' => 200, 'message' => 'something went wrong']);
        $this->assertEquals($entity->getCode(), '200');
        $this->assertEquals($entity->getMessage(), 'something went wrong');
    }
}
