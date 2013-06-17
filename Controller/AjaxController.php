<?php

namespace Fredb\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\Response;


class AjaxController extends Controller
{
	
    /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/admin/ajax/sortcompletelist",name="sort_complete_list")
     */
    public function sortcompetelistAction()
    {        
        
		$class_name = $this->getRequest()->get("class_name");
		$ids_ranking = $this->getRequest()->get("ids_ranking");
		$ids_record   =$this->getRequest()->get("ids_record");
                $aRankings   = explode("_",$ids_ranking);
                $aRecords     = explode("_",$ids_record);
        

                foreach ($aRecords as $key => $id_record){
                        $oItem = $this->getDoctrine()->getRepository($class_name)->findOneById($id_record); 
                        $oItem->setOrder($aRankings[$key]);
                        $this->getDoctrine()->getEntityManager()->flush();
                }	
				

        
        return new Response('');
    }	
	
	

	
    /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/admin/ajax/deleteitemfromfulllist",name="delete_item_from_full_list")
     */
    public function deleteitemfromfulllistAction()
    {        
		$id_item = $this->getRequest()->get("id_item");
		$class_name = $this->getRequest()->get("class_name");
		$oItem = $this->getDoctrine()->getRepository($class_name)->findOneById($id_item);
		if($oItem){
			/* @var $oEntityItemService \Zgroupe\EntityItem\EntityItemService */
			$oEntityItemService = $this->get("entity_item_service");
			$oEntityItemService->removeCompletlyEntity($oItem);
		}		
	return new Response('');
    }	
	
	
    
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/admin/ajax/addlinkitemtolist",name="add_link_item_to_list")
     */
    public function addlinkitemtolistAction()
    {        
		$curent_lang		= $this->get('session')->getLocale();
		$aDatas			= json_decode($this->getRequest()->get("datas"));
		$id_item_to_link	= $this->getRequest()->get("id_item");
		$oEntity			= $this->getDoctrine()->getRepository($aDatas->class_entity)->findOneById($aDatas->id_entity);
		$oItem			= $this->getDoctrine()->getRepository($aDatas->class_item)->findOneById($id_item_to_link);	
		if($oEntity and $oItem){
			/* @var $oEntityItemService \Zgroupe\EntityItem\EntityItemService */
			$oEntityItemService = $this->get("entity_item_service");
			$oEntityItemService->addItemsToEntity(array($oItem), $oEntity);
		}
		try{
			if($oItem instanceof \Fred\DatasBundle\Entity\Video and ($oEntity instanceof \Fred\DatasBundle\Entity\Channel or $oEntity instanceof \Fred\DatasBundle\Entity\Hightlight)){
				$oSiteName		= $this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:Style")->findOneById(\Fred\DatasBundle\Entity\Style::ID_TITLE_PROJECT);
				//Alert mail
				$aAlerts = $this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:Alert")->findBy(  array( "type" => $oEntity->getType(), "num" => $oEntity->getId()   ));
				foreach ($aAlerts as $oAlert){
					$string_view =$this->renderView("FredFoBundle:Mail:newvideo.html.twig", array("oEntity" =>$oEntity, "oItem"=>$oItem, "url"=>$oItem->getUrlItem($oAlert->getLang(),$oEntity,"",true),"lang"=>$oAlert->getLang()));
					$oMail = new \Zend_Mail("UTF-8");
					$oMail->setSubject($this->get('translator')->trans("A new video is available",array(),'messages',$oAlert->getLang()));
					$oMail->setFrom($oSiteName->getDesc(), $this->get('translator')->trans("A new video is available",array(),'messages',$oAlert->getLang()));
					$oMail->addTo($oAlert->getMail());
					$oMail->setBodyHtml($string_view);
					$oMail->send();
				}

				//update status twitter
					        $oStyleTwitterToken		= $this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:Style")->findOneById(\Fred\DatasBundle\Entity\Style::ID_TWITTER_TOKEN);
						$oStyleTwitterPass			= $this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:Style")->findOneById(\Fred\DatasBundle\Entity\Style::ID_TWITTER_PASS);
					        $oStyleTwitterConsumer		= $this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:Style")->findOneById(\Fred\DatasBundle\Entity\Style::ID_TWITTER_CONSUMER);
						$oStyleTwitterConsumerPass	= $this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:Style")->findOneById(\Fred\DatasBundle\Entity\Style::ID_TWITTER_CONSUMER_PASS);
						$pass = $oStyleTwitterPass->getDesc();
						if(!empty($pass)){
							$token = new \Zend_Oauth_Token_Access();
							$token->setToken($oStyleTwitterToken->getDesc())->setTokenSecret($oStyleTwitterPass->getDesc());
							$options = array(
							'accessToken'    => $token,
							'consumerKey'    => $oStyleTwitterConsumer->getDesc(),
							'consumerSecret' => $oStyleTwitterConsumerPass->getDesc());
							$twitter    = new \Zend_Service_Twitter($options);
							$twitter->account->verifyCredentials();
							$url = \Zgroupe\ToolBox::makeTinyURL($oItem->getUrlItem($curent_lang,$oEntity,"",true));
							$twitter->status->update('A new video is available on '.$oSiteName->getDesc().' : '.$url);
						}			
			}
		}catch(Exception $e){ echo "error Alerts";}	
        return new Response('');
    }	
	    
	
	
	
     /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/admin/ajax/sortlist",name="sort_list")
     */
    public function sortlistAction()
    {        
		$aDatas			= json_decode($this->getRequest()->get("datas"));	
		$oEntity			= $this->getDoctrine()->getRepository($aDatas->class_entity)->findOneById($aDatas->id_entity);
		$item_class		= $aDatas->class_item;
		$ids_ranking		= $this->getRequest()->get("ids_ranking") ;
		$ids_record		= $this->getRequest()->get("ids_record") ;
                $aRankings      = explode("_",$ids_ranking);
                $aRecords       = explode("_",$ids_record);
				
		if($oEntity){
			/* @var $oEntityItemService \Zgroupe\EntityItem\EntityItemService */
			$oEntityItemService = $this->get("entity_item_service");
				$aItemsToSort = array();
				foreach ($aRecords as $id_records){
					$oItem = $this->getDoctrine()->getRepository($item_class)->findOneById($id_records);
					if($oItem)
						$aItemsToSort[] = $oItem;
				}
				$oEntityItemService->sortExistingItemsByExistingEntity($aItemsToSort, $oEntity);
		}
        return new Response('');
    }	
	
	
     /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/admin/ajax/detachitemfromlist",name="detach_item_from_list")
     */
    public function detachitemfromlistAction()
    {        
		$aDatas = json_decode($this->getRequest()->get("datas"));
		$oEntity =$this->getDoctrine()->getRepository($aDatas->class_entity)->findOneById($aDatas->id_entity);
		$oItem   =$this->getDoctrine()->getRepository($aDatas->class_item)->findOneById($aDatas->id_item);
		if($oEntity and $oItem){
			/* @var $oEntityItemService \Zgroupe\EntityItem\EntityItemService */
			$oEntityItemService = $this->get("entity_item_service");
			$oEntityItemService->removeRelationItemFromEntity($oEntity, $oItem);
		}
        return new Response('');
    }		
	
	
	
	
	
	
	
