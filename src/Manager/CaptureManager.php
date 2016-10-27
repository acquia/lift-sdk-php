<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Captures;
use Acquia\LiftClient\Entity\CapturesResponse;
use GuzzleHttp\Psr7\Request;

class CaptureManager extends ManagerBase
{
    /**
     * Add one or more captures.
     *
     * @see http://docs.decision-api.acquia.com/#capture_post
     *
     * @param \Acquia\LiftClient\Entity\Captures $captures
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function add(Captures $captures)
    {
        $body = $captures->json();
        $url = '/capture';
        $request = new Request('POST', $url, [], $body);
        $data = $this->client->getResponseJson($request);

        return new CapturesResponse($data);
    }
}
