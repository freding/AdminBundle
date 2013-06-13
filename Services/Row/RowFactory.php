<?php

namespace Fredb\AdminBundle\Services\Row;

use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\HttpFoundation\Request;
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

        
	public function getRowClass($oAnnotation){
                $oRow = null;  
                if(get_class($oAnnotation) == "Fredb\AdminBundle\Annotations\ManageByBo"){
                    $class_row = $oAnnotation->getRowClass();
                    /** @var \Fredb\AdminBundle\Services\Row\ConcretRow\ClassRow\ManageByBoRow $oRow */
                    $oRow = new $class_row();
                    $oRow->setName($oAnnotation->user_name);
                    $oRow->setOrder($oAnnotation->order);
                    $oRow->setMother_node($oAnnotation->mother_node);
                    $oRow->setLang_class_namespace($oAnnotation->lang_class_namespace);
                    
                }else{
			throw new \Exception("Can not create RowClass from Annotation:".\Zend_Debug::dump($oAnnotation));
		}
 
		return $oRow;
        }
        
        
        

	public function getRowProperty(){
                $oRow = null;
		$aValueSubmited    = $request->get($propertie_name);
		$is_form_submited = ($request->getMethod() == 'POST');
                
                
		if($type == ""){
				
			$oRow = new ConcretRow\ColorRow();
			$oRow->setName($oAnnotation->name);
				
				
				
                }else{
			throw new \Exception("Can not create Row from type : ".$type);
		}
                
		return $oRow;
	}
	
	
	
			
			
	public function getRowLink(){
                $oRow = null;  
            
		return $oRow;
        }		
			
			
			
			
}

?>
