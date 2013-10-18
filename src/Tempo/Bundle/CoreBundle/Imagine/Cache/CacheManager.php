<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\CoreBundle\Imagine\Cache;

use Imagine\Image\ImagineInterface;
use Imagine\Filter\Basic\Resize;
use Imagine\Image\Box;

class CacheManager
{

    /**
     * @var string
     */
    private $webPath;
    private $driver;

    public function __construct(ImagineInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param $webPath
     */
    public function setBasePath($webPath)
    {
        $this->webPath = $webPath;
    }

    public function getBrowserPath($path,$size)
    {
        $file =  $this->getResolver($path);

        $imagePath  =  explode('web', $this->generateImage($file, array($size, $size)));
        return $imagePath[1];
    }


    protected function getResolver($path)
    {
        $path = ltrim($path, '/');

        if (substr($path, 0, 7) == 'bundles') {
            $path = $this->webPath .'../'.$path;
        }

        return $path;
    }

    protected function generateImage($path, $sizes)
    {
        $imageOriginal = $this->webPath.'media/cache/'.md5(pathinfo($path, PATHINFO_BASENAME)).'.'.pathinfo($path, PATHINFO_EXTENSION);
        $filter = new Resize(new Box($sizes[0], $sizes[1]));

        $filter
            ->apply($this->driver->open($path))
            ->save($imageOriginal, array('quality' => 70));

        return $imageOriginal;
    }
}