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

class ColorFactory {

    /**
     * @return IColor
     */
    public static function black() {
        return new Color(0, 0, 0);
    }

    /**
     * @return IColor
     */
    public static function white() {
        return new Color(255, 255, 255);
    }

    /**
     * @param string $hex
     * @return IColor
     * @throws DotMatrixRendererException
     */
    public static function fromHex($hex) {
        $hex = ltrim($hex, '#');
        if (!ctype_xdigit($hex) || strlen($hex) != 6) {
            throw new DotMatrixRendererException('Invalid hex color value');
        }
        return new Color(hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2)));
    }

    /**
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return IColor
     * @throws DotMatrixRendererException
     */
    public static function fromRGB($red, $green, $blue) {
        return new Color($red, $green, $blue);
    }

}