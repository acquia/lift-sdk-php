<?php

namespace Acquia\LiftClient\Entity;

class CampaignPatchPayload extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    /**
     * Set Campaign Label
     */
    public function setLabel($label)
    {
        $this['label'] = $label;
    }

    /**
     * Get Campaign Label
     * 
     * @return string 
     */
    public function getLabel()
    {
        return $this->getEntityValue('label', '');
    }

    /**
     * Set Campaign Description
     */
    public function setDescription($description)
    {
        $this['description'] = $description;
    }

    /**
     * Returns campaign description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->getEntityValue('description', '');
    }

    /**
     * Set Campaign Type. Value can only be "target", "ab", "dynamic" or "mixed"
     */
    public function setType($type)
    {
        $this['type'] = $type;
    }

    /**
     * Returns Campaign Type. Value can only be "target", "ab", "dynamic" or "mixed"
     *
     * @return string 
     */
    public function getType()
    {
        return $this->getEntityValue('type', '');
    }

    /**
     * Set Campaign Status. Value can only be "unpublished", "scheduled", "published","completed","archived"
     */
    public function setStatus($status)
    {
        $this['status'] = $status;
    }

    /**
     * Returns Campaign Status. Value can only be "unpublished", "scheduled", "published","completed","archived"
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->getEntityValue('status', '');
    }

}
