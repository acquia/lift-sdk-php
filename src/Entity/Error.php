<?php

namespace Acquia\LiftClient\Entity;

class Error extends Entity
{
    /**
     * Gets the 'code' parameter.
     *
     * @return int The error code
     */
    public function getCode()
    {
        return $this->getEntityValue('code', 0);
    }

    /**
     * Gets the 'message' parameter.
     *
     * @return string The error message
     */
    public function getMessage()
    {
        return $this->getEntityValue('message', '');
    }
}
