<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Entity;
use ReflectionClass;

class EntityTest extends \PHPUnit_Framework_TestCase
{
    public function testgetEntityValue()
    {
        $class = new ReflectionClass('Acquia\LiftClient\Entity\Entity');
        $method = $class->getMethod('getEntityValue');
        $method->setAccessible(true);
        // Test our protected method
        $entity = new Entity(['foo' => 'bar']);
        $this->assertEquals($method->invokeArgs($entity, array('foo', '')), 'bar');
    }

    public function testJson()
    {
        $entity = new Entity(['foo' => 'bar']);
        $this->assertEquals($entity->json(), '{"foo":"bar"}');
    }
}
