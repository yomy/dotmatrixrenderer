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

use YomY\DotMatrixRenderer\Color\Color;

class ColorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     * @dataProvider RGBDataProvider
     */
    public function testColorValues($r, $g, $b) {
        $color = new Color($r, $g, $b);
        $this->assertEquals($r, $color->getRed());
        $this->assertEquals($g, $color->getGreen());
        $this->assertEquals($b, $color->getBlue());
    }

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     * @dataProvider invalidRGBDataProvider
     */
    public function testColorInvalidValues($r, $g, $b) {
        $this->setExpectedException('YomY\DotMatrixRenderer\DotMatrixRendererException');
        new Color($r, $g, $b);
    }

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     * @dataProvider RGBDataProvider
     */
    public function testColorGetHex($r, $g, $b) {
        $color = new Color($r, $g, $b);
        $hex = sprintf("%02x%02x%02x", $r, $g, $b);
        $this->assertEquals($hex, $color->getHex());
    }

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     * @dataProvider RGBDataProvider
     */
    public function testColorGetDec($r, $g, $b) {
        $color = new Color($r, $g, $b);
        $dec = round($r / 255, 5) . ' ' . round($g / 255, 5) . ' ' . round($b / 255, 5);
        $this->assertEquals($dec, $color->getDec());
    }

    /**
     * RGB data provider
     *
     * @return array
     */
    public function RGBDataProvider() {
        return array(
            array(0, 0, 0),
            array(255, 0, 0),
            array(0, 255, 0),
            array(0, 0, 255),
            array(255, 255, 255)
        );
    }

    /**
     * Invalid RGB data provider
     *
     * @return array
     */
    public function invalidRGBDataProvider() {
        return array(
            array(-1, 0, 0),
            array(0, -1, 0),
            array(0, 0, -1),
            array(256, 0, 0),
            array(0, 256, 0),
            array(0, 0, 256)
        );
    }
}