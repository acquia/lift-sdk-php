<?php

namespace Acquia\LiftClient;

class Visibility extends \ArrayObject
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    /**
     * @param array $pages
     *   Specify pages by using their paths. The '*' character is a wildcard.
     *   Example paths are http://mywebsite.com/user for the current user's page
     *   and http://mywebsite.com/user/* for every user page.
     *
     * @return \Acquia\LiftClient\Visibility
     */
    public function setPages(array $pages = [])
    {
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
        return $this->getValue('pages', '');
    }

    /**
     * @param string $condition
     *   Sets the condition of this visibility object. Can be 'show' or 'hide'.
     *   Any other option will be ignored.
     *
     * @return \Acquia\LiftClient\Visibility
     */
    public function setCondition($condition)
    {
        if ($condition === 'show' || $condition === 'hide') {
            $this['condition'] = $condition;
        }

        return $this;
    }

    /**
     * Gets the 'condition' parameter.
     *
     * @return array
     */
    public function getCondition()
    {
        return $this->getValue('condition', '');
    }

    /**
     *
     * @param string $key
     * @param string $default
     *
     * @return mixed
     */
    protected function getValue($key, $default)
    {
        return isset($this[$key]) ? $this[$key] : $default;
    }

}
