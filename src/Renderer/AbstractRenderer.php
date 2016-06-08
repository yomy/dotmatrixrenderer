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
namespace YomY\DotMatrixRenderer\Renderer;

use YomY\DotMatrixRenderer\Color\IColor;
use YomY\DotMatrixRenderer\Matrix\IMatrix;
use YomY\DotMatrixRenderer\DotMatrixRendererException;
use YomY\DotMatrixRenderer\Renderer\Resource\IRenderedResource;

abstract class AbstractRenderer implements IRenderer {

    const MINIMUM_MODULE_SIZE = 1;
    const MINIMUM_MODULE_OFFSET = 0;

    /**
     * @var IMatrix
     */
    private $matrix;

    /**
     * @var IColor
     */
    private $darkColor;

    /***
     * @var IColor
     */
    private $lightColor;

    /**
     * @var int
     */
    private $moduleSize;

    /**
     * @var int
     */
    private $moduleOffset;

    /**
     * @param IMatrix $matrix
     * @param IColor $darkColor
     * @param IColor $lightColor
     * @param int $moduleSize
     * @param int $moduleOffset
     * @throws DotMatrixRendererException
     */
    public function __construct(IMatrix $matrix, IColor $darkColor, IColor $lightColor, $moduleSize, $moduleOffset) {
        $this->matrix = $matrix;
        $this->darkColor = $darkColor;
        $this->lightColor = $lightColor;
        $this->moduleSize = (int)$moduleSize;
        $this->moduleOffset = (int)$moduleOffset;
        if ($this->moduleSize < self::MINIMUM_MODULE_SIZE) {
            throw new DotMatrixRendererException('Module size too small');
        }
        if ($this->moduleOffset < self::MINIMUM_MODULE_OFFSET) {
            throw new DotMatrixRendererException('Module offset too small');
        }
    }

    /**
     * @return IMatrix
     */
    protected function getMatrix() {
        return $this->matrix;
    }

    /**
     * @return IColor
     */
    protected function getDarkColor() {
        return $this->darkColor;
    }

    /**
     * @return IColor
     */
    protected function getLightColor() {
        return $this->lightColor;
    }

    /**
     * @return int
     */
    protected function getModuleSize() {
        return $this->moduleSize;
    }

    /**
     * @return int
     */
    protected function getModuleOffset() {
        return $this->moduleOffset;
    }

    /**
     * @return int
     */
    protected function getTotalSize() {
        return $this->getModuleOffset() * 2 * $this->getModuleSize() + $this->getMatrix()->getSize() * $this->getModuleSize();
    }

    /**
     * @return IRenderedResource
     */
    public abstract function render();

}