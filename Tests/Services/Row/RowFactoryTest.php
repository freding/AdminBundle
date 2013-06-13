<?php

namespace Fredb\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Finder\Finder;

class RowFactoryTest extends WebTestCase
{
    public function testGetRowClass()
    {

        
        $finder = new Finder();
        $finder->files()->in(__DIR__."/../../../Annotations/ConcretAnnotations/ClassRow/");

        foreach ($finder as $file) {
            \Zend_Debug::dump($file);

        }
        
        
        $this->assertTrue(true);
    }
}
