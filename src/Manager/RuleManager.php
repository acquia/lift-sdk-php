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
        'visible_on_page' => null,
        'prefetch' => null,
        'sort' => null,
        'start' => null,
        'rows' => null,
        'sort_field' => null,
        'status' => null,
    ];

    /**
     * Get a list of Rules.
     *
     * Example of how to structure the $options parameter:
     * <code>
     * $options = [
     *     'visible_on_page'  => 'node/1/*',
     *     'prefetch'  => true,
     *     'sort'  => 'asc',
     *     'start'  => 0,
     *     'rows'  => 10,
     *     'sort_field'  => 'updated',
     *     'status'  => 'published'
     * ];
     * </code>
     *
     * @see http://docs.decision-api.acquia.com/#rules_get
     *
     * @param array $options
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Rule[]
     */
    public function query($options = [])
    {
        $url = '/rules';
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
     * @see http://docs.decision-api.acquia.com/#rules__ruleId__get
     *
     * @param array $id
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function get($id)
    {
        $url = "/rules/{$id}";

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
     * @see http://docs.decision-api.acquia.com/#rules_post
     *
     * @param \Acquia\LiftClient\Entity\Rule $rule
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Rule
     */
    public function add(Rule $rule)
    {
        $body = $rule->json();
        $url = '/rules';
        $request = new Request('POST', $url, [], $body);
        $data = $this->getResponseJson($request);

        return new Rule($data);
    }

    /**
     * Deletes a rule by ID.
     *
     * @see http://docs.decision-api.acquia.com/#rules__ruleId__delete
     *
     * @param string $id
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return bool
     */
    public function delete($id)
    {
        $url = "/rules/{$id}";
        $this->client->delete($url);

        return true;
    }
}
