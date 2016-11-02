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
     * @return string
     */
    public function getContentList()
    {
        $contentList = $this->getEntityValue('content', '');
        $ret = [];
        foreach ($contentList as $content) {
            $ret[] = new Content($content);
        }

        return $ret;
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
