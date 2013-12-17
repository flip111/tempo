<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\CoreBundle\Tests\Imagine\Cache;

use Symfony\Component\Finder\Finder;
use Tempo\Bundle\CoreBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Filesystem\Filesystem;
use Imagine\Gd\Imagine;

class CacheManagerTest  extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->filesystem = new Filesystem();
        $this->fixturesDir = str_replace('/', DIRECTORY_SEPARATOR,__DIR__).DIRECTORY_SEPARATOR.'../../Fixtures';

        $this->tempDir =  DIRECTORY_SEPARATOR.sys_get_temp_dir().'/imagine_autogen_test';

        $this->imagine = new Imagine();
        $this->cacheManager = new CacheManager($this->imagine, $this->filesystem);
        $this->cacheManager->setBasePath($this->tempDir);

        if ($this->filesystem->exists($this->tempDir)) {
            $this->filesystem->remove($this->tempDir);
        }

        $this->filesystem->mkdir($this->tempDir);
    }

    public function testGetBrowserPath()
    {
        try {
            $this->cacheManager->getBrowserPath($this->fixturesDir.'/assets/cats.jpeg', array(100, 100));
        }

        catch (InvalidArgumentException $expected) {
            $this->fail('An expected exception has not been raised.');
        }
    }
}