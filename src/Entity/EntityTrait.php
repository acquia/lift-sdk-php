<?php

namespace Acquia\LiftClient\Entity;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Serializer;

trait EntityTrait
{
  /**
   * @param string $key
   * @param string|int|float|array $default
   *
   * @return mixed
   */
  protected function getEntityValue($key, $default)
  {
      return isset($this[$key]) ? $this[$key] : $default;
  }

  /**
   * Returns the json representation of the current object.
   *
   * @return string
   */
  public function json()
  {
      $encoders = array(new JsonEncoder());
      $normalizers = array(new CustomNormalizer());
      $serializer = new Serializer($normalizers, $encoders);

      return $serializer->serialize($this, 'json');
  }
}
