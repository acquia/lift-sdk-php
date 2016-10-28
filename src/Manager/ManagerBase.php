<?php

namespace Acquia\LiftClient\Manager;

abstract class ManagerBase
{
    /**
     * @var \Acquia\LiftClient\Lift The Acquia Lift Client
     */
    protected $client;

    /**
     * @param \Acquia\LiftClient\Lift $client The Acquia Lift Client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }
}
