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
            
            $classes = get_declared_classes();
            include $file;
            $diff = array_diff(get_declared_classes(), $classes);
            $class = reset($diff);
            
            \Zend_Debug::dump($class);

        }
        
        
        $this->assertTrue(true);
    }
}
