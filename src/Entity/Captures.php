<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;

class Captures extends CapturesBase
{
    /**
     * Sets the 'touch_identifier' parameter.
     *
     * @param string $touchIdentifier Internal identifier for the touch, if this field is left empty, lift will
     *                                generate a touch identifier and include it in the response
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Captures
     */
    public function setTouchIdentifier($touchIdentifier)
    {
        if (!is_string($touchIdentifier)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['touch_identifier'] = $touchIdentifier;

        return $this;
    }

    /**
     * Sets the 'identity' parameter.
     *
     * @param string $identity Visitor's primary identity information
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Captures
     */
    public function setIdentity($identity)
    {
        if (!is_string($identity)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['identity'] = $identity;

        return $this;
    }

    /**
     * Sets the 'identity_source' parameter.
     *
     * @param string $identitySource Type of visitor's primary identity information. Specific string (account, email,
     *                               facebook, twitter, tracking, name) or custom identifier type
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Captures
     */
    public function setIdentitySource($identitySource)
    {
        if (!is_string($identitySource)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['identity_source'] = $identitySource;

        return $this;
    }

    /**
     * Sets the 'do_not_track' parameter.
     *
     * @param bool $doNotTrack Flag to indicate whether the person should not be tracked
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Captures
     */
    public function setDoNotTrack($doNotTrack)
    {
        if (!is_bool($doNotTrack)) {
            throw new LiftSdkException('Argument must be an instance of boolean.');
        }
        $this['do_not_track'] = $doNotTrack;

        return $this;
    }

    /**
     * Sets the 'return_segments' parameter.
     *
     * @param bool $returnSegments Flag to indicate whether the person should not be tracked
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Captures
     */
    public function setReturnSegments($returnSegments)
    {
        if (!is_bool($returnSegments)) {
            throw new LiftSdkException('Argument must be an instance of boolean.');
        }
        $this['return_segments'] = $returnSegments;

        return $this;
    }

    /**
     * Sets the 'site_id' parameter.
     *
     * @param string $siteId The customer site matching external_site_id in the configuration database. Used for
     *                       filtering segments to evaluate and the default site_id for captures. If not specified then
     *                       the last capture is used to calculate the site_id for filtering segments
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Captures
     */
    public function setSiteId($siteId)
    {
        if (!is_string($siteId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['site_id'] = $siteId;

        return $this;
    }

    /**
     * Sets the 'captures' parameter.
     *
     * @param Capture[] $captures List of captures
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Captures
     */
    public function setCaptures($captures)
    {
        $this['captures'] = [];
        foreach ($captures as $capture) {
            $this['captures'][] = $capture->getArrayCopy();
        }

        return $this;
    }
}
