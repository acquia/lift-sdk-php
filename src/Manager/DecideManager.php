<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Decide;
use Acquia\LiftClient\Entity\DecideResponse;
use GuzzleHttp\Psr7\Request;

class DecideManager extends ManagerBase
{

    /**
     * {@inheritdoc}
     */
    protected $queryParameters = [
        'cdf_version' => null,      // String - CDF version used in content provider. Values accepted are empty string, 1 or 2. Currently the default CDF is 1 
        'prefetch' => null,         // Boolean - Whether or not to prefetch the HTML of the content item requested. Default is false
        'entities' => null          // String - Indicate API to return full cdf options
    ];

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
    public function decide(Decide $decide, $options = [])
    {
        $body = $decide->json();
        $url = DECIDE_EP;
        $url .= $this->getQueryString($options);

        $request = new Request('POST', $url, [], $body);
        $data = $this->getResponseJson($request);

        return new DecideResponse($data);
    }
}
