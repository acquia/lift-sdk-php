<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;
use Acquia\LiftClient\Utility\Utility;

class Goal extends \ArrayObject
{
    use EntityTrait;

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
     * @return \Acquia\LiftClient\Entity\Goal
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
     * @return string The Identifier of the Goal
     */
    public function getId()
    {
        return $this->getEntityValue('id', '');
    }

    /**
     * Sets the 'name' parameter.
     *
     * @param string $name
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Goal
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['name'] = $name;

        return $this;
    }

    /**
     * Gets the 'name' parameter.
     *
     * @return string The Name of the Goal
     */
    public function getName()
    {
        return $this->getEntityValue('name', '');
    }

    /**
     * Sets the 'description' parameter.
     *
     * @param string $description
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Goal
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
     * @return string The Description of the Goal
     */
    public function getDescription()
    {
        return $this->getEntityValue('description', '');
    }

    /**
     * Sets the 'rule_ids' parameter.
     *
     * @param array $ruleIds
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Goal
     */
    public function setRuleIds(array $ruleIds)
    {
        if (Utility::arrayDepth($ruleIds) > 1) {
            throw new LiftSdkException('Rule Ids argument is more than 1 level deep.');
        }

        // Set only the array values to the rule_ids property.
        $this['rule_ids'] = array_values($ruleIds);

        return $this;
    }

    /**
     * Gets the 'rule_ids' parameter.
     *
     * @return array The Rule Identifiers
     */
    public function getRuleIds()
    {
        return $this->getEntityValue('rule_ids', array());
    }

    /**
     * Sets the 'site_ids' parameter.
     *
     * @param array $siteIds
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Goal
     */
    public function setSiteIds(array $siteIds)
    {
        if (Utility::arrayDepth($siteIds) > 1) {
            throw new LiftSdkException('site_ids argument is more than 1 level deep.');
        }

        // Set only the array values to the site_ids property.
        $this['site_ids'] = array_values($siteIds);

        return $this;
    }

    /**
     * Gets the 'site_ids' parameter.
     *
     * @return array The Site Identifiers
     */
    public function getSiteIds()
    {
        return $this->getEntityValue('site_ids', array());
    }

    /**
     * Sets the 'event_names' parameter.
     *
     * @param array $eventNames
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Goal
     */
    public function setEventNames(array $eventNames)
    {
        if (Utility::arrayDepth($eventNames) > 1) {
            throw new LiftSdkException('Event Names argument is more than 1 level deep.');
        }

        // Set only the array values to the event_names property.
        $this['event_names'] = array_values($eventNames);

        return $this;
    }

    /**
     * Gets the 'rule_ids' parameter.
     *
     * @return array The Rule Identifiers
     */
    public function getEventNames()
    {
        return $this->getEntityValue('event_names', array());
    }

    /**
     * Sets the 'global' parameter.
     *
     * @param bool $global
     *
     * @return \Acquia\LiftClient\Entity\Slot
     */
    public function setGlobal($global)
    {
        $this['global'] = $global;

        return $this;
    }

    /**
     * Gets the 'global' parameter.
     *
     * @return bool
     */
    public function getGlobal()
    {
        return $this->getEntityValue('global', false);
    }

    /**
     * Sets the 'value' parameter.
     *
     * @param float|int $value
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Goal
     */
    public function setValue($value)
    {
        if (!is_float($value) && !is_int($value)) {
            throw new LiftSdkException('Argument must be an instance of float or int.');
        }
        $this['value'] = $value;

        return $this;
    }

    /**
     * Gets the 'value' parameter.
     *
     * @return float
     */
    public function getValue()
    {
        return $this->getEntityValue('value', '');
    }
}
