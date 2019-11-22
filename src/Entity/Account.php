<?php

namespace Acquia\LiftClient\Entity;

class Account extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    /**
     * Returns account id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->getEntityValue('id', '');
    }

    /**
     * Returns account name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getEntityValue('name', '');
    }

    /**
     * Returns account description. Field is optional
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->getEntityValue('description', '');
    }

    /**
     * Returns account description. Field is optional
     *
     * @return string 
     */
    public function getLicenseId()
    {
        return $this->getEntityValue('license_id', '');
    }
}
