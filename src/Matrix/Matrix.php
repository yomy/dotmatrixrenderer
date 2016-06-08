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
namespace YomY\DotMatrixRenderer\Matrix;

use YomY\DotMatrixRenderer\DotMatrixRendererException;

class Matrix implements IMatrix {

    /**
     * @var array
     */
    private $matrix;

    /**
     * @var int
     */
    private $size;

    public function __construct(array $matrix) {
        $this->matrix = array();
        $size = count($matrix);
        foreach ($matrix as $row) {
            $rowSize = count($row);
            if ($rowSize != $size) {
                throw new DotMatrixRendererException('Matrix row and column count is not the same');
            }
            $this->matrix[] = array_map(function($value) {
                return (bool)$value;
            }, $row);
        }
    }

    /**
     * @return int
     */
    public function getSize() {
        if (is_null($this->size)) {
            $this->size = count($this->matrix);
        }
        return $this->size;
    }

    /**
     * @param int $row
     * @param int $col
     * @return bool
     * @throws DotMatrixRendererException
     */
    public function isDark($row, $col) {
        $size = $this->getSize();
        if ($row >= $size || $col >= $size || $row < 0 || $col < 0) {
            throw new DotMatrixRendererException('Coordinates out of bounds');
        }
        return (bool)$this->matrix[$row][$col];
    }

    /**
     * @param int $row
     * @param int $col
     * @return bool
     * @throws DotMatrixRendererException
     */
    public function isLight($row, $col) {
        return !$this->isDark($row, $col);
    }

    /**
     * @return array(array(bool))
     */
    public function getMatrix() {
        return $this->matrix;
    }

}