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
namespace YomY\DotMatrixRenderer\Color;

use YomY\DotMatrixRenderer\DotMatrixRendererException;

class Color implements IColor {

    /**
     * @var int
     */
    private $red;

    /**
     * @var int
     */
    private $green;

    /**
     * @var int
     */
    private $blue;

    /**
     * @param int $red
     * @param int $green
     * @param int $blue
     * @throws DotMatrixRendererException
     */
    public function __construct($red, $green, $blue) {
        if (
            (int)$red > 255 || (int)$red < 0
            || (int)$green > 255 || (int)$green < 0
            || (int)$blue > 255 || (int)$blue < 0
        ) {
            throw new DotMatrixRendererException('Color value out of bounds');
        }
        $this->red = (int)$red;
        $this->green = (int)$green;
        $this->blue = (int)$blue;
    }

    /**
     * Get red component value
     *
     * @return int
     */
    public function getRed() {
        return $this->red;
    }

    /**
     * Get green component value
     *
     * @return int
     */
    public function getGreen() {
        return $this->green;
    }

    /**
     * Get blue component value
     *
     * @return int
     */
    public function getBlue() {
        return $this->blue;
    }

    /**
     * Get Hex string of color without leading #
     * @return string
     */
    public function getHex() {
        return sprintf("%02x%02x%02x", $this->getRed(), $this->getGreen(), $this->getBlue());
    }

    /**
     * Get decimal string of color with values 0-1. e.x. (0.4 0.1 0.2)
     *
     * @return string
     */
    public function getDec() {
        return round($this->getRed() / 255, 5) . ' ' . round($this->getGreen() / 255, 5) . ' ' . round($this->getBlue() / 255, 5);
    }

}