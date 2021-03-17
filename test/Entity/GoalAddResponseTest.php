<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\GoalAddResponse;
use PHPUnit\Framework\TestCase;

class GoalAddResponseTest extends TestCase
{
    public function testStatusAndErrors()
    {
        $entity = new GoalAddResponse(['status' => 'SOME-STATUS', 'errors' => [['code' => 'INVALID_UID', 'message' => 'something went wrong']]]);
        $this->assertEquals($entity->getStatus(), 'SOME-STATUS');
        $this->assertEquals($entity->getErrors()[0]->getCode(), 'INVALID_UID');
        $this->assertEquals($entity->getErrors()[0]->getMessage(), 'something went wrong');
    }
}
