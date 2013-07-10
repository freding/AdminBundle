<?php 
namespace Fredb\AdminBundle\Annotations\ConcretAnnotations\Property;
use Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractVisualAnnotation;

/** @Annotation 
 *  require user_name
 */
class Text extends AbstractVisualAnnotation
{


	public $length;
	public $default_value;
	public $require;
	public $disable;
        public $price_format;
  
    public function getRowClass() {
        return "Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow";
    }
    public function getType() {
        return self::TYPE_PROPERTY;
    }

    public function getTemplateName() {
        return "FredbAdminBundle:ViewLine:text.html.twig";
    }
    
    
    
    
    
    
    
}
