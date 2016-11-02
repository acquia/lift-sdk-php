<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;
use Acquia\LiftClient\Utility\Utility;

class Visibility extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    /**
     * @param array $pages Specify pages by using their paths. The '*' character
     *                     is a wildcard. Example paths are
     *                     http://mywebsite.com/user for the current user's page
     *                     and http://mywebsite.com/user/* for every user page
     *
     * @return \Acquia\LiftClient\Entity\Visibility
     */
    public function setPages(array $pages = [])
    {
        if (Utility::arrayDepth($pages) > 1) {
            throw new LiftSdkException('Pages argument is more than 1 level deep.');
        }

        $this['pages'] = $pages;

        return $this;
    }

    /**
     * Gets the 'pages' parameter.
     *
     * @return array
     */
    public function getPages()
    {
        return $this->getEntityValue('pages', '');
    }

    /**
     * @param string $condition Can be 'show' or 'hide'. Any other option will
     *                          be ignored
     *
     * @throws \Acquia\LiftClient\Exception\LiftSdkException
     *
     * @return \Acquia\LiftClient\Entity\Visibility
     */
    public function setCondition($condition)
    {
        if (!is_string($condition)) {
            throw new LiftSdkException('Argument must be an instance of string.');
        }

        if ($condition !== 'show' && $condition !== 'hide') {
            throw new LiftSdkException('Status much be either show or hide.');
        }
        $this['condition'] = $condition;

        return $this;
    }

    /**
     * Gets the 'condition' parameter.
     *
     * @return array
     */
    public function getCondition()
    {
        return $this->getEntityValue('condition', '');
    }
}
