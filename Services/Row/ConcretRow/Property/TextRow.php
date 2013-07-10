<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\Property;

use Fredb\AdminBundle\Services\Row\AbstractRow\RowAbstractProperty;
use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity;
use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableLangEntity;

/**
 * @author fredericbourbigot
 */
class TextRow extends RowAbstractProperty {
    
    
    protected $length;
    protected $disable;
    
    
	public function __construct(){


	}
    
    
    public function getErrorMessages() {
        $status =  false;
        if($this->getIs_form_submited()){
                $aErrors = array();
                
                $value_field = "";
                if($this->is_langueable){
                    $aValues = $this->getValue();
                    $value_field = $aValues[$this->lang];
                }else{
                   $value_field = $this->getValue(); 
                }
                
                if($this->getIs_require() and strlen($value_field)<1 ){
                        $aErrors[] = self::ERROR_FILL_FIELD;
                }

                $status = $aErrors;
        }
        return $status;
    }
    
    public function prepareSave(AdministrableEntity &$oClass, AdministrableLangEntity $oEntityLang, \Doctrine\ORM\EntityManager $oEntityManager) {
        if($this->is_langueable){
            $reflClass = new \ReflectionClass($oEntityLang);
            $attribut = $reflClass->getProperty($this->getProperty_name());
            $attribut->setAccessible(true);
            $aValues = $this->getValue();
            $value_field = $aValues[$this->lang];
            $attribut->setValue($oEntityLang, $value_field);
            $oEntityLang->setId($oClass->getId());
            $oEntityLang->setLang($this->lang);
            $oEntityManager->persist($oEntityLang);
            $oEntityManager->flush();
            $oEntityManager->detach($oEntityLang);
        }else{
            $reflClass = new \ReflectionClass(get_class($oClass));
            $attribut = $reflClass->getProperty($this->getProperty_name());
            $attribut->setAccessible(true);
            $attribut->setValue($oClass, $this->getValue());
        }    
    }
    
    
    
    
    
    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function getDisable() {
        return $this->disable;
    }

    public function setDisable($disable) {
        $this->disable = $disable;
    }


    
    
    
    
}


