<?php 
namespace Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Price extends Text
{


  
    public function getRowClass() {
        return "Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow\PriceRow";
    }


    public function getTemplateName() {
        return "FredbAdminBundle:ViewLine:text.html.twig";
    }
    
    
    
    
    
    
    
}
