<?php

namespace Acquia\LiftClient\Entity;

class CampaignResponse extends Entity
{
    /**
     * Gets the 'touch_identifier' parameter.
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return string
     */
    public function getTouchIdentifier()
    {
        $lwr = $this->getLiftWebResponse();

        return $lwr->getEntityValue('touch_identifier', '');
    }

    private function getLiftWebResponse()
    {
        $lwr = $this->getEntityValue('lift_web_response', []);

        return new Entity($lwr);
    }

    /**
     * Gets the 'identity' parameter.
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return string
     */
    public function getIdentity()
    {
        $lwr = $this->getLiftWebResponse();

        return $lwr->getEntityValue('identity', '');
    }

    /**
     * Returns the total count of campaign(s). Default value is 0
     *
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getEntityValue('total_count', 0);
    }

    /**
     * Returns list of Campaign(s). Default is empty list 
     *
     * @return Campaign[]
     */
    public function getCampaigns()
    {
        $campaigns = $this->getEntityValue('campaigns', []);
        foreach ($campaigns as $c) {
            $ret[] = new Campaign($c);
        }

        return $ret;
    }

}
