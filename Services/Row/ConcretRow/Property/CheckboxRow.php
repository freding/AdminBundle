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

    public function __construct(\Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractAnnotation $oAnnotation) {
        
    }	
    
    public function setRowValue($oAnnotation, $is_form_submited, $aValueSubmited, $mode_edition, $value_attribute, $lang_available, $lang){
        if($is_form_submited){
            if($lang_available){
                if(isset($aValueSubmited[$lang_available])){
                    $this->setValue($aValueSubmited[$lang_available]);
                } 
            }else{
                $this->setValue($aValueSubmited);
            } 
        }else{
            if($mode_edition == \Fredb\AdminBundle\Services\ToolBox::MODE_CREATE){
                $this->setValue($oAnnotation->default_value);
            }else{
                $this->setValue($value_attribute);
            }
        }  
    }
    
    
    
    
}

?>
