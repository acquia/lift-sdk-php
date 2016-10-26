<?php

namespace Acquia\LiftClient\Entity;

trait EntityValueTrait {

  /**
   *
   * @param string $key
   * @param string $default
   *
   * @return mixed
   */
  private function getEntityValue($key, $default)
  {
    return isset($this[$key]) ? $this[$key] : $default;
  }

}