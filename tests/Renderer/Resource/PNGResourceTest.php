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

use YomY\DotMatrixRenderer\Renderer\Resource\PNGResource;

class PNGResourceTest extends \PHPUnit_Framework_TestCase {

    public function testResourceConstruct() {
        $gd = imagecreate(1, 1);
        new PNGResource($gd);
        imagedestroy($gd);
    }

    public function testInvalidResourceConstruct() {
        $this->setExpectedException('YomY\DotMatrixRenderer\DotMatrixRendererException');
        new PNGResource(null);
    }

    public function testResourceRawData() {
        $gd = imagecreate(1, 1);
        imagecolorallocate($gd, 0, 0, 0);
        $pngResource = new PNGResource($gd);
        $this->assertEquals($this->getRawData($gd), $pngResource->getRawData());
        imagedestroy($gd);
    }

    private function getRawData($gd) {
        ob_start();
        imagepng($gd);
        return ob_get_clean();
    }

}