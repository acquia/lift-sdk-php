<?php

namespace Acquia\LiftClient\Entity;

class TestConfigBase extends Entity implements TestConfigInterface
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }
}
