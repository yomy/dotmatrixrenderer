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
namespace YomY\DotMatrixRenderer;

use YomY\DotMatrixRenderer\Color\IColor;
use YomY\DotMatrixRenderer\Matrix\IMatrix;
use YomY\DotMatrixRenderer\Renderer\IRenderer;

class EffectFactory {

    const EFFECT_SQUARE = 'Square';
    const EFFECT_SMALLSQUARE = 'SmallSquare';
    const EFFECT_SMALLSQUARE_INVERTED = 'SmallSquareInverted';
    const EFFECT_CIRCLE = 'Circle';
    const EFFECT_CHECKERBOARD = 'Checkerboard';
    const EFFECT_FLUID = 'Fluid';

    /**
     * @param string $effect
     * @param IMatrix $matrix
     * @param IColor $darkColor
     * @param IColor $lightColor
     * @param int $moduleSize
     * @param int $moduleOffset
     * @return IRenderer
     * @throws DotMatrixRendererException
     */
    public static function createPNG(
        $effect, IMatrix $matrix, IColor $darkColor, IColor $lightColor, $moduleSize, $moduleOffset
    ) {
        $effectClass = "YomY\\DotMatrixRenderer\\Renderer\\PNG\\Effect\\" . $effect;
        if (class_exists($effectClass)) {
            return new $effectClass($matrix, $darkColor, $lightColor, $moduleSize, $moduleOffset);
        } else {
            throw new DotMatrixRendererException('Invalid effect');
        }
    }

}