<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Site;
use Acquia\LiftClient\Entity\SiteResponse;
use GuzzleHttp\Psr7\Request;

class SiteManager extends ManagerBase
{
    /**
     * Get a list of sites associated with account
     *
     * @see http://docs.lift.acquia.com/decision/v2/#sites_get
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Site[]
     */
    public function getSites()
    {
        $url = SITES_EP;

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        // Get them as Segment objects
        $sites = [];
        foreach ($data as $dataItem) {
            $sites[] = new Site($dataItem);
        }

        return $sites;
    }

    /**
     * Returns the site details associated by site id
     *
     * @see http://docs.lift.acquia.com/decision/v2/#sites__site_id__get
     *
     * @param string $id
     * 
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Site
     */
    public function getSite($id)
    {
        $url = SITES_EP."/".$id;

        // Push request to API
        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        return new Site($data);
    }

    /**
     * Create/Update a list of customer sites associated with account
     *
     * @see http://docs.lift.acquia.com/decision/v2/#sites_post
     *
     * @param Site[] sites
     * 
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return SiteResponse[] 
     */
    public function post(array $sites)
    {
        $url = SITES_EP;

        $body = json_encode($sites);
        $request = new Request('POST', $url, [], $body);
        $data = $this->getResponseJson($request);

        $siteResps = [];
        foreach ($data as $dataItem) {
            $siteResps[] = new SiteResponse($dataItem);
        }

        return $siteResps;
    }

    /**
     * Delete customer site by id
     *
     * @see http://docs.lift.acquia.com/decision/v2/#sites__site_id__delete
     *
     * @param string $id
     * 
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return boolean
     */
    public function delete($id)
    {
        $url = SITES_EP."/".$id;

        // Push request to API
        $this->client->delete($url);

        return true;
    }
}
