<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;
use Acquia\LiftClient\Utility\Utility;

class Decide extends Entity
{
    /**
     * Sets the 'slots' parameter.
     *
     * @param array $slotIds list of slot identifiers we want a decision for
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Decide
     */
    public function setSlots(array $slotIds)
    {
        if (Utility::arrayDepth($slotIds) > 1) {
            throw new LiftSdkException('Slot Ids argument is more than 1 level deep.');
        }
        $this['slots'] = $slotIds;

        return $this;
    }

    /**
     * Sets the 'url' parameter.
     *
     * @param string $url The url where we want to get decisions for
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Decide
     */
    public function setUrl($url)
    {
        if (!is_string($url)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['url'] = $url;

        return $this;
    }

    /**
     * Sets the 'do_not_track' parameter.
     *
     * @param bool $doNotTrack Flag to indicate whether the person should not be tracked
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Decide
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
     * Sets the 'preview' parameter.
     *
     * @param bool $preview Flag to indicate whether the person should not be tracked
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Decide
     */
    public function setPreview($preview)
    {
        if (!is_bool($preview)) {
            throw new LiftSdkException('Argument must be an instance of boolean.');
        }
        $this['preview'] = $preview;

        return $this;
    }

    /**
     * Sets the 'segments' parameter.
     *
     * @param array $segments list of segment ids that will be used for decision process
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Decide
     */
    public function setSegments(array $segments)
    {
        if (Utility::arrayDepth($segments) > 1) {
            throw new LiftSdkException('Segment Ids argument is more than 1 level deep.');
        }
        $this['segments'] = $segments;

        return $this;
    }

    /**
     * Sets the 'touch_identifier' parameter.
     *
     * @param string $touchIdentifier Internal identifier for the touch, if this field is left empty, lift will
     *                                generate a touch identifier and include it in the response
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Decide
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
     * @return \Acquia\LiftClient\Entity\Decide
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
     * @return \Acquia\LiftClient\Entity\Decide
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
     * Sets the 'identity_expiry' parameter.
     *
     * @param string $identityExpiry - Expiry date of identity in UNix time (seconds since 1970)
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Decide
     */
    public function setIdentityExpiry($identityExpiry)
    {
        if (!is_int($identityExpiry)) {
            throw new LiftSdkException('Argument must be an instance of integer.');
        }
        $this['identity_expiry'] = $identityExpiry;

        return $this;
    }

    /**
     * Sets the 'captures' parameter.
     *
     * @param Capture[] $captures List of captures
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Decide
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
