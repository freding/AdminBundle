<?php 
namespace Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class LongText extends Text
{

	public $height;
        public $rich;
  
    public function getRowClass() {
        return "Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow\LongTextRow";
    }


    public function getTemplateName() {
        return "FredbAdminBundle:ViewLine:long_text.html.twig";
    }
    
    
    
    
    
    
    
}
