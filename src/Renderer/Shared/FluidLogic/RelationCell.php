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
namespace YomY\DotMatrixRenderer\Renderer\Shared\FluidLogic;

class RelationCell {

    /**
     * @var array
     */
    private $relations;

    /**
     * @param bool $tl
     * @param bool $t
     * @param bool $tr
     * @param bool $l
     * @param bool $c
     * @param bool $r
     * @param bool $bl
     * @param bool $b
     * @param bool $br
     */
    public function __construct($tl, $t, $tr, $l, $c,  $r, $bl, $b, $br) {
        $this->relations = array(
            1 => !!$bl,
            2 => !!$b,
            3 => !!$br,
            4 => !!$l,
            5 => !!$c,
            6 => !!$r,
            7 => !!$tl,
            8 => !!$t,
            9 => !!$tr
        );
    }

    /**
     * @return bool
     */
    public function bottomLeft() {
        return $this->relations[1];
    }

    /**
     * @return bool
     */
    public function bottom() {
        return $this->relations[2];
    }

    /**
     * @return bool
     */
    public function bottomRight() {
        return $this->relations[3];
    }

    /**
     * @return bool
     */
    public function left() {
        return $this->relations[4];
    }

    /**
     * @return bool
     */
    public function isDark() {
        return $this->relations[5];
    }

    /**
     * @return bool
     */
    public function right() {
        return $this->relations[6];
    }

    /**
     * @return bool
     */
    public function topLeft() {
        return $this->relations[7];
    }

    /**
     * @return bool
     */
    public function top() {
        return $this->relations[8];
    }

    /**
     * @return bool
     */
    public function topRight() {
        return $this->relations[9];
    }

    /**
     * @return bool
     */
    public function anyTopLeft() {
        return $this->relations[4] || $this->relations[7] || $this->relations[8];
    }

    /**
     * @return bool
     */
    public function anyTopRight() {
        return $this->relations[8] || $this->relations[9] || $this->relations[6];
    }

    /**
     * @return bool
     */
    public function anyBottomLeft() {
        return $this->relations[2] || $this->relations[1] || $this->relations[4];
    }

    /**
     * @return bool
     */
    public function anyBottomRight() {
        return $this->relations[2] || $this->relations[3] || $this->relations[6];
    }

    /**
     * @return int
     */
    public function neighbourCount() {
        return ($this->relations[2] ? 1 : 0)
            + ($this->relations[4] ? 1 : 0)
            + ($this->relations[6] ? 1 : 0)
            + ($this->relations[8] ? 1 : 0);
    }

    /**
     * @return int
     */
    public function surroundCount() {
        return ($this->relations[1] ? 1 : 0)
        + ($this->relations[2] ? 1 : 0)
        + ($this->relations[3] ? 1 : 0)
        + ($this->relations[4] ? 1 : 0)
        + ($this->relations[6] ? 1 : 0)
        + ($this->relations[7] ? 1 : 0)
        + ($this->relations[8] ? 1 : 0)
        + ($this->relations[9] ? 1 : 0);
    }

}