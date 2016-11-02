<?php

namespace Acquia\LiftClient\Entity;

class Decision extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    /**
     * Gets the 'slot_id' parameter.
     *
     * @return string
     */
    public function getSlotId()
    {
        return $this->getEntityValue('slot_id', '');
    }

    /**
     * Gets the 'slot_name' parameter.
     *
     * @return string
     */
    public function getSlotName()
    {
        return $this->getEntityValue('slot_name', '');
    }

    /**
     * Gets the 'content' parameter.
     *
     * @return Content
     */
    public function getContent()
    {
        $content = $this->getEntityValue('content', []);

        return new Content($content);
    }

    /**
     * Gets the 'policy' parameter.
     *
     * @return string
     */
    public function getPolicy()
    {
        return $this->getEntityValue('policy', '');
    }

    /**
     * Gets the 'rule_id' parameter.
     *
     * @return string
     */
    public function getRuleId()
    {
        return $this->getEntityValue('rule_id', '');
    }

    /**
     * Gets the 'rule_id' parameter.
     *
     * @return string
     */
    public function getRuleName()
    {
        return $this->getEntityValue('rule_name', '');
    }
}