     /**
     * @Route("/ajax/uploadtempvideoadmin",name="upload_temp_video_admin")
     */
	public function uploadtempvideoadminAction(){

		try{
					//if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
					//	echo "fo";
					//}	
				$user_session_id = $this->getRequest()->get("PHPSESSID");
				$oAddMedia = $this->getDoctrine()->getRepository("FredDatasBundle:AddMedia")->findOneBy(array("userId"=>  $user_session_id,"type"=>  \Fred\DatasBundle\Entity\AddMedia::TYPE_VIDEO));

				if($oAddMedia){
					$this->getDoctrine()->getEntityManager()->remove ($oAddMedia);
					$this->getDoctrine()->getEntityManager()->flush();
				}

				$oAddMedia = new \Fred\DatasBundle\Entity\AddMedia();
				$oAddMedia->setUserId($user_session_id);
				$AUTH_EXT = array( ".mov", ".avi",".mpg",".mp4",".flv") ;
				$extension = strrchr($_FILES['Filedata']['name'], ".") ;

				if(in_array($extension,$AUTH_EXT)){ 		
					$md5_name = md5($user_session_id.$_FILES['Filedata']['name'].time()).$extension;
					$md5_name_flv = md5($user_session_id.$_FILES['Filedata']['name'].time()).".mp4";
					$folder_real_size		=  __DIR__.'/../File/';
					$tempFile 			= $_FILES['Filedata']['tmp_name'];					
					$targetFile_real_size =  str_replace('//','/',$folder_real_size) . $md5_name;		
					$ok = move_uploaded_file($tempFile,$targetFile_real_size);
					$oAddMedia->setType(\Fred\DatasBundle\Entity\AddMedia::TYPE_VIDEO);		
					$oAddMedia->setName($_FILES['Filedata']['name']);
					$oAddMedia->setRealName(\Fred\DatasBundle\Entity\Video::VIDEO_YAKAST_BASE_URL.date("Y",time())."/".date("m",time())."/".$md5_name_flv);
					$oAddMedia->setMd5Name($md5_name);
					$oAddMedia->setMd5NameFlv($md5_name_flv);
					$this->getDoctrine()->getEntityManager()->persist($oAddMedia);
					$this->getDoctrine()->getEntityManager()->flush();
					
					echo "".$_FILES['Filedata']['name'];
					
				}else{
					echo "<div style='color:#E6A901;'>".$this->get('translator')->trans('Format(.mov, .avi,.mpg,.mp4,.flv)')."</div>";
				}
			
		}catch (Exception $e){
			echo $e->getMessage();
			
		}		
		return new Response('');
		
	}	
	

	
	
