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
use YomY\DotMatrixRenderer\Renderer\Shared\FluidLogic\ConnectionMap;
use YomY\DotMatrixRenderer\Renderer\Shared\FluidLogic\RelationCell;

class Fluid extends PNGRenderer {

    /**
     * Render matrix
     */
    protected function renderMatrix() {
        imagefilledrectangle($this->GDResource, 0, 0, $this->getTotalSize(), $this->getTotalSize(), $this->lightColorGD);
        $connectionMap = new ConnectionMap($this->getMatrix());
        for ($row = 0; $row < $this->getMatrix()->getSize(); $row++) {
            for ($col = 0; $col < $this->getMatrix()->getSize(); $col++) {
                $this->renderCell($connectionMap->getCell($row, $col), $row, $col);
            }
        }
    }

    /**
     * @param RelationCell $cell
     * @param int $row
     * @param int $col
     */
    private function renderCell(RelationCell $cell, $row, $col) {
        $x = $this->getModuleCoordinate($col);
        $y = $this->getModuleCoordinate($row);
        $xc = $x + $this->getModuleSize() / 2;
        $yc = $y + $this->getModuleSize() / 2;
        if ($cell->isDark()) {
            $this->renderDarkCell($cell, $x, $y, $xc, $yc);
        } else {
            $this->renderLightCell($cell, $x, $y, $xc, $yc);
        }
    }

    /**
     * @param RelationCell $cell
     * @param int $x
     * @param int $y
     * @param int $xc
     * @param int $yc
     */
    private function renderDarkCell(RelationCell $cell, $x, $y, $xc, $yc) {
        imagefilledellipse($this->GDResource, $xc, $yc, $this->getModuleSize()-1, $this->getModuleSize()-1, $this->darkColorGD);
        if ($cell->anyTopLeft()) {
            imagefilledrectangle($this->GDResource, $x, $y, $xc, $yc, $this->darkColorGD);
        }
        if ($cell->anyTopRight()) {
            imagefilledrectangle($this->GDResource, $xc, $y, $x + $this->getModuleSize(), $yc, $this->darkColorGD);
        }
        if ($cell->anyBottomLeft()) {
            imagefilledrectangle($this->GDResource, $x, $yc, $xc, $y + $this->getModuleSize(), $this->darkColorGD);
        }
        if ($cell->anyBottomRight()) {
            imagefilledrectangle($this->GDResource, $xc, $yc, $x + $this->getModuleSize(), $y + $this->getModuleSize(), $this->darkColorGD);
        }
    }

    /**
     * @param RelationCell $cell
     * @param int $x
     * @param int $y
     * @param int $xc
     * @param int $yc
     */
    private function renderLightCell(RelationCell $cell, $x, $y, $xc, $yc) {
        if ($cell->topLeft()) {
            imagefilledrectangle($this->GDResource, $x, $y, $xc, $yc, $this->darkColorGD);
        }
        if ($cell->topRight()) {
            imagefilledrectangle($this->GDResource, $xc, $y, $x + $this->getModuleSize(), $yc, $this->darkColorGD);
        }
        if ($cell->bottomLeft()) {
            imagefilledrectangle($this->GDResource, $x, $yc, $xc, $y + $this->getModuleSize(), $this->darkColorGD);
        }
        if ($cell->bottomRight()) {
            imagefilledrectangle($this->GDResource, $xc, $yc, $x + $this->getModuleSize(), $y + $this->getModuleSize(), $this->darkColorGD);
        }
        imagefilledellipse($this->GDResource, $xc, $yc, $this->getModuleSize() - 1, $this->getModuleSize() - 1, $this->lightColorGD);
    }

}