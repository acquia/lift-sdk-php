<?php

namespace Acquia\LiftClient\Entity;

class CapturesResponse extends CapturesBase
{
    /**
     * Gets the 'status' parameter.
     *
     * @return Error[]|null The errors, if there were any
     */
    public function getErrors()
    {
        $ret = [];
        $errors = $this->getEntityValue('errors', []);
        if (empty($errors)) {
            return null;
        }
        foreach ($errors as $error) {
            $ret[] = new Error($error);
        }

        return $ret;
    }

    /**
     * Gets the 'matched_segments' parameter.
     *
     * @return Segment[]
     */
    public function getMatchedSegments()
    {
        $ret = [];
        $segments = $this->getEntityValue('matched_segments', []);
        foreach ($segments as $segment) {
            $ret[] = new Segment($segment);
        }

        return $ret;
    }
}
