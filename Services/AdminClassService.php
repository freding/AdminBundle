<?php


namespace Fredb\AdminBundle\Services;
use Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractAnnotation;
use Doctrine\Common\Annotations\CachedReader;
/**
 *
 * @author fredericbourbigot
 */
class AdminClassService{
	
        /** @var \Doctrine\ORM\EntityManager $oEntityManager  */
        private $_em;
	/** @var Doctrine\Common\Annotations\CachedReader $oAnnotationReader   */
	private $oAnnotationReader; 	
        /** @var \Fredb\AdminBundle\Services\Row\RowFactory */
        private $oRowFactory;
        /** @var \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity $oAdministrableEntity */
	private $aLangsAvailable;	
	/** @ var array of  RowAbstractClass */
	private $aRowsClass = array();
        
        private $aEntityNamespaces = array();
        
	public function __construct(CachedReader $oAnnotationReader  , \Doctrine\ORM\EntityManager $oEntityManager, \Fredb\AdminBundle\Services\Row\RowFactory $oRowFactory, $aLangs){
		$this->_em		 = $oEntityManager;
		$this->oAnnotationReader = $oAnnotationReader;
                $this->oRowFactory       = $oRowFactory; 
                $this->aLangsAvailable   = $aLangs;
                $this->aEntityNamespaces = $this->_em->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();
	}	
	
	
        public function getALangsAvailable() {
            return $this->aLangsAvailable;
        }

        
        private static function compareFieldsOrder($a, $b) {
        return strcmp($a->order, $b->order);
        }        
        
        private function sortRows(){
            usort($this->aRowsClass, array( $this ,'compareFieldsOrder')); 
        }
                
	/**
	 * @return array of RowAbstractClass
	 */
	public function getRowClass(){
   
            foreach($this->aEntityNamespaces as $entity_namespace){
                $reflectionClass  = new \ReflectionClass($entity_namespace);		
                foreach(AbstractAnnotation::$aAnnotationsClass as $annotation_type){
                    $oAnnotationClass = $this->oAnnotationReader->getClassAnnotation($reflectionClass, $annotation_type); 
                    if($oAnnotationClass)
                        $this->aRowsClass[] = $this->oRowFactory->getRowClass($oAnnotationClass); 			
                }	
            }    
            
            $this->sortRows();
            
            return $this->aRowsClass;
	}
	

        

        
        
        
        
        
        
        
        
        
	
	
	
}

