<?php

namespace Acquia\LiftClient\Entity;

abstract class CapturesBase extends Entity
{
    /**
     * Gets the 'touch_identifier' parameter.
     *
     * @return string
     */
    public function getTouchIdentifier()
    {
        return $this->getEntityValue('touch_identifier', '');
    }

    /**
     * Gets the 'identity' parameter.
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->getEntityValue('touch_identifier', '');
    }

    /**
     * Gets the 'identity_source' parameter.
     *
     * @return string
     */
    public function getIdentitySource()
    {
        return $this->getEntityValue('identity_source', '');
    }
}
