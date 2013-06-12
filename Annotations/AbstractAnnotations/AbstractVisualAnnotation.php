<?php 
namespace Fredb\AdminBundle\Annotations\AbstractAnnotations;
use Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractAnnotation;
/** @Annotation */
Abstract class AbstractVisualAnnotation extends AbstractAnnotation
{

        abstract public function getTemplateName();        
        
}
