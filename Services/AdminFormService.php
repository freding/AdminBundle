<?php


namespace Fredb\AdminBundle\Services;
use Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractAnnotation;
use Doctrine\Common\Annotations\CachedReader;
/**
 *
 * @author fredericbourbigot
 */
class AdminFormService{
	
        /** @var \Doctrine\ORM\EntityManager $oEntityManager  */
        private $_em;
	/** @var Doctrine\Common\Annotations\CachedReader $oAnnotationReader   */
	private $oAnnotationReader; 	
        /** @var \Fredb\AdminBundle\Services\Row\RowFactory */
        private $oRowFactory;
        /** @var \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity $oAdministrableEntity */
	private $oClass = null;
	/** @ var array of  RowAbstractLink */
	private $aRowsLink = array();
	/** @ var array of  RowAbstractProperty */
	private $aRowsProperty = array(); 
        
        
	public function __construct(CachedReader $oAnnotationReader  , \Doctrine\ORM\EntityManager $oEntityManager, \Fredb\AdminBundle\Services\Row\RowFactory $oRowFactory){
		$this->_em		 = $oEntityManager;
		$this->oAnnotationReader = $oAnnotationReader;
                $this->oRowFactory       = $oRowFactory; 
                
		//$this->aLangsAvailable = $this->_em->getRepository("FredDatasBundle:Lang")->findBy(array("activated" => Zgroupe\ToolBox::ACTIVATED));
	}	
	
	
        public function setEntity(\Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity $oAdministrableEntity){
            $this->oClass = $oAdministrableEntity;
        }
        
	public function isEntitySet(){
            if($this->oClass === null){
                return false;
            }else{
                return true;
            }
        }
	
        public function isEntitySetException(){
            if($this->isEntitySet() === false)
                throw new \Exception("Entity must be set and must implements \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity");  
        }
        
        
        
	/**
	 * @return array of RowAbstractLink
	 */
	public function getRowLink(){
            $this->isEntitySetException(); 
            $aRows = array();
		
                
            return $aRows;
	}
        
        
        
	/**
	 * @return array of RowAbstractProperty
	 */
	public function getRowProperty(){
            $this->isEntitySetException(); 
            $aRows = array();
		
                
            return $aRows;
	}
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
	
	
	
}

