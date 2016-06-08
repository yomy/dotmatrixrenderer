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

require_once('MockRenderer.php');

use YomY\DotMatrixRenderer\Color\Color;
use YomY\DotMatrixRenderer\Matrix\Matrix;

class AbstractRendererTest extends \PHPUnit_Framework_TestCase {

    public function testRendererData() {
        $data = array(array(1, 0), array(0, 1));
        $matrix = new Matrix($data);
        $darkColor = new Color(0, 0, 0);
        $lightColor = new Color(1, 1, 1);
        $moduleSize = 10;
        $moduleOffset = 4;
        $expectedTotalSize = $moduleOffset * 2 * $moduleSize + count($data) * $moduleSize;
        $mockRenderer = new MockRenderer($matrix, $darkColor, $lightColor, $moduleSize, $moduleOffset);
        $this->assertEquals($matrix, $this->invokeMockMethod($mockRenderer, 'getMatrix'));
        $this->assertEquals($darkColor, $this->invokeMockMethod($mockRenderer, 'getDarkColor'));
        $this->assertEquals($lightColor, $this->invokeMockMethod($mockRenderer, 'getLightColor'));
        $this->assertEquals($moduleSize, $this->invokeMockMethod($mockRenderer, 'getModuleSize'));
        $this->assertEquals($moduleOffset, $this->invokeMockMethod($mockRenderer, 'getModuleOffset'));
        $this->assertEquals($expectedTotalSize, $this->invokeMockMethod($mockRenderer, 'getTotalSize'));
    }

    public function testInvalidModuleSize() {
        $this->setExpectedException('YomY\DotMatrixRenderer\DotMatrixRendererException');
        $data = array(array(1, 0), array(0, 1));
        $matrix = new Matrix($data);
        $darkColor = new Color(0, 0, 0);
        $lightColor = new Color(1, 1, 1);
        $moduleSize = 0;
        $moduleOffset = 4;
        new MockRenderer($matrix, $darkColor, $lightColor, $moduleSize, $moduleOffset);
    }

    public function testInvalidModuleOffset() {
        $this->setExpectedException('YomY\DotMatrixRenderer\DotMatrixRendererException');
        $data = array(array(1, 0), array(0, 1));
        $matrix = new Matrix($data);
        $darkColor = new Color(0, 0, 0);
        $lightColor = new Color(1, 1, 1);
        $moduleSize = 5;
        $moduleOffset = -5;
        new MockRenderer($matrix, $darkColor, $lightColor, $moduleSize, $moduleOffset);
    }

    private function invokeMockMethod($object, $method, $args = null) {
        $method = new \ReflectionMethod($object, $method);
        $method->setAccessible(true);
        if (is_array($args)) {
            $result = $method->invokeArgs($object, $args);
        } else {
            $result = $method->invoke($object);
        }
        return $result;
    }

}