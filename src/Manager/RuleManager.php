<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Rule;
use GuzzleHttp\Psr7\Request;

class RuleManager extends ManagerBase
{
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
     *     'rows'  => 0,
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
        $url .= isset($options['visible_on_page']) ? "&visible_on_page={$options['visible_on_page']}" : '';
        $url .= isset($options['prefetch']) ? "&prefetch={$options['prefetch']}" : true;
        $url .= isset($options['sort']) ? "&sort={$options['sort']}" : 'asc';
        $url .= isset($options['start']) ? "&start={$options['start']}" : 0;
        $url .= isset($options['rows']) ? "&rows={$options['rows']}" : 10;
        $url .= isset($options['sort_field']) ? "&sort_field={$options['sort_field']}" : 'updated';
        $url .= isset($options['status']) ? "&status={$options['status']}" : 'published';

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->client->getResponseJson($request);

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
        $data = $this->client->getResponseJson($request);

        return new Rule($data);
    }

    /**
     * Add a rule.
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
        $data = $this->client->getResponseJson($request);

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
