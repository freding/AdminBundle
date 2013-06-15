<?php

namespace Fredb\AdminBundle\Tests;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseTestCase extends WebTestCase
{
    
    /** @var \Doctrine\ORM\EntityManager $oEntityManager  */
    protected $_em;   
    
    static protected function createKernel(array $options = array())
    {
        
        
        $oKernel = self::$kernel = new AppKernel(
            isset($options['config']) ? $options['config'] : 'default.yml'
        );
        $this->_em = $oKernel->getContainer()->get('doctrine.orm.entity_manager');
        return $oKernel;
        
    }

    protected function setUp()
    {
        self::createKernel();
        $fs = new Filesystem();
        //$fs->remove(sys_get_temp_dir().'/JMSPaymentCoreBundle/');
    }

    protected final function importDatabaseSchema()
    {
       

        $metadata = $this->_em->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->_em);
            $schemaTool->dropDatabase();
            $schemaTool->createSchema($metadata);
        }
    }
}