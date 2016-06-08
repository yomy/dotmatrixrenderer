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
namespace YomY\DotMatrixRenderer\Renderer\Resource;

use YomY\DotMatrixRenderer\DotMatrixRendererException;

class PNGResource implements IRenderedResource {

    const RESOURCE_TYPE = 'gd';

    /**
     * @var resource
     */
    private $GDResource;

    /**
     * @param resource $resource
     * @throws DotMatrixRendererException
     */
    public function __construct($resource) {
        if (is_resource($resource) && get_resource_type($resource) == self::RESOURCE_TYPE) {
            $this->GDResource = $resource;
        } else {
            throw new DotMatrixRendererException('Invalid resource');
        }
    }

    /**
     * Get raw resource data
     *
     * @return string
     */
    public function getRawData() {
        ob_start();
        imagepng($this->GDResource);
        return ob_get_clean();
    }

    /**
     * Output resource to browser
     */
    public function output() {
        header("Content-type: image/png");
        imagepng($this->GDResource);
    }

    /**
     * Initialize download of resource
     *
     * @param string $filename
     */
    public function download($filename) {
        header("Content-type: image/png");
        header('Content-Disposition: attachment; filename="' . $filename . '.png');
        imagepng($this->GDResource);
        exit();
    }

}