<?php

namespace Acquia\LiftClient\Test;

use Acquia\LiftClient\Utility\Utility;

class UtilityTest extends TestBase
{
    public function testArrayDepth()
    {
        $arrayOneLevelDeep = array(
          'level' => 1,
        );

        $arrayTwoLevelsDeep = array(
          'level' => array(
            'level' => 2,
          ),
        );

        $arrayThreeLevelsDeep = array(
          'level' => array(
            'level' => array(
              'level' => 3,
            ),
          ),
        );

        $this->assertEquals(Utility::arrayDepth($arrayOneLevelDeep), 1);
        $this->assertEquals(Utility::arrayDepth($arrayTwoLevelsDeep), 2);
        $this->assertEquals(Utility::arrayDepth($arrayThreeLevelsDeep), 3);
    }
}
