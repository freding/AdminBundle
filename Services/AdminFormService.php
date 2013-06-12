<?php


namespace Fredb\AdminBundle\Services;

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
		
        /** @var \Zgroupe\EntityItem\EntityItemService $oEntityItemService */
        private $oEntityItemService;
        
        /** @var \Zgroupe\EntityItem\EntityItemService $oEntityItemService */
	private $oClass;
	
	private $aLangsAvailable;
		
	/** @ var array of  RowAbstract*/
	private $aRows = array();
	
	public function __construct(CachedReader $oAnnotationReader  , \Doctrine\ORM\EntityManager $oEntityManager){
		$this->_em		 = $oEntityManager;
		$this->oAnnotationReader = $oAnnotationReader;
		//$this->aLangsAvailable = $this->_em->getRepository("FredDatasBundle:Lang")->findBy(array("activated" => Zgroupe\ToolBox::ACTIVATED));
	}	
	
	
	
	
	/**
	 * @return array of RowAbstract
	 */
	public function getRows(){
                $aRows = array();
		
                
                
                
                
                
                
                
                
                
                
                
                
                
                
		return $aRows;
	}
	

	
	
	
}

