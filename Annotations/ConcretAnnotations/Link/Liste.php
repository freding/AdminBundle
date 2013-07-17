<?php 
namespace Fredb\AdminBundle\Annotations\ConcretAnnotations\Link;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Liste extends \Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractLinkAnnotation
{

    public $class_item_linked;

  
    public function getRowClass() {
        return "Fredb\AdminBundle\Services\Row\ConcretRow\Link\ListeRow";
    }
    public function getType() {
        return self::TYPE_LINK;
    }

    public function getTemplateName() {
        return "FredbAdminBundle:ViewLine:liste.html.twig";
    }
    
    
    
    
    
    
    
    
}
