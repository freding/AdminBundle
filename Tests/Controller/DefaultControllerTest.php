<?php

namespace Fredb\AdminBundle\Tests\Controller;

use Fredb\AdminBundle\Tests\TestCase;

class DefaultControllerTest extends TestCase
{
    public function testIndex()
    {
            
        var_dump($this->getEntityManager()->getRepository("FredbAdmin:Test")->findOneById(1));
        
        $this->assertTrue(true);
    }
}
