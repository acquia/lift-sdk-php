<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Capture;
use DateTime;

class CaptureTest extends \PHPUnit_Framework_TestCase
{
    public function testPersonUdf()
    {
        $entity = new Capture();
        $entity->setPersonUdf(1, 'test-udf-value');
        $this->assertEquals($entity->json(), '{"person_udf1":"test-udf-value"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument $num must be an instance of integer.
     */
    public function testPersonUdfRangeIsInt()
    {
        $entity = new Capture();
        $entity->setPersonUdf('string', 'value');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument $num must be greater than 0 and smaller or equal to 50.
     */
    public function testPersonUdfIsValidRange()
    {
        $entity = new Capture();
        $entity->setPersonUdf(51, 'value');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument $value must be an instance of string.
     */
    public function testPersonUdfValueIsString()
    {
        $entity = new Capture();
        $entity->setPersonUdf(1, 100);
    }

    public function testEventUdf()
    {
        $entity = new Capture();
        $entity->setEventUdf(1, 'test-udf-value');
        $this->assertEquals($entity->json(), '{"event_udf1":"test-udf-value"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument $num must be an instance of integer.
     */
    public function testEventUdfRangeIsInt()
    {
        $entity = new Capture();
        $entity->setEventUdf('string', 'value');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument $num must be greater than 0 and smaller or equal to 50.
     */
    public function testEventUdfIsValidRange()
    {
        $entity = new Capture();
        $entity->setEventUdf(51, 'value');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument $value must be an instance of string.
     */
    public function testEventUdfValueIsString()
    {
        $entity = new Capture();
        $entity->setEventUdf(1, 100);
    }

    public function testTouchUdf()
    {
        $entity = new Capture();
        $entity->setEventUdf(1, 'test-udf-value');
        $this->assertEquals($entity->json(), '{"event_udf1":"test-udf-value"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument $num must be an instance of integer.
     */
    public function testTouchUdfRangeIsInt()
    {
        $entity = new Capture();
        $entity->setTouchUdf('string', 'value');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument $num must be greater than 0 and smaller or equal to 20.
     */
    public function testTouchUdfIsValidRange()
    {
        $entity = new Capture();
        $entity->setTouchUdf(21, 'value');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument $value must be an instance of string.
     */
    public function testTouchUdfValueIsString()
    {
        $entity = new Capture();
        $entity->setTouchUdf(1, 100);
    }

    public function testEventName()
    {
        $entity = new Capture();
        $entity->setEventName('test-event-name');
        $this->assertEquals($entity->json(), '{"event_name":"test-event-name"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testEventNameNoString()
    {
        $entity = new Capture();
        $entity->setEventName(123);
    }

    public function testEventSource()
    {
        $entity = new Capture();
        $entity->setEventSource('test-event-source');
        $this->assertEquals($entity->json(), '{"event_source":"test-event-source"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testEventSourceNoString()
    {
        $entity = new Capture();
        $entity->setEventSource(123);
    }

    public function testEventDate()
    {
        $date = DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z');
        $entity = new Capture();
        $entity->setEventDate($date);
        $this->assertEquals($entity->json(), '{"event_date":"2016-01-05T22:04:39.000Z"}');
    }

    public function testIdentities()
    {
        $entity = new Capture();
        $entity->setIdentities(['test-identity-value' => 'test-identity-key', 'something-else' => 'key']);
        $this->assertEquals($entity->json(), '{"identities":{"test-identity-value":"test-identity-key","something-else":"key"}}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Identities argument is more than 1 level deep.
     */
    public function testIdentitiesArrayTwoLevels()
    {
        $entity = new Capture();
        $entity->setIdentities(['test-identity-value' => ['another-level']]);
    }

    public function testSiteId()
    {
        $entity = new Capture();
        $entity->setSiteId('test-site-id');
        $this->assertEquals($entity->json(), '{"site_id":"test-site-id"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testSiteIdNoString()
    {
        $entity = new Capture();
        $entity->setSiteId(123);
    }

    public function testUrl()
    {
        $entity = new Capture();
        $entity->setUrl('test-url');
        $this->assertEquals($entity->json(), '{"url":"test-url"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testUrlNoString()
    {
        $entity = new Capture();
        $entity->setUrl(123);
    }

    public function testReferralUrl()
    {
        $entity = new Capture();
        $entity->setReferralUrl('test-referral-url');
        $this->assertEquals($entity->json(), '{"referral_url":"test-referral-url"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testReferralUrlNoString()
    {
        $entity = new Capture();
        $entity->setReferralUrl(123);
    }

    public function testUserAgent()
    {
        $entity = new Capture();
        $entity->setUserAgent('test-user-agent');
        $this->assertEquals($entity->json(), '{"user_agent":"test-user-agent"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testUserAgentNoString()
    {
        $entity = new Capture();
        $entity->setUserAgent(123);
    }

    public function testPlatform()
    {
        $entity = new Capture();
        $entity->setPlatform('test-platform');
        $this->assertEquals($entity->json(), '{"platform":"test-platform"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testPlatformNoString()
    {
        $entity = new Capture();
        $entity->setPlatform(123);
    }

    public function testIpAddress()
    {
        $entity = new Capture();
        $entity->setIpAddress('127.0.0.1');
        $this->assertEquals($entity->json(), '{"ip_address":"127.0.0.1"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testIpAddressNoString()
    {
        $entity = new Capture();
        $entity->setIpAddress(123);
    }

    public function testPersona()
    {
        $entity = new Capture();
        $entity->setPersona('test-persona');
        $this->assertEquals($entity->json(), '{"persona":"test-persona"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testPersonaNoString()
    {
        $entity = new Capture();
        $entity->setPersona(123);
    }

    public function testEngagementScore()
    {
        $entity = new Capture();
        $entity->setEngagementScore(100);
        $this->assertEquals($entity->json(), '{"engagement_score":100}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of integer.
     */
    public function testEngagementScoreNoInt()
    {
        $entity = new Capture();
        $entity->setEngagementScore('test-engagement-score');
    }

    public function testPersonalizationFields()
    {
        $entity = new Capture();
        $entity->setPersonalizationAudienceName('test-personalization-audience-name');
        $this->assertEquals($entity->json(), '{"personalization_audience_name":"test-personalization-audience-name"}');

        $entity = new Capture();
        $entity->setPersonalizationChosenVariation('test-personalization-chosen-variation');
        $this->assertEquals($entity->json(), '{"personalization_chosen_variation":"test-personalization-chosen-variation"}');

        $entity = new Capture();
        $entity->setPersonalizationDecisionPolicy('test-personalization-decision-policy');
        $this->assertEquals($entity->json(), '{"personalization_decision_policy":"test-personalization-decision-policy"}');

        $entity = new Capture();
        $entity->setPersonalizationGoalName('test-personalization-goal-name');
        $this->assertEquals($entity->json(), '{"personalization_goal_name":"test-personalization-goal-name"}');

        $entity = new Capture();
        $entity->setPersonalizationGoalValue('test-personalization-goal-value');
        $this->assertEquals($entity->json(), '{"personalization_goal_value":"test-personalization-goal-value"}');

        $entity = new Capture();
        $entity->setPersonalizationMachineName('test-personalization-machine-name');
        $this->assertEquals($entity->json(), '{"personalization_machine_name":"test-personalization-machine-name"}');

        $entity = new Capture();
        $entity->setPersonalizationName('test-personalization-name');
        $this->assertEquals($entity->json(), '{"personalization_name":"test-personalization-name"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testPersonalizationAudienceNameNoString()
    {
        $entity = new Capture();
        $entity->setPersonalizationAudienceName(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testPersonalizationChosenVariationNoString()
    {
        $entity = new Capture();
        $entity->setPersonalizationChosenVariation(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testPersonalizationDecisionPolicyNoString()
    {
        $entity = new Capture();
        $entity->setPersonalizationDecisionPolicy(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testPersonalizationGoalNameNoString()
    {
        $entity = new Capture();
        $entity->setPersonalizationGoalName(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testPersonalizationGoalValueNoString()
    {
        $entity = new Capture();
        $entity->setPersonalizationGoalValue(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testPersonalizationMachineNameNoString()
    {
        $entity = new Capture();
        $entity->setPersonalizationMachineName(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testPersonalizationNameNoString()
    {
        $entity = new Capture();
        $entity->setPersonalizationName(123);
    }

    public function testDecisionFields()
    {
        $entity = new Capture();
        $entity->setDecisionContentId('test-decision-content-id');
        $this->assertEquals($entity->json(), '{"decision_content_id":"test-decision-content-id"}');

        $entity = new Capture();
        $entity->setDecisionContentName('test-decision-content-name');
        $this->assertEquals($entity->json(), '{"decision_content_name":"test-decision-content-name"}');

        $entity = new Capture();
        $entity->setDecisionGoalId('test-decision-decision-goal-id');
        $this->assertEquals($entity->json(), '{"decision_goal_id":"test-decision-decision-goal-id"}');

        $entity = new Capture();
        $entity->setDecisionGoalName('test-decision-goal-name');
        $this->assertEquals($entity->json(), '{"decision_goal_name":"test-decision-goal-name"}');

        $entity = new Capture();
        $entity->setDecisionGoalValue('test-decision-goal-value');
        $this->assertEquals($entity->json(), '{"decision_goal_value":"test-decision-goal-value"}');

        $entity = new Capture();
        $entity->setDecisionPolicy('test-decision-policy');
        $this->assertEquals($entity->json(), '{"decision_policy":"test-decision-policy"}');

        $entity = new Capture();
        $entity->setDecisionRuleId('test-decision-rule-id');
        $this->assertEquals($entity->json(), '{"decision_rule_id":"test-decision-rule-id"}');

        $entity = new Capture();
        $entity->setDecisionRuleName('test-decision-rule-name');
        $this->assertEquals($entity->json(), '{"decision_rule_name":"test-decision-rule-name"}');

        $entity = new Capture();
        $entity->setDecisionSlotId('test-decision-slot-id');
        $this->assertEquals($entity->json(), '{"decision_slot_id":"test-decision-slot-id"}');

        $entity = new Capture();
        $entity->setDecisionSlotName('test-decision-slot-name');
        $this->assertEquals($entity->json(), '{"decision_slot_name":"test-decision-slot-name"}');

        $entity = new Capture();
        $entity->setDecisionViewMode('test-decision-view-mode');
        $this->assertEquals($entity->json(), '{"decision_view_mode":"test-decision-view-mode"}');

        $entity = new Capture();
        $entity->setDecisionCampaignId('test-campaign-id');
        $entity->setDecisionCampaignName('test-campaign-name');
        $entity->setDecisionCampaignType('target');
        $this->assertEquals($entity->json(), '{"decision_campaign_id":"test-campaign-id","decision_campaign_name":"test-campaign-name","decision_campaign_type":"target"}');

        $entity = new Capture();
        $entity->setDecisionCampaignType('ab');
        $this->assertEquals($entity->json(), '{"decision_campaign_type":"ab"}');

        $entity = new Capture();
        $entity->setDecisionCampaignType('dynamic');
        $this->assertEquals($entity->json(), '{"decision_campaign_type":"dynamic"}');

        $entity = new Capture();
        $entity->setDecisionCampaignType('mixed');
        $this->assertEquals($entity->json(), '{"decision_campaign_type":"mixed"}');

        $entity = new Capture();
        $entity->setDecisionABVariationId('test-ab-variation-id');
        $entity->setDecisionABVariationLabel('test-ab-variation-label');
        $this->assertEquals($entity->json(), '{"decision_rule_ab_variation_id":"test-ab-variation-id","decision_rule_ab_variation_label":"test-ab-variation-label"}');

        $entity = new Capture();
        $entity->setDecisionContextLanguage('en');
        $this->assertEquals($entity->json(), '{"decision_context_language":"en"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionContentIdNoString()
    {
        $entity = new Capture();
        $entity->setDecisionContentId(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionContentNameNoString()
    {
        $entity = new Capture();
        $entity->setDecisionContentName(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionGoalIdNoString()
    {
        $entity = new Capture();
        $entity->setDecisionGoalId(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionGoalNameNoString()
    {
        $entity = new Capture();
        $entity->setDecisionGoalName(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionGoalValueNoString()
    {
        $entity = new Capture();
        $entity->setDecisionGoalValue(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionPolicy()
    {
        $entity = new Capture();
        $entity->setDecisionPolicy(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionRuleId()
    {
        $entity = new Capture();
        $entity->setDecisionRuleId(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionRuleName()
    {
        $entity = new Capture();
        $entity->setDecisionRuleName(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionSlotName()
    {
        $entity = new Capture();
        $entity->setDecisionSlotName(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionSlotId()
    {
        $entity = new Capture();
        $entity->setDecisionSlotId(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionCampaignId()
    {
        $entity = new Capture();
        $entity->setDecisionCampaignId(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionCampaignName()
    {
        $entity = new Capture();
        $entity->setDecisionCampaignName(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionCampaignType()
    {
        $entity = new Capture();
        $entity->setDecisionCampaignType(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument value is not supported.
     */
    public function testDecisionCampaignTypeValue()
    {
        $entity = new Capture();
        $entity->setDecisionCampaignType("absfa");
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionABVariationId()
    {
        $entity = new Capture();
        $entity->setDecisionABVariationId(123);
    }


    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionABVariationLabel()
    {
        $entity = new Capture();
        $entity->setDecisionABVariationLabel(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionViewMode()
    {
        $entity = new Capture();
        $entity->setDecisionViewMode(123);
    }

    public function testCaptureIdentifier()
    {
        $entity = new Capture();
        $entity->setCaptureIdentifier('test-capture-identifier');
        $this->assertEquals($entity->json(), '{"capture_identifier":"test-capture-identifier"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testCaptureIdentifierNoString()
    {
        $entity = new Capture();
        $entity->setCaptureIdentifier(123);
    }

    public function testClientTimeZone()
    {
        $entity = new Capture();
        $entity->setClientTimezone('Americas/New_York');
        $this->assertEquals($entity->json(), '{"client_timezone":"Americas\/New_York"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testClientTimeZoneNoString()
    {
        $entity = new Capture();
        $entity->setClientTimezone(123);
    }

    public function testJavascriptVersion()
    {
        $entity = new Capture();
        $entity->setJavascriptVersion('3');
        $this->assertEquals($entity->json(), '{"javascript_version":"3"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testJavascriptVersionNoString()
    {
        $entity = new Capture();
        $entity->setJavascriptVersion(123);
    }

    public function testPostId()
    {
        $entity = new Capture();
        $entity->setPostId('test-post-id');
        $this->assertEquals($entity->json(), '{"post_id":"test-post-id"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testPostIdNoString()
    {
        $entity = new Capture();
        $entity->setPostId(123);
    }

    public function testContentFields()
    {
        $entity = new Capture();
        $entity->setContentId('test-content-id');
        $this->assertEquals($entity->json(), '{"content_id":"test-content-id"}');

        $entity = new Capture();
        $entity->setContentTitle('test-content-title');
        $this->assertEquals($entity->json(), '{"content_title":"test-content-title"}');

        $entity = new Capture();
        $entity->setContentType('test-content-type');
        $this->assertEquals($entity->json(), '{"content_type":"test-content-type"}');

        $entity = new Capture();
        $entity->setContentSection('test-content-section');
        $this->assertEquals($entity->json(), '{"content_section":"test-content-section"}');

        $entity = new Capture();
        $entity->setContentKeywords('test-content-keywords');
        $this->assertEquals($entity->json(), '{"content_keywords":"test-content-keywords"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentIdNoString()
    {
        $entity = new Capture();
        $entity->setContentId(123);
    }

    public function testContentUuid()
    {
        $entity = new Capture();
        $entity->setContentUuid('ecf826eb-3ef0-4aa6-aae2-9f6e5886bbb6');
        $this->assertEquals($entity->json(), '{"content_uuid":"ecf826eb-3ef0-4aa6-aae2-9f6e5886bbb6"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of valid UUID.
     */
    public function testContentUuidInvalidUuid()
    {
        $entity = new Capture();
        $entity->setContentUuid('invalid-uuid');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentTitleNoString()
    {
        $entity = new Capture();
        $entity->setContentTitle(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentTypeNoString()
    {
        $entity = new Capture();
        $entity->setContentType(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentSectionNoString()
    {
        $entity = new Capture();
        $entity->setContentSection(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentKeywordsNoString()
    {
        $entity = new Capture();
        $entity->setContentKeywords(123);
    }

    public function testAuthor()
    {
        $entity = new Capture();
        $entity->setAuthor('test-author');
        $this->assertEquals($entity->json(), '{"author":"test-author"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testAuthorNoString()
    {
        $entity = new Capture();
        $entity->setAuthor(123);
    }

    public function testPageType()
    {
        $entity = new Capture();
        $entity->setPageType('test-page-type');
        $this->assertEquals($entity->json(), '{"page_type":"test-page-type"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testPageTypeNoString()
    {
        $entity = new Capture();
        $entity->setPageType(123);
    }

    public function testPublishedDate()
    {
        $date = DateTime::createFromFormat(DateTime::ATOM, '2016-01-05T22:04:39Z');
        $entity = new Capture();
        $entity->setPublishedDate($date);
        $this->assertEquals($entity->json(), '{"published_date":"2016-01-05T22:04:39.000Z"}');
    }

    public function testContextLanguage()
    {
        $entity = new Capture();
        $entity->setContextLanguage('en');
        $this->assertEquals($entity->json(), '{"context_language":"en"}');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContextLanguageNoString()
    {
        $entity = new Capture();
        $entity->setContextLanguage(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionContextLanguageNoString()
    {
        $entity = new Capture();
        $entity->setDecisionContextLanguage(123);
    }
}
