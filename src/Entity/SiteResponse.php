<?php

namespace Acquia\LiftClient\Entity;

class SiteResponse extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    /**
     * Gets the 'status' parameter.
     *
     * @return string Status update for create/update customer site
     */
    public function getStatus()
    {
        return $this->getEntityValue('status', '');
    }

    /**
     * Returns Site object
     *
     * @return Site
     */
    public function getItem()
    {
        $siteData = $this->getEntityValue('item', []);

        return new Site($siteData);
    }

    /**
     * Returns a list of errors. If not present, it will return empty array
     *
     * @return Error[] The Description of the Goal
     */
    public function getErrors()
    {
        $errors = [];
        $data = $this->getEntityValue('errors', []);

        foreach ($data as $dataItem) {
            $errors[] = new Error($dataItem);
        }

        return $errors;
    }
}
