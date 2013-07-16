<?php
namespace Fredb\AdminBundle\Services\AdministrableEntity\FO;
use Doctrine\Common\Annotations\CachedReader;
use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity;
/**
 *
 * @author fredericbourbigot
 */
class LinkService {
   
    /** @var \Doctrine\ORM\EntityManager $oEntityManager  */
    protected $_em;
    /** @var \Fredb\AdminBundle\Services\AdministrableEntity\EntityItemService $oEntityItemService */
    protected $oEntityItemService;  
    /** @var Doctrine\Common\Annotations\CachedReader $oAnnotationReader   */
    private $oAnnotationReader; 
        
    public function __construct(\Doctrine\ORM\EntityManager $oEntityManager, \Fredb\AdminBundle\Services\AdministrableEntity\EntityItemService $oEntityItemService, CachedReader $oAnnotationReader){
        $this->_em                  = $oEntityManager;
        $this->oEntityItemService   = $oEntityItemService;
        $this->oAnnotationReader    = $oAnnotationReader;
    }
    

    public function getAItemsForEntityAndProperty(AdministrableEntity $oEntity, $property_name){
        $oAnnotation        = $this->getAnnotationForEntityAndProperty($oEntity, $property_name);
        $class_item_linked  = $oAnnotation->class_item_linked;
        $aResults           = array();
	$oTypeLinked        = new $class_item_linked();
	$aTypeLinked        = $this->oEntityItemService->getItemsFromEntity($oTypeLinked, $oEntity);
        if(count($aTypeLinked)>0){
                return $aTypeLinked;
        }else{
                return $aResults;
        }
    }
    
    public function hasItemsForEntityAndProperty(AdministrableEntity $oEntity, $property_name){
        $aItems = $this->getAItemsForEntityAndProperty($oEntity, $property_name);
        if(count($aItems)>0){
            return true;
        }else{
            return false;
        }
    }

    public function getFirstItemForEntityAndProperty(AdministrableEntity $oEntity, $property_name){
        $aItems = $this->getAItemsForEntityAndProperty($oEntity, $property_name);
        if(isset($aItems[0])){
            return $aItems[0];
        }else{
            return null;
        }
    }
    
    
    private function getAnnotationForEntityAndProperty(AdministrableEntity $oEntity, $property_name){
        $return             = array();
        $reflClass          = new \ReflectionClass(get_class($oEntity));
        $oReflexionProperty = $reflClass->getProperty($property_name);     
        $aAnnotations       = $this->oAnnotationReader->getPropertyAnnotations($oReflexionProperty);
        if(count($aAnnotations)>0){
            $oAnnotation    = $aAnnotations[0];
        }    
        if(!$oAnnotation)
            throw new Exception("Annotation not found for class: ".get_class($oEntity).", property: ".$property_name);
        return $oAnnotation;
    }
    
    
    
    
}


