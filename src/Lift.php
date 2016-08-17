<?php

namespace Acquia\LiftClient;

use Acquia\Hmac\Digest as Digest;
use Acquia\Hmac\Guzzle\HmacAuthMiddleware;
use Acquia\Hmac\RequestSigner;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;

class Lift extends Client
{
    /**
     * Overrides \GuzzleHttp\Client::__construct()
     *
     * @param string $apiKey
     * @param string $secretKey
     * @param string $origin
     * @param array  $config
     */
    public function __construct($apiKey, $secretKey, $origin, array $config = [])
    {
        // "base_url" parameter changed to "base_uri" in Guzzle6, so the following line
        // is there to make sure it does not disrupt previous configuration.
        if (!isset($config['base_uri']) && isset($config['base_url'])) {
            $config['base_uri'] = $config['base_url'];
        }

        // Setting up the headers.
        $config['headers']['Content-Type'] = 'application/json';

        // Add the authentication handler
        // @see https://github.com/acquia/http-hmac-spec
        $requestSigner = new RequestSigner(new Digest\Version1('sha256'));
        $middleware = new HmacAuthMiddleware($requestSigner, $apiKey, $secretKey);

        if (!isset($config['handler'])) {
            $config['handler'] = HandlerStack::create();
        }
        $config['handler']->push($middleware);

        parent::__construct($config);
    }

    /**
     * Pings the service to ensure that it is available.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @since 0.2.0
     */
    public function ping()
    {
        return $this->get('/ping');
    }

    protected function getResponseJson(RequestInterface $request)
    {
        $response = $this->send($request);
        $body = (string) $response->getBody();
        return json_decode($body, TRUE);
    }
}
