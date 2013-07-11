<?php

namespace Fredb\AdminBundle\Services\Row;

use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\HttpFoundation\Request;
use Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractAnnotation;
use Fredb\AdminBundle\Services\Row\ConcretRow\Property;
use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableLangEntity;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\Text;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\Property\CheckBox;
/**
 *
 * @author fredericbourbigot
 */
class RowFactory {

	/** @var \Doctrine\ORM\EntityManager $oEntityManager  */
	protected $_em;



	public function __construct(\Doctrine\ORM\EntityManager $oEntityManager){
		$this->_em			   = $oEntityManager;

	}

        
	public function getRowClass($oAnnotation,$entity_namespace){
                $oRow = null;  
                if(get_class($oAnnotation) == "Fredb\AdminBundle\Annotations\ConcretAnnotations\ClassRow\ManageByBo"){
                    $class_row = $oAnnotation->getRowClass();
                    /** @var \Fredb\AdminBundle\Services\Row\ConcretRow\ClassRow\ManageByBoRow $oRow */
                    $oRow = new $class_row();
                    $oRow->setName($oAnnotation->user_name);
                    $oRow->setOrder($oAnnotation->order);
                    $oRow->setMother_node($oAnnotation->mother_node);
                    $oRow->setLang_class_namespace($oAnnotation->lang_class_namespace);
                    $oRow->setClass_namespace($entity_namespace);
                    
                }else{
			throw new \Exception("Can not create RowClass from Annotation:".\Zend_Debug::dump($oAnnotation));
		}
 
		return $oRow;
        }
        
        
        

	public function getRowProperty(AbstractAnnotation $oAnnotation, $lang, $oClass, $property_name, $request, $mode_edition, $value_attribute, $lang_available = null){
                $oRow               = null;
		$aValueSubmited     = $request->get($property_name);
		$is_form_submited   = ($request->getMethod() == 'POST');
                $row_class          =$oAnnotation->getRowClass();  
                $oRow               = new $row_class();
		if($oAnnotation instanceof Text){
                    if($oAnnotation instanceof Text\LongText){
                        $oRow->setHeight($oAnnotation->height);
                        $oRow->setRich($oAnnotation->rich);
                    }else if($oAnnotation instanceof Text\Date){    

                    }else if($oAnnotation instanceof Text\Color){    

                    }
                    $oRow->setLength($oAnnotation->length);
                    $oRow->setDisable($oAnnotation->disable);
                    $oRow->setIs_require($oAnnotation->require);
        

                    
                    if($is_form_submited){
                        if($lang_available){
                            if(isset($aValueSubmited[$lang])){
                                $oRow->setValue($aValueSubmited[$lang]);
                            } 
                        }else{
                            $oRow->setValue($aValueSubmited);
                        }    
                    }else{
                        if($mode_edition == \Fredb\AdminBundle\Services\ToolBox::MODE_CREATE){
                                $oRow->setValue($oAnnotation->default_value[$lang]);
                        }else{
                           
                                $oRow->setValue($value_attribute);
                        }
                    }
                    
                    
                    
                }else if($oAnnotation instanceof CheckBox){   
                    $oRow = new Property\CheckBoxRow();
                    
                    if($is_form_submited){
                        if($lang_available){
                            if(isset($aValueSubmited[$lang])){
                                $oRow->setValue($aValueSubmited[$lang]);
                            } 
                        }else{
                            $oRow->setValue($aValueSubmited);
                        } 
                    }else{
			if($mode_edition == \Fredb\AdminBundle\Services\ToolBox::MODE_CREATE){
                            $oRow->setValue($oAnnotation->default_value);
			}else{
                            $oRow->setValue($value_attribute);
			}
                    } 
                    
                }else{
                    throw new \Exception("Can not create Row from annotation : ".get_class($oAnnotation));
		}
                
                if(isset($oAnnotation->user_name[$lang])){
                    $oRow->setName($oAnnotation->user_name[$lang]);
                }else{
                    
                    throw new \Exception("'user_name' is not defined in
                                          - Class : '".  get_class($oClass)."'
                                          - Property :'".$property_name."'                         

                                          - Lang :'".$lang."'
                                          - Annotation type: '".get_class($oAnnotation)."'   
                                        ");    
                }
                
                if($oClass instanceof AdministrableLangEntity){
                    $oRow->setIs_langueable(true);
                    $oRow->setLang($lang_available);
                }
                
                $oRow->setIs_form_submited($is_form_submited);
                $oRow->setTemplate_name($oAnnotation->getTemplateName());
                $oRow->setProperty_name($property_name);
                
                
		return $oRow;
	}
	
	
	
			
			
	public function getRowLink(){
                $oRow = null;  
            
		return $oRow;
        }		
			
			
			
			
}

?>
