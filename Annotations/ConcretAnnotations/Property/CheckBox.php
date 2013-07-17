<?php 
namespace Fredb\AdminBundle\Annotations\ConcretAnnotations\Property;
use Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractVisualAnnotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class CheckBox extends AbstractVisualAnnotation
{

    public $default_value;
        
        
    public function getRowClass() {
        return "Fredb\AdminBundle\Services\Row\ConcretRow\Property\CheckBoxRow";
    }

    public function getTemplateName() {
        return "FredbAdminBundle:ViewLine:checkbox.html.twig";
    }

    public function getType() { 
       return self::TYPE_PROPERTY;         
    }
    
    
    
    
    
    
    
}
