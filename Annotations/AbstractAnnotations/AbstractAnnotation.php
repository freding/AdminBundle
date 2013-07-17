<?php 
namespace Fredb\AdminBundle\Annotations\AbstractAnnotations;
use Doctrine\Common\Annotations\Annotation;
/** @Annotation */
Abstract class AbstractAnnotation extends Annotation
{
    
    
	const TYPE_MANAGE_BY_BO         = "Fredb\AdminBundle\Annotations\ConcretAnnotations\ClassRow\ManageByBo";        
	static $aAnnotationsClass = array(
            self::TYPE_MANAGE_BY_BO
	);
    
        const TYPE_PROPERTY_TEXT        = "Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text";  
        const ANNOTATION_TEXT           = "text";  
        const TYPE_PROPERTY_CHECKBOX    = "Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\CheckBox";  
        const ANNOTATION_CHECKBOX       = "checkbox";   
	static $aAnnotationsProperty = array(
            self::ANNOTATION_TEXT       =>self::TYPE_PROPERTY_TEXT,
            self::ANNOTATION_CHECKBOX   =>self::TYPE_PROPERTY_CHECKBOX,   
	);
    
        
        const TYPE_LINK_IMAGE           = "Fredb\AdminBundle\Annotations\ConcretAnnotations\Link\Image";  
        const ANNOTATION_IMAGE          = "image";  
        const TYPE_LINK_LISTE           = "Fredb\AdminBundle\Annotations\ConcretAnnotations\Link\Liste";  
        const ANNOTATION_LISTE          = "liste";   
	static $aAnnotationsLink = array(
            self::ANNOTATION_IMAGE      =>self::TYPE_LINK_IMAGE,
            self::ANNOTATION_LISTE      =>self::TYPE_LINK_LISTE,   
	);        
    
	const TYPE_CLASS      = "class"; 
	const TYPE_PROPERTY   = "property";
        const TYPE_LINK       = "link";
	
	public $user_name;
        
        abstract public function getType();
        abstract public function getRowClass();
        
        
}
