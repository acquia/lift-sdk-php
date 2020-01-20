<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Rule;
use GuzzleHttp\Psr7\Request;

class RuleManager extends ManagerBase
{
    /**
     * {@inheritdoc}
     */
    protected $queryParameters = [
        'context_language' => null, // Required if cdf_version is 2. Must pass 2 or 4 letter language code (ie. 'en', 'fr')
        'cdf_version' => null, // Default set to 1 if not passed
        'prefetch' => null,
        'sort' => null,
        'start' => null,
        'rows' => null,
        'sort_field' => null,
        'status' => null,
        'slot_id' => null
    ];

    /**
     * Get a list of Rules.
     *
     * Example of how to structure the $options parameter:
     * <code>
     * $options = [
     *     'context_language' => 'en',
     *     'cdf_version' => '2', 
     *     'prefetch'  => true,
     *     'sort'  => 'asc',
     *     'start'  => 0,
     *     'rows'  => 10,
     *     'sort_field'  => 'updated',
     *     'status'  => 'published',
     *     'slot_id' => 'test-slot-id-1'
     * ];
     * </code>
     *
     * @see http://docs.lift.acquia.com/decision/v2/#rules_get
     *
     * @param array $options
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Rule[]
     */
    public function query($options = [])
    {
        $url = RULES_EP;
        $url .= $this->getQueryString($options);

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        // Get them as Rule objects
        $rules = [];
        foreach ($data as $dataItem) {
            $rules[] = new Rule($dataItem);
        }

        return $rules;
    }

    /**
     * Get a specific rule.
     *
     * @see http://docs.lift.acquia.com/decision/v2/#rules__ruleId__get
     *
     * @param array $id
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function get($id, $options = [])
    {
        $url = RULES_EP."/".$id;
        $url .= $this->getQueryString($options); // Only context_language and cdf_version is useable. Other fields will be ignored

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        return new Rule($data);
    }

    /**
     * Add or update a rule.
     *
     * To Update a rule, use a Rule object with an existing identifier.
     *
     * @see http://docs.lift.acquia.com/decision/v2/#rules_post
     *
     * @param \Acquia\LiftClient\Entity\Rule $rule
     * @param array $options - query parameters
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function add(Rule $rule, $options = [])
    {
        $body = $rule->json();
        
        $url = RULES_EP;
        $url .= $this->getQueryString($options);

        $request = new Request('POST', $url, [], $body);
        $data = $this->getResponseJson($request);

        return new Rule($data);
    }


    /**
     * Update specific rule
     *
     * Currently the endpoint only supports updating segment, priority, description, and label.
     *
     * @see http://docs.lift.acquia.com/decision/v2/#rules_post
     *
     * @param \Acquia\LiftClient\Entity\Rule $rule
     * @param array $options - query parameters. Only cdf_version and context_language is supported. Everything else is ignored
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function patch(Rule $rule, $options = [])
    {
        $body = $rule->json();
        $ruleId = $rule->getId();

        $url = RULES_EP."/{$ruleId}";
        $url .= $this->getQueryString($options);

        $request = new Request('PATCH', $url, [], $body);
        $data = $this->getResponseJson($request);

        return new Rule($data);
    }

    /**
     * Delete rule either by account and site id
     *
     * @see http://docs.lift.acquia.com/decision/v2/#rules__ruleId__delete
     *
     * @param string $id - Optional field
     * 
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return bool
     */
    public function delete()
    {
        $url = RULES_EP;
        $this->client->delete($url);

        return true;
    }

    /**
     * Delete rule either by id
     *
     * @see http://docs.lift.acquia.com/decision/v2/#rules__ruleId__delete
     *
     * @param string $id - Optional field
     * 
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return bool
     */
    public function deleteById($id)
    {
        $url = RULES_EP."/{$id}";
        $this->client->delete($url);

        return true;
    }
}
