<?php


namespace Fredb\AdminBundle\Services\Row\AbstractRow;

/**
 *
 * @author fredericbourbigot
 */
abstract class RowAbstractLink extends RowAbstract{
	
    protected $name;
        
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

      

    abstract public function prepareSave();

}