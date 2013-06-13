<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\ClassRow;

use Fredb\AdminBundle\Services\Row\AbstractRow\RowAbstractClass;
/**
 * @author fredericbourbigot
 */
class ManageByBoRow extends RowAbstractClass {
    
    public $order;
    private $mother_node;  
    private $lang_class_namespace;
    
    
    public function getOrder() {
        return $this->order;
    }

    public function setOrder($order) {
        $this->order = $order;
    }

    public function getMother_node() {
        return $this->mother_node;
    }

    public function setMother_node($mother_node) {
        $this->mother_node = $mother_node;
    }

    public function getLang_class_namespace() {
        return $this->lang_class_namespace;
    }

    public function setLang_class_namespace($lang_class_namespace) {
        $this->lang_class_namespace = $lang_class_namespace;
    }

    
    
    
}

?>
