<?php

namespace Acquia\LiftClient\Route;

use GuzzleHttp\Psr7\Request;

class Slots {

    /**
     * @var \Acquia\LiftClient\Lift
     *   The Acquia Lift Client
     */
    protected $client;

    /**
     * @param \Acquia\LiftClient\Lift $client
     *   The Acquia Lift Client
     */
    public function __construct($client) {
        $this->client = $client;
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
    public function query($options = [])
    {
        $variables = $options + [
            'limit' => 1000,
            'start' => 0,
          ];

        $url = "/slots";
        $url .= isset($variables['visible_on_page']) ? "&visible_on_page={$variables['visible_on_page']}" : '';
        $url .= isset($variables['status']) ? "&status={$variables['status']}" : '';

        // Now make the request.
        $request = new Request('GET', $url);
        return $this->client->getResponseJson($request);
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
     * @return \Acquia\LiftClient\DataObject\Slot
     *
     * @throws \GuzzleHttp\Exception\RequestException
     */
    public function get($slot_id)
    {
        $url = "/slots/{$slot_id}";

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->client->getResponseJson($request);
        return new \Acquia\LiftClient\DataObject\Slot($data);
    }

    /**
     * Add a slot
     *
     * @param \Acquia\LiftClient\DataObject\Slot $slot
     *
     * @return \Acquia\LiftClient\DataObject\Slot
     *
     * @throws \GuzzleHttp\Exception\RequestException

     */
    public function add(\Acquia\LiftClient\DataObject\Slot $slot)
    {
        $body = $slot->json();
        $url = "/slots";
        $request = new Request('POST', $url, [], $body);
        $data = $this->client->getResponseJson($request);
        return new \Acquia\LiftClient\DataObject\Slot($data);
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
    public function delete($id)
    {
        $url = "/slots/{$id}";
        return $this->client->delete($url);
    }

}