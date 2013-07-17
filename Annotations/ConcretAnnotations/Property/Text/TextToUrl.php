<?php 
namespace Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class TextToUrl extends Text
{

    public $link_field_url;
  
    public function getRowClass() {
        return "Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow\TextToUrlRow";
    }


    public function getTemplateName() {
        return "FredbAdminBundle:ViewLine:text.html.twig";
    }
    
    
    
    
    
    
    
}
