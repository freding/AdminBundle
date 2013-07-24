<?php 
namespace Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Video extends Text
{


  
    public function getRowClass() {
        return "Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow\VideoRow";
    }


    public function getTemplateName() {
        return "FredbAdminBundle:ViewLine:video.html.twig";
    }
    
    
    
    
    
    
    
}
