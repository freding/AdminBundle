<?php

namespace Fredb\AdminBundle\Tests\Controller;

use Fredb\AdminBundle\Tests\BaseTestCase;
use Symfony\Component\Finder\Finder;

class RowFactoryTest extends BaseTestCase
{
    
    
    
    
    
    
    
    
    public function testGetRowClass()
    {
        $this->createClient();
        $this->importDatabaseSchema();
        $c = self::$kernel->getContainer();
        $oEntityManager = $c->get('doctrine.orm.entity_manager');

        $oRowFactory = new \Fredb\AdminBundle\Services\Row\RowFactory($oEntityManager);
        
        $finder = new Finder();
        $finder->files()->in(__DIR__."/../../../Annotations/ConcretAnnotations/ClassRow/");

        
        foreach ($finder as $file) {
            $aFilePart      = explode("/", $file);
            $size           =sizeof($aFilePart);
            $class_name     = "Fredb\AdminBundle\Annotations\ConcretAnnotations\ClassRow\\".str_replace(".php", "", $aFilePart[$size-1]);
            $oAnnotation    = new $class_name(array()); 
            $this->assertTrue($oRowFactory->getRowClass($oAnnotation) instanceof Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractNoVisualAnnotation);
        }
        
        
        
    }
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
}
