<?php

namespace Acquia\LiftClient\Manager;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

abstract class ManagerBase
{
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

}
