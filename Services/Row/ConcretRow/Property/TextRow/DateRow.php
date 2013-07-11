<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;

use Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;
use Fredb\AdminBundle\Services\ToolBox;

/**
 * @author fredericbourbigot
 */
class DateRow extends TextRow {
    

    public function prepareSave(&$oClass) {
        $reflClass = new \ReflectionClass(get_class($oClass));
        $attribut = $reflClass->getProperty($this->getProperty_name());
        $attribut->setAccessible(true);   
        
        if($this->is_langueable){
            $aValues = $this->getValue();
            $value_field = $aValues[$this->lang];
            $attribut->setValue($oClass, ToolBox::PickerTimeToTimestamp($value_field));
        }else{
            $attribut->setValue($oClass, ToolBox::PickerTimeToTimestamp($this->getValue()));
        }    
    }
    
}


