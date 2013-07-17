<?php 
namespace Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Date extends Text
{


  
    public function getRowClass() {
        return "Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow\DateRow";
    }


    public function getTemplateName() {
        return "FredbAdminBundle:ViewLine:date.html.twig";
    }
    
    
    
    
    
    
    
}
