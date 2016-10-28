<?php

namespace Acquia\LiftClient\Entity;

class LiftError extends Error
{
    /**
     * Gets the 'code' parameter.
     *
     * @return string The error code
     */
    public function getCode()
    {
        return $this->getEntityValue('code', '');
    }
}
