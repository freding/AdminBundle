<?php

namespace Fredb\AdminBundle\Services\Row\ConcretRow\Property;

use Fredb\AdminBundle\Services\Row\AbstractRow\RowAbstractProperty;
use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity;
use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableLangEntity;

class CheckboxRow extends RowAbstractProperty{
	

    
    public function getErrorMessages() {
        return false;
    }

    public function prepareSave(AdministrableEntity &$oClass, AdministrableLangEntity $oEntityLang, \Doctrine\ORM\EntityManager $oEntityManager) {
	$reflClass = new \ReflectionClass(get_class($oClass));
	$attribut = $reflClass->getProperty($this->getProperty_name());
	$attribut->setAccessible(true);
	$attribut->setValue($oClass, $this->getValue());
    }	
    
    
    
    
    
    
}

?>
