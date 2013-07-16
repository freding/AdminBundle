<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;

use Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;


/**
 * @author fredericbourbigot
 */
class TextToUrlRow extends TextRow {
    
    const ERROR_FIELD_ALREADY_EXIST		= "Field content already set";    
    
    /** @var \Doctrine\ORM\EntityManager $oEm  */
    private $oEm;
    private $oClass;
    protected $link_field_url;
    
    
    private function isNameExist($name){
        $return = false;

        try{
            $oItem  =$this->oEm->getRepository(get_class($this->oClass))->findBy(array($this->link_field_url=>$this->getUrlEncodeName($name)));
            if(count($oItem)>=1){

                
                
                $reflClass = new \ReflectionClass($this->oClass);
		$attribut = $reflClass->getProperty($this->link_field_url);
                $attribut->setAccessible(true);
		$attribut->getValue($this->oClass);
                if($attribut->getValue($this->oClass) != $this->getUrlEncodeName($name)){
                    $return = true;
                }
                    
            }    
        }  catch (\Exception $e){
            throw new \Exception("Field :'".$this->link_field_url."' don't exist in class : '".get_class($this->oClass)."'");
        }
        
      
        return $return;
    }
    
    private function getUrlEncodeName($name){
        return \Fredb\AdminBundle\Services\ToolBox::normaliza($name);
    }
 
    
    
    public function __construct(\Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractAnnotation $oAnnotation,\Doctrine\ORM\EntityManager $oEm, $oClass) {
         //if(!($oClass instanceof \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity)) 
         //    throw new \Exception("TextToUrl annotation must be set on AdministrableEntity field");
         parent::__construct($oAnnotation);
         $this->setLink_field_url($oAnnotation->link_field_url);
         $this->oEm     = $oEm;
         $this->oClass  = $oClass;
    }
       
    
    
    public function getErrorMessages() {
        $status = parent::getErrorMessages();
        
        if($this->isNameExist($this->getValue())){
           $aErrors[] = self::ERROR_FIELD_ALREADY_EXIST; 
           $status = $aErrors;
        }
        
        return $status;
    }
    
    
    
    public function getLink_field_url() {
        return $this->link_field_url;
    }

    public function setLink_field_url($link_field_url) {
        $this->link_field_url = $link_field_url;
    }


    public function prepareSave(&$oClass) {
        parent::prepareSave($oClass);
        $reflClass = new \ReflectionClass($oClass);
	$attribut = $reflClass->getProperty($this->link_field_url);
        $attribut->setAccessible(true);
	$attribut->setValue($this->oClass,$this->getUrlEncodeName($this->getValue()));
        
        
    }
    
}


