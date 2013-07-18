<?php
namespace Fredb\AdminBundle\Services\AdministrableEntity\FO;
use Doctrine\Common\Annotations\CachedReader;
use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity;
/**
 *
 * @author fredericbourbigot
 */
class LangService {
    
    const URL_FORMAT = "'/^[a-zA-Z\d-_]{2,50}$/'";
    
    /** @var \Doctrine\ORM\EntityManager $oEntityManager  */
    protected $_em; 
    /** @var Doctrine\Common\Annotations\CachedReader $oAnnotationReader   */
    private $oAnnotationReader; 
    /** @var Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity $oEntity   */
    private $oEntity = null; 
    
    
    private function isUrlRightFormat($name){
        if(   !preg_match('/^[a-zA-Z\d-_]{2,50}$/', $name)       )
            throw new \Exception("Wrong url format");
        return true;
    }
    
    public function __construct(\Doctrine\ORM\EntityManager $oEntityManager, CachedReader $oAnnotationReader){
        $this->_em                  = $oEntityManager;
        $this->oAnnotationReader    = $oAnnotationReader;
    }
    

    public function setEntity(AdministrableEntity $oEntity){
        $this->oEntity = $oEntity;
    }
    
    
    public function isEntitySet(){
        if($this->oEntity === null){
            return false;
        }else{
            return true;
        }
    }

    public function isEntitySetException(){
        if($this->isEntitySet() === false)
            throw new \Exception("Entity must be set and must implements \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity");  
    }
    
    
    
    public function getLangClass(AdministrableEntity $oEntity = null){
        if($oEntity == null){
            $oEntitySet = $this->oEntity;
        }else{
            $oEntitySet = $oEntity;
        }
        $reflClass          = new \ReflectionClass(get_class($oEntitySet));
        $annotation_type    = "Fredb\AdminBundle\Annotations\ConcretAnnotations\ClassRow\ManageByBo";
        $oAnnotationClass   = $this->oAnnotationReader->getClassAnnotation($reflClass, $annotation_type);
        $class_lang_name    = $oAnnotationClass->lang_class_namespace;
        $oClassLang         = new $class_lang_name(); 
        if(!($oClassLang instanceof \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableLangEntity))
            throw new \Exception($class_lang_name." is not instance of '\Fredb\AdminBundle\Services\AdministrableEntity\AdministrableLangEntity'"); 
        return $class_lang_name;
    }
    
    public function findEntityByUrlName($name_url, $field_name){
        $this->isEntitySetException();  
        $this->isUrlRightFormat($name_url);
        $oEntity = $this->_em->getRepository(get_class($this->oEntity))->findOneBy(array($field_name => $name_url));
        if(!$oEntity)
            throw new \Exception("Item not found");
        return $oEntity;
    }
    
    
    public function findEntityLangByUrlName($name_url, $field_name, $lang){
        $this->isEntitySetException();  
        $this->isUrlRightFormat($name_url);
        $name_lang_class = $this->getLangClass();
        $oEntityLang     = $this->_em->getRepository($name_lang_class)->findOneBy(array($field_name => $name_url, "lang" => $lang));
        if(!$oEntityLang){
            throw new \Exception("ItemLang not found");
        }else{
            $oEntity = $this->_em->getRepository(get_class($this->oEntity))->findOneById($oEntityLang->getId());
            if(!$oEntity)
                throw new \Exception("Item not found");
        }    
        return $oEntity;
    }
    
    
    public function getEntityLangForEntity(AdministrableEntity $oEntity, $lang){
        $Class_name_lang = $this->getLangClass($oEntity);
        $oEntity         = $this->_em->getRepository($Class_name_lang)->findOneBy(array("id"=>$oEntity->getId() , "lang"=>$lang));
        return $oEntity;
    }
    
    
    
    
    
    
    
    
    
    
    
    
}


