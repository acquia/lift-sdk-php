<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;
use DateTime;

class Rule extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    var $ALLOWED_RULE_TYPES = array('target', 'ab', 'dynamic');

    /**
     * Sets the 'id' parameter.
     *
     * @param string $id
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Rule
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
     * @return string The Identifier of the Rule
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
     * @return \Acquia\LiftClient\Entity\Rule
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
     * Gets the 'label' parameter.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->getEntityValue('label', '');
    }

    /**
     * Sets the 'segment' parameter.
     *
     * @param string $segment
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function setSegment($segment)
    {
        if (!is_string($segment)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['segment'] = $segment;

        return $this;
    }

    /**
     * Gets the 'segment' parameter.
     *
     * @return string
     */
    public function getSegment()
    {
        return $this->getEntityValue('segment', '');
    }

    /**
     * Sets the 'priority' parameter.
     *
     * Higher number means the rule display / apply first.
     *
     * @param int $priority
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function setPriority($priority)
    {
        if (!is_integer($priority)) {
            throw new LiftSdkException('Argument must be an instance of integer.');
        }
        $this['priority'] = $priority;

        return $this;
    }

    /**
     * Gets the 'priority' parameter.
     *
     * @return int The priority of the Rule
     */
    public function getPriority()
    {
        return $this->getEntityValue('priority', 0);
    }

    /**
     * Sets the 'status' parameter.
     *
     * @param string $status
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function setStatus($status)
    {
        if (!is_string($status)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        if ($status !== 'published' && $status !== 'unpublished' && $status !== 'archived' 
            && $status !== 'scheduled' && $status !== 'completed') {
            throw new LiftSdkException('Status must one of the following value {published, unpublishedm, archived, scheduled, completed}');
        }
        $this['status'] = $status;

        return $this;
    }

    /**
     * Gets the 'status' parameter.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getEntityValue('status', '');
    }

    /**
     * Sets the 'type' parameter.
     *
     * @param string $type
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function setType($type)
    {
        if (!is_string($type)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        if ($type !== 'target' && $type !== 'ab' && $type !== 'dynamic') {
            throw new LiftSdkException('Type much be either target, ab or dynamic');
        }
        $this['type'] = $type;

        return $this;
    }

    /**
     * Gets the 'type' parameter.
     *
     * @return string
     */
    public function getType()
    {
        return $this->getEntityValue('type', '');
    }

    /**
     * Sets the 'description' parameter.
     *
     * @param string $description
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Rule
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
     * @return string The Description of the Rule
     */
    public function getDescription()
    {
        return $this->getEntityValue('description', '');
    }

    /**
     * Sets the 'campaign_id' parameter.
     *
     * @param string $campaignId
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function setCampaignId($campaignId)
    {
        if (!is_string($campaignId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['campaign_id'] = $campaignId;

        return $this;
    }

    /**
     * Gets the 'campaign_id' parameter.
     *
     * @return string The campaign id associated with rule id
     */
    public function getCampaignId()
    {
        return $this->getEntityValue('campaign_id', '');
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
     * Sets the Rule test_config property.
     *
     * @param \Acquia\LiftClient\Entity\TestConfigInterface[] $testConfig
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function setTestConfig(array $testConfig)
    {
        // To facilitate TypeHinting in PHPStorm we redefine what $testConfig is
        // here. We know it inherits from the TestConfigInterface and is a child
        // of TestConfigBase.
        /** @var \Acquia\LiftClient\Entity\TestConfigBase $testConfig */

        // Get class of the testConfig object.
        $type = get_class($testConfig[0]);

        // Only allow one test type at a time.
        $this['testconfig'] = [];
        switch ($type) {
            case 'Acquia\LiftClient\Entity\TestConfigTarget':
                $this['testconfig']['target'] = $testConfig;
                break;
            case 'Acquia\LiftClient\Entity\TestConfigAb':

                $this['testconfig']['ab'] = $testConfig;
                break;
            case 'Acquia\LiftClient\Entity\TestConfigDynamic':
                $this['testconfig']['dynamic'] = $testConfig;
                break;
        }

        return $this;
    }

    /**
     * Gets the 'test_config' parameter.
     *
     * @return \Acquia\LiftClient\Entity\TestConfigInterface|null $testConfig
     */
    public function getTestConfig()
    {
        $testConfig = $this->getEntityValue('testconfig', []);
        // We know the array only has one possible set of options.
        // Get its key and value.
        reset($testConfig);
        $key = key($testConfig);

        // If key not a valid rule type, function will return null
        if (!in_array($key, $this->ALLOWED_RULE_TYPES)){
            return null;
        }

        $ret = [];
        foreach ($testConfig as $tc){
            // Based on the config, we load the different objects.
            switch ($key) {
                case 'target':
                    array_push($ret, new TestConfigTarget($testConfig[$key]));
                    break;
                case 'ab':
                    array_push($ret, new TestConfigAb($testConfig[$key]));
                    break;
                case 'dynamic':
                    array_push($ret, new TestConfigDynamic($testConfig[$key]));
                    break;
            }
        }
        
        return $ret;
    }

    /**
     * Gets the 'errors' parameter.
     *
     * @return Error|null The errors, if there were any
     */
    public function getError()
    {
        $error = $this->getEntityValue('error', null);
        if ($error == null) {
            return null;
        }

        return new Error($error);
    }
}
