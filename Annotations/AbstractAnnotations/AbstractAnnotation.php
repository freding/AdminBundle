<?php 
namespace Fredb\AdminBundle\Annotations\AbstractAnnotations;
use Doctrine\Common\Annotations\Annotation;
/** @Annotation */
Abstract class AbstractAnnotation extends Annotation
{
	const TYPE_CLASS      = "class"; 
	const TYPE_PROPERTY   = "property";
        const TYPE_LINK       = "link";
	
	public $user_name;
        
        abstract public function getType();
        abstract public function getRowClass();
        
        
}
