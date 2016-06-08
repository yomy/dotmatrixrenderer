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

use YomY\DotMatrixRenderer\Matrix\Matrix;
use YomY\DotMatrixRenderer\Matrix\MatrixFactory;

class MatrixFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @param array $data
     * @dataProvider matrixDataProvider
     */
    public function testCreateFromCharArray(array $data) {
        $charArray = $this->buildCharArray($data);
        $matrix = MatrixFactory::createFromCharArray($charArray);
        $expectedMatrix = new Matrix($data);
        $this->assertEquals($expectedMatrix, $matrix);
    }

    /**
     * @param array $data
     * @dataProvider invalidMatrixDataProvider
     */
    public function testCreateFromInvalidCharArray(array $data) {
        $this->setExpectedException('YomY\DotMatrixRenderer\DotMatrixRendererException');
        $charArray = $this->buildCharArray($data);
        MatrixFactory::createFromCharArray($charArray);
    }

    /**
     * @param array $data
     * @dataProvider matrixDataProvider
     */
    public function testCreateFromString(array $data) {
        $string = $this->buildString($data);
        $matrix = MatrixFactory::createFromString($string);
        $expectedMatrix = new Matrix($data);
        $this->assertEquals($expectedMatrix, $matrix);
    }

    /**
     * @param array $data
     * @dataProvider invalidMatrixDataProvider
     */
    public function testCreateFromInvalidString(array $data) {
        $this->setExpectedException('YomY\DotMatrixRenderer\DotMatrixRendererException');
        $string = $this->buildString($data);
        MatrixFactory::createFromString($string);
    }

    private function buildCharArray($data) {
        $charArray = array();
        foreach ($data as $row => $col) {
            $charArray[$row] = implode('', $col);
        }
        return $charArray;
    }

    private function buildString($data) {
        $charArray = $this->buildCharArray($data);
        return implode('', $charArray);
    }

    public function matrixDataProvider() {
        return array(
            array(
                array(
                    array(0, 0, 0),
                    array(0, 0, 0),
                    array(0, 0, 0)
                )
            ),
            array(
                array(
                    array('1', '0', '1'),
                    array('0', '1', '0'),
                    array('1', '0', '1')
                )
            ),
            array(
                array(
                    array('a', 'b', 'c'),
                    array('d', 'e', 'f'),
                    array('g', 'h', 'i')
                )
            )
        );
    }

    public function invalidMatrixDataProvider() {
        return array(
            array(
                array(
                    array('', '0', '1'),
                    array('0', '1', '0'),
                    array('1', '0', '1')
                )
            ),
            array(
                array(
                    array('a', 'b', 'c'),
                    array('d', 'e', 'f'),
                    array('g', 'h', '')
                )
            )
        );
    }

}