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
/**
        $c = self::$kernel->getContainer();
        $em = $c->get('doctrine.orm.entity_manager');  
        
        
        $oTest = new \Fredb\AdminBundle\Entity\JEntityItem();
        $oTest->setIdEntity(1);
        $oTest->setIdItem(1);
        $oTest->setTypeEntity("r");
        $oTest->setTypeItem("e");
        $oTest->setOrderId(1);
        $oTest->setTag("tag");
        $em->persist($oTest);
        $em->flush();
*/

        $oRowFactory = new \Fredb\AdminBundle\Services\Row\RowFactory($em);
        
        $finder = new Finder();
        $finder->files()->in(__DIR__."/../../../Annotations/ConcretAnnotations/ClassRow/");
        
        foreach ($finder as $file) {
            $aFilePart      = explode("/", $file);
            $size           =sizeof($aFilePart);
            $class_name     = "Fredb\AdminBundle\Annotations\ConcretAnnotations\ClassRow\\".str_replace(".php", "", $aFilePart[$size-1]);
            $oAnnotation    = new $class_name(array());

            $this->assertTrue($oRowFactory->getRowClass($oAnnotation) instanceof \Fredb\AdminBundle\Services\Row\AbstractRow\RowAbstractClass);
        }
        
        
        
    }
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
}
