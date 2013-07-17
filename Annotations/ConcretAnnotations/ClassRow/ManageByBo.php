<?php 
namespace Fredb\AdminBundle\Annotations\ConcretAnnotations\ClassRow;
use Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractNoVisualAnnotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class ManageByBo extends AbstractNoVisualAnnotation
{

    const MENU_ROW_KEY = "menu"; 
    
    public $order;
    public $mother_node;  
    public $lang_class_namespace;
    
  
    public function getRowClass() {
        return "Fredb\AdminBundle\Services\Row\ConcretRow\ClassRow\ManageByBoRow";
    }
    public function getType() {
        return self::TYPE_CLASS;
    }
}
