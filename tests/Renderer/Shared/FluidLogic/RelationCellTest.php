<?php
/*
   Copyright 2016 Milos Jovanovic <email.yomy@gmail.com>

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
 */
namespace YomY\DotMatrixRenderer\Tests;

use YomY\DotMatrixRenderer\Renderer\Shared\FluidLogic\RelationCell;

class RelationCellTest extends \PHPUnit_Framework_TestCase {

    /**
     * @param int $l1
     * @param int $l2
     * @param int $l3
     * @param int $l4
     * @param int $l5
     * @param int $l6
     * @param int $l7
     * @param int $l8
     * @param int $l9
     * @dataProvider combinationDataProvider
     */
    public function testRelationCellValues($l1, $l2, $l3, $l4, $l5, $l6, $l7, $l8, $l9) {
        $relationCell = new RelationCell($l7, $l8, $l9, $l4, $l5, $l6, $l1, $l2, $l3);
        $expectedNeighborCount = $l2 + $l4 + $l6 + $l8;
        $expectedSurroundCount = $l1 + $l2 + $l3 + $l4 + $l6 + $l7 + $l8 + $l9;
        $this->assertEquals($l1, $relationCell->bottomLeft());
        $this->assertEquals($l2, $relationCell->bottom());
        $this->assertEquals($l3, $relationCell->bottomRight());
        $this->assertEquals($l4, $relationCell->left());
        $this->assertEquals($l5, $relationCell->isDark());
        $this->assertEquals($l6, $relationCell->right());
        $this->assertEquals($l7, $relationCell->topLeft());
        $this->assertEquals($l8, $relationCell->top());
        $this->assertEquals($l9, $relationCell->topRight());
        $this->assertEquals($l1 || $l2 || $l4, $relationCell->anyBottomLeft());
        $this->assertEquals($l2 || $l3 || $l6, $relationCell->anyBottomRight());
        $this->assertEquals($l4 || $l7 || $l8, $relationCell->anyTopLeft());
        $this->assertEquals($l8 || $l9 || $l6, $relationCell->anyTopRight());
        $this->assertEquals($expectedNeighborCount, $relationCell->neighbourCount());
        $this->assertEquals($expectedSurroundCount, $relationCell->surroundCount());
    }

    /**
     * @return array
     */
    public function combinationDataProvider() {
        $combinations = array();
        for ($i = 0; $i <= pow(2, 9); $i++) {
            $combinations[] = array(
                $i & 1,
                $i >> 1 & 1,
                $i >> 2 & 1,
                $i >> 3 & 1,
                $i >> 4 & 1,
                $i >> 5 & 1,
                $i >> 6 & 1,
                $i >> 7 & 1,
                $i >> 8 & 1
            );
        }
        return $combinations;
    }

}