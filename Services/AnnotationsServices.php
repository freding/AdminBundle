<?php

namespace Fredb\Services;

use Doctrine\Common\Annotations\CachedReader;
/**
 *
 * @author fredericbourbigot
 */
class AnnotationsServices {
	
	private $oClass;
	
	/** @var Doctrine\Common\Annotations\CachedReader $oAnnotationReader   */
	private $oAnnotationReader; 		
	
	public function __construct(CachedReader $oAnnotationReader){
		$this->oAnnotationReader = $oAnnotationReader;
	}
	
	
	
	public function setClass($oClass){
		$this->oClass = $oClass;
		
	}
	
	public function isAnnotationEnable($Annotation_name){
		if(!$this->oClass)
			throw new \Exception("Class must be set to be check");
		$reflClass			= new \ReflectionClass($this->oClass);   
		$classAnnotations	= @$this->oAnnotationReader->getClassAnnotation($reflClass, $Annotation_name);
		if($classAnnotations instanceof $Annotation_name){ 	
			return true;
		}else{
			return false;
		}
		
	}
	
	
	
	
}

?>
