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

	/** @var \Zgroupe\EntityItem\EntityItemService $oEntityItemService */
	protected $oEntityItemService;

	public function __construct(\Doctrine\ORM\EntityManager $oEntityManager,  \Zgroupe\EntityItem\EntityItemService $oEntityItemService){
		$this->_em			   = $oEntityManager;
		$this->oEntityItemService          = $oEntityItemService;
	}

        
	public function getRowClass(){
                $oRow = null;  
            
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
