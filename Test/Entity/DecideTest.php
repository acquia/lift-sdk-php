<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Capture;
use Acquia\LiftClient\Entity\Decide;

class DecideTest extends \PHPUnit_Framework_TestCase
{
    public function testTouchIdentifier()
    {
        $entity = new Decide();
        $entity->setTouchIdentifier('test-touch-identifier');
        $this->assertEquals($entity->json(), '{"touch_identifier":"test-touch-identifier"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testTouchIdentifierIsString()
    {
        $entity = new Decide();
        $entity->setTouchIdentifier(100);
    }

    public function testIdentity()
    {
        $entity = new Decide();
        $entity->setIdentity('test-identity');
        $this->assertEquals($entity->json(), '{"identity":"test-identity"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIdentityIsString()
    {
        $entity = new Decide();
        $entity->setIdentity(100);
    }

    public function testIdentitySource()
    {
        $entity = new Decide();
        $entity->setIdentitySource('test-identity-source');
        $this->assertEquals($entity->json(), '{"identity_source":"test-identity-source"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIdentitySourceIsString()
    {
        $entity = new Decide();
        $entity->setIdentitySource(100);
    }

    public function testDoNotTrack()
    {
        $entity = new Decide();
        $entity->setDoNotTrack(true);
        $this->assertEquals($entity->json(), '{"do_not_track":true}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of boolean.
     */
    public function testDoNotTrackIsBoolean()
    {
        $entity = new Decide();
        $entity->setDoNotTrack(100);
    }

    public function testCapture()
    {
        $capture = new Capture();
        $capture
            ->setAuthor('nick');

        $entity = new Decide();
        $entity->setCaptures([$capture]);
        $this->assertEquals($entity->json(), '{"captures":[{"author":"nick"}]}');
    }

    public function testUrl()
    {
        $entity = new Decide();
        $entity->setUrl('test-url');
        $this->assertEquals($entity->json(), '{"url":"test-url"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testUrlIsString()
    {
        $entity = new Decide();
        $entity->setUrl(100);
    }

    public function testSlots()
    {
        $entity = new Decide();
        $entity->setSlots(['test-slot-id']);
        $this->assertEquals($entity->json(), '{"slots":["test-slot-id"]}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Slot Ids argument is more than 1 level deep.
     */
    public function testSlotsArrayDepth()
    {
        $entity = new Decide();
        $entity->setSlots(['test-slot-id' => ['too-deep']]);
    }
}
