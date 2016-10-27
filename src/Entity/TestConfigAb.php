<?php

namespace Acquia\LiftClient\Entity;

class TestConfigAb extends TestConfigBase
{
    /**
     * Sets the 'probabilities' parameter.
     *
     * @param Probability[] $probabilities
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\TestConfigAb
     */
    public function setProbabilities(array $probabilities)
    {
        $this['probabilities'] = [];
        foreach ($probabilities as $probability) {
            // We need to 'normalize' the data.
            $this['probabilities'][] = $probability->getArrayCopy();
        }

        return $this;
    }

    /**
     * Gets the 'probabilities' parameter.
     *
     * @return Probability[]
     */
    public function getProbabilities()
    {
        $probabilities = $this->getEntityValue('probabilities', '');
        $ret = [];
        foreach ($probabilities as $probability) {
            $ret[] = new Probability($probability);
        }

        return $ret;
    }
}
