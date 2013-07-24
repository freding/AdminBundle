<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;

use Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;


/**
 * @author fredericbourbigot
 */
class VideoRow extends TextRow {
    
    const TYPE_FICHIER      = 1;
    const TYPE_PERMALIEN    = 2;  
    const FIELD_SEPARATOR   = "----l----";
    
    
    public function __construct(\Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractAnnotation $oAnnotation) {
         parent::__construct($oAnnotation);

    }
        
    public function getErrorMessages() {
        $status =  false;
        if($this->getIs_form_submited()){
            $aValues = $this->getValue();
            if( !empty($aValues[self::TYPE_FICHIER]) and !empty($aValues[self::TYPE_PERMALIEN]) ){
                $status = array("Only one field must be set");
            }else if( empty($aValues[self::TYPE_FICHIER]) and empty($aValues[self::TYPE_PERMALIEN]) ){
                if($this->getIs_require() == true)
                    $status = array(\Fredb\AdminBundle\Services\Row\AbstractRow\RowAbstractProperty::ERROR_FILL_FIELD);                
            }
              
        }

        return $status;
    }
        

    private function getaVideoInfo($name){
        $aResults = array(self::TYPE_FICHIER => "", self::TYPE_PERMALIEN => "");
        $aInfos = explode(self::FIELD_SEPARATOR, $name);   
        if(isset($aInfos[1])){
            if($aInfos[1] == self::TYPE_FICHIER){
                $aResults[self::TYPE_FICHIER] = $aInfos[0];
            }elseif ($aInfos[1] == self::TYPE_PERMALIEN) {
                $aResults[self::TYPE_PERMALIEN] = $aInfos[0];  
            }
        }
        return $aResults;
    }
    
    public function setRowValue($oAnnotation, $is_form_submited, $aValueSubmited, $mode_edition, $value_attribute, $lang_available, $lang){
        if($is_form_submited){
            $this->setValue($aValueSubmited);
        }else{
 
            $this->setValue($this->getaVideoInfo($value_attribute));
        }   
    }
    
    
    public function prepareSave(&$oClass) {
        $aValues    = $this->getValue();
        $link_store = "";
        if(!empty($aValues[self::TYPE_PERMALIEN])){
            $link_store = $aValues[self::TYPE_PERMALIEN].self::FIELD_SEPARATOR.self::TYPE_PERMALIEN;
        }else{
            $link_store = $aValues[self::TYPE_FICHIER].self::FIELD_SEPARATOR.self::TYPE_FICHIER;
        }
            
        $reflClass = new \ReflectionClass(get_class($oClass));
        $attribut = $reflClass->getProperty($this->getProperty_name());
        $attribut->setAccessible(true); 
        $attribut->setValue($oClass, $link_store);

    }
    
    
    
}


