<?php

namespace Acquia\LiftClient;

use DateTime;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;

class Slot extends \ArrayObject
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
     * @return \Acquia\LiftClient\Slot
     */
    public function setId($id)
    {
        $this['id'] = $id;

        return $this;
    }

    /**
     * Gets the 'id' parameter.
     *
     * @return string
     */
    public function getid()
    {
        return $this->getValue('id', '');
    }

    /**
     * Sets the 'label' parameter.
     *
     * @param string $label
     *
     * @return \Acquia\LiftClient\Slot
     */
    public function setLabel($label)
    {
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
        return $this->getValue('label', '');
    }

    /**
     * Sets the 'description' parameter.
     *
     * @param string $description
     *
     * @return \Acquia\LiftClient\Slot
     */
    public function setDescription($description)
    {
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
        return $this->getValue('description', '');
    }

    /**
     * Sets the 'html' parameter.
     *
     * @param string $html
     *
     * @return \Acquia\LiftClient\Slot
     */
    public function setHtml($html)
    {
        $this['html'] = $html;

        return $this;
    }

    /**
     * Gets the 'html' parameter.
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->getValue('html', '');
    }

    /**
     * Sets the 'status' parameter.
     *
     * @param bool $status
     *
     * @return \Acquia\LiftClient\Slot
     */
    public function setStatus($status)
    {
        if ($status === TRUE) {
            $this['status'] = 'enabled';
        }
        else {
            $this['status'] = 'disabled';
        }

        return $this;
    }

    /**
     * Gets the 'status' parameter.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getValue('status', '');
    }

    /**
     * Sets the 'visibility' parameter.
     *
     * @param \Acquia\LiftClient\Visibility $visibility
     *
     * @return \Acquia\LiftClient\Slot
     */
    public function setVisibility(Visibility $visibility)
    {
        $this['visibility'] = $visibility;

        return $this;
    }

    /**
     * Gets the 'visibility' parameter.
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->getValue('visibility', '');
    }

    /**
     * Gets the 'created' parameter.
     *
     * @return DateTime
     */
    public function getCreated()
    {
        $date = $this->getValue('created', '');
        $datetime = DateTime::createFromFormat(DateTime::ISO8601, $date);
        return $datetime;
    }

    /**
     * Gets the 'updated' parameter.
     *
     * @return DateTime
     */
    public function getUpdated()
    {
        $date = $this->getValue('updated', '');
        $datetime = DateTime::createFromFormat(DateTime::ISO8601, $date);
        return $datetime;
    }

    /**
     * Returns the json representation of the current object.
     *
     * @return string
     */
    public function json()
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new CustomNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        return $serializer->serialize($this, 'json');
    }

    /**
     *
     * @param string $key
     * @param string $default
     *
     * @return mixed
     */
    protected function getValue($key, $default)
    {
        return isset($this[$key]) ? $this[$key] : $default;
    }
}
