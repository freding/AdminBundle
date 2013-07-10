<?php

namespace Fredb\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\Request;
use Fredb\AdminBundle\Services\ToolBox;

class ItemController extends Controller
{

	

    
    
    
	
    /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{_locale}/admin/{item_type}/list",name="admin_item_list", defaults={"_locale" = "fr"}, requirements={"_locale" = "en|fr|it"})
     * @Template()
     */
    public function listAction()
    {   
        //$oItem = $this->getDoctrine()->getRepository("AcmeDemoBundle:Test2")->findOneById(5);
        //$oEntityItemService = $this->get("entity_item_service");
        //$oEntityItemService->removeCompletlyEntity($oItem);
        
        
                $lang = $this->getRequest()->get("_locale");
		$entity_type_to_manage  = urldecode($this->getRequest()->get("item_type"));
                /* @var $oAdmin_class_service Fredb\AdminBundle\Services\AdminClassService  */
                $oAdmin_class_service   = $this->get("admin_class_service");
		$oModule                = $oAdmin_class_service->getEntityToManage($entity_type_to_manage);
                $is_list_sorteable      = $oAdmin_class_service->isEntitySortable($entity_type_to_manage);

		if($oModule){
                    $aSortable = array();
                    if($is_list_sorteable)
                        $aSortable = array("order" =>"asc");  
                    $aItems = $this->getDoctrine()->getRepository($entity_type_to_manage)->findBy(array(),$aSortable);

			return array(           "aItems"			=> $aItems, 
						"module_name"                   => $oAdmin_class_service->getUserName($entity_type_to_manage, $lang),
						"is_list_sorteable"		=> $is_list_sorteable,
						"lang"				=> $lang,
						"item_type"			=> $this->getRequest()->get("item_type")
					   );
		}else{
			throw $this->createNotFoundException('You cannot manage this entity');
		}
    
        return array();
    }	
	
	
    /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{_locale}/admin/{item_type}/create",name="admin_item_create", defaults={"_locale" = "fr"}, requirements={"_locale" = "en|fr|it"})
     * @Route("/{_locale}/admin/{item_type}/create/{id_item}",name="admin_item_modify", defaults={"_locale" = "fr"}, requirements={"_locale" = "en|fr|it"})
     * @Template()
     */
    public function createAction(Request $request)
    {   
		$lang = $this->getRequest()->get("_locale");
		$entity_type_to_manage  = urldecode($this->getRequest()->get("item_type"));
                /* @var $oAdmin_class_service Fredb\AdminBundle\Services\AdminClassService  */
                $oAdmin_class_service = $this->get("admin_class_service");
		$oItem                = $oAdmin_class_service->getEntityToManage($entity_type_to_manage);
                $oItemLang            = $oAdmin_class_service->getLangClass($entity_type_to_manage);
                $aLangsAvailable      = $oAdmin_class_service->getALangsAvailable();
                        
		if($oItem){
			$mode_edition ="";
			$id_item = $request->get("id_item");
                        
			if(isset($id_item)){
				$mode_edition = ToolBox::MODE_MODIFY;
				$oItem = $this->getDoctrine()->getRepository($entity_type_to_manage)->findOneById($id_item);
                                if($oItemLang){
                                    $oItemLangTest = $this->getDoctrine()->getRepository($oAdmin_class_service->getLangClassNamespace($entity_type_to_manage))->findOneById(array("id"=>$id_item,"lang"=>$lang));
                                    if($oItemLangTest)
                                        $oItemLang = $oItemLangTest;
                                }    
				if(!$oItem){
					$mode_edition = ToolBox::MODE_CREATE;
				}
			}else{
				$mode_edition = ToolBox::MODE_CREATE;
			}

			/* @var $oAdminFormService Zgroupe\AdminForm\AdminFormService */
			$oAdminFormService = $this->get("admin_form_service");
			$oAdminFormService->setEntity($oItem);                   
                        $oAdminFormService->setEntityLang($oItemLang);
                        $oAdminFormService->setALangs($aLangsAvailable);
			$aRowsProperty = $oAdminFormService->getRowProperty($lang,$request,$mode_edition);
              
			$aErrors = array();
			if ($request->getMethod() == 'POST'){
				$aRows = $oAdminFormService->checkErrorsForm();
				if($oAdminFormService->isFormErrorFree()){
					$id_item = $oAdminFormService->save($mode_edition);
					$this->get('session')->setFlash('update_ok', "Save Ok");
					return $this->redirect($this->generateUrl("admin_item_modify", array("item_type"=>$this->getRequest()->get("item_type"), "id_item"=>$id_item  )));
				}	
			}	

			return array("aRowsProperty" => $aRowsProperty, "mode"=> ToolBox::$aModes[$mode_edition], "Type" ,"update_status" =>"","module_name" =>$oAdmin_class_service->getUserName($entity_type_to_manage,$lang),	"item_type"			=> $entity_type_to_manage);
		}else{
			throw $this->createNotFoundException('You cannot manage this entity');
		}			
    }	
	
	
	
	
	
	
	
	
	
}
