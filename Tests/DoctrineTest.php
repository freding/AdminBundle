<?php

namespace Fredb\AdminBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DoctrineTest extends WebTestCase{

    protected $entityManager = null;
 
    public function setUp()  
    {
        $conn = \Doctrine\DBAL\DriverManager::getConnection(array(
            'driver' => 'pdo_sqlite',
            'memory' => true
        ));

        $config = new \Doctrine\ORM\Configuration();
        $config->setAutoGenerateProxyClasses(true);
        $config->setProxyDir(\sys_get_temp_dir());
        $config->setProxyNamespace('Tests\Entities');
        $config->setMetadataDriverImpl(new AnnotationDriver(new IndexedReader(new AnnotationReader())));
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());

        $params = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );

        $this->entityManager =  \Doctrine\ORM\EntityManager::create($params, $config);  

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);

        $classes = array(
            $this->entityManager->getClassMetadata("\Fredb\AdminBundle\Entity\Account")
            //$this->entityManager->getClassMetadata("\Fredb\AdminBundle\Entity\User"),

        );

        $schemaTool->dropSchema($classes);
        $schemaTool->createSchema($classes);    
    }
  
}  
