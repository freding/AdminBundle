<?php

namespace Fredb\AdminBundle\Tests\Controller;

use Fredb\AdminBundle\Tests\BaseTestCase;
use Symfony\Component\Finder\Finder;

class RowFactoryTest extends BaseTestCase
{
    
    
    
    
    
    
    
    
    public function testGetRowClass()
    {
        $oTest = new \Acme\DemoBundle\Entity\Test2();
        $oTest->setChaine("test");
        $this->_em->persist($oTest);
        $this->_em->flush();
        \Zend_Debug::dump($oTest);
        $this->assertTrue($oTest->getId()>=0);

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
