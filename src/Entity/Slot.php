<?php

namespace Acquia\LiftClient\Entity;

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
     * @return \Acquia\LiftClient\Entity\Slot
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
    public function getId()
    {
        return $this->getEntityValue('id', '');
    }

    /**
     * Sets the 'label' parameter.
     *
     * @param string $label
     *
     * @return \Acquia\LiftClient\Entity\Slot
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
        return $this->getEntityValue('label', '');
    }

    /**
     * Sets the 'description' parameter.
     *
     * @param string $description
     *
     * @return \Acquia\LiftClient\Entity\Slot
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
        return $this->getEntityValue('description', '');
    }

    /**
     * Sets the 'html' parameter.
     *
     * @param string $html
     *
     * @return \Acquia\LiftClient\Entity\Slot
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
        return $this->getEntityValue('html', '');
    }

    /**
     * Sets the 'status' parameter.
     *
     * @param bool $status
     *
     * @return \Acquia\LiftClient\Entity\Slot
     */
    public function setStatus($status)
    {
        if ($status === true) {
            $this['status'] = 'enabled';
        } else {
            $this['status'] = 'disabled';
        }

        return $this;
    }

    /**
     * Gets the 'status' parameter.
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
     * @return DateTime
     */
    public function getCreated()
    {
        $date = $this->getEntityValue('created', '');
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
        $date = $this->getEntityValue('updated', '');
        $datetime = DateTime::createFromFormat(DateTime::ISO8601, $date);

        return $datetime;
    }
}