     /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/admin/ajax/getlistblockforpage",name="admin_get_list_block_for_page")
     * @Template
     */
    public function getlistblockforpageAction()
    {         $lang			= $this->get('session')->getLocale();
		$page = $this->getRequest()->get("page");
		$aBlocksPositionLeft   = $this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:BlockManager")->getBlockPlace($page,Block::POSITION_LEFT);
		$aBlocksPositionRight = $this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:BlockManager")->getBlockPlace($page,Block::POSITION_RIGHT);
		
		$aBlockAddeable	=	$this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:Block")->findAll();
		
                return array('page'=>$page, 'aBlocksPositionLeft' => $aBlocksPositionLeft, 'aBlocksPositionRight'=>$aBlocksPositionRight,"aBlockAddeable" => $aBlockAddeable ,"lang"=>$lang);
    }	
	
	
	
     /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/admin/ajax/addblock",name="admin_add_block")
     */
    public function addblockAction()
    {         $lang	    = $this->get('session')->getLocale();
              $page         = $this->getRequest()->get("page");
              $position     = $this->getRequest()->get("position");
              $block_id     = $this->getRequest()->get("block_id");
              
              $aBlockManager = $this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:BlockManager")->findBy(array("pagename"=>$page,"horizontal"=>$position,"blockid"=>$block_id));
              if(count($aBlockManager)==0){
                  $oBlockManager = new \Fred\DatasBundle\Entity\BlockManager();
                  $oBlockManager->setBlockid($block_id);
                  $oBlockManager->setDeleteable(\Fred\DatasBundle\Entity\BlockManager::IS_REMOVEABLE_BLOCK);
                  $oBlockManager->setHorizontal($position);
                  $oBlockManager->setOriginal(\Fred\DatasBundle\Entity\BlockManager::ORIGINAL_POSITION_BLOCK_DELETEABLE);
                  $oBlockManager->setPagename($page);
                  $this->getDoctrine()->getEntityManager()->persist($oBlockManager);
                  $this->getDoctrine()->getEntityManager()->flush();
              }
              
              
              return new Response('');
    }	
	
	
	
	
	
     /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/admin/ajax/romoveblock",name="admin_remove_block")
     */
    public function removeblockAction()
    {         $lang	    = $this->get('session')->getLocale();
              $page         = $this->getRequest()->get("page");
              $aDatas       = json_decode($this->getRequest()->get("aDatas"));  //$aDatas->id_block     $aDatas->position

              $oBlockManager =$this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:BlockManager")->findOneBy(array("pagename"=>$page,"horizontal"=>$aDatas->position,"blockid"=>$aDatas->id_block,"deleteable"=>  \Fred\DatasBundle\Entity\BlockManager::IS_REMOVEABLE_BLOCK ));
              
              if($oBlockManager){
                  $this->getDoctrine()->getEntityManager()->remove ($oBlockManager);
                  $this->getDoctrine()->getEntityManager()->flush();
              }
              
       return new Response('');
    }	
	
	
    
