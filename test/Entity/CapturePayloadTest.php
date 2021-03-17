<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Capture;
use Acquia\LiftClient\Entity\CapturePayload;
use PHPUnit\Framework\TestCase;

class CapturePayloadTest extends TestCase
{
    public function testTouchIdentifier()
    {
        $entity = new CapturePayload();
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
        $entity = new CapturePayload();
        $entity->setTouchIdentifier(100);
    }

    public function testIdentity()
    {
        $entity = new CapturePayload();
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
        $entity = new CapturePayload();
        $entity->setIdentity(100);
    }

    public function testIdentitySource()
    {
        $entity = new CapturePayload();
        $entity->setIdentitySource('test-identity-source');
        $this->assertEquals($entity->json(), '{"identity_source":"test-identity-source"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIdentitySourceIsString()
    {
        $entity = new CapturePayload();
        $entity->setIdentitySource(100);
    }

    public function testDoNotTrack()
    {
        $entity = new CapturePayload();
        $entity->setDoNotTrack(true);
        $this->assertEquals($entity->json(), '{"do_not_track":true}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of boolean.
     */
    public function testDoNotTrackIsBoolean()
    {
        $entity = new CapturePayload();
        $entity->setDoNotTrack(100);
    }

    public function testReturnSegments()
    {
        $entity = new CapturePayload();
        $entity->setReturnSegments(true);
        $this->assertEquals($entity->json(), '{"return_segments":true}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of boolean.
     */
    public function testReturnSegmentsIsBoolean()
    {
        $entity = new CapturePayload();
        $entity->setReturnSegments(100);
    }

    public function testCapture()
    {
        $capture = new Capture();
        $capture
            ->setAuthor('nick');

        $entity = new CapturePayload();
        $entity->setCaptures([$capture]);
        $this->assertEquals($entity->json(), '{"captures":[{"author":"nick"}]}');
    }
}
