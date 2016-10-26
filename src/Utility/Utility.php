<?php

namespace Acquia\LiftClient\Utility;

class Utility
{
    /**
   * Define the Depth of an array.
   * Proudly found elsewhere.
   *
   * @see http://stackoverflow.com/a/262944/3664381
   *
   * @param array $array
   *
   * @return int
   */
  public static function arrayDepth(array $array)
  {
      $max_depth = 1;

      foreach ($array as $value) {
          if (is_array($value)) {
              $depth = self::arrayDepth($value) + 1;

              if ($depth > $max_depth) {
                  $max_depth = $depth;
              }
          }
      }

      return $max_depth;
  }
}
