<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Capture;
use Acquia\LiftClient\Entity\Decide;
use Acquia\LiftClient\Exception\LiftSdkException;
use PHPUnit\Framework\TestCase;

class DecideTest extends TestCase
{
    public function testSlots()
    {
        $entity = new Decide();
        $entity->setSlots(['test-slot-id']);
        $this->assertEquals($entity->json(), '{"slots":["test-slot-id"]}');
    }

    public function testSlotsArrayDepth()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Slot Ids argument is more than 1 level deep.");
        $entity = new Decide();
        $entity->setSlots(['test-slot-id' => ['too-deep']]);
    }

    public function testUrl()
    {
        $entity = new Decide();
        $entity->setUrl('test-url');
        $this->assertEquals($entity->json(), '{"url":"test-url"}');
    }

    public function testUrlIsString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Decide();
        $entity->setUrl(100);
    }

    public function testDoNotTrack()
    {
        $entity = new Decide();
        $entity->setDoNotTrack(true);
        $this->assertEquals($entity->json(), '{"do_not_track":true}');
    }

    public function testDoNotTrackIsBoolean()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of boolean.");
        $entity = new Decide();
        $entity->setDoNotTrack(100);
    }

    public function testPreview()
    {
        $entity = new Decide();
        $entity->setPreview(true);
        $this->assertEquals($entity->json(), '{"preview":true}');
    }

    public function testPreviewIsBoolean()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of boolean.");
        $entity = new Decide();
        $entity->setPreview(100);
    }

    public function testSegments()
    {
        $entity = new Decide();
        $entity->setSegments(['test-segment-id-1', 'test-segment-id-2']);
        $this->assertEquals($entity->json(), '{"segments":["test-segment-id-1","test-segment-id-2"]}');
    }

    public function testSegmentsArrayDepth()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Segment Ids argument is more than 1 level deep.");
        $entity = new Decide();
        $entity->setSegments(['test-segment-id' => ['too-deep']]);
    }

    public function testTouchIdentifier()
    {
        $entity = new Decide();
        $entity->setTouchIdentifier('test-touch-identifier');
        $this->assertEquals($entity->json(), '{"touch_identifier":"test-touch-identifier"}');
    }

    public function testTouchIdentifierIsString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Decide();
        $entity->setTouchIdentifier(100);
    }

    public function testIdentity()
    {
        $entity = new Decide();
        $entity->setIdentity('test-identity');
        $this->assertEquals($entity->json(), '{"identity":"test-identity"}');
    }

    public function testIdentityIsString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Decide();
        $entity->setIdentity(100);
    }

    public function testIdentitySource()
    {
        $entity = new Decide();
        $entity->setIdentitySource('test-identity-source');
        $this->assertEquals($entity->json(), '{"identity_source":"test-identity-source"}');
    }

    public function testIdentitySourceIsString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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

    public function testIdentityExpiryIsInt()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of integer.");
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
