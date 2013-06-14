<?php

namespace Fredb\AdminBundle\Tests\Controller;

use Fredb\AdminBundle\Tests\BaseTestCase;
use Symfony\Component\Finder\Finder;

class RowFactoryTest extends BaseTestCase
{
    
    
    
    
    
    
    
    
    public function testGetRowClass()
    {
        
        $oTest = new \Fredb\AdminBundle\Entity\JEntityItem();
        $oTest->setIdEntity(1);
        $oTest->setIdItem(1);
        $oTest->setTypeEntity("r");
        $oTest->setTypeItem("e");
        $oTest->setOrderId(1);
        $oTest->setTag("tag");
        //$this->_em->persist($oTest);
        //$this->_em->flush();
        \Zend_Debug::dump($oTest);
\Zend_Debug::dump($this->_em);

        $oRowFactory = new \Fredb\AdminBundle\Services\Row\RowFactory($this->_em);
        
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
