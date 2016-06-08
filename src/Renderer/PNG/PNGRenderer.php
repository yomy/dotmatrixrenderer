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
namespace YomY\DotMatrixRenderer\Renderer\PNG;

use YomY\DotMatrixRenderer\Color\IColor;
use YomY\DotMatrixRenderer\Matrix\IMatrix;
use YomY\DotMatrixRenderer\Renderer\AbstractRenderer;
use YomY\DotMatrixRenderer\Renderer\Resource\PNGResource;

abstract class PNGRenderer extends AbstractRenderer {

    /**
     * @var resource
     */
    protected $GDResource;

    /**
     * @var int
     */
    protected $darkColorGD;

    /**
     * @var int
     */
    protected $lightColorGD;

    public function __construct(IMatrix $matrix, IColor $darkColor, IColor $lightColor, $moduleSize, $moduleOffset) {
        parent::__construct($matrix, $darkColor, $lightColor, $moduleSize, $moduleOffset);
        $this->initializeGD();
    }

    /**
     * Initialize GD image
     */
    protected function initializeGD() {
        $imageSize = $this->getTotalSize();
        $this->GDResource = imagecreate($imageSize, $imageSize);
        $this->lightColorGD = imagecolorallocate(
            $this->GDResource,
            $this->getLightColor()->getRed(),
            $this->getLightColor()->getGreen(),
            $this->getLightColor()->getBlue()
        );
        $this->darkColorGD = imagecolorallocate(
            $this->GDResource,
            $this->getDarkColor()->getRed(),
            $this->getDarkColor()->getGreen(),
            $this->getDarkColor()->getBlue()
        );
    }

    /**
     * Gets module top/left coordinate based on module size and offset
     *
     * @param int $index column/row
     * @return int
     */
    protected function getModuleCoordinate($index) {
        return $this->getModuleSize() * $this->getModuleOffset() + $index * $this->getModuleSize();
    }

    /**
     * @return PNGResource
     */
    public function render() {
        $this->renderMatrix();
        return new PNGResource($this->GDResource);
    }

    /**
     * @return void
     */
    abstract protected function renderMatrix();

}