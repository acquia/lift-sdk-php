<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;

class TestConfigAb extends TestConfigBase
{
    
    /**
     * Sets the 'variation_id' parameter.
     *
     * @param string $variationId 
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\TestConfigAb
     */
    public function setVariationId($variationId)
    {
        if (!is_string($variationId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['variation_id'] = $variationId;

        return $this;
    }

    /**
     * Gets the 'variation_id' parameter.
     *
     * @return string The Variation Id associated with the AB rule
     */
    public function getVariationId()
    {
        return $this->getEntityValue('variation_id', '');
    }

    /**
     * Sets the 'variation_label' parameter.
     *
     * @param string $variationLabel
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\TestConfigAb
     */
    public function setVariationLabel($variationLabel)
    {
        if (!is_string($variationLabel)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['variation_label'] = $variationLabel;

        return $this;
    }

    /**
     * Gets the 'variation_label' parameter.
     *
     * @return string The Variation Label associated with the AB rule
     */
    public function getVariationLabel()
    {
        return $this->getEntityValue('variation_label', '');
    }

    /**
     * Sets the 'probability' parameter.
     *
     * @param double $probability
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\TestConfigAb
     */
    public function setProbability($probability)
    {
        if (!is_numeric($probability)) {
            throw new LiftSdkException('Argument must be numeric');
        }

        if ($probability > 1 || $probability < 0) {
            throw new LiftSdkException('Invalid value of probabiity');
        }

        $this['probability'] = $probability;

        return $this;
    }

    /**
     * Gets the 'probabilities' parameter.
     *
     * @return float
     */
    public function getProbability()
    {
        return $this->getEntityValue('probability', '');
    }

    /**
     * Sets the 'slots' parameter.
     *
     * @param TestConfigTarget[] $slotList - the slot list structure is the exact same as the TestConfigTarget structure
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\TestConfigAb
     */
    public function setSlotList(array $slotList)
    {
        $this['slots'] = [];
        foreach ($slotList as $slot) {
            // We need to 'normalize' the data.
            $this['slots'][] = $slot->getArrayCopy();
        }

        return $this;
    }

    /**
     * Gets the 'slots' parameter.
     *
     * @return TestConfigTarget[] The list of slots this rule applies to. Slots uses the same structure as TestConfigTarget so it will be re-used here
     */
    public function getSlotList()
    {
        $slotList = $this->getEntityValue('slots', '');
        $ret = [];
        foreach ($slotList as $slot) {
            $ret[] = new TestConfigTarget($slot);
        }

        return $ret;
    }
}
