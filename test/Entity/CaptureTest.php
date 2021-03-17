<?php

namespace Acquia\LiftClient\Test\Entity;

use Acquia\LiftClient\Entity\Capture;
use DateTime;
use PHPUnit\Framework\TestCase;
use Acquia\LiftClient\Exception\LiftSdkException;

class CaptureTest extends TestCase
{
    public function testPersonUdf()
    {
        $entity = new Capture();
        $entity->setPersonUdf(1, 'test-udf-value');
        $this->assertEquals($entity->json(), '{"person_udf1":"test-udf-value"}');
    }

    public function testPersonUdfRangeIsInt()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument \$num must be an instance of integer.");
        $entity = new Capture();
        $entity->setPersonUdf('string', 'value');
    }

    public function testPersonUdfIsValidRange()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument \$num must be greater than 0 and smaller or equal to 50.");
        $entity = new Capture();
        $entity->setPersonUdf(51, 'value');
    }

    public function testPersonUdfValueIsString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument \$value must be an instance of string.");
        $entity = new Capture();
        $entity->setPersonUdf(1, 100);
    }

    public function testEventUdf()
    {
        $entity = new Capture();
        $entity->setEventUdf(1, 'test-udf-value');
        $this->assertEquals($entity->json(), '{"event_udf1":"test-udf-value"}');
    }

    public function testEventUdfRangeIsInt()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument \$num must be an instance of integer.");
        $entity = new Capture();
        $entity->setEventUdf('string', 'value');
    }

    public function testEventUdfIsValidRange()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument \$num must be greater than 0 and smaller or equal to 50.");
        $entity = new Capture();
        $entity->setEventUdf(51, 'value');
    }

    public function testEventUdfValueIsString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument \$value must be an instance of string.");
        $entity = new Capture();
        $entity->setEventUdf(1, 100);
    }

    public function testTouchUdf()
    {
        $entity = new Capture();
        $entity->setEventUdf(1, 'test-udf-value');
        $this->assertEquals($entity->json(), '{"event_udf1":"test-udf-value"}');
    }

    public function testTouchUdfRangeIsInt()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument \$num must be an instance of integer.");
        $entity = new Capture();
        $entity->setTouchUdf('string', 'value');
    }

    public function testTouchUdfIsValidRange()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument \$num must be greater than 0 and smaller or equal to 20.");
        $entity = new Capture();
        $entity->setTouchUdf(21, 'value');
    }

    public function testTouchUdfValueIsString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument \$value must be an instance of string.");
        $entity = new Capture();
        $entity->setTouchUdf(1, 100);
    }

    public function testEventName()
    {
        $entity = new Capture();
        $entity->setEventName('test-event-name');
        $this->assertEquals($entity->json(), '{"event_name":"test-event-name"}');
    }

    public function testEventNameNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setEventName(123);
    }

    public function testEventSource()
    {
        $entity = new Capture();
        $entity->setEventSource('test-event-source');
        $this->assertEquals($entity->json(), '{"event_source":"test-event-source"}');
    }

    public function testEventSourceNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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

    public function testIdentitiesArrayTwoLevels()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Identities argument is more than 1 level deep.");
        $entity = new Capture();
        $entity->setIdentities(['test-identity-value' => ['another-level']]);
    }

    public function testSiteId()
    {
        $entity = new Capture();
        $entity->setSiteId('test-site-id');
        $this->assertEquals($entity->json(), '{"site_id":"test-site-id"}');
    }

    public function testSiteIdNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setSiteId(123);
    }

    public function testUrl()
    {
        $entity = new Capture();
        $entity->setUrl('test-url');
        $this->assertEquals($entity->json(), '{"url":"test-url"}');
    }

    public function testUrlNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setUrl(123);
    }

    public function testReferralUrl()
    {
        $entity = new Capture();
        $entity->setReferralUrl('test-referral-url');
        $this->assertEquals($entity->json(), '{"referral_url":"test-referral-url"}');
    }

    public function testReferralUrlNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setReferralUrl(123);
    }

    public function testUserAgent()
    {
        $entity = new Capture();
        $entity->setUserAgent('test-user-agent');
        $this->assertEquals($entity->json(), '{"user_agent":"test-user-agent"}');
    }

    public function testUserAgentNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setUserAgent(123);
    }

    public function testPlatform()
    {
        $entity = new Capture();
        $entity->setPlatform('test-platform');
        $this->assertEquals($entity->json(), '{"platform":"test-platform"}');
    }

    public function testPlatformNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setPlatform(123);
    }

    public function testIpAddress()
    {
        $entity = new Capture();
        $entity->setIpAddress('127.0.0.1');
        $this->assertEquals($entity->json(), '{"ip_address":"127.0.0.1"}');
    }

    public function testIpAddressNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setIpAddress(123);
    }

    public function testPersona()
    {
        $entity = new Capture();
        $entity->setPersona('test-persona');
        $this->assertEquals($entity->json(), '{"persona":"test-persona"}');
    }

    public function testPersonaNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setPersona(123);
    }

    public function testEngagementScore()
    {
        $entity = new Capture();
        $entity->setEngagementScore(100);
        $this->assertEquals($entity->json(), '{"engagement_score":100}');
    }

    public function testEngagementScoreNoInt()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of integer.");
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

    public function testPersonalizationAudienceNameNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setPersonalizationAudienceName(123);
    }

    public function testPersonalizationChosenVariationNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setPersonalizationChosenVariation(123);
    }

    public function testPersonalizationDecisionPolicyNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setPersonalizationDecisionPolicy(123);
    }

    public function testPersonalizationGoalNameNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setPersonalizationGoalName(123);
    }

    public function testPersonalizationGoalValueNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setPersonalizationGoalValue(123);
    }

    public function testPersonalizationMachineNameNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setPersonalizationMachineName(123);
    }

    public function testPersonalizationNameNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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

    public function testDecisionContentIdNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionContentId(123);
    }

    public function testDecisionContentNameNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionContentName(123);
    }

    public function testDecisionGoalIdNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionGoalId(123);
    }

    public function testDecisionGoalNameNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionGoalName(123);
    }

    public function testDecisionGoalValueNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionGoalValue(123);
    }

    public function testDecisionPolicy()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");$entity = new Capture();
        $entity->setDecisionPolicy(123);
    }

    public function testDecisionRuleId()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionRuleId(123);
    }

    public function testDecisionRuleName()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionRuleName(123);
    }

    public function testDecisionSlotName()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionSlotName(123);
    }

    public function testDecisionSlotId()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionSlotId(123);
    }

    public function testDecisionCampaignId()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionCampaignId(123);
    }

    public function testDecisionCampaignName()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionCampaignName(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionCampaignType()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionCampaignType(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument value is not supported.
     */
    public function testDecisionCampaignTypeValue()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument value is not supported");
        $entity = new Capture();
        $entity->setDecisionCampaignType("absfa");
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionABVariationId()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionABVariationId(123);
    }


    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionABVariationLabel()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setDecisionABVariationLabel(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionViewMode()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of valid UUID.");
        $entity = new Capture();
        $entity->setContentUuid('invalid-uuid');
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentTitleNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setContentTitle(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentTypeNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setContentType(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentSectionNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setContentSection(123);
    }

    /**
     * @expectedException     \Acquia\LiftClient\Exception\LiftSdkException
     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testContentKeywordsNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
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
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $entity = new Capture();
        $entity->setContextLanguage(123);
    }

    /**

     * @expectedExceptionMessage Argument must be an instance of string.
     */
    public function testDecisionContextLanguageNoString()
    {
        $this->expectException(LiftSdkException::class);
        $this->expectExceptionMessage("Argument must be an instance of string.");
        $this->expectException(LiftSdkException::class);
        $entity = new Capture();
        $entity->setDecisionContextLanguage(123);
    }
}
