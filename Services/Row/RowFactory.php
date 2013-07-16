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
        /** @var \Fredb\AdminBundle\Services\AdministrableEntity\EntityItemService $oEntityItemService */
        protected $oEntityItemService;  


	public function __construct(\Doctrine\ORM\EntityManager $oEntityManager, \Fredb\AdminBundle\Services\AdministrableEntity\EntityItemService $oEntityItemService){
		$this->_em                  = $oEntityManager;
                $this->oEntityItemService   = $oEntityItemService;

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
        
        
        

	public function getRow(AbstractAnnotation $oAnnotation, $lang, $oClass, $property_name, $request, $mode_edition, $value_attribute, $lang_available = null){
		$aValueSubmited     = $request->get($property_name);
		$is_form_submited   = ($request->getMethod() == 'POST');
                $row_class          = $oAnnotation->getRowClass();
                if($row_class == "Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow\TextToUrlRow"){
                    $oRow               = new $row_class($oAnnotation, $this->_em, $oClass);
                }else if($row_class == "Fredb\AdminBundle\Services\Row\ConcretRow\Link\ListeRow"){    
                    $oRow               = new $row_class($oAnnotation, $this->_em, $this->oEntityItemService, $oClass);
                }else if($row_class == "Fredb\AdminBundle\Services\Row\ConcretRow\Link\ImageRow"){    
                    $oRow               = new $row_class($oAnnotation, $this->_em, $this->oEntityItemService, $oClass);
                }else{
                    $oRow               = new $row_class($oAnnotation);
                }    
                if($oRow instanceof AbstractRow\RowAbstractProperty)
                    $oRow->setRowValue($oAnnotation, $is_form_submited, $aValueSubmited, $mode_edition, $value_attribute, $lang_available, $lang);
                $id_class = $oClass->getId();               
                if(!empty($id_class) and ($oAnnotation instanceof \Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractLinkAnnotation)){
                    $oRow->setId($oClass->getId());
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
                $oRow->setMode_edition($mode_edition);
                $oRow->setIs_form_submited($is_form_submited);
                $oRow->setTemplate_name($oAnnotation->getTemplateName());
                $oRow->setProperty_name($property_name);
                $oRow->setUser_lang($lang);
                $oRow->setClass_namespace(get_class($oClass));
		return $oRow;
	}
	
	
	
			
	
			
			
			
			
}

?>
