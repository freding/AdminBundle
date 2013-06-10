<?php

namespace Fredb\AdminBundle\Tests;


/**
 * A Simple Test Case used for testing Doctrine ORM
 * Provides functions useful in testing your entities as your build them.
 *
 * @author camm (cameronmanderson@gmail.com)
 */
class TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Doctrine\ORM\Tools\SchemaTool
     */
    static $sqlLogger;

    /**
     * @var int
     */
    private $queryCount = 0;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \Doctrine\Common\EventManager
     */
    private $eventManager;

    /**
     * @var array
     */
    protected $paths = array();

    /**
     * @var string
     */
    protected $resource;

    /**
     * Set up called prior to running tests
     * @return void
     */
    protected function setUp()
    {
        $this->loadSchemas(array('Fredb\AdminBundle\Entity\Test'));
    }

    
    /**
     * Tear down process run after tests
     * @return void
     */
    protected function tearDown()
    {
        //
    }

    /**
     * Loads a fixture
     * @throws \Exception
     * @param $fixtureClass
     * @return void
     */
    public function loadFixture($fixtureClass)
    {
        if(!class_Exists($fixtureClass)) throw new \Exception('Could not locate the fixture class '  . $fixtureClass . '. Ensure it is autoloadable');
        $fixture = new $fixtureClass();
        if(!($fixture instanceof \Doctrine\Common\DataFixtures\FixtureInterface))
            throw new \Exception('Class ' . $fixtureClass . ' does not implement the FixtureInterface.');

        $fixture->load($this->getEntityManager());
    }

    /**
     * Resets the query counter index
     * @return void
     */
    public function resetQueryCount()
    {
        if(!empty(self::$sqlLogger)) {
            $this->queryCount = count(self::$sqlLogger->queries);
        }
    }

    /**
     * Returns with the number of queries since last reset of counter
     * @return int
     */
    public function getQueryCount()
    {
        if(!empty(self::$sqlLogger)) {
            return count(self::$sqlLogger->queries) - $this->queryCount;
        }
    }

    /**
     * Load a database schema into the database
     * @param $entityClasses array of FQCN
     * @return void
     */
    public function loadSchemas($entityClasses)
    {
        $this->dropDatabase();
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->getEntityManager());
        
        $classes = array();
        foreach($entityClasses as $className) {
            $classes[] = $this->getEntityManager()->getClassMetadata($className);
        }
        if(!empty($classes)) {
            $schemaTool->createSchema($classes);
        }
    }

    /**
     * Add doctrine event manager lifecycle listener
     * @param $events Array of Event constants to listen to
     * @param $listener
     * @return void
     */
    public function addLifecycleEventListener($events = array(), $listener)
    {
        if(empty($this->entityManager))
            throw new \Exception('Please establish the entity manager connection using getEntityManager prior to adding event listeners');
        $this->eventManager->addEventListener($events, $listener);
    }

    /**
     * Add doctrine event manager lifecycle event subscriber
     * @throws \Exception
     * @param $subscriber
     * @return void
     */
    public function addLifecycleEventSubscriber($subscriber)
    {
        if(empty($this->entityManager))
            throw new \Exception('Please establish the entity manager connection using getEntityManager prior to adding event subscribers');
        $this->eventManager->addEventSubscriber($subscriber);
    }

    /**
     * Returns with the initialised entity manager
     * @throws
     * @return
     */
    public function getEntityManager()
    {
        // If we have an entity manager return it
        if(!empty($this->entityManager)) return $this->entityManager;

        // Register a new entity
        $this->eventManager = new \Doctrine\Common\EventManager();

        // TODO: Register Listeners
        $conn = array(
            'driver' => 'pdo_sqlite',
            'path' => $this->resource,
            'memory' => true
        );
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($this->paths, true);
        if (!$config->getMetadataDriverImpl()) {
            throw ORMException::missingMappingDriverImpl();
        }

        // Setup use of SQL Logger
        if(empty(self::$sqlLogger)) {
            self::$sqlLogger = new \Doctrine\DBAL\Logging\DebugStack();
        }

        $config->setResultCacheImpl(new \Doctrine\Common\Cache\MemcacheCache('localhost', '11211'));

        $config->setSQLLogger(self::$sqlLogger);
        $conn = \Doctrine\DBAL\DriverManager::getConnection($conn, $config, $this->eventManager);
        $this->entityManager = \Doctrine\ORM\EntityManager::create($conn, $config, $conn->getEventManager());
        return $this->entityManager;
    }

    /**
     * Drop the entity manager
     * @return void
     */
    public function dropEntityManager()
    {
        $this->entityManager = null;
    }

    /**
     * Drop the database file
     * @return void
     */
    public function dropDatabase()
    {
        if(trim($this->getResource()) && preg_match('/\.db$', $this->getResource())) {
            @unlink($this->getResource());
        }
        $this->dropEntityManager();
    }

    /**
     * @return string
     */
    public function getResource()
    {
        if(!empty($this->resources)) return __DIR__ . '/../Resources/test.db';
    }
}