<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;

class TestConfigTarget extends TestConfigBase implements TestConfigInterface
{
    /**
     * Sets the 'slot_id' parameter.
     *
     * @param string $slotId 
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\TestConfigTarget
     */
    public function setSlotId($slotId)
    {
        if (!is_string($slotId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['slot_id'] = $slotId;

        return $this;
    }

    /**
     * Gets the 'slot_id' parameter.
     *
     * @return string The Slot Id that the target rule is associated with
     */
    public function getSlotId()
    {
        return $this->getEntityValue('slot_id', '');
    }

    /**
     * Sets the 'content' parameter.
     *
     * @param Content[] $contentList
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\TestConfigTarget
     */
    public function setContentList(array $contentList)
    {
        $this['contents'] = [];
        foreach ($contentList as $content) {
            // We need to 'normalize' the data.
            $this['contents'][] = $content->getArrayCopy();
        }

        return $this;
    }

    /**
     * Gets the 'content' parameter.
     *
     * @return ContentView[] The list of content this rule applies to
     */
    public function getContentList()
    {
        $contentList = $this->getEntityValue('contents', '');
        $ret = [];
        foreach ($contentList as $content) {
            $ret[] = new ContentView($content);
        }

        return $ret;
    }
}
