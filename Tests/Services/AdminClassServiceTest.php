<?php

namespace Fredb\AdminBundle\Tests\Services;

use Fredb\AdminBundle\Tests\BaseTestCase;

class AdminClassServiceTest extends BaseTestCase
{
    private $oContainer;
    private $oAdminClassService;
    
    public function setUp() {
        parent::setUp();
        $this->createClient();
        //$this->importDatabaseSchema();
        $this->oContainer           = self::$kernel->getContainer();
        $this->oAdminClassService   = $this->oContainer->get("admin_class_service");
    }
    
    
    
    
    
    public function testGetALangsAvailable()
    {
        $aLangs = $this->oAdminClassService->getALangsAvailable();
        $this->assertTrue(count($aLangs)>=1);
        
    }
    
    

    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
}
