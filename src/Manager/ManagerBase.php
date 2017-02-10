<?php

namespace Acquia\LiftClient\Manager;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

abstract class ManagerBase
{
    /**
     * @var array A list of query parameters that the URL could possibly have
     */
    protected $queryParameters = [];

    /**
     * @var \GuzzleHttp\ClientInterface The request client
     */
    protected $client;

    /**
     * @param \GuzzleHttp\ClientInterface $client The request client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get the client.
     *
     * @return \GuzzleHttp\ClientInterface The request client
     */
    public function getClient() {
      return $this->client;
    }

    /**
     * Make the given Request and return as JSON Decoded PHP object.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return mixed the value encoded in <i>json</i> in appropriate
     *               PHP type. Values true, false and
     *               null (case-insensitive) are returned as <b>TRUE</b>, <b>FALSE</b>
     *               and <b>NULL</b> respectively. <b>NULL</b> is returned if the
     *               <i>json</i> cannot be decoded or if the encoded
     *               data is deeper than the recursion limit
     */
    protected function getResponseJson(RequestInterface $request)
    {
        $response = $this->client->send($request);
        $body = (string) $response->getBody();

        return json_decode($body, true);
    }

    /**
     * Get query string of using the options.
     *
     * @param $options The options
     * @return string  The query string
     */
    protected function getQueryString($options) {
      $queries = [];
      foreach ($this->queryParameters as $queryName => $queryDefaultValue) {
        // Use user value if possible.
        if (isset($options[$queryName])) {
          $queries[] = $queryName . '=' . $options[$queryName];
          continue;
        }
        // Use default value if possible.
        if (!isset($options[$queryName]) && is_string($queryDefaultValue)) {
          $queries[] = $queryName . '=' . $queryDefaultValue;
          continue;
        }
      }
      $queryString = implode('&', $queries);
      return empty($queryString) ? '' : '?' . $queryString;
    }

}
