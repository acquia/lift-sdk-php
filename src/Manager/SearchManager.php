<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Content;
use Acquia\LiftClient\Entity\ViewMode;
use GuzzleHttp\Psr7\Request;

/**
 * Retrieving content search results
 */

class SearchManager extends ManagerBase
{
    /**
     * {@inheritdoc}
     */
    protected $queryParameters = [
        'context_language' => null, // Required if cdf_version is 2. Must pass 2 or 4 letter language code (ie. 'en', 'fr')
        'cdf_version' => null,      // Default set to 1 if not passed,
        'prefetch' => null,         // bool, default is false
        'sort' => null,             // bool (true for ascending, false for descending. Default is set to false)
        'start' => null,            // Starting index search. default is set to 0
        'rows' => null,             // Number of search results. Default is 10
        'q' => null,                // The keyword or phrase to find (fuzzy match) in the content's title.
        'view_mode' => null,        // View mode id of interest. You can get list of View modes from ViewModeManager
        'content_type' => null,     // Filter on content matching at least one of the specified content types. Multiple values are possible.
        'origins' => null,          // Filter on content matching at least one of the specified origins. Multiple values are possible.
        'tags' => null,             // Filter content matching at least one the ids of the associated tags. Multiple values are possible.
        'date_start' => null,       // Filter on content modified after this date. Format yyyy-mm-dd or now-d/d. See the elasticsearch docs for more info on date math.
        'date_end' => null,         // Filter on content modified before this date. Format yyyy-mm-dd or now. See the elasticsearch docs for more info on date math.
        'date_timezone' => null     // The timezone offset for the date range. Format +/-(e.g., -04:00)
    ];

    /**
     * Get a list of view modes associated with account
     *
     * @see http://docs.lift.acquia.com/decision/v2/#search_get
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Content[]
     */
    public function get($options = [])
    {
        $url = SEARCH_EP;
        $url .= $this->getQueryString($options);

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        // Retrieve all view-mode objects
        $contents = [];
        foreach ($data as $dataItem) {
            $contents[] = new Content($dataItem);
        }

        return $contents;
    }

}
