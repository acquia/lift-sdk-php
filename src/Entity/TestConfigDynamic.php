<?php

namespace Acquia\LiftClient\Entity;

class TestConfigDynamic extends TestConfigBase implements TestConfigInterface
{
    /**
     * Sets the 'slot_id' parameter.
     *
     * @param string $slotId 
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\TestConfigDynamic
     */
    public function setSlotId($slotId)
    {
        if (!is_string($slotId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['slot_id'] = $slot_id;

        return $this;
    }

    /**
     * Gets the 'slot_id' parameter.
     *
     * @return string The Slot Id that the target rule is associated with
     */
    public function geSlotId()
    {
        return $this->getEntityValue('slot_id', '');
    }

    /**
     * Sets the 'filter_id' parameter.
     *
     * @param string $filterId 
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\TestConfigDynamic
     */
    public function setFilterId($filterId)
    {
        if (!is_string($filterId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['filter_id'] = $filterId;

        return $this;
    }

    /**
     * Gets the 'filterId' parameter.
     *
     * @return string The Filter Id associated with dynamic rule
     */
    public function getFilterId()
    {
        return $this->getEntityValue('filter_id', '');
    }

/**
     * Sets the 'algorithm' parameter.
     *
     * @param string $algorithm 
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\TestConfigDynamic
     */
    public function setAlgorithm($algorithm)
    {
        if (!is_string($algorithm)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['algorithm'] = $algorithm;

        return $this;
    }

    /**
     * Gets the 'algorithm' parameter.
     *
     * @return string The Filter Id associated with dynamic rule
     */
    public function getAlgorithm()
    {
        return $this->getEntityValue('filter_id', '');
    }

    /**
     * Sets the 'content' parameter.
     *
     * @param Content[] $contentList
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\TestConfigDynamic
     */
    public function setContentList(array $contentList)
    {
        $this['content'] = [];
        foreach ($contentList as $content) {
            // We need to 'normalize' the data.
            $this['content'][] = $content->getArrayCopy();
        }

        return $this;
    }

    /**
     * Gets the 'content' parameter.
     *
     * @return Content[] The list of content this rule applies to
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

}
