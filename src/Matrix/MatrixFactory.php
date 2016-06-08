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

class MatrixFactory {

    /**
     * @param array $charArray
     * @return IMatrix
     */
    public static function createFromCharArray(array $charArray) {
        $data = array();
        foreach ($charArray as $row => $column) {
            $data[$row] = array_map(function($cell) {
                return (bool)$cell;
            }, str_split($column));
        }
        return new Matrix($data);
    }

    /**
     * @param string $string
     * @return IMatrix
     * @throws DotMatrixRendererException
     */
    public static function createFromString($string) {
        $size = sqrt(strlen($string));
        if ($size != (int)$size) {
            throw new DotMatrixRendererException('Invalid string length');
        }
        $charArray = str_split($string, (int)$size);
        if (count($charArray) != (int)$size) {
            throw new DotMatrixRendererException('Matrix row and column count is not the same');
        }
        return self::createFromCharArray($charArray);
    }

}