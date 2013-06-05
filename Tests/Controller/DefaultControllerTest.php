<?php

namespace Fredb\AdminBundle\Tests\Controller;

use Fredb\AdminBundle\Tests\DoctrineTest;

class DefaultControllerTest extends DoctrineTest
{
    public function testIndex()
    {
        $oTest = $this->entityManager->getRepository("FredbAdminBundle:Test")->findOneById(1);
        var_dump($oTest);
        
        $this->assertTrue(true);
    }
}
