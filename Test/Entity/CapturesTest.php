<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Capture;
use Acquia\LiftClient\Entity\Captures;

class CapturesTest extends \PHPUnit_Framework_TestCase
{
    public function testTouchIdentifier()
    {
        $entity = new Captures();
        $entity->setTouchIdentifier('test-touch-identifier');
        $this->assertEquals($entity->json(), '{"touch_identifier":"test-touch-identifier"}');
        $this->assertEquals($entity->getTouchIdentifier(), 'test-touch-identifier');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testTouchIdentifierIsString()
    {
        $entity = new Captures();
        $entity->setTouchIdentifier(100);
    }

    public function testIdentity()
    {
        $entity = new Captures();
        $entity->setIdentity('test-identity');
        $this->assertEquals($entity->json(), '{"identity":"test-identity"}');
        $this->assertEquals($entity->getIdentity(), 'test-identity');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIdentityIsString()
    {
        $entity = new Captures();
        $entity->setIdentity(100);
    }

    public function testIdentitySource()
    {
        $entity = new Captures();
        $entity->setIdentitySource('test-identity-source');
        $this->assertEquals($entity->json(), '{"identity_source":"test-identity-source"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIdentitySourceIsString()
    {
        $entity = new Captures();
        $entity->setIdentitySource(100);
    }

    public function testDoNotTrack()
    {
        $entity = new Captures();
        $entity->setDoNotTrack(true);
        $this->assertEquals($entity->json(), '{"do_not_track":true}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of boolean.
     */
    public function testDoNotTrackIsBoolean()
    {
        $entity = new Captures();
        $entity->setDoNotTrack(100);
    }

    public function testReturnSegments()
    {
        $entity = new Captures();
        $entity->setReturnSegments(true);
        $this->assertEquals($entity->json(), '{"return_segments":true}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of boolean.
     */
    public function testReturnSegmentsIsBoolean()
    {
        $entity = new Captures();
        $entity->setReturnSegments(100);
    }

    public function testCapture()
    {
        $capture = new Capture();
        $capture
            ->setAuthor('nick');

        $entity = new Captures();
        $entity->setCaptures([$capture]);
        $this->assertEquals($entity->json(), '{"captures":[{"author":"nick"}]}');
    }
}
