<?php

namespace Fredb\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\Request;
use Zgroupe\ToolBox;

class ItemController extends Controller
{

	
	
    /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{_locale}/admin/{item_type}/list",name="admin_item_list", defaults={"_locale" = "fr"}, requirements={"_locale" = "en|fr|it"})
     * @Template()
     */
    public function listAction()
    {   
        
        //ToolBox::cropImage("/image/zgroupe_header.png", "/image/test.png", 20, 20);
        
		$entity_type_to_manage = ucfirst($this->getRequest()->get("item_type"));
		$oModule = $this->getDoctrine()->getRepository("FredDatasBundle:Module")->findOneBy( array("class_name"=>$entity_type_to_manage) );
		$repos_name			=  "FredDatasBundle:".$entity_type_to_manage;
		$class_name			=  "Fred\DatasBundle\Entity\\".$entity_type_to_manage;
		if($oModule){
                    
                    
                        $aDesigners = "";
                        $selectedDesignerId = "none";
                        if($entity_type_to_manage == "Product"){
                            $aDesigners = $this->getDoctrine()->getRepository("FredDatasBundle:Designer")->findAll();
                            
                            $id_designer = $this->getRequest()->get("id_designer");
                            if(!empty($id_designer) and ($id_designer != "none")){
                                $oDesigner          = $this->getDoctrine()->getRepository("FredDatasBundle:Designer")->findOneById($id_designer);
                                $oProductType       = new \Fred\DatasBundle\Entity\Product();
                                $oEntityItemService = \Fred\DatasBundle\FredDatasBundle::getContainer()->get("entity_item_service");
                                $aItems             = $oEntityItemService->getEntitiesFromItem($oProductType, $oDesigner);
                                $selectedDesignerId = $id_designer;
                            }else{
                                $aItems = $this->getDoctrine()->getRepository($repos_name)->findBy(array(),array("order" =>"asc"));
                            }   
                            
                            
                        }else{
                            $aItems = $this->getDoctrine()->getRepository($repos_name)->findBy(array(),array("order" =>"asc"));
                        }
                    
                    
			
			// Check annotations on class
			/* @var $oZgroupeAnnotationsService Zgroupe\Annotations\Services\AnnotationsServices */
			$oZgroupeAnnotationsService = $this->get("annotations_zgroupe_service");
			$oZgroupeAnnotationsService->setClass($class_name);
			$is_list_sorteable		= $oZgroupeAnnotationsService->isAnnotationEnable("Zgroupe\Annotations\AllListSorteableClass");
			$is_item_list_deleteable  = $oZgroupeAnnotationsService->isAnnotationEnable("Zgroupe\Annotations\AllListDeleteableClass");
			
			$lang = "fr";
			

                        
                        
			return array(           "aItems"			=> $aItems, 
						"module_name"                   =>$oModule->getEnglishName(),
						"is_list_sorteable"		=> $is_list_sorteable,
						"is_item_list_deleteable"       => $is_item_list_deleteable,
						"lang"				=> $lang,
						"item_type"			=> $this->getRequest()->get("item_type"),
						"entity_to_manage"              => $class_name,
                                                "aDesigners"                    => $aDesigners,
                                                "selectedDesignerId"            => $selectedDesignerId
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
		$entity_type_to_manage = ucfirst($this->getRequest()->get("item_type"));
		$oModule = $this->getDoctrine()->getRepository("FredDatasBundle:Module")->findOneBy( array("class_name"=>$entity_type_to_manage) );
		$repos_name			=  "FredDatasBundle:".$entity_type_to_manage;
		$class_name			=  "Fred\DatasBundle\Entity\\".$entity_type_to_manage;
                
                $current_language = "fr";
		if($oModule){
			$mode_edition ="";
			$id_item = $request->get("id_item");
			if(isset($id_item)){
				$mode_edition = ToolBox::MODE_MODIFY;
				$oItem = $this->getDoctrine()->getRepository($repos_name)->findOneById($id_item);
				if(!$oItem){
					$mode_edition = ToolBox::MODE_CREATE;
					$oItem = new $class_name();
				}
			}else{
				$mode_edition = ToolBox::MODE_CREATE;
				$oItem = new $class_name();
			}

			/* @var $oAdminFormService Zgroupe\AdminForm\AdminFormService */
			$oAdminFormService = $this->get("admin_form_service");
			$oAdminFormService->setClassForForm($oItem);
			$aRows = $oAdminFormService->getRows($request,$mode_edition,$current_language);
			$aErrors = array();
			if ($request->getMethod() == 'POST'){
				$aRows = $oAdminFormService->checkErrorsForm();
				if($oAdminFormService->isFormErrorFree()){
					$id_item = $oAdminFormService->save($mode_edition);
					$this->get('session')->setFlash('update_ok', "Save Ok");
					return $this->redirect($this->generateUrl("admin_item_modify", array("item_type"=>$this->getRequest()->get("item_type"), "id_item"=>$id_item  )));
				}	
			}	

					return array("aRows" => $aRows, "mode"=> ToolBox::$aModes[$mode_edition], "Type" ,"update_status" =>"","module_name" =>$oModule->getEnglishName(),	"item_type"			=> $this->getRequest()->get("item_type"));
		}else{
			throw $this->createNotFoundException('You cannot manage this entity');
		}			
    }	
	
	
	
	
	
	
	
	
	
}
