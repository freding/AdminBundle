<?php
namespace Fredb\AdminBundle\Services\AdministrableEntity\FO;
use Doctrine\Common\Annotations\CachedReader;
use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity;
/**
 *
 * @author fredericbourbigot
 */
class PicturesService {
   
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
    
    
    public function getAPicturesForEntityAndProperty(AdministrableEntity $oEntity, $property_name){
        $aImage         = array();
        $aImageInfos    = $this->getAImageInfosForEntityAndProperty($oEntity, $property_name);
	$oPictureType   = new \Fredb\AdminBundle\Entity\Picture();		
        $aPictures = $this->oEntityItemService->getItemsFromEntity($oPictureType, $oEntity, $this->getAnnotationForEntityAndProperty($oEntity, $property_name)->tag);
        if(count($aPictures)>0){ 
            $oPicture = $aPictures[0];
            foreach ($this->getAImageInfosForEntityAndProperty($oEntity, $property_name) as $aImageInfos) {
                $path                   =  \Fredb\AdminBundle\Services\AdministrableEntity\EntityItemService::UPLOAD_DIRECTORY.$aImageInfos["folder"].$oPicture->getName();
                $aImageInfos["folder"]  = $path;
                $aImage[$aImageInfos["name"]] = $aImageInfos;
            }
        }	
        return $aImage;
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
    
    
    private function getAImageInfosForEntityAndProperty(AdministrableEntity $oEntity, $property_name){
        $oAnnotation    = $this->getAnnotationForEntityAndProperty($oEntity, $property_name);
        $image_infos    = $oAnnotation->constant_format_pictures;  
        $class_vars     = get_class_vars(get_class($oEntity));
        if(isset($class_vars[$image_infos])){
            return $class_vars[$image_infos];
        }else{
            throw new Exception("Array InfoImage not found in class : ".get_class($oEntity).", property: ".$property_name);
        }
        
    }
    
    
}


