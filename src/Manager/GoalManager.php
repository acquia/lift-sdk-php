<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Entity;
use Acquia\LiftClient\Entity\Goal;
use Acquia\LiftClient\Entity\GoalAddResponse;
use Acquia\LiftClient\Exception\LiftSdkException;
use GuzzleHttp\Psr7\Request;

class GoalManager extends ManagerBase
{
    /**
     * {@inheritdoc}
     */
    protected $queryParameters = [
        'global' => null,
        'limit_by_site' => null,
    ];

    /**
     * @var array Valid boolean query strings.
     */
    private $validBooleanQueryStrings = [
        'true',
        'false',
    ];

    /**
     * Get a list of Goals.
     *
     * Example of how to structure the $options parameter:
     * <code>
     * $options = [
     *     'global'  => 'false',
     *     'limit_by_site'  => 'true',
     * ];
     * </code>
     * Note: the options "global" and "limit_by_site" work together to determine
     * what goals are coming back. Please see the truth table on following page.
     *
     * @see http://docs.decision-api.acquia.com/#goals_get
     *
     * @param array $options
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Goal[]
     */
    public function query($options = [])
    {
        $url = '/goals';
        $url .= $this->getQueryString($options);

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        // Get them as Goal objects
        $goals = [];
        foreach ($data as $dataItem) {
            $goals[] = new Goal($dataItem);
        }

        return $goals;
    }

    /**
     * Get a specific goal.
     *
     * @see http://docs.decision-api.acquia.com/#goals__goal_id__get
     *
     * @param array $id
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\Goal
     */
    public function get($id)
    {
        $url = "/goals/{$id}";

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->getResponseJson($request);

        return new Goal($data);
    }

    /**
     * Add a goal.
     *
     * @see http://docs.decision-api.acquia.com/#goals_post
     *
     * @param \Acquia\LiftClient\Entity\Goal $goal
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return \Acquia\LiftClient\Entity\GoalAddResponse
     */
    public function add(Goal $goal)
    {
        // goals only supports adding a list of goals
        // we do not want to support that in the SDK for consistency reasons, so
        // we convert it to an array here.
        $goals = new Entity([$goal->getArrayCopy()]);
        $body = $goals->json();
        $url = '/goals';
        $request = new Request('POST', $url, [], $body);
        $data = $this->getResponseJson($request);

        return new GoalAddResponse($data);
    }

    /**
     * Deletes a goal by ID.
     *
     * @see http://docs.decision-api.acquia.com/#goals__goal_id__delete
     *
     * @param string $id
     *
     * @throws \GuzzleHttp\Exception\RequestException
     *
     * @return bool
     */
    public function delete($id)
    {
        $url = "/goals/{$id}";
        $this->client->delete($url);

        return true;
    }

    /**
     * Get query string of using the options.
     *
     * @param $options The options
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return string  The query string
     */
    protected function getQueryString($options) {
        if (isset($options['global']) && !in_array($options['global'], $this->validBooleanQueryStrings)) {
            throw new LiftSdkException('The "global" parameter must be a string value of "true" or "false", or absent.');
        }
        if (isset($options['limit_by_site']) && !in_array($options['limit_by_site'], $this->validBooleanQueryStrings)) {
            throw new LiftSdkException('The "limit_by_site" parameter must be a string value of "true" or "false", or absent.');
        }

        return parent::getQueryString($options);
    }
}
