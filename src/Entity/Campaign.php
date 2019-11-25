<?php

namespace Acquia\LiftClient\Entity;

class Campaign extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    /**
     * Returns campaign id
     *
     * @return string
     */
    public function getId()
    {
        return $this->getEntityValue('id', '');
    }

    /**
     * Returns campaign site id
     *
     * @return string
     */
    public function getSiteId()
    {
        return $this->getEntityValue('site_id', '');
    }

    /**
     * Returns campaign label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->getEntityValue('label', '');
    }

    /**
     * Returns campaign description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->getEntityValue('description', '');
    }

    /**
     * Returns campaign type. Values can only be "target", "ab", "dynamic" or "mixed"
     *
     * @return string 
     */
    public function getType()
    {
        return $this->getEntityValue('type', '');
    }

    /**
     * Returns campaign status. Value can only be "unpublished", "scheduled", "published","completed","archived"
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->getEntityValue('status', '');
    }

    /**
     * Returns campaign entity tag which must be used for updating campaigns
     *
     * @return string 
     */
    public function getEtag()
    {
        return $this->getEntityValue('etag', '');
    }

    /**
     * Returns campaign's created time. Timestamp in ISO 8601 format: YYYY-MM-DDTHH:MM:SSZ.
     *
     * @return string 
     */
    public function getCreated()
    {
        return $this->getEntityValue('created', '');
    }

    /**
     * Returns campaign's last update time. Timestamp in ISO 8601 format: YYYY-MM-DDTHH:MM:SSZ.
     *
     * @return string 
     */
    public function getUpdated()
    {
        return $this->getEntityValue('updated', '');
    }

    /**
     * Returns campaign's start time. Timestamp in ISO 8601 format: YYYY-MM-DDTHH:MM:SSZ.
     *
     * @return string 
     */
    public function getStartAt()
    {
        return $this->getEntityValue('start_at', '');
    }

    /**
     * Returns campaign's start time. Timestamp in ISO 8601 format: YYYY-MM-DDTHH:MM:SSZ.
     *
     * @return string 
     */
    public function getEndAt()
    {
        return $this->getEntityValue('end_at', '');
    }

     /**
     * Returns list of rule ids associated with campaign
     *
     * @return string[]
     */
    public function getRuleIds()
    {
        $ruleIds = $this->getEntityValue('rule_ids', []);
        $retVal = [];

        foreach ($ruleIds as $ruleId) {
            $retVal[] = $ruleId;
        }


        return $retVal;
    }

    /**
     * Returns list of goal ids associated with campaign
     *
     * @return string[]
     */
    public function getGoalIds()
    {
        $ruleIds = $this->getEntityValue('goal_ids', []);
        $retVal = [];

        foreach ($ruleIds as $ruleId) {
            $retVal[] = $ruleId;
        }

        return $retVal;
    }
    
}
