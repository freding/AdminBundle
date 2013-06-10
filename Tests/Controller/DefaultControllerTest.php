<?php

namespace Fredb\AdminBundle\Tests\Controller;

use Fredb\AdminBundle\Tests\TestCase;

class DefaultControllerTest extends TestCase
{
    public function testIndex()
    {
            $this->setUp();
        var_dump($this->getEntityManager()->getRepository("FredbAdminBundle:Test")->findOneById(1));
        
        $this->assertTrue(true);
    }
}
