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

interface IColor {

    /**
     * Get red component value
     *
     * @return int
     */
    public function getRed();

    /**
     * Get green component value
     *
     * @return int
     */
    public function getGreen();

    /**
     * Get blue component value
     *
     * @return int
     */
    public function getBlue();

    /**
     * Get Hex string of color without leading #
     *
     * @return string
     */
    public function getHex();

    /**
     * Get decimal string of color with values 0-1. e.x. (0.4 0.1 0.2)
     *
     * @return string
     */
    public function getDec();

}