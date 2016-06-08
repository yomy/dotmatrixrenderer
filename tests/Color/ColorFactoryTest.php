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
use YomY\DotMatrixRenderer\Color\ColorFactory;

class ColorFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     * @dataProvider RGBDataProvider
     */
    public function testGetColorByRGB($r, $g, $b) {
        $color = ColorFactory::fromRGB($r, $g, $b);
        $expectedColor = new Color($r, $g, $b);
        $this->assertEquals($expectedColor, $color);
    }

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     * @dataProvider invalidRGBDataProvider
     */
    public function testGetColorByInvalidRGB($r, $g, $b) {
        $this->setExpectedException('YomY\DotMatrixRenderer\DotMatrixRendererException');
        ColorFactory::fromRGB($r, $g, $b);
    }

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     * @dataProvider RGBDataProvider
     */
    public function testGetColorByHex($r, $g, $b) {
        $hex = sprintf("%02x%02x%02x", $r, $g, $b);
        $color = ColorFactory::fromHex($hex);
        $expectedColor = new Color($r, $g, $b);
        $this->assertEquals($expectedColor, $color);
    }

    /**
     * @param string $hex
     * @dataProvider invalidHEXDataProvider
     */
    public function testGetColorByInvalidHex($hex) {
        $this->setExpectedException('YomY\DotMatrixRenderer\DotMatrixRendererException');
        ColorFactory::fromHex($hex);
    }

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     * @dataProvider RGBDataProvider
     */
    public function testGetColorByHexWithPrefix($r, $g, $b) {
        $hex = '#' . sprintf("%02x%02x%02x", $r, $g, $b);
        $color = ColorFactory::fromHex($hex);
        $expectedColor = new Color($r, $g, $b);
        $this->assertEquals($expectedColor, $color);
    }

    /**
     * Test black color
     */
    public function testBlackColor() {
        $color = ColorFactory::black();
        $expectedColor = new Color(0, 0, 0);
        $this->assertEquals($expectedColor, $color);
    }

    /**
     * Test white color
     */
    public function testWhiteColor() {
        $color = ColorFactory::white();
        $expectedColor = new Color(255, 255, 255);
        $this->assertEquals($expectedColor, $color);
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

    /**
     * Invalid HEX data provider
     *
     * @return array
     */
    public function invalidHEXDataProvider() {
        return array(
            array('NOT_HEX'),
            array('00000I'),
            array('ABCDEFABCDEF'),
            array('ABCDE'),
            array(''),
            array(null)
        );
    }
}