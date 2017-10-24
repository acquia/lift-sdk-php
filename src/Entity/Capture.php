<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;
use Acquia\LiftClient\Utility\Utility;
use DateTime;

class Capture extends Entity
{
    const PERSON_UDF_COUNT = 50;
    const EVENT_UDF_COUNT = 50;
    const TOUCH_UDF_COUNT = 20;

    const UUID_PATTERN = '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/i';

    /**
     * Set the 'person_udf#' field.
     *
     * @param int    $num   Which field to fetch. Can be from 1 till 50
     * @param string $value Custom fields for the Acquia Lift Person Capture Phase
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPersonUdf($num, $value)
    {
        if (!is_int($num)) {
            throw new LiftSdkException('Argument $num must be an instance of integer.');
        }
        if ($num < 1 || $num > self::PERSON_UDF_COUNT) {
            throw new LiftSdkException('Argument $num must be greater than 0 and smaller or equal to 50.');
        }
        if (!is_string($value)) {
            throw new LiftSdkException('Argument $value must be an instance of string.');
        }
        $this['person_udf'.$num] = $value;

        return $this;
    }

    /**
     * Set the 'event_udf#' field.
     *
     * @param int    $num   Which field to fetch. Can be from 1 till 50
     * @param string $value Custom fields for the Acquia Lift Event Capture Phase
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setEventUdf($num, $value)
    {
        if (!is_int($num)) {
            throw new LiftSdkException('Argument $num must be an instance of integer.');
        }
        if ($num < 1 || $num > self::EVENT_UDF_COUNT) {
            throw new LiftSdkException('Argument $num must be greater than 0 and smaller or equal to 50.');
        }
        if (!is_string($value)) {
            throw new LiftSdkException('Argument $value must be an instance of string.');
        }
        $this['event_udf'.$num] = $value;

        return $this;
    }

    /**
     * Set the 'touch_udf#' field.
     *
     * @param int    $num   Which field to fetch. Can be from 1 till 20
     * @param string $value Custom fields for the Acquia Lift Touch Capture Phase
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setTouchUdf($num, $value)
    {
        if (!is_int($num)) {
            throw new LiftSdkException('Argument $num must be an instance of integer.');
        }
        if ($num < 1 || $num > self::TOUCH_UDF_COUNT) {
            throw new LiftSdkException('Argument $num must be greater than 0 and smaller or equal to 20.');
        }
        if (!is_string($value)) {
            throw new LiftSdkException('Argument $value must be an instance of string.');
        }
        $this['event_udf'.$num] = $value;

        return $this;
    }

    /**
     * Sets the 'event_name' parameter.
     *
     * @param string $eventName Event name corresponding to the captured information - the event type matching this
     *                          event name must match the master list of events created in Acquia Lift Web
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setEventName($eventName)
    {
        if (!is_string($eventName)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['event_name'] = $eventName;

        return $this;
    }

    /**
     * Sets the 'event_source' parameter.
     *
     * @param string $eventSource Source of the event - can be used to pass event data from tools you have set up to
     *                            send data to Acquia Lift Web (the default Acquia Lift Web value is web; depending on
     *                            your website's configuration, examples may include csrtool1 and promo1)
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setEventSource($eventSource)
    {
        if (!is_string($eventSource)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['event_source'] = $eventSource;

        return $this;
    }

    /**
     * Sets the 'event_date' parameter.
     *
     * @param DateTime $eventDate
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setEventDate(DateTime $eventDate)
    {
        // Lift Profile Manager is currently accepting this ISO 8601 format:
        // "2017-02-07T19:59:53.123Z" (or "2017-02-07T19:59:53.000Z" pre 7.0 ).
        // todo: the above comment needs updating
        // todo: works for all but hhvm-3.18.5
        $format = 'Y-m-d\TH:i:s.v\Z';
        if (version_compare(phpversion(), '7.0', '<')) {
            $format = 'Y-m-d\TH:i:s.000\Z';
        }
        $this['event_date'] = $eventDate->format($format);

        return $this;
    }

    /**
     * Sets the 'identities' parameter.
     *
     * @param array $identities Additional identity information
     *
     * Example of how to structure the $identities parameter:
     * <code>
     * $options = [
     *     'john.smith@acquia.com'  => 'email',
     *     'John Smith' => 'name',
     * ];
     * </code>
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setIdentities(array $identities)
    {
        if (Utility::arrayDepth($identities) > 1) {
            throw new LiftSdkException('Identities argument is more than 1 level deep.');
        }
        $this['identities'] = $identities;

        return $this;
    }

    /**
     * Sets the 'url' parameter.
     *
     * @param string $url Event's URL
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setUrl($url)
    {
        if (!is_string($url)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['url'] = $url;

        return $this;
    }

    /**
     * Sets the 'referral_url' parameter.
     *
     * @param string $referralUrl Referrer's URL
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setReferralUrl($referralUrl)
    {
        if (!is_string($referralUrl)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['referral_url'] = $referralUrl;

        return $this;
    }

    /**
     * Sets the 'content_title' parameter.
     *
     * @param string $contentTitle Page title
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setContentTitle($contentTitle)
    {
        if (!is_string($contentTitle)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['content_title'] = $contentTitle;

        return $this;
    }

    /**
     * Sets the 'user_agent' parameter.
     *
     * @param string $userAgent Visitor's user agent
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setUserAgent($userAgent)
    {
        if (!is_string($userAgent)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['user_agent'] = $userAgent;

        return $this;
    }

    /**
     * Sets the 'platform' parameter.
     *
     * @param string $platform Visitor's platform
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPlatform($platform)
    {
        if (!is_string($platform)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['platform'] = $platform;

        return $this;
    }

    /**
     * Sets the 'ip_address' parameter.
     *
     * @param string $ipAddress Visitor's IP address (supports both IPv4 and IPv6 addresses)
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setIpAddress($ipAddress)
    {
        if (!is_string($ipAddress)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['ip_address'] = $ipAddress;

        return $this;
    }

    /**
     * Sets the 'persona' parameter.
     *
     * @param string $persona User-defined category into which a visitor fits, based on their viewing of particular
     *                        content
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPersona($persona)
    {
        if (!is_string($persona)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['persona'] = $persona;

        return $this;
    }

    /**
     * Sets the 'engagement_score' parameter.
     *
     * @param int $engagementScore The number that you have chosen to signify the importance of a visitor's interest in
     *                             an event
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setEngagementScore($engagementScore)
    {
        if (!is_integer($engagementScore)) {
            throw new LiftSdkException('Argument must be an instance of integer.');
        }
        $this['engagement_score'] = $engagementScore;

        return $this;
    }

    /**
     * Sets the 'personalization_name' parameter.
     *
     * @param string $personalizationName Name of personalization associated with an event
     *
     * @deprecated Only used in Lift 2. For Lift 3, please use fields with prefix decision
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPersonalizationName($personalizationName)
    {
        if (!is_string($personalizationName)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['personalization_name'] = $personalizationName;

        return $this;
    }

    /**
     * Sets the 'personalization_machine_name' parameter.
     *
     * @param string $personalizationMachineName Machine name of personalization associated with an event
     *
     * @deprecated Only used in Lift 2. For Lift 3, please use fields with prefix decision
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPersonalizationMachineName($personalizationMachineName)
    {
        if (!is_string($personalizationMachineName)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['personalization_machine_name'] = $personalizationMachineName;

        return $this;
    }

    /**
     * Sets the 'personalization_chosen_variation' parameter.
     *
     * @param string $personalizationChosenVariation The variation (decision) chosen for an event
     *
     * @deprecated Only used in Lift 2. For Lift 3, please use fields with prefix decision
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPersonalizationChosenVariation($personalizationChosenVariation)
    {
        if (!is_string($personalizationChosenVariation)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['personalization_chosen_variation'] = $personalizationChosenVariation;

        return $this;
    }

    /**
     * Sets the 'personalization_audience_name' parameter.
     *
     * @param string $personalizationAudienceName The name of the audience
     *
     * @deprecated Only used in Lift 2. For Lift 3, please use fields with prefix decision
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPersonalizationAudienceName($personalizationAudienceName)
    {
        if (!is_string($personalizationAudienceName)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['personalization_audience_name'] = $personalizationAudienceName;

        return $this;
    }

    /**
     * Sets the 'personalization_decision_policy' parameter.
     *
     * @param string $personalizationDecisionPolicy The decision policy used - for example, explore or target
     *
     * @deprecated Only used in Lift 2. For Lift 3, please use fields with prefix decision
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPersonalizationDecisionPolicy($personalizationDecisionPolicy)
    {
        if (!is_string($personalizationDecisionPolicy)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['personalization_decision_policy'] = $personalizationDecisionPolicy;

        return $this;
    }

    /**
     * Sets the 'personalization_goal_name' parameter.
     *
     * @param string $personalizationGoalName The name of the goal reached
     *
     * @deprecated Only used in Lift 2. For Lift 3, please use fields with prefix decision
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPersonalizationGoalName($personalizationGoalName)
    {
        if (!is_string($personalizationGoalName)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['personalization_goal_name'] = $personalizationGoalName;

        return $this;
    }

    /**
     * Sets the 'personalization_goal_value' parameter.
     *
     * @param string $personalizationGoalValue The value of the goal reached
     *
     * @deprecated Only used in Lift 2. For Lift 3, please use fields with prefix decision
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPersonalizationGoalValue($personalizationGoalValue)
    {
        if (!is_string($personalizationGoalValue)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['personalization_goal_value'] = $personalizationGoalValue;

        return $this;
    }

    /**
     * Sets the 'decision_slot_id' parameter.
     *
     * @param string $decisionSlotId Decision Slot Id
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setDecisionSlotId($decisionSlotId)
    {
        if (!is_string($decisionSlotId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['decision_slot_id'] = $decisionSlotId;

        return $this;
    }

    /**
     * Sets the 'decision_slot_name' parameter.
     *
     * @param string $decisionSlotName Decision Slot Name
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setDecisionSlotName($decisionSlotName)
    {
        if (!is_string($decisionSlotName)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['decision_slot_name'] = $decisionSlotName;

        return $this;
    }

    /**
     * Sets the 'decision_rule_id' parameter.
     *
     * @param string $decisionRuleId Decision Slot Name
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setDecisionRuleId($decisionRuleId)
    {
        if (!is_string($decisionRuleId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['decision_rule_id'] = $decisionRuleId;

        return $this;
    }

    /**
     * Sets the 'decision_rule_name' parameter.
     *
     * @param string $decisionRuleName Decision Slot Name
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setDecisionRuleName($decisionRuleName)
    {
        if (!is_string($decisionRuleName)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['decision_rule_name'] = $decisionRuleName;

        return $this;
    }

    /**
     * Sets the 'decision_content_id' parameter.
     *
     * @param string $decisionContentId Decision Content Id
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setDecisionContentId($decisionContentId)
    {
        if (!is_string($decisionContentId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['decision_content_id'] = $decisionContentId;

        return $this;
    }

    /**
     * Sets the 'decision_content_name' parameter.
     *
     * @param string $decisionContentName Decision Content Name
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setDecisionContentName($decisionContentName)
    {
        if (!is_string($decisionContentName)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['decision_content_name'] = $decisionContentName;

        return $this;
    }

    /**
     * Sets the 'decision_goal_id' parameter.
     *
     * @param string $decisionGoalId Decision Goal Id
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setDecisionGoalId($decisionGoalId)
    {
        if (!is_string($decisionGoalId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['decision_goal_id'] = $decisionGoalId;

        return $this;
    }

    /**
     * Sets the 'decision_goal_name' parameter.
     *
     * @param string $decisionGoalName Decision Goal Name
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setDecisionGoalName($decisionGoalName)
    {
        if (!is_string($decisionGoalName)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['decision_goal_name'] = $decisionGoalName;

        return $this;
    }

    /**
     * Sets the 'decision_goal_value' parameter.
     *
     * @param string $decisionGoalValue Decision Goal Value
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setDecisionGoalValue($decisionGoalValue)
    {
        if (!is_string($decisionGoalValue)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['decision_goal_value'] = $decisionGoalValue;

        return $this;
    }

    /**
     * Sets the 'decision_view_mode' parameter.
     *
     * @param string $decisionViewMode Decision View Mode
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setDecisionViewMode($decisionViewMode)
    {
        if (!is_string($decisionViewMode)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['decision_view_mode'] = $decisionViewMode;

        return $this;
    }

    /**
     * Sets the 'decision_policy' parameter.
     *
     * @param string $decisionPolicy The decision policy used - for example, explore or target
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setDecisionPolicy($decisionPolicy)
    {
        if (!is_string($decisionPolicy)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['decision_policy'] = $decisionPolicy;

        return $this;
    }

    /**
     * Sets the 'capture_identifier' parameter.
     *
     * @param string $captureIdentifier Unique identifier for the capture
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setCaptureIdentifier($captureIdentifier)
    {
        if (!is_string($captureIdentifier)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['capture_identifier'] = $captureIdentifier;

        return $this;
    }

    /**
     * Sets the 'client_timezone' parameter.
     *
     * @param string $clientTimezone Client Timezone
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setClientTimezone($clientTimezone)
    {
        if (!is_string($clientTimezone)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['client_timezone'] = $clientTimezone;

        return $this;
    }

    /**
     * Sets the 'javascript_version' parameter.
     *
     * @param string $javascriptVersion version of the javascript that generated the capture
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setJavascriptVersion($javascriptVersion)
    {
        if (!is_string($javascriptVersion)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['javascript_version'] = $javascriptVersion;

        return $this;
    }

    /**
     * Sets the 'post_id' parameter.
     *
     * @param string $postId Post id of an article
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPostId($postId)
    {
        if (!is_string($postId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['post_id'] = $postId;

        return $this;
    }

    /**
     * Sets the 'content_id' parameter.
     *
     * @param string $contentId Content id of an article
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setContentId($contentId)
    {
        if (!is_string($contentId)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['content_id'] = $contentId;

        return $this;
    }

    /**
     * Sets the 'content_uuid' parameter.
     *
     * @param string $contentUuid UUID of an article
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setContentUuid($contentUuid)
    {
        if (!preg_match(self::UUID_PATTERN, $contentUuid)) {
            throw new LiftSdkException('Argument must be an instance of valid UUID.');
        }
        $this['content_uuid'] = $contentUuid;

        return $this;
    }

    /**
     * Sets the 'content_type' parameter.
     *
     * @param string $contentType Content-type to which a piece of visitor-viewed content belongs
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setContentType($contentType)
    {
        if (!is_string($contentType)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['content_type'] = $contentType;

        return $this;
    }

    /**
     * Sets the 'content_section' parameter.
     *
     * @param string $contentSection Content section of an article
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setContentSection($contentSection)
    {
        if (!is_string($contentSection)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['content_section'] = $contentSection;

        return $this;
    }

    /**
     * Sets the 'content_keywords' parameter.
     *
     * @param string $contentKeywords Content keywords of an article
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setContentKeywords($contentKeywords)
    {
        if (!is_string($contentKeywords)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['content_keywords'] = $contentKeywords;

        return $this;
    }

    /**
     * Sets the 'author' parameter.
     *
     * @param string $author Author of an article
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setAuthor($author)
    {
        if (!is_string($author)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['author'] = $author;

        return $this;
    }

    /**
     * Sets the 'page_type' parameter.
     *
     * @param string $pageType Category of page the visitor viewed (examples include article page, tag page, and home page)
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPageType($pageType)
    {
        if (!is_string($pageType)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['page_type'] = $pageType;

        return $this;
    }

    /**
     * Sets the 'thumbnail_url' parameter.
     *
     * @param string $thumbnailUrl Thumbnail URL of an article
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setThumbnailUrl($thumbnailUrl)
    {
        if (!is_string($thumbnailUrl)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }
        $this['thumbnail_url'] = $thumbnailUrl;

        return $this;
    }

    /**
     * Sets the 'published_date' parameter.
     *
     * @param DateTime $publishedDate Publish date of an article
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Capture
     */
    public function setPublishedDate(DateTime $publishedDate)
    {
        // Lift Profile Manager is currently accepting this ISO 8601 format:
        // "2017-02-07T19:59:53.123456Z".
        // "2017-02-07T19:59:53.123Z" (or "2017-02-07T19:59:53.000Z" pre 7.0 ).
        // todo: the above comment needs updating
        // todo: works for all but hhvm-3.18.5
        $format = 'Y-m-d\TH:i:s.v\Z';
        if (version_compare(phpversion(), '7.0', '<')) {
            $format = 'Y-m-d\TH:i:s.000\Z';
        }
        $this['published_date'] = $publishedDate->format($format);

        return $this;
    }
}
