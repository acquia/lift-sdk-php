<?php

namespace Acquia\LiftClient\Entity;
use DateTime;

/**
 * Primarily used for /search endpoint
 */
use Acquia\LiftClient\Exception\LiftSdkException;

/**
 * Content is used is
 */

class Content extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    /**
     * @param string $id
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Content
     */
    public function setId($id)
    {
        if (!is_string($id)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['id'] = $id;

        return $this;
    }

    /**
     * Gets the 'id' parameter.
     *
     * @return string
     */
    public function getId()
    {
        return $this->getEntityValue('id', '');
    }

    /**
     * @param string $title
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Content
     */
    public function setTitle($title)
    {
        if (!is_string($title)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['title'] = $title;

        return $this;
    }

    /**
     * Gets the 'title' parameter.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getEntityValue('title', '');
    }

    /**
     * 
     * @param string $contentConnectorId
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Content
     */
    public function setContentConnectorId($contentConnectorId)
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
        return $this->getEntityValue('content_connector_id', '');
    }

    /**
     * Gets the 'created' parameter.
     *
     * @return DateTime|false
     */
    public function getCreated()
    {
        $date = $this->getEntityValue('created', 0);
        // The ISO8601 DateTime format is not compatible with ISO-8601, but is left this way for backward compatibility
        // reasons. Use DateTime::ATOM or DATE_ATOM for compatibility with ISO-8601 instead.
        // See http://php.net/manual/en/class.datetime.php
        $datetime = DateTime::createFromFormat(DateTime::ATOM, $date);

        return $datetime;
    }

    /**
     * Gets the 'updated' parameter.
     *
     * @return DateTime|false
     */
    public function getUpdated()
    {
        $date = $this->getEntityValue('updated', 0);
        // The ISO8601 DateTime format is not compatible with ISO-8601, but is left this way for backward compatibility
        // reasons. Use DateTime::ATOM or DATE_ATOM for compatibility with ISO-8601 instead.
        // See http://php.net/manual/en/class.datetime.php
        $datetime = DateTime::createFromFormat(DateTime::ATOM, $date);

        return $datetime;
    }

    /**
     * @param string $baseUrl
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Content
     */
    public function setBaseUrl($baseUrl)
    {
        if (!is_string($baseUrl)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['base_url'] = $baseUrl;

        return $this;
    }

    /**
     * Gets the 'base_url' parameter.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->getEntityValue('base_url', '');
    }

    /**
     * @param ViewMode[] $viewModes
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\ViewMode[]
     */
    public function setViewModes(array $viewModes)
    {
        $this['view_modes'] = [];
        foreach ($viewModes as $viewMode) {
            // We need to 'normalize' the data.
            $this['view_modes'][] = $viewMode->getArrayCopy();
        }

        return $this;
    }

    /**
     * Gets the 'view_modes' parameter.
     *
     * @return \Acquia\LiftClient\Entity\ViewMode[]
     */
    public function getViewModes()
    {        
        $data = $this->getEntityValue('view_modes', []);

        $viewModes = [];
        foreach ($data as $dataItem) {
            $viewModes[] = new ViewMode($dataItem);
        }

        return $viewModes;
    }
}
