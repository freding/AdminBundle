<?php


namespace Fredb\AdminBundle\Services\Row\AbstractRow;

/**
 *
 * @author fredericbourbigot
 */
abstract class RowAbstract{
	
    protected $type;
    protected $annotation_namespace;
        
    
    
    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getAnnotation_namespace() {
        return $this->annotation_namespace;
    }

    public function setAnnotation_namespace($annotation_namespace) {
        $this->annotation_namespace = $annotation_namespace;
    }


}