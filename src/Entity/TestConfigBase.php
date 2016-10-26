<?php

namespace Acquia\LiftClient\Entity;

class TestConfigBase extends \ArrayObject implements TestConfigInterface
{
    use EntityTrait;

  /**
   * @param array $array
   */
  public function __construct(array $array = [])
  {
      parent::__construct($array);
  }
}
