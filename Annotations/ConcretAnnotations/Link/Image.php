<?php 
namespace Fredb\AdminBundle\Annotations\ConcretAnnotations\Link;
/** @Annotation 
 *  require user_name
 */
class Image extends \Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractLinkAnnotation
{
    public $constant_format_pictures;
    public $tag;
    public $crop;
    public $id_fo_image;
    
    public function getRowClass() {
        return "Fredb\AdminBundle\Services\Row\ConcretRow\Link\ImageRow";
    }
    public function getType() {
        return self::TYPE_LINK;
    }

    public function getTemplateName() {
        return "FredbAdminBundle:ViewLine:image.html.twig";
    }    
    
}
