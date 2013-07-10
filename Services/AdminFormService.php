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
        
        private $oClassLang = null;
        
	/** @ var array of  RowAbstractLink */
	private $aRowsLink = array();
	/** @ var array of  RowAbstractProperty */
	private $aRowsProperty = array(); 
        
        private $aLangs = array();
        
	public function __construct(CachedReader $oAnnotationReader  , \Doctrine\ORM\EntityManager $oEntityManager, \Fredb\AdminBundle\Services\Row\RowFactory $oRowFactory){
		$this->_em		 = $oEntityManager;
		$this->oAnnotationReader = $oAnnotationReader;
                $this->oRowFactory       = $oRowFactory; 
                
		//$this->aLangsAvailable = $this->_em->getRepository("FredDatasBundle:Lang")->findBy(array("activated" => Zgroupe\ToolBox::ACTIVATED));
	}	
	
	
        public function setEntity(\Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity $oAdministrableEntity){
            $this->oClass = $oAdministrableEntity;
        }
        
        public function setEntityLang(\Fredb\AdminBundle\Services\AdministrableEntity\AdministrableLangEntity $oEntityLang){
            $this->oClassLang = $oEntityLang;
        }
        
        public function setALangs($aLangs){
            $this->aLangs = $aLangs;
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
        
        
        private function getaAnnotationsContentForClass($oClass, $aListAnnotationAvailable){
            $aAnnotations = array();
            $reflClass = new \ReflectionClass(get_class($oClass));   
            $aProperties = $reflClass->getProperties();   
            foreach ($aProperties as $properties){ 		
                foreach($aListAnnotationAvailable as $annotation_type){
                    $propertieAnnotation = @$this->oAnnotationReader->getPropertyAnnotation($properties,$annotation_type); 
                    if($propertieAnnotation instanceof $annotation_type){
                        $aAnnotations[]= array("oAnnotation"=>$propertieAnnotation,"content"=>$properties);
                    }

                }	
            }     
                                
            return $aAnnotations;               
        }
        
        
        
	/**
	 * @return array of RowAbstractProperty
	 */
	public function getRowProperty($lang, $request, $mode_edition){
            $this->isEntitySetException(); 

            /** introspection Class  */
            $aAnnotationsForClass = $this->getaAnnotationsContentForClass($this->oClass, AbstractAnnotation::$aAnnotationsProperty);
            foreach ($aAnnotationsForClass as $annotationForClass) {
                $oAnnotation            = $annotationForClass["oAnnotation"];
                $oContentObject         = $annotationForClass["content"];
                $oContentObject->setAccessible(true);
		$value_attribute        = $oContentObject->getValue($this->oClass);
                $this->aRowsProperty[]  = $this->oRowFactory->getRowProperty($oAnnotation, $lang, $this->oClass, $oContentObject->name,$request,$mode_edition, $value_attribute);    
            }
            
            
            
            /** introspection ClassLang  */
            $aAnnotationsForClass = $this->getaAnnotationsContentForClass($this->oClassLang, AbstractAnnotation::$aAnnotationsProperty);

            foreach ($aAnnotationsForClass as $annotationForClass) {
                $oAnnotation            = $annotationForClass["oAnnotation"];
                $oContentObject         = $annotationForClass["content"];
                $oContentObject->setAccessible(true);
		$value_attribute        = $oContentObject->getValue($this->oClassLang);
                foreach($this->aLangs as $lang_available){
                    $this->aRowsProperty[]  = $this->oRowFactory->getRowProperty($oAnnotation, $lang, $this->oClassLang, $oContentObject->name,$request,$mode_edition, $value_attribute, $lang_available); 
                }    
            }
            
            
            return $this->aRowsProperty;
	}
        
        
        
 
        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
	/**
	 * @return array of RowAbstract
	 */
	public function checkErrorsForm(){
		if(count($this->aRowsProperty )<1)
			throw new \Exception("Rows must be set to be checked(please call getRows() )");
		
		foreach ($this->aRowsProperty as $oRow){
			/* @var $oRow RowAbstract */
			
			
		}
		
		
		return $this->aRowsProperty;
	}
	
	public function isFormErrorFree(){
		if(count($this->aRowsProperty )<1)
			throw new \Exception("Rows must be set to be checked(please call getRows() )");
		$is_form_error_free = true;
		foreach ($this->aRowsProperty as $oRow){
			/* @var $oRow RowAbstract */
			if($oRow->getErrorMessages()!=false)
				return false;
		}
		return $is_form_error_free;
	}
	
	
	public function save($mode_edition){

		if($mode_edition == ToolBox::MODE_CREATE){
                    $this->_em->persist($this->oClass);
                    $this->_em->flush();     
		}


                
                
		foreach ($this->aRowsProperty as $oRow)
			$oRow->prepareSave($this->oClass, $this->oClassLang, $this->_em);

		$this->oClass->setCreationDate();
		$this->_em->flush();
		return $this->oClass->getId();
	}
	
        
        
        
        
        
	
	
	
}

