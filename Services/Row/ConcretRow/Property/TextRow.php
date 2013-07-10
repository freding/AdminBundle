<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\Property;

use Fredb\AdminBundle\Services\Row\AbstractRow\RowAbstractProperty;
use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity;

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
                if($this->getIs_require() and strlen($this->getValue())<1 ){
                        $aErrors[] = self::ERROR_FILL_FIELD;
                }

                $status = $aErrors;
        }
        return $status;
    }
    
    public function prepareSave(AdministrableEntity &$oClass) {

	$reflClass = new \ReflectionClass(get_class($oClass));
	$attribut = $reflClass->getProperty($this->getProperty_name());
	$attribut->setAccessible(true);
	$attribut->setValue($oClass, $this->getValue());

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


