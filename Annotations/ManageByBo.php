<?php 
namespace Fredb\AdminBundle\Annotations;
use Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractNoVisualAnnotation;

/** @Annotation */
class ManageByBo extends AbstractNoVisualAnnotation
{

    public $order;
    public $mother_node;  
    public $lang_class_namespace;
    
  
    public function getRowClass() {
        return "";
    }
    public function getType() {
        return self::TYPE_CLASS;
    }
}
