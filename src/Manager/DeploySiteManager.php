<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\DeploySiteResponse;
use GuzzleHttp\Psr7\Request;

/**
 * Deploy the complete source site to the destination site. 
 * If the destination site already exists, the deployment will continue and overwrite the current state of the destination site. 
 * This overwrite includes all campaigns and rules currently configured on the destination site.
 */

class DeploySiteManager extends ManagerBase
{

    /**
     * {@inheritdoc}
     */
    protected $queryParameters = [
        'dist_site_id' => null,
        'source_site_id' => null
    ];

    /**
     * Get a list of sites associated with account
     *
     * @see http://docs.lift.acquia.com/decision/v2/#deploy_site_post
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\DeploySiteResponse
     */
    public function post($options = [])
    {
        $url = DEPLOY_SITE_EP;
        $url .= $this->getQueryString($options);

        // Now make the request.
        $request = new Request('POST', $url);
        $data = $this->getResponseJson($request);

        return new DeploySiteResponse($data);
    }

}
