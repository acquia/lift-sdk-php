<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;
use DateTime;

class Slot extends Entity
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
     * @return \Acquia\LiftClient\Entity\Slot
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
     * Sets the 'label' parameter.
     *
     * @param string $label
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Slot
     */
    public function setLabel($label)
    {
        if (!is_string($label)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['label'] = $label;

        return $this;
    }

    /**
     * Gets the 'id' parameter.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->getEntityValue('label', '');
    }

    /**
     * Sets the 'description' parameter.
     *
     * @param string $description
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Slot
     */
    public function setDescription($description)
    {
        if (!is_string($description)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['description'] = $description;

        return $this;
    }

    /**
     * Gets the 'description' parameter.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getEntityValue('description', '');
    }

    /**
     * Sets the 'css_selector' parameter.
     *
     * @param string $css_selector
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Slot
     */
    public function setCssSelector($css_selector)
    {
      if (!is_string($css_selector)) {
        throw new LiftSdkException('Argument must be an instance of string.');
      }
      $this['css_selector'] = $css_selector;

      return $this;
    }

    /**
     * Gets the 'css_selector' parameter.
     *
     * @return string
     */
    public function getCssSelector()
    {
      return $this->getEntityValue('css_selector', '');
    }

    /**
     * Sets the 'status' parameter.
     *
     * @param bool $status
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Slot
     */
    public function setStatus($status)
    {
        if (!is_bool($status)) {
            throw new LiftSdkException('Argument must be an instance of boolean.');
        }
        if ($status) {
            $this['status'] = 'enabled';
        } else {
            $this['status'] = 'disabled';
        }

        return $this;
    }

    /**
     * Gets the 'status' parameter. True if the slot is published. False is it is not.
     *
     * @return bool
     */
    public function getStatus()
    {
        $status = $this->getEntityValue('status', '');
        if ($status == 'enabled') {
            return true;
        }

        return false;
    }

    /**
     * Sets the 'visibility' parameter.
     *
     * @param \Acquia\LiftClient\Entity\Visibility $visibility
     *
     * @return \Acquia\LiftClient\Entity\Slot
     */
    public function setVisibility(Visibility $visibility)
    {
        // We need to 'normalize' the data.
        $this['visibility'] = $visibility->getArrayCopy();

        return $this;
    }

    /**
     * Gets the 'visibility' parameter.
     *
     * @return Visibility
     */
    public function getVisibility()
    {
        $visibility = $this->getEntityValue('visibility', []);

        return new Visibility($visibility);
    }

    /**
     * Gets the 'created' parameter.
     *
     * @return DateTime|false
     */
    public function getCreated()
    {
        $date = $this->getEntityValue('created', '');
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
        $date = $this->getEntityValue('updated', '');
        // The ISO8601 DateTime format is not compatible with ISO-8601, but is left this way for backward compatibility
        // reasons. Use DateTime::ATOM or DATE_ATOM for compatibility with ISO-8601 instead.
        // See http://php.net/manual/en/class.datetime.php
        $datetime = DateTime::createFromFormat(DateTime::ATOM, $date);

        return $datetime;
    }
}
