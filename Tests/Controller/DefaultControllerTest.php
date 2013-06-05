<?php

namespace Fredb\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
        var_dump($em);
        
        $this->assertTrue(true);
    }
}
