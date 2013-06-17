<?php


namespace Fredb\AdminBundle\Services\Row\AbstractRow;

/**
 *
 * @author fredericbourbigot
 */
abstract class RowAbstract{
	
    protected $name;
    protected $class_namespace;
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

        
    public function getType() {
        return get_class($this);
    }





    public function getClass_namespace() {
        return $this->class_namespace;
    }
    
    
    public function getUrlClass_namespace() {
         return urlencode($this->getClass_namespace());
    }   
    
    public function setClass_namespace($class_namespace) {
        $this->class_namespace = $class_namespace;
    }


    

}