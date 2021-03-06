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
namespace YomY\DotMatrixRenderer\Renderer\PNG\Effect;

use YomY\DotMatrixRenderer\Renderer\PNG\PNGRenderer;

class SmallSquareInverted extends PNGRenderer {

    /**
     * Render matrix
     */
    protected function renderMatrix() {
        imagefilledrectangle($this->GDResource, 0, 0, $this->getTotalSize(), $this->getTotalSize(), $this->lightColorGD);
        $offsetStart = $this->getModuleOffset() * $this->getModuleSize();
        $offsetEnd = $offsetStart + $this->getMatrix()->getSize() * $this->getModuleSize();
        imagefilledrectangle($this->GDResource, $offsetStart, $offsetStart, $offsetEnd, $offsetEnd, $this->darkColorGD);
        $squareOffset = floor($this->getModuleSize() * 0.8);
        for ($row = 0; $row < $this->getMatrix()->getSize(); $row++) {
            for ($col = 0; $col < $this->getMatrix()->getSize(); $col++) {
                if ($this->getMatrix()->isLight($row, $col)) {
                    $x = $this->getModuleCoordinate($col) + ($this->getModuleSize() - $squareOffset) / 2;
                    $y = $this->getModuleCoordinate($row) + ($this->getModuleSize() - $squareOffset) / 2;
                    imagefilledrectangle($this->GDResource, $x, $y, $x + $squareOffset, $y + $squareOffset, $this->lightColorGD);
                }
            }
        }
    }
}