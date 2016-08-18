<?php

namespace Acquia\LiftClient;

use Acquia\Hmac\Guzzle\HmacAuthMiddleware;
use Acquia\Hmac\Key;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

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
    public function __construct($apiKey, $secretKey, $realm, array $config = []) {
        // "base_url" parameter changed to "base_uri" in Guzzle6, so the following line
        // is there to make sure it does not disrupt previous configuration.
        if (!isset($config['base_uri']) && isset($config['base_url'])) {
            $config['base_uri'] = $config['base_url'];
        }

        // Setting up the headers.
        $config['headers']['Content-Type'] = 'application/json';

        // A key consists of your UUID and a MIME base64 encoded shared secret.
        $key = new Key($apiKey, $secretKey);

        // Set our default HandlerStack if nothing is provided
        if (!isset($config['handler'])) {
            $config['handler'] = HandlerStack::create();
        }
        if (isset($config['auth_middleware'])) {
            if ($config['auth_middleware'] !== FALSE) {
                $config['handler']->push($config['auth_middleware']);
            }
        } else {
            $middleware = new HmacAuthMiddleware($key, 'Decision');
            $config['handler']->push($middleware);
        }
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
}
