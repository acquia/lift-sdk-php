<?php

namespace Acquia\LiftClient\Entity;

class DecideResponse extends Entity
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

    private function getLiftWebResponse() {
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
     * Gets the 'identity_source' parameter.
     *
     * Type of visitor's primary identity information. Specific string (account, email,
     * facebook, twitter, tracking, name) or custom identifier type
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return int
     */
    public function getIdentityExpiry()
    {
        $lwr = $this->getLiftWebResponse();
        return $lwr->getEntityValue('identity_expiry', 0);
    }

    /**
     * Gets the 'segments' parameter.
     *
     * @return Segment[]
     */
    public function getMatchedSegments()
    {
        $lwr = $this->getLiftWebResponse();
        $ret = [];
        $segments = $lwr->getEntityValue('segments', []);
        foreach ($segments as $segment) {
            $ret[] = new Segment($segment);
        }

        return $ret;
    }

    /**
     * gets the 'set_do_not_track' parameter.
     *
     * Flag to indicate whether the person should not be tracked
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return bool
     */
    public function getSetDoNotTrack()
    {
        return $this->getEntityValue('set_do_not_track', false);
    }

    /**
     * Gets the 'matched_segments' parameter.
     *
     * @return Segment[]
     */
    public function getDecisions()
    {
        $ret = [];
        $decisions = $this->getEntityValue('decisions', []);
        foreach ($decisions as $decision) {
            $ret[] = new Decision($decision);
        }

        return $ret;
    }
}
