<?php

namespace Acquia\LiftClient;


class SlotResponse
{

    /**
     * @var \Psr\Http\Message\ResponseInterface
     *   The HTTP Response.
     */
    protected $response;

    /**
     * @var \Acquia\LiftClient\DataObject\Slot[]
     *   A list of slots.
     */
    protected $slots;

    /**
     * @param \Psr\Http\Message\ResponseInterface
     *   The HTTP Response
     * @param \Acquia\LiftClient\DataObject\Slot[]
     *   A list of slots
     */
    public function __construct($response, $slots = [])
    {
        $this->response = $response;
        $this->slots = $slots;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @return \Acquia\LiftClient\DataObject\Slot[]
     */
    public function getSlots() {
        return $this->slots;
    }
}
