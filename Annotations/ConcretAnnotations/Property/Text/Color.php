<?php 
namespace Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Color extends Text
{


  
    public function getRowClass() {
        return "Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow\ColorRow";
    }


    public function getTemplateName() {
        return "FredbAdminBundle:ViewLine:color.html.twig";
    }
    
    
    
    
    
    
    
}
