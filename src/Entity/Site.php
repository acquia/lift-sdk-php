<?php

namespace Acquia\LiftClient\Entity;

class Site extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    /**
     * Gets the 'id' parameter.
     *
     * @return string The Identifier of the Segment
     */
    public function getId()
    {
        return $this->getEntityValue('id', '');
    }

    /**
     * Gets the 'name' parameter.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getEntityValue('name', '');
    }

    /**
     * Gets the 'description' parameter.
     *
     * @return string The Description of the Goal
     */
    public function getUrl()
    {
        return $this->getEntityValue('url', '');
    }
}
