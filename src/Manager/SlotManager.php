<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Slot;
use GuzzleHttp\Psr7\Request;

class SlotManager extends ManagerBase
{
    /**
     * {@inheritdoc}
     */
    protected $queryParameters = [
        'visible_on_page' => null,
        'status' => null,
    ];

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
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Slot[]
     */
    public function query($options = [])
    {
        $url = '/slots';
        $url .= $this->getQueryString($options);

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        // Get them as Slot objects
        $slots = [];
        foreach ($data as $dataItem) {
            $slots[] = new Slot($dataItem);
        }

        return $slots;
    }

    /**
     * Get a specific slot.
     *
     * Example of how to structure the $options parameter:
     *
     * @see http://docs.decision-api.acquia.com/#slots__slotId__get
     *
     * @param array $id
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Slot
     */
    public function get($id)
    {
        $url = "/slots/{$id}";

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        return new Slot($data);
    }

    /**
     * Add a slot.
     *
     * @param \Acquia\LiftClient\Entity\Slot $slot
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Slot
     */
    public function add(Slot $slot)
    {
        $body = $slot->json();
        $url = '/slots';
        $request = new Request('POST', $url, [], $body);
        $data = $this->getResponseJson($request);

        return new Slot($data);
    }

    /**
     * Deletes a slot by ID.
     *
     * @param string $id
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return bool
     */
    public function delete($id)
    {
        $url = "/slots/{$id}";
        $this->client->delete($url);

        return true;
    }
}
