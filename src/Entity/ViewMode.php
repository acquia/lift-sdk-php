<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;

class ViewMode extends Entity
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
     * @param string $id
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\ViewMode
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
     * Gets the 'label' parameter.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->getEntityValue('label', '');
    }

    /**
     * Gets the 'html' parameter.
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->getEntityValue('html', '');
    }

    /**
     * Gets the 'preview_image' parameter.
     *
     * @return string
     */
    public function getPreviewImage()
    {
        return $this->getEntityValue('preview_image', '');
    }
}
