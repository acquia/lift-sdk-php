<?php

namespace Acquia\LiftClient;

use Acquia\LiftClient\Manager\CaptureManager;
use Acquia\LiftClient\Manager\DecideManager;
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

class Lift
{
    /**
     * @var \GuzzleHttp\ClientInterface Unauthenticated client
     */
    private $unauthenticatedClient;

    /**
     * @var \GuzzleHttp\ClientInterface Authenticated client
     */
    private $authenticatedClient;

    /**
     * Constructor.
     *
     * @param string $account_id The Lift Web Account Identifier. Eg.: MYACCOUNT
     * @param string $site_id    The Lift Web Site Identifier. Eg.: my-drupal-site
     * @param string $public_key The Lift Web Public Key. Not all API keys have
     *                           the same permissions so be mindful which key
     *                           you are using
     * @param string $secret_key The Lift Web Secret Key belonging to the Public
     *                           Key
     * @param array  $config     Additional configs
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

        // Create both unauthenticated and authenticated handler stacks.
        $handlerStack = isset($config['handler']) ? $config['handler'] : HandlerStack::create();
        $accountAndSiteIdHandler = $this->getAccountAndSiteIdHandler($account_id, $site_id);
        $handlerStack->push($accountAndSiteIdHandler, 'acquia_lift_account_and_site_ids');

        // Both stacks are cloned so they are both completely internal now.
        $unauthenticatedHandlerStack = clone $handlerStack;
        $authenticatedHandlerStack = clone $handlerStack;

        // Set an authentication handler accordingly.
        if (isset($config['auth_middleware'])) {
            if ($config['auth_middleware'] !== false) {
                $authenticatedHandlerStack->push($config['auth_middleware'], 'acquia_lift_hmac_auth');
            }
        } else {
            // A key consists of your UUID and a MIME base64 encoded shared secret.
            $authKey = new Key($public_key, $secret_key);
            $middleware = new HmacAuthMiddleware($authKey, 'Decision');
            $authenticatedHandlerStack->push($middleware, 'acquia_lift_hmac_auth');
        }

        // Create both unauthenticated and authenticated handlers.
        $config['handler'] = $unauthenticatedHandlerStack;
        $this->unauthenticatedClient = new Client($config);
        $config['handler'] = $authenticatedHandlerStack;
        $this->authenticatedClient = new Client($config);
    }

    /**
     * Get a handler that adds lift account id and site id.
     *
     * @param string $account_id The Lift Web Account Identifier. Eg.: MYACCOUNT
     * @param string $site_id    The Lift Web Site Identifier. Eg.: my-drupal-site
     * @return function The handler that adds Lift account id and site id
     */
    private function getAccountAndSiteIdHandler($account_id, $site_id)
    {
        // We cannot keep references in such functions.
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
     * @return mixed the value encoded in the JSON.
     */
    public function ping()
    {
        $request = new Request('GET', '/ping');
        $response = $this->authenticatedClient->send($request);
        $body = (string) $response->getBody();

        return json_decode($body, true);
    }

    /**
     * Get the Slot Manager.
     *
     * @return \Acquia\LiftClient\Manager\SlotManager
     */
    public function getSlotManager()
    {
        return new SlotManager($this->authenticatedClient);
    }

    /**
     * Get the Slot Manager.
     *
     * @return \Acquia\LiftClient\Manager\GoalManager
     */
    public function getGoalManager()
    {
        return new GoalManager($this->authenticatedClient);
    }

    /**
     * Get the Segment Manager.
     *
     * @return \Acquia\LiftClient\Manager\SegmentManager
     */
    public function getSegmentManager()
    {
        return new SegmentManager($this->authenticatedClient);
    }

    /**
     * Get the Rules Manager.
     *
     * @return \Acquia\LiftClient\Manager\RuleManager
     */
    public function getRuleManager()
    {
        return new RuleManager($this->authenticatedClient);
    }

    /**
     * Get the Capture Manager.
     *
     * @return \Acquia\LiftClient\Manager\CaptureManager
     */
    public function getCaptureManager()
    {
        return new CaptureManager($this->unauthenticatedClient);
    }

    /**
     * Get the Decide Manager.
     *
     * @return \Acquia\LiftClient\Manager\DecideManager
     */
    public function getDecideManager()
    {
        return new DecideManager($this->unauthenticatedClient);
    }

}
