<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;

class Probability extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    /**
     * Sets the 'id' parameter.
     *
     * @param string $contentId
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Probability
     */
    public function setContentId($contentId)
    {
        if (!is_string($contentId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['id'] = $contentId;

        return $this;
    }

    /**
     * Gets the 'id' parameter.
     *
     * @return string The Identifier of the Content Identifier
     */
    public function getContentId()
    {
        return $this->getEntityValue('id', '');
    }

    /**
     * @param string $contentConnectorId
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Probability
     */
    public function setContentConnectorId($contentConnectorId = 'content_hub')
    {
        if (!is_string($contentConnectorId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['content_connector_id'] = $contentConnectorId;

        return $this;
    }

    /**
     * Gets the 'content_connector_id' parameter.
     *
     * @return string
     */
    public function getContentConnectorId()
    {
        return $this->getEntityValue('content_connector_id', 'content_hub');
    }

    /**
     * Sets the 'content_view_id' parameter.
     *
     * @param string $contentViewId
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Probability
     */
    public function setContentViewId($contentViewId)
    {
        if (!is_string($contentViewId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['content_view_id'] = $contentViewId;

        return $this;
    }

    /**
     * Gets the 'content_view_id' parameter.
     *
     * @return string The Content View Mode Identifier
     */
    public function getContentViewId()
    {
        return $this->getEntityValue('content_view_id', '');
    }

    /**
     * Sets the 'fraction' parameter.
     *
     * @param int|float $fraction
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Probability
     */
    public function setFraction($fraction)
    {
        if (!is_numeric($fraction)) {
            throw new LiftSdkException('Argument must be an instance of any numeric type (int|float).');
        }
        if ($fraction > 1 || $fraction < 0) {
            throw new LiftSdkException('Argument must be between 0 and 1 or those values themselves.');
        }
        $this['fraction'] = $fraction;

        return $this;
    }

    /**
     * Gets the 'fraction' parameter.
     *
     * @return int|float The fraction
     */
    public function getFraction()
    {
        return $this->getEntityValue('fraction', 0);
    }
}
