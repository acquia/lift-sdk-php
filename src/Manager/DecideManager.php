<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Decide;
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
    public function add(Decide $decide)
    {
        $body = $decide->json();
        $url = '/capture';
        $request = new Request('POST', $url, [], $body);
        $data = $this->client->getResponseJson($request);

        return new DecideResponse($data);
    }
}
