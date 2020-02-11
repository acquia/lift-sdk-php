<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\SiteResponse;

class SiteResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testSiteResponseProperties_Success()
    {
        $siteResp = new SiteResponse(
            [
                'status' => 'SUCCESS',
                'item' => [
                    'id' => 'test-site-id-1', 
                    'name' => 'Test Site Name 1', 
                    'url' => 'http://testsiteurl1'
                ]
            ]);

        $this->assertEquals($siteResp->getStatus(), "SUCCESS");
        $this->assertEquals($siteResp->getItem()->getId(), "test-site-id-1");
        $this->assertEquals($siteResp->getItem()->getName(), "Test Site Name 1");
        $this->assertEquals($siteResp->getItem()->getUrl(), "http://testsiteurl1");
    }

    public function testSiteResponseProperties_Error()
    {
        $siteResp = new SiteResponse([
            'status' => 'FAILURE',
            'errors' => [
                [
                    'code' => 'INVALID_NAME',
                    'message' => 'Customer site name cannot be empty'
                ]
            ],
            'item' => [
                'id' => 'test-site-id-2', 
                'name' => ''
            ]
        ]);
        
        $this->assertEquals($siteResp->getStatus(), "FAILURE");
        $this->assertEquals(sizeof($siteResp->getErrors()), 1);
        $this->assertEquals($siteResp->getErrors()[0]->getCode(), "INVALID_NAME");
        $this->assertEquals($siteResp->getErrors()[0]->getMessage(), "Customer site name cannot be empty");
        $this->assertEquals($siteResp->getItem()->getId(), "test-site-id-2");
        $this->assertEquals($siteResp->getItem()->getName(), "");
    }


}
