<?php

namespace Acquia\LiftClient\Manager;

use Acquia\LiftClient\Entity\Goal;
use GuzzleHttp\Psr7\Request;

class GoalManager extends ManagerBase
{
    /**
     * Get a list of Goals.
     *
     * Example of how to structure the $options parameter:
     * <code>
     * $options = [
     *     'limit_by_site'  => 'my-site-id'
     * ];
     * </code>
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
        $url .= isset($options['limit_by_site']) ? "&limit_by_site={$options['limit_by_site']}" : '';

        // Now make the request.
        $request = new Request('GET', $url);
        $data = $this->client->getResponseJson($request);

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
        $data = $this->client->getResponseJson($request);

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
     * @return \Acquia\LiftClient\Entity\Goal
     */
    public function add(Goal $goal)
    {
        $body = $goal->json();
        $url = '/goals';
        $request = new Request('POST', $url, [], $body);
        $data = $this->client->getResponseJson($request);

        return new Goal($data);
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
}
