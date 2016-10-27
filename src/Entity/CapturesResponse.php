<?php

namespace Acquia\LiftClient\Entity;

class CapturesResponse extends CapturesBase
{
    /**
     * Gets the 'error' parameter.
     *
     * @return string
     */
    public function getError()
    {
        return $this->getEntityValue('error', '');
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
