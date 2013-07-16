<?php

namespace Fredb\AdminBundle\Tests\Services;

use Fredb\AdminBundle\Tests\BaseTestCase;

class AnnotationsServicesTest extends BaseTestCase
{
    
    
    
    
    
    
    
    
    public function testGetRowClass()
    {
        $this->createClient();
        $this->importDatabaseSchema();
        $c = self::$kernel->getContainer();
        $o =$c->get("link_service");
        \Zend_Debug::dump($o);
        
    }
    
    

    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
}
