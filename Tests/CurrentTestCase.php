<?php

namespace Fredb\AdminBundle\Tests;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\PersistentObject;
use Doctrine\ORM\Tools\SchemaTool;

class CurrentTestCase extends \PHPUnit_Framework_Testcase
{
    protected $em, $tool;


    public function setUp()
    {
        $this->setUpDatabase(); // wrap this again
        $this->setUpSchema();
        /* more setup here */
    }

    public function tearDown()
    {
        $classes = array(
            $this->em->getClassMetadata('Fredb\AdminBundle\Entity\Test'),
        );
        $this->tool->dropSchema($classes);
        unset($tool);
        unset($em);
    }

    public function setUpDatabase()
    {
        $isDevMode      = true;
        $doctrineConfig = Setup::createAnnotationMetadataConfiguration(
            array('Fredb\AdminBundle\Entity'),
            $isDevMode
        );

        // database configuration parameters
        $dbConfig = array(
            'host'     => '127.0.0.1',
            'user'     => 'root',
            'password' => '',
            'dbname'   => 'admin_annotation',
        );

        $this->em = EntityManager::create($dbConfig, $doctrineConfig);
        PersistentObject::setObjectManager($this->em);
    }

    public function setUpSchema()
    {
        $this->tool = new SchemaTool($this->em);
        $classes = array(
            $this->em->getClassMetadata('Fredb\AdminBundle\Entity\Test'),
        );
        $this->tool->createSchema($classes);
    }
}