        /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/admin/ajax/sortblock",name="admin_ajax_sort_block")
     */
    public function sortblockAction()
    {         $lang	    = $this->get('session')->getLocale();
              $page         = $this->getRequest()->get("page");
              $position     = $this->getRequest()->get("position");
              $aIdsRecord   = explode("_", $this->getRequest()->get("ids_record"));
              $i=1;
              foreach ($aIdsRecord as $id){
                  $oBlockManager =$this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:BlockManager")->findOneById($id);
                  $oBlockManager->setOrder($i);
                  $this->getDoctrine()->getEntityManager()->flush();
                  $i++;
              }

       return new Response('');
    }	    
    
    
    
	
	
	
     /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/admin/ajax/addpage",name="admin_ajax_add_page")
     */
    public function addpageAction()
    {        
	 $lang			= $this->get('session')->getLocale();
	 $aResultsNameRub	= $this->getRequest()->get('aResultsNameRub');
	 $parent_id		= $this->getRequest()->get('parent_id');
	 $aLangs			= $this->getDoctrine()->getRepository("FredDatasBundle:Lang")->findBy(array("activated" => \Zgroupe\ToolBox::ACTIVATED));
	 
	  $aResultsUrlRub		= array();
	  $aResultsUrlRubExist	= array();
	  $message_error		= "";
	  foreach ($aLangs as $oLang){
		  if(empty($aResultsNameRub[$oLang->getSname()])){
			echo $this->get("translator")->trans("Name cannot be empty");die();	  
		  }
		  $aResultsUrlRub[$oLang->getSname()] = \Zgroupe\ToolBox::normaliza( $aResultsNameRub[$oLang->getSname()] );
		  if($this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:Composite")->isUrlNameExist($aResultsUrlRub[$oLang->getSname()], $oLang->getSname())){
			  $aResultsUrlRubExist[$oLang->getSname()] = true;
			  
			  $message_error .= $this->get("translator")->trans("Name already exist")." (".$oLang->getSname().")<br>";
		  }else{
			  $aResultsUrlRubExist[$oLang->getSname()] = false;
		  } 
		  
	  }
	  if(\strlen($message_error)>0){
		  echo $message_error;die();
	  }

	 
	 $oComposite = new \Fred\DatasBundle\Entity\Composite();
	 $oComposite->setActive(\Fred\DatasBundle\Entity\Composite::IS_ACTIVE);
	 $oComposite->setCreationDate(\time());
	 $this->getDoctrine()->getEntityManager()->persist($oComposite);
	 $this->getDoctrine()->getEntityManager()->flush();
	 if($parent_id == \Fred\DatasBundle\Entity\Composite::NO_PARENTS){
		 $oComposite->setIs_root(\Fred\DatasBundle\Entity\Composite::IS_ROOT_COMPOSITE);
	 }else{
		$oComposite->setIs_root(\Fred\DatasBundle\Entity\Composite::IS_NOT_ROOT_COMPOSITE); 
		
		$oCompositeFather = $this->getDoctrine()->getEntityManager()->getRepository("FredDatasBundle:Composite")->findOneById($parent_id);
		if($oCompositeFather){
			$oPagesService = $this->get("pages_service");
			$oPagesService->addChildCompositeForFatherComposite($oComposite, $oCompositeFather);
		}else{
			$this->getDoctrine()->getEntityManager()->remove($oComposite);
			$this->getDoctrine()->getEntityManager()->flush();
			die();
		}
	 }

	 $oComposite->setLink_enable(\Fred\DatasBundle\Entity\Composite::HAS_LINK_COMPOSITE);
	 $this->getDoctrine()->getEntityManager()->flush();
	 
	 foreach ($aLangs as $oLang){
		 $oCompositeLang = new \Fred\DatasBundle\Entity\CompositeLang();
		 $oCompositeLang->setId($oComposite->getId());
		 $oCompositeLang->setLang($oLang->getSname());
		 $oCompositeLang->setName($aResultsNameRub[$oLang->getSname()]);
		 $oCompositeLang->setNameUrl($aResultsUrlRub[$oLang->getSname()]);
		 $this->getDoctrine()->getEntityManager()->persist($oCompositeLang);
		 $this->getDoctrine()->getEntityManager()->flush();		 
	 }	  
		  
       return new Response('');
    }	    
    	
	
	
	
	
	
	
	
	
     /**
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/admin/ajax/deletepage",name="admin_ajax_delete_page")
     */
    public function deletepageAction()
    {  	
	 $lang			= $this->get('session')->getLocale();
	 $composite_id		= $this->getRequest()->get('composite_id');
	 $oComposite		= $this->getDoctrine()->getRepository("FredDatasBundle:Composite")->findOneById($composite_id);
	 if($oComposite){
		 $oPagesService = $this->get("pages_service");
		 $oPagesService->deleteComposite($oComposite);
	 }
		 
	 
       return new Response('');
    }
    
    
	
	
	
	
	
	
}
