<?php

namespace Acquia\LiftClient\Entity;

class DeploySiteResponse extends Entity
{
    /**
     * Retrieve values from 'error' parameter.
     *
     * @return string|null An error message, if present
     */
    public function getError()
    {
        $error = $this->getEntityValue('error', '');
        if (empty($error)) {
            return null;
        }

        return $error;
    }
}
