<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\Property;

use Fredb\AdminBundle\Services\Row\AbstractRow\RowAbstractProperty;


/**
 * @author fredericbourbigot
 */
class TextRow extends RowAbstractProperty {
    
    
    protected $length;
    protected $disable;
    
    
    public function __construct(\Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractAnnotation $oAnnotation) {
        $this->setLength($oAnnotation->length);
        $this->setDisable($oAnnotation->disable);
        $this->setIs_require($oAnnotation->require);
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
                    $this->setValue($oAnnotation->default_value[$lang]);
            }else{
                    $this->setValue($value_attribute);
            }
        } 
    }    
    
    public function getErrorMessages() {
        $status =  false;
        if($this->getIs_form_submited()){
                $aErrors = array();
                
                $value_field = "";
                if($this->is_langueable){
                    $aValues = $this->getValue();
                    if(isset($aValues[$this->lang]))
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
    
    public function prepareSave(&$oClass) {
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


