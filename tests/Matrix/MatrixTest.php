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

class MatrixTest extends \PHPUnit_Framework_TestCase {

    /**
     * @param array $data
     * @dataProvider matrixDataProvider
     */
    public function testMatrixIsDarkIsLight(array $data) {
        $matrix = new Matrix($data);
        foreach ($data as $row => $columns) {
            foreach ($columns as $col => $module) {
                $this->assertEquals((bool)$module, $matrix->isDark($row, $col));
                $this->assertEquals(!$module, $matrix->isLight($row, $col));
            }
        }
    }

    /**
     * @param array $data
     * @dataProvider matrixDataProvider
     */
    public function testMatrixGetSize(array $data) {
        $matrix = new Matrix($data);
        $this->assertEquals(count($data), $matrix->getSize());
    }

    /**
     * @param array $data
     * @dataProvider invalidMatrixDataProvider
     */
    public function testCreateInvalidMatrix(array $data) {
        $this->setExpectedException('YomY\DotMatrixRenderer\DotMatrixRendererException');
        new Matrix($data);
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
                    array(1, 0, 0),
                    array(0, 1, 0),
                    array(0, 0, 1)
                )
            ),
            array(
                array(
                    array(1, 1, 1),
                    array(1, 1, 1),
                    array(1, 1, 1)
                )
            ),
            array(
                array(
                    array(true, true, true),
                    array(true, true, true),
                    array(true, true, true)
                )
            ),
            array(
                array(
                    array(false, false, false),
                    array(false, false, false),
                    array(false, false, false)
                )
            ),
            array(
                array(
                    array(false, true, true),
                    array(true, false, true),
                    array(true, true, false)
                )
            ),
            array(
                array(
                    array('', true, 0),
                    array(5, array(), 9),
                    array('string', '0', null)
                )
            ),
            array(
                array(
                    array(1)
                )
            ),
            array(
                array(
                    array(1, 1, 1, 1, 1),
                    array(0, 0, 0, 0, 0),
                    array(1, 1, 1, 1, 1),
                    array(0, 0, 0, 0, 0),
                    array(1, 1, 1, 1, 1)
                )
            ),
        );
    }

    public function invalidMatrixDataProvider() {
        return array(
            array(
                array(
                    array(0, 0, 0),
                    array(0, 0, 0)
                )
            ),
            array(
                array(
                    array(0),
                    array(0)
                )
            ),
            array(
                array(
                    array(0, 0),
                    array(0)
                )
            ),
            array(
                array(
                    array(0),
                    array(0, 0)
                )
            ),
            array(
                array(
                    array(0, 0)
                )
            )
        );
    }

}