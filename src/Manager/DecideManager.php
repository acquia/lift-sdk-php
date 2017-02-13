<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Decide;
use Acquia\LiftClient\Entity\DecideResponse;
use GuzzleHttp\Psr7\Request;

class DecideManager extends ManagerBase
{
    /**
     * Make one or more decisions.
     *
     * @see http://docs.decision-api.acquia.com/#decide_post
     *
     * @param \Acquia\LiftClient\Entity\Decide $decide
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\DecideResponse
     */
    public function decide(Decide $decide)
    {
        $body = $decide->json();
        $url = '/decide';
        $request = new Request('POST', $url, [], $body);
        $data = $this->getResponseJson($request);

        return new DecideResponse($data);
    }
}
