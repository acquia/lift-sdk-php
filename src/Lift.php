<?php

namespace Acquia\LiftClient;

use Acquia\LiftClient\Manager\RuleManager;
use Acquia\LiftClient\Manager\SegmentManager;
use Acquia\LiftClient\Manager\SlotManager;
use Acquia\LiftClient\Manager\GoalManager;
use NickVeenhof\Hmac\Guzzle\HmacAuthMiddleware;
use NickVeenhof\Hmac\Key;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class Lift extends Client
{
    /**
     * @var \NickVeenhof\Hmac\KeyInterface A sample key
     */
    protected $authKey;

    /**
     * @var string The account we are using
     */
    protected $accountId;

    /**
     * @var string The site identifier we are using
     */
    protected $siteId;

    /**
     * Overrides \GuzzleHttp\Client::__construct().
     *
     * @param string $account_id The Lift Web Account Identifier. Eg.: MYACCOUNT
     * @param string $site_id    The Lift Web Site Identifier. Eg.: my-drupal-site
     * @param string $public_key The Lift Web Public Key. Not all API keys have
     *                           the same permissions so be mindful which key
     *                           you are using
     * @param string $secret_key The Lift Web Secret Key belonging to the Public
     *                           Key
     * @param array  $config
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

        // Add our Account and Site identifiers.
        $config['handler']->push($this->addLiftAccountAndSiteId());

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

    public function addLiftAccountAndSiteId()
    {
        // We cannot keep references in such functions.
        $account_id = $this->accountId;
        $site_id = $this->siteId;

        return function (callable $handler) use ($account_id, $site_id) {
            return function (
              RequestInterface $request,
              array $options
            ) use ($handler, $account_id, $site_id) {
                $auth_query = "account_id={$account_id}&site_id={$site_id}";
                $uri = $request->getUri();
                $query = $uri->getQuery();
                if (empty($query)) {
                    $query = $auth_query;
                } else {
                    $query = $query.'&'.$auth_query;
                }
                $uri = $uri->withQuery($query);
                $uri->withQuery($query);

                $request = $request->withUri($uri);

                return $handler($request, $options);
            };
        };
    }

    /**
     * Pings the service to ensure that it is available.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\RequestException
     */
    public function ping()
    {
        // Now make the request.
        $request = new Request('GET', '/ping');

        return $this->getResponseJson($request);
    }

    /**
     * Get the Slot Manager.
     *
     * @return \Acquia\LiftClient\Manager\SlotManager
     */
    public function getSlotManager()
    {
        return new SlotManager($this);
    }

    /**
     * Get the Slot Manager.
     *
     * @return \Acquia\LiftClient\Manager\GoalManager
     */
    public function getGoalManager()
    {
        return new GoalManager($this);
    }

    /**
     * Get the Segment Manager.
     *
     * @return \Acquia\LiftClient\Manager\SegmentManager
     */
    public function getSegmentManager()
    {
        return new SegmentManager($this);
    }

    /**
     * Get the Rules Manager.
     *
     * @return \Acquia\LiftClient\Manager\RuleManager
     */
    public function getRuleManager()
    {
        return new RuleManager($this);
    }

    /**
     * Make the given Request and return as JSON Decoded PHP object.
     *
     * @param RequestInterface $request
     *
     * @return mixed the value encoded in <i>json</i> in appropriate
     *               PHP type. Values true, false and
     *               null (case-insensitive) are returned as <b>TRUE</b>, <b>FALSE</b>
     *               and <b>NULL</b> respectively. <b>NULL</b> is returned if the
     *               <i>json</i> cannot be decoded or if the encoded
     *               data is deeper than the recursion limit
     *
     * @throws \GuzzleHttp\Exception\RequestException
     */
    public function getResponseJson(RequestInterface $request)
    {
        $response = $this->send($request);
        $body = (string) $response->getBody();

        return json_decode($body, true);
    }
}
