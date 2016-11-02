<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\CapturesResponse;

class CapturesResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testErrors()
    {
        $data = [
            'errors' => [
                [
                    'code' => '400',
                    'message' => 'Something went wrong',
                ],
            ],
        ];

        $entity = new CapturesResponse($data);

        $this->assertEquals($entity->json(), '{"errors":[{"code":"400","message":"Something went wrong"}]}');
        $this->assertEquals($entity->getErrors()[0]->getCode(), '400');
        $this->assertEquals($entity->getErrors()[0]->getMessage(), 'Something went wrong');
    }

    public function testMatchedSegments()
    {
        $data = [
            'matched_segments' => [
                [
                    'id' => 'segment-id',
                    'name' => 'segment-name',
                    'description' => 'segment-description',
                ],
            ],
        ];

        $entity = new CapturesResponse($data);
        $this->assertEquals($entity->json(), '{"matched_segments":[{"id":"segment-id","name":"segment-name","description":"segment-description"}]}');
        $this->assertEquals($entity->getMatchedSegments()[0]->getId(), 'segment-id');
        $this->assertEquals($entity->getMatchedSegments()[0]->getName(), 'segment-name');
        $this->assertEquals($entity->getMatchedSegments()[0]->getDescription(), 'segment-description');
    }
}
