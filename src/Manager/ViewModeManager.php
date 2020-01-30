<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\ViewMode;
use GuzzleHttp\Psr7\Request;

/**
 * Retrieving the list of view-modes associated with the account id
 */

class ViewModeManager extends ManagerBase
{

    /**
     * {@inheritdoc}
     */
    protected $queryParameters = [
        'context_language' => null, // Required if cdf_version is 2. Must pass 2 or 4 letter language code (ie. 'en', 'fr')
        'cdf_version' => null // Default set to 1 if not passed
    ];

    /**
     * Get a list of sites associated with account
     *
     * @see http://docs.lift.acquia.com/decision/v2/#view_modes_get
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\ViewMode[]
     */
    public function get($options = [])
    {
        $url = VIEW_MODES_EP;
        $url .= $this->getQueryString($options);

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        // Retrieve all view-mode objects
        $viewModes = [];
        foreach ($data as $dataItem) {
            $viewModes[] = new ViewMode($dataItem);
        }

        return $viewModes;
    }

}
