<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;

use Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;
use Fredb\AdminBundle\Services\ToolBox;

/**
 * @author fredericbourbigot
 */
class DateRow extends TextRow {
    
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
                    $this->setValue($oAnnotation->default_value[$lang]);
            }else{
                if(!empty($value_attribute))
                    $this->setValue(ToolBox::TimestampToPickerTime($value_attribute));
            }
        } 
    }  

    public function prepareSave(&$oClass) {
        $reflClass = new \ReflectionClass(get_class($oClass));
        $attribut = $reflClass->getProperty($this->getProperty_name());
        $attribut->setAccessible(true);   
        $value = $this->getValue();
        if(!empty($value)){
            $attribut->setValue($oClass, ToolBox::PickerTimeToTimestamp($this->getValue()));
        }else{
            $attribut->setValue($oClass, "");
        }    
    }
    
    
    
    

    
    
    
    
    
    
    
    
    
}


