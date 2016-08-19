<?php

namespace Acquia\LiftClient;

use Acquia\Hmac\Guzzle\HmacAuthMiddleware;
use Acquia\Hmac\Key;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class Lift extends Client
{

    /**
     * @var \Acquia\Hmac\KeyInterface
     *   A sample key.
     */
    protected $authKey;

    /**
     * @var string
     *   The account we are using.
     */
    protected $accountId;

    /**
     * @var string
     *   The site identifier we are using.
     */
    protected $siteId;

    /**
     * Overrides \GuzzleHttp\Client::__construct()
     *
     * @param string $account_id
     *   The Lift Web Account Identifier. Eg.: MYACCOUNT
     * @param string $site_id
     *   The Lift Web Site Identifier. Eg.: my-drupal-site
     * @param string $public_key
     *   The Lift Web Public Key. Not all API keys have the same permissions so be
     *   mindful which key you are using.
     * @param string $secret_key
     *   The Lift Web Secret Key belonging to the Public Key
     * @param array $config
     */
    public function __construct(
      $account_id,
      $site_id,
      $public_key,
      $secret_key,
      array $config = []
    ) {
        // "base_url" parameter changed to "base_uri" in Guzzle6, so the following line
        // is there to make sure it does not disrupt previous configuration.
        if (!isset($config['base_uri']) && isset($config['base_url'])) {
            $config['base_uri'] = $config['base_url'];
        }

        // Setting up the headers.
        $config['headers']['Content-Type'] = 'application/json';

        // A key consists of your UUID and a MIME base64 encoded shared secret.
        $this->authKey = new Key($public_key, $secret_key);

        $this->accountId = $account_id;
        $this->siteId = $site_id;

        // Set our default HandlerStack if nothing is provided
        if (!isset($config['handler'])) {
            $config['handler'] = HandlerStack::create();
        }
        if (isset($config['auth_middleware'])) {
            if ($config['auth_middleware'] !== false) {
                $config['handler']->push($config['auth_middleware']);
            }
        } else {
            $middleware = new HmacAuthMiddleware($this->authKey, 'Decision');
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
        // Now make the request.
        $request = new Request('GET', '/ping');
        return $this->getResponseJson($request);
    }

    /**
     * Get a list of slots.
     *
     * Example of how to structure the $options parameter:
     * <code>
     * $options = [
     *     'visible_on_page'  => 'http://localhost/blog/*',
     *     'status' => 'enabled',
     * ];
     * </code>
     *
     * @see http://docs.decision-api.acquia.com/#slots_get
     *
     * @param array $options
     *
     * @return array
     *
     * @throws \GuzzleHttp\Exception\RequestException
     */
    public function getSlots($options = [])
    {
        $variables = $options + [
            'limit' => 1000,
            'start' => 0,
          ];

        $url = "/slots?account_id={$this->accountId}&site_id={$this->siteId}";
        $url .= isset($variables['visible_on_page']) ? "&visible_on_page={$variables['visible_on_page']}" : '';
        $url .= isset($variables['status']) ? "&status={$variables['status']}" : '';

        // Now make the request.
        $request = new Request('GET', $url);

        return $this->getResponseJson($request);
    }

    /**
     * Get a specific slot
     *
     * Example of how to structure the $options parameter:
     *
     * @see http://docs.decision-api.acquia.com/#slots__slotId__get
     *
     * @param array $options
     *
     * @return array
     *
     * @throws \GuzzleHttp\Exception\RequestException
     */
    public function getSlot($slot_id)
    {
        $url = "/slots/{$slot_id}?account_id={$this->accountId}&site_id={$this->siteId}";

        // Now make the request.
        $request = new Request('GET', $url);

        return $this->getResponseJson($request);
    }

    /**
     * Add a slot
     *
     * @param Slot $slot
     *
     * @return Slot
     *
     * @throws \GuzzleHttp\Exception\RequestException

     */
    public function addSlot(Slot $slot)
    {
        $body = $slot->json();
        $url = "/slots?account_id={$this->accountId}&site_id={$this->siteId}";
        $request = new Request('POST', $url, [], $body);
        $data = $this->getResponseJson($request);
        return new Slot($data);
    }

    /**
     * Deletes a slot by ID.
     *
     * @param  string $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\RequestException
     */
    public function deleteSlot($id)
    {
        $url = "/slots/{$id}?account_id={$this->accountId}&site_id={$this->siteId}";
        return $this->delete($url);
    }

    /**
     * Make the given Request and return the Response as a PHP Object.
     *
     * @param RequestInterface $request
     *
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\RequestException
     */
    protected function getResponseJson(RequestInterface $request)
    {
        $response = $this->send($request);
        $body = (string) $response->getBody();
        return json_decode($body, TRUE);
    }
}
