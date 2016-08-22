<?php

namespace Acquia\LiftClient;

use Acquia\LiftClient\DataObject\Slot;
use GuzzleHttp\Psr7\Request;

class SlotManager
{

    /**
     * @var \Acquia\LiftClient\Lift
     *   The Acquia Lift Client
     */
    protected $client;

    /**
     * @param \Acquia\LiftClient\Lift $client
     *   The Acquia Lift Client
     */
    public function __construct($client)
    {
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
     * @return \Acquia\LiftClient\DataObject\Slot[]
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
        $data = $this->client->getResponseJson($request);

        // Get them as Slot objects
        $slots = [];
        foreach ($data as $dataItem) {
            $slots[] = new Slot($dataItem);
        }

        return $slots;
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
    public function get(
      $slotId
    ) {
        $url = "/slots/{$slotId}";

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->client->getResponseJson($request);

        return new Slot($data);
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
    public function add(
      Slot $slot
    ) {
        $body = $slot->json();
        $url = "/slots";
        $request = new Request('POST', $url, [], $body);
        $data = $this->client->getResponseJson($request);

        return new Slot($data);
    }

    /**
     * Deletes a slot by ID.
     *
     * @param string $id
     *
     * @return bool
     *   returns TRUE if successful.
     *
     * @throws \GuzzleHttp\Exception\RequestException
     */
    public function delete(
      $id
    ) {
        $url = "/slots/{$id}";
        $this->client->delete($url);

        return true;
    }
}
