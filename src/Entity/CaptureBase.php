<?php

namespace Acquia\LiftClient\Entity;

abstract class CaptureBase extends Entity
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
     * Gets the 'identifier' parameter.
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->getEntityValue('identity', '');
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
