<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\CapturePayload;
use Acquia\LiftClient\Entity\CapturesResponse;
use GuzzleHttp\Psr7\Request;

class CaptureManager extends ManagerBase
{
    /**
     * Add one or more captures.
     *
     * @see http://docs.decision-api.acquia.com/#capture_post
     *
     * @param \Acquia\LiftClient\Entity\CapturePayload $capturePayload
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\CapturesResponse
     */
    public function add(CapturePayload $capturePayload)
    {
        $body = $capturePayload->json();
        $url = '/capture';
        $request = new Request('POST', $url, [], $body);
        $data = $this->getResponseJson($request);

        return new CapturesResponse($data);
    }
}
