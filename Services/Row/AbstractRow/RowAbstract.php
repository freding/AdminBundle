<?php


namespace Fredb\AdminBundle\Services\Row\AbstractRow;

/**
 *
 * @author fredericbourbigot
 */
abstract class RowAbstract{
	
    protected $name;
    
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

        
    public function getType() {
        return get_class($this);
    }

    public function getUrlType() {
        return urlencode($this->getType());
    }



}