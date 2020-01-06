<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Capture;
use Acquia\LiftClient\Entity\Decide;

class DecideTest extends \PHPUnit_Framework_TestCase
{
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

    public function testPreview()
    {
        $entity = new Decide();
        $entity->setPreview(true);
        $this->assertEquals($entity->json(), '{"preview":true}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of boolean.
     */
    public function testPreviewIsBoolean()
    {
        $entity = new Decide();
        $entity->setPreview(100);
    }

    public function testSegments()
    {
        $entity = new Decide();
        $entity->setSegments(['test-segment-id-1', 'test-segment-id-2']);
        $this->assertEquals($entity->json(), '{"segments":["test-segment-id-1","test-segment-id-2"]}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Segment Ids argument is more than 1 level deep.
     */
    public function testSegmentsArrayDepth()
    {
        $entity = new Decide();
        $entity->setSegments(['test-segment-id' => ['too-deep']]);
    }

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

    public function testIdentityExpiry()
    {
        $entity = new Decide();
        $unixTime = time();
        $entity->setIdentityExpiry($unixTime);
        $this->assertEquals($entity->json(), '{"identity_expiry":'.$unixTime.'}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of integer.
     */
    public function testIdentityExpiryIsInt()
    {
        $entity = new Decide();
        $entity->setIdentityExpiry("test");
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

}
