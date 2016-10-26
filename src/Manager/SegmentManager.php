<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Goal;
use Acquia\LiftClient\Entity\Segment;
use GuzzleHttp\Psr7\Request;

class SegmentManager extends ManagerBase
{
    /**
     * Get a list of Segments.
     *
     * @see http://docs.decision-api.acquia.com/#goals_get
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Segment[]
     */
    public function query()
    {
        $url = '/segments';

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->client->getResponseJson($request);

        // Get them as Segment objects
        $segments = [];
        foreach ($data as $dataItem) {
            $segments[] = new Segment($dataItem);
        }

        return $segments;
    }
}
