<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;

class Content extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        // Set content_hub as default content_connector_id when adding content
        $array['content_connector_id'] = 'content_hub';
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
        $this['title'] = $id;

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
     * @param ViewMode $viewMode
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Content
     */
    public function setViewMode(ViewMode $viewMode)
    {
        $this['view_mode'] = $viewMode->getArrayCopy();

        return $this;
    }

    /**
     * Gets the 'id' parameter.
     *
     * @return viewMode
     */
    public function getViewMode()
    {
        $viewMode = $this->getEntityValue('view_mode', []);

        return new ViewMode($viewMode);
    }
}
