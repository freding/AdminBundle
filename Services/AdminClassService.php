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
                $this->getRowClass();
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
            $this->aRowsClass = array();
            foreach($this->aEntityNamespaces as $entity_namespace){
                $reflectionClass  = new \ReflectionClass($entity_namespace);		
                foreach(AbstractAnnotation::$aAnnotationsClass as $annotation_type){
                    $oAnnotationClass = $this->oAnnotationReader->getClassAnnotation($reflectionClass, $annotation_type); 
                    if($oAnnotationClass){
                        $oRow = $this->oRowFactory->getRowClass($oAnnotationClass,$entity_namespace); 
                        $this->aRowsClass[$oRow->getClass_namespace()] = $oRow; 
                    }    
                }	
            }    
            
            //$this->sortRows();
            
            return $this->aRowsClass;
	}
	

        
        public function isClassNamespaceIsManageable($class_namespace){
            $find = false;
            foreach ($this->aRowsClass as $oClassRow){ 
                if($oClassRow->getClass_namespace() == $class_namespace)
                    return true;
            }
            return $find;
        }
        
        
        
        public function getLangClass($namespace_class){
            $namespace_lang = $this->aRowsClass[$namespace_class]->lang_class_namespace;
            if($namespace_lang){
                try{
                   $namespace_lang = new $namespace_lang();
                }  catch (Exception $e){
                    throw new \Exception("You cannot manage this entity lang");
                }
            }
            
            return $namespace_lang;
        }
        
        
        public function getLangClassNamespace($namespace_class){
            return $this->aRowsClass[$namespace_class]->lang_class_namespace; 
        }
        
        
        public function getEntityToManage($namespace_class){
            if($this->isClassNamespaceIsManageable($namespace_class) == true){
                return new $namespace_class();
            }
            throw new \Exception("You cannot manage this entity");
        }
        
        
        
        public function getEntityToManageByNamespaceAndId($namespace_class, $id){
            $oEntity = $this->_em->getRepository($namespace_class)->findOneById($id);
            if(!$oEntity)
                $oEntity = $this->getEntityToManage ($namespace_class);
            return $oEntity;
        }
        
        public function getaEntityLangToManageByNamespaceAndId($namespace_class, $id){
            $aEntityLang   = array();
            
            $namespace_lang = $this->getLangClassNamespace($namespace_class);
            if($namespace_lang == null)
                return $aEntityLang;
            foreach ($this->aLangsAvailable as $lang) {
                $oEntityLang = $this->_em->getRepository($namespace_lang)->findOneBy(array("id"=>$id,"lang"=>$lang));
                if($oEntityLang){
                   $aEntityLang[$lang]  = $oEntityLang; 
                }else{
                   $oEntityLangNew      = new $namespace_lang();
                   $oEntityLangNew->setLang($lang);
                   $aEntityLang[$lang]  = $oEntityLangNew;
                }
            }
            return $aEntityLang;
        }
        
        public function isEntitySortable($namespace_class){
            try{
                $oEntity = new $namespace_class();
                
                return ($oEntity instanceof \Fredb\AdminBundle\Services\AdministrableEntity\SortableEntity);
            }catch(\Exception $e){
                \Zend_Debug::dump($e); 
            }
            
            
            
        }
        
        public function getUserName($namespace_class, $lang){
 
           if(isset($this->aRowsClass[$namespace_class])){
               $aLang = $this->aRowsClass[$namespace_class]->getName();
               if(isset($aLang[$lang])){
                   return $aLang[$lang];
               }else{
                    throw new \Exception($lang." is not defined for this entity");           
               }
           }else{
               throw new \Exception("You cannot manage this entity");
           }
           
        }
	
	
	
}

