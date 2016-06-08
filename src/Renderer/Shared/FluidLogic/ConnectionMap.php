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
namespace YomY\DotMatrixRenderer\Renderer\Shared\FluidLogic;

use YomY\DotMatrixRenderer\Matrix\IMatrix;

class ConnectionMap {

    /**
     * @var array
     */
    private $map;

    /**
     * @var IMatrix
     */
    private $matrix;

    public function __construct(IMatrix $matrix) {
        $this->matrix = $matrix;
        $this->generateRelationCellMap($this->calculateConnections());
    }

    /**
     * @param $row
     * @param $col
     * @return RelationCell
     */
    public function getCell($row, $col) {
        return $this->map[$row][$col];
    }



    /**
     * Returns 0 or 1 representing if module should be light or dark.
     * Returns 0 if module is out of bounds instead of throwing exception
     *
     * @param int $row
     * @param int $col
     * @return int
     */
    private function isDarkInt($row, $col) {
        $size = $this->matrix->getSize();
        if ($row >= $size || $col >= $size || $row < 0 || $col < 0) {
            return 0;
        }
        return $this->matrix->isDark($row, $col) ? 1 : 0;
    }

    /**
     * Makes a module connection map of matrix array.
     * Each cell is represented by values 0-9 showing relative position of neighboring cells
     * (index 0 represents that cell is surrounded)
     *
     * X = current cell
     * T=Top, L=Left, R=Right, B=Bottom
     *
     * TL T TR       7  8  9
     * L  X  R   =   4  5  6
     * BL B BR       1  2  3
     *
     * @return array
     */
    private function calculateConnections() {
        $map = array();
        $whiteRecheck = array();
        for ($row=0; $row < $this->matrix->getSize(); $row++) {
            for ($col=0; $col < $this->matrix->getSize(); $col++) {
                $map[$row][$col][5] = $this->isDarkInt($row, $col);
                $map[$row][$col][0] = 0;
                $map[$row][$col][4] = $this->isDarkInt($row, $col - 1);
                $map[$row][$col][6] = $this->isDarkInt($row, $col + 1);
                $map[$row][$col][8] = $this->isDarkInt($row - 1, $col);
                $map[$row][$col][2] = $this->isDarkInt($row + 1, $col);
                $map[$row][$col][7] = $this->isDarkInt($row - 1, $col - 1);
                $map[$row][$col][9] = $this->isDarkInt($row - 1, $col + 1);
                $map[$row][$col][1] = $this->isDarkInt($row + 1, $col - 1);
                $map[$row][$col][3] = $this->isDarkInt($row + 1, $col + 1);
                if (!$map[$row][$col][5]) {
                    $fullCount = $map[$row][$col][1] + $map[$row][$col][2] + $map[$row][$col][3] + $map[$row][$col][4]
                        + $map[$row][$col][6] + $map[$row][$col][7] + $map[$row][$col][8] + $map[$row][$col][9];
                    $soloCount = $map[$row][$col][2] + $map[$row][$col][4] + $map[$row][$col][6] + $map[$row][$col][8];
                    $map[$row][$col][7] = 0;
                    $map[$row][$col][9] = 0;
                    $map[$row][$col][1] = 0;
                    $map[$row][$col][3] = 0;
                    if ($this->isDarkInt($row, $col - 1) && $this->isDarkInt($row - 1, $col)) {
                        $map[$row][$col][7] = 1;
                    }
                    if ($this->isDarkInt($row, $col + 1) && $this->isDarkInt($row - 1, $col)) {
                        $map[$row][$col][9] = 1;
                    }
                    if ($this->isDarkInt($row, $col - 1) && $this->isDarkInt($row + 1, $col)) {
                        $map[$row][$col][1] = 1;
                    }
                    if ($this->isDarkInt($row, $col + 1) && $this->isDarkInt($row + 1, $col)) {
                        $map[$row][$col][3] = 1;
                    }
                    if ($fullCount >= 5) {
                        $whiteRecheck[]=array('row' => $row, 'col' => $col);
                    }
                    if ($soloCount >= 4) {
                        $map[$row][$col][0] = 1;
                    }
                }
            }
        }
        foreach ($whiteRecheck as $key => $cw) {
            $row = $cw['row'];
            $col = $cw['col'];
            if (isset($map[$row + 1][$col - 1]) && !$map[$row + 1][$col - 1][5] && isset($map[$row + 1][$col - 1]) && $map[$row + 1][$col - 1][0]) {
                $map[$row][$col][1] = 0;
                $map[$row][$col - 1][3] = 0;
                $map[$row + 1][$col][7] = 0;
                $map[$row + 1][$col - 1][9] = 0;
            }
            if (isset($map[$row + 1][$col + 1]) && !$map[$row + 1][$col + 1][5] && isset($map[$row + 1][$col + 1]) && $map[$row + 1][$col + 1][0]) {
                $map[$row][$col][3] = 0;
                $map[$row][$col + 1][1] = 0;
                $map[$row + 1][$col][9] = 0;
                $map[$row + 1][$col + 1][7] = 0;
            }
        }
        return $map;
    }

    /**
     * @param array $map
     */
    private function generateRelationCellMap(array &$map) {
        $this->map = array();
        for ($row = 0; $row < $this->matrix->getSize(); $row++) {
            for ($col = 0; $col < $this->matrix->getSize(); $col++) {
                $this->map[$row][$col] = new RelationCell(
                    $map[$row][$col][7],
                    $map[$row][$col][8],
                    $map[$row][$col][9],
                    $map[$row][$col][4],
                    $map[$row][$col][5],
                    $map[$row][$col][6],
                    $map[$row][$col][1],
                    $map[$row][$col][2],
                    $map[$row][$col][3]
                );
            }
        }
    }

}