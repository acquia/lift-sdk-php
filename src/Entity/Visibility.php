<?php

namespace Acquia\LiftClient\Entity;

class Visibility extends \ArrayObject
{
    use EntityValueTrait;

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
     * @return \Acquia\LiftClient\Entity\Visibility
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
        return $this->getEntityValue('pages', '');
    }

    /**
     * @param string $condition
     *   Sets the condition of this visibility object. Can be 'show' or 'hide'.
     *   Any other option will be ignored.
     *
     * @return \Acquia\LiftClient\Entity\Visibility
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
        return $this->getEntityValue('condition', '');
    }

    /**
     *
     * @param string $key
     * @param string $default
     *
     * @return mixed
     */
    protected function getEntityValue($key, $default)
    {
        return isset($this[$key]) ? $this[$key] : $default;
    }
}
