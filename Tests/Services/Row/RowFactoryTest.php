<?php

namespace Fredb\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Finder\Finder;

class RowFactoryTest extends WebTestCase
{
    
    
    
    
    
    
    
    
    public function testGetRowClass()
    {
        
        
        
        $kernel = static::createKernel();
        $kernel->boot();
        $oEntityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
   
        $oRowFactory = new \Fredb\AdminBundle\Services\Row\RowFactory($oEntityManager);
        
        $finder = new Finder();
        $finder->files()->in(__DIR__."/../../../Annotations/ConcretAnnotations/ClassRow/");

        foreach ($finder as $file) {
            $class_name = "Fredb\AdminBundle\Annotations\ConcretAnnotations\ClassRow\\".str_replace(".php", "", "ManageByBo.php");
            $oAnnotation = new $class_name(array()); 
            $this->assertTrue($oRowFactory->getRowClass($oAnnotation) instanceof Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractNoVisualAnnotation);
        }
        
        
        
    }
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
}
