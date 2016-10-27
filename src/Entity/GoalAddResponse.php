<?php

namespace Acquia\LiftClient\Entity;

use Acquia\LiftClient\Exception\LiftSdkException;
use Acquia\LiftClient\Utility\Utility;

class GoalAddResponse extends Entity
{
    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        parent::__construct($array);
    }

    /**
     * Gets the 'status' parameter.
     *
     * @return string The status of the addition
     */
    public function getStatus()
    {
        return $this->getEntityValue('status', '');
    }

    /**
     * Gets the 'status' parameter.
     *
     * @return Error[]|NULL The errors, if there were any
     */
    public function getErrors()
    {
        $ret = [];
        $errors = $this->getEntityValue('errors', []);
        if (empty($errors)) {
            return NULL;
        }
        foreach ($errors as $error) {
            $ret[] = new Error($error);
        }
        return $ret;
    }
}
