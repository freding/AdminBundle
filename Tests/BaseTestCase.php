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
        return self::$kernel = new AppKernel(
            isset($options['config']) ? $options['config'] : 'default.yml'
        );
    }

    protected function setUp()
    {
        $fs = new Filesystem();
        //$fs->remove(sys_get_temp_dir().'/JMSPaymentCoreBundle/');
    }

    protected final function importDatabaseSchema()
    {
        $this->em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
            $schemaTool->dropDatabase();
            $schemaTool->createSchema($metadata);
        }
    }
}