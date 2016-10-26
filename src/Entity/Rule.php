<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;
use DateTime;

class Rule extends \ArrayObject
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
     * Sets the 'slot_id' parameter.
     *
     * @param string $slotId
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function setSlotId($slotId)
    {
        if (!is_string($slotId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['slot_id'] = $slotId;

        return $this;
    }

    /**
     * Gets the 'description' parameter.
     *
     * @return string The Description of the Rule
     */
    public function getSlotId()
    {
        return $this->getEntityValue('slot_id', '');
    }

    /**
     * Sets the 'weight' parameter.
     *
     * @param int $weight
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function setWeight($weight)
    {
        if (!is_integer($weight)) {
            throw new LiftSdkException('Argument must be an instance of integer.');
        }
        $this['weight'] = $weight;

        return $this;
    }

    /**
     * Gets the 'description' parameter.
     *
     * @return int The Description of the Rule
     */
    public function getWeight()
    {
        return $this->getEntityValue('weight', 0);
    }

    /**
     * Sets the 'content' parameter.
     *
     * @param Content[] $contentList
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function setContent(array $contentList)
    {
        $this['content'] = [];
        foreach ($contentList as $content) {
            // We need to 'normalize' the data.
            $this['content'][] = $content->getArrayCopy();
        }

        return $this;
    }

    /**
     * Gets the 'content' parameter.
     *
     * @return Content[] The list of content this rule applies to
     */
    public function getContent()
    {
        $contentList = $this->getEntityValue('content', '');
        $ret = [];
        foreach ($contentList as $content) {
            $ret[] = new Content($content);
        }

        return $ret;
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
            throw new LiftSdkException('Argument must be an instance of integer.');
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
            throw new LiftSdkException('Argument must be an instance of integer.');
        }
        if ($status !== 'published' && $status !== 'unpublished' && $status !== 'archived') {
            throw new LiftSdkException('Status much be either published, unpublished or archived');
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

    /**
     * Sets the Rule test_config property.
     *
     * @param \Acquia\LiftClient\Entity\TestConfigInterface $testConfig
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function setTestConfig(TestConfigInterface $testConfig)
    {
        // To facilitate TypeHinting in PHPStorm we redefine what $testConfig is
        // here. We know it inherits from the TestConfigInterface and is a child
        // of TestConfigBase.
        /** @var \Acquia\LiftClient\Entity\TestConfigBase $testConfig */

        // Get class of the testConfig object.
        $type = get_class($testConfig);

        // Only allow one test type at a time.
        $this['testconfig'] = [];
        switch ($type) {
            case 'Acquia\LiftClient\Entity\TestConfigAb':
                $this['testconfig']['ab'] = $testConfig->getArrayCopy();
                break;
            case 'Acquia\LiftClient\Entity\TestConfigMab':
                $this['testconfig']['mab'] = $testConfig->getArrayCopy();
                break;
            case 'Acquia\LiftClient\Entity\TestConfigTarget':
                $this['testconfig']['target'] = $testConfig->getArrayCopy();
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

        // Based on the config, we load the different objects.
        switch ($key) {
            case 'ab':
                return new TestConfigAb($testConfig);
            case 'mab':
                return new TestConfigMab($testConfig);
                break;
            case 'target':
                return new TestConfigTarget($testConfig);
                break;
        }

        return null;
    }
}
