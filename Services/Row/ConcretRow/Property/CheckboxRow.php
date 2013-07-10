<?php

namespace Fredb\AdminBundle\Services\Row\ConcretRow\Property;

use Fredb\AdminBundle\Services\Row\AbstractRow\RowAbstractProperty;

class CheckboxRow extends RowAbstractProperty{
	

    
    public function getErrorMessages() {
        return false;
    }

    public function prepareSave(&$oClass) {
        $reflClass = new \ReflectionClass(get_class($oClass));
        $attribut = $reflClass->getProperty($this->getProperty_name());
        $attribut->setAccessible(true);   
        
        if($this->is_langueable){
            $aValues = $this->getValue();
            if(isset($aValues[$this->lang])){
                $value_field = $aValues[$this->lang]; 
            }else{
               $value_field = \Fredb\AdminBundle\Services\ToolBox::ACTIVATED_NOT;
            }

            $attribut->setValue($oClass, $value_field);
        }else{
            $attribut->setValue($oClass, $this->getValue());
        } 
    }	
    
    
    
    
    
    
}

?>
