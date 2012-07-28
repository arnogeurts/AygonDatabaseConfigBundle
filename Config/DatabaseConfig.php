<?php

namespace Aygon\DatabaseConfigBundle\Config;

use Aygon\DatabaseConfigBundle\Entity\Config;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Description of DatabaseConfig
 *
 * @author Arno Geurts
 */
class DatabaseConfig implements \IteratorAggregate
{
    /**
     * Cached config data
     * @var array
     */
    private $cache;
    
    /**
     * The Doctrine registry
     * @var Registry
     */
    private $doctrine;
    
    /**
     * Which entity manager to use
     * @var string 
     */
    private $entityManager;
    
    /**
     * Constructor
     * Inject the Doctrine registry
     * 
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine, $entityManager = null)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $entityManager;
    }
    
    /**
     * Get a parameter
     * 
     * @param string $key
     * @param string $default
     */
    public function get($key, $default = null)
    {
        $config = $this->getConfig();
        
        if ( ! array_key_exists($key, $config)) {
            return $default;
        }
        
        return $config[$key];
    }
    
    /**
     * Set a parameter in the config
     * 
     * @param string $key
     * @param string $value 
     */
    
    public function set($key, $value) 
    {
        $em = $this->getEntityManager();
        $repo = $em->getRepository('AygonDatabaseConfigBundle:Config');
        
        $config = $repo->findBy(array('name' => $key));
        if ($config === null) {
            throw new \Exception(sprintf('Config variable %s was not found', $key));
        }
        
        $config->setValue($value);
        $em->persist($config);
        $em->flush();
        $this->clearCache();
    }
    
    /**
     * Get the config variables
     * 
     * @return array 
     */
    private function getConfig()
    {
        if ($this->cache === null) {
            $repo = $this->getEntityManager()->getRepository('AygonDatabaseConfigBundle:Config');
            $data = $repo->findAll();
            
            $this->cache = array();
            foreach ($data as $config) {
                $this->cache[$config->getName()] = $config->getWorkingValue();
            }
        }
        
        return $this->cache;
    }
    
    /**
     * Clear the config cache
     * 
     * @return void 
     */
    private function clearCache()
    {
        $this->cache = null;
    }
    
    /**
     * Get the doctrine entity manager
     * 
     * @return EntityManager 
     */
    private function getEntityManager()
    {
        return $this->doctrine->getEntityManager($this->entityManager);
    }
    
    /**
     * Get the iterator to walk through the config
     * 
     * @return \Iterator 
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getConfig());
    }
}

?>
