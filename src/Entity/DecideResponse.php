<?php

namespace Acquia\LiftClient\Entity;

class DecideResponse extends CapturesBase
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
        return $this->getEntityValue('touch_identifier', '');
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
        return $this->getEntityValue('identity', '');
    }

    /**
     * Gets the 'identity_source' parameter.
     *
     * Type of visitor's primary identity information. Specific string (account, email,
     * facebook, twitter, tracking, name) or custom identifier type
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return string
     */
    public function getIdentitySource()
    {
        return $this->getEntityValue('identity_source', '');
    }

    /**
     * Gets the 'segments' parameter.
     *
     * @return Segment[]
     */
    public function getMatchedSegments()
    {
        $ret = [];
        $segments = $this->getEntityValue('segments', []);
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
