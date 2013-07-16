<?php
namespace Fredb\AdminBundle\Services\AdministrableEntity;


/**
 * @todo revoir les functions d'upload de photo + recuperer list
 */
class EntityItemService{
	
	const ASSOC_TYPE_ITEMS_ENTITY 	        = 2;
	const ASSOC_TYPE_ENTITIES_ITEM          = 3;	

	
	const UPLOAD_DIRECTORY = "/upload/items/";
	const UPLOAD_DIRECTORY_FILE = "/upload/items/file/";
	
	
 	static public function getFrontDirectory(){
 		return $_SERVER ["DOCUMENT_ROOT"].self::UPLOAD_DIRECTORY;
 	}
	
 	static public function getFileDirectory(){
 		return $_SERVER ["DOCUMENT_ROOT"].self::UPLOAD_DIRECTORY_FILE;
 	}	
	
	
        /** @var \Doctrine\ORM\EntityManager $oEntityManager  */
        private $_em;

        /**  */
        public function __construct(\Doctrine\ORM\EntityManager $oEntityManager) {
            
            $this->_em = $oEntityManager;

        }

		
	

	public function addItemsToEntity(array $aItems, AdministrableEntity $oEntity,$tag=null)
	{
		$this->addXstoY($aItems,$oEntity,self::ASSOC_TYPE_ITEMS_ENTITY,$tag);	
	}
	
	
	public function addEntitiesToItem(array $aEntities, AdministrableEntity $oItem,$tag=null)
	{
		$this->addXstoY($aEntities,$oItem,self::ASSOC_TYPE_ENTITIES_ITEM,$tag);
	}
	
	public function getItemsFromEntity(AdministrableEntity $oItemForReturnType, AdministrableEntity $oEntityInDb, $tag=null,$number_result=null,$first_result=null){
        return $this->getXsfromY($oItemForReturnType,$oEntityInDb,self::ASSOC_TYPE_ITEMS_ENTITY,$tag, $number_result, $first_result);
	}
	
	public function getEntitiesFromItem(AdministrableEntity $oEntityForReturnType, AdministrableEntity $oItemInDb, $tag=null,$number_result=null,$first_result=null){
        return $this->getXsfromY($oEntityForReturnType,$oItemInDb,self::ASSOC_TYPE_ENTITIES_ITEM,$tag, $number_result, $first_result);	
	}
	
	public function sortExistingItemsByExistingEntity(array $aItemsToSort, AdministrableEntity $oEntityInDb){

		$order_id_index =1;
		foreach ($aItemsToSort as $oItem){ /* @var $oItem EntityItemInterface */
			if(!$oItem instanceof AdministrableEntity)
				throw new \Exception("Wrong Type");			
			$oJEntityItem = $this->_em->getRepository("FredbAdminBundle:JEntityItem")->findOneBy(array('idEntity' => $oEntityInDb->getId(), 'typeEntity' => $oEntityInDb->getTag(),'idItem' => $oItem->getId(), 'typeItem' => $oItem->getTag()));
			if(isset($oJEntityItem)){ /* @var $oJEntityItem JEntityItem */
				$oJEntityItem->setOrderId($order_id_index);
				$this->_em->flush();
				$order_id_index++;
			}
			
		}
		
	}	
	
	
	public function sortExistingEntitiesByExistingItem(array $aEntitiesToSort, AdministrableEntity $oItemInDb){
	
	
	
		$order_id_index =1;
		foreach ($aEntitiesToSort as $oEntitie){ /* @var $oEntitie EntityItemInterface */
			if(!$oEntitie instanceof EntityItemInterface)
				throw new \Exception("Wrong Type");			
			$oJEntityItem = $this->_em->getRepository("FredbAdminBundle:JEntityItem")->findOneBy(array('idEntity' => $oEntitie->getId(), 'typeEntity' => $oEntitie->getTag(),'idItem' => $oItemInDb->getId(), 'typeItem' => $oItemInDb->getTag()));
			if(isset($oJEntityItem)){ /* @var $oJEntityItem JEntityItem */
				$oJEntityItem->setOrderId($order_id_index);
				$this->_em->flush();
				$order_id_index++;
			}
			
		}
		
		
		
	}	
	
	public function removeRelationItemFromEntity(AdministrableEntity $oEntityInDb, AdministrableEntity $oItemInDb){
		$dql="DELETE FredbAdminBundle:JEntityItem j 
		WHERE j.idEntity = ".$oEntityInDb->getId()." and j.typeEntity = '".$oEntityInDb->getTag()."' 
		and j.idItem = ".$oItemInDb->getId()." and j.typeItem = '".$oItemInDb->getTag()."'";
		$query = $this->_em->createQuery($dql);
		$result = $query->execute();
		if($result>0){
			return true;
		}else{
			return false;
		}
	}
	
	
	public function removeCompletlyEntity(AdministrableEntity $oEntityInDb){
		$dql="DELETE FredbAdminBundle:JEntityItem j 
		WHERE (j.idEntity = ".$oEntityInDb->getId()." and j.typeEntity = '".$oEntityInDb->getTag()."')
		or (j.idItem = ".$oEntityInDb->getId()." and j.typeItem = '".$oEntityInDb->getTag()."')
		";
		$query = $this->_em->createQuery($dql);
		$result = $query->execute();

		if($oEntityInDb instanceof LangueableInterface){
			$sql = "DELETE from ".$oEntityInDb->getLangTable()." where ".$oEntityInDb->getLangFieldId()."=".$oEntityInDb->getId();
			$this->_em->getConnection()->exec($sql);
		}
		$this->_em->merge($oEntityInDb);
                $this->_em->remove($oEntityInDb);
                $this->_em->flush();

	}
	
	

	public function removeRelationItemTypeFromEntity(AdministrableEntity $oEntityInDb, $item_type,  $tag=null){
		if(!$item_type)
			throw new \Exception("Item type must be specify");
		$dql="DELETE FredbAdminBundle:JEntityItem j 
		WHERE j.idEntity = ".$oEntityInDb->getId()." and j.typeEntity = '".$oEntityInDb->getTag()."' 
		and j.typeItem = '".$item_type."'";
		if($tag)
			$dql .=" and j.tag='".$tag."'";
		$query = $this->_em->createQuery($dql);
		$result = $query->execute();
		if($result>0){
			return true;
		}else{
			return false;
		}
	}
	
	public function removeImageFromEntity(AdministrableEntity $oEntityInDb,  $tag){
		$dql="DELETE FredbAdminBundle:JEntityItem j 
		WHERE j.idEntity = ".$oEntityInDb->getId()." and j.typeEntity = '".$oEntityInDb->getTag()."' 
		and j.typeItem = '".\Fredb\AdminBundle\Entity\Picture::STR_TYPE_ENTITY."'
                and j.tag='".$tag."'    
                ";
		$query = $this->_em->createQuery($dql);
		$result = $query->execute();
		if($result>0){
			return true;
		}else{
			return false;
		}
        }

	/**
	 * @param EntityItemInterface $oXToReturn
	 * @param EntityItemInterface $oYInDb
	 * @return array
	 */
	private function getXsfromY($oXToReturn, $oYInDb, $type = self::ASSOC_TYPE_ITEMS_ENTITY, $tag=null,$number_result=null,$first_result=null){
            $oXToReturn_namespace   = get_class($oXToReturn);        
            $oYInDb_namespace       = get_class($oYInDb);
		if(!$this->isEntityStored($oYInDb)){
			throw new \Exception("instance must exist in DataBase");
		}
		$sql_tag_part ="";
		if($tag)
			$sql_tag_part = " and j.tag='".$tag."'"; 
		if($type == self::ASSOC_TYPE_ITEMS_ENTITY){
			$dql = "SELECT r FROM ".$oXToReturn_namespace." r, FredbAdminBundle:JEntityItem j , ".$oYInDb_namespace." e
			where e.id=j.idEntity 
			and r.id=j.idItem
			and j.typeEntity='".$oYInDb->getTag() ."' 
			and j.typeItem='".$oXToReturn->getTag()."'
			and e.id=".$oYInDb->getId()."
			".$sql_tag_part."	
			order by j.orderId
			"; 
		}elseif($type == self::ASSOC_TYPE_ENTITIES_ITEM){
			$dql = "SELECT e FROM ".$oXToReturn_namespace." e, FredbAdminBundle:JEntityItem j , ".$oYInDb_namespace." r
			where e.id=j.idEntity 
			and r.id=j.idItem
			and j.typeEntity='".$oXToReturn->getTag() ."' 
			and j.typeItem='".$oYInDb->getTag()."'
			and r.id=".$oYInDb->getId()."
			".$sql_tag_part."
			order by j.orderId
			"; 
		}else{
			throw new \Exception("type of Assoc does not exist");
		}	
		
		$query = $this->_em->createQuery($dql);
		if(isset($number_result)){
			$query->setMaxResults($number_result);
			if(isset($first_result)){
				$query->setFirstResult($first_result);
			}

		}			
		return $query->getResult();
	}
	
	
	
	
	/**
	 * @param array $aXs
	 * @param EntityItemInterface $o
	 * @return void
	 */
	private function addXstoY($aXs, $oY, $type = self::ASSOC_TYPE_ITEMS_ENTITY, $tag=null){
		if(!$this->isEntityStored($oY)){
			$this->_em->persist($oY);
			$this->_em->flush();
		}
		foreach ($aXs as $oX){
			if(!$oX instanceof AdministrableEntity)
				throw new \Exception("Wrong Type");
			if(!$this->isEntityStored($oX)){	
				$this->_em->persist($oX);	
				$this->_em->flush();
			}
			$oEntityItem = new \Fredb\AdminBundle\Entity\JEntityItem();
			if($type == self::ASSOC_TYPE_ITEMS_ENTITY){
				$oEntityItem->setIdEntity($oY->getId());
				$oEntityItem->setTypeEntity($oY->getTag());
				$oEntityItem->setIdItem($oX->getId());
				$oEntityItem->setTypeItem($oX->getTag());
			}elseif($type == self::ASSOC_TYPE_ENTITIES_ITEM){
				$oEntityItem->setIdEntity($oX->getId());
				$oEntityItem->setTypeEntity($oX->getTag());
				$oEntityItem->setIdItem($oY->getId());
				$oEntityItem->setTypeItem($oY->getTag());
			}	
			if($tag)
				$oEntityItem->setTag($tag);
			$this->_em->persist($oEntityItem);
			$this->_em->flush();
		}		
	}
	
	
	
	
	/**
	 * @param EntityItemInterface $entity
	 * @return boolean
	 */
	private function isEntityStored(AdministrableEntity $oEntity){
		$id = $oEntity->getId();
		if(empty($id)){
			return false;
		}else{
			return true;
		}	
	}
	
	
	
	
	
	
	
	
	
	
	public function addFileToEntity(AdministrableEntity $oEntity,		$input_name,$tag,$delete_item_already_linked = false){
	
		
		try{

		      $adapter = new \Zend_File_Transfer_Adapter_Http();
		      $adapter->addValidator('MimeType',false,array('application/pdf'),$input_name);
		      $ext ="";		
		      switch ($adapter->getMimeType($input_name)){
		      	case 'application/pdf':
		      		$ext ="pdf";
		      	break;
		      }  
	
		      if($adapter->isValid($input_name)){
				$name_md5 		= md5(time().$adapter->getFileName($input_name, false).$tag);
				$name_md5_ext 	= $name_md5.".".$ext;
				$url_picture_full	= self::getFileDirectory().$name_md5_ext;
				$adapter->addFilter('Rename', $url_picture_full);
				
				if($adapter->receive($input_name)){ 	
					$oFile = new \Fredb\AdminBundle\Entity\File;
					$oFile->setName($name_md5_ext);
					$oFile->setActive(\Zgroupe\ToolBox::ACTIVATED);
					$oFile->setCreationDate(time());
					$oFile->setOwnerId($oEntity->getId());
					$oFile->setOwnerKind($oEntity->getTag());					
					$this->_em->persist($oFile);
					$this->_em->flush();
					$oEntityMerge = $this->_em->merge($oEntity);
					if($delete_item_already_linked)
						$this->removeRelationItemTypeFromEntity($oEntityMerge, $oFile->getTag(),$tag);
					$this->addItemsToEntity(array($oFile), $oEntityMerge,$tag);
					
				}else{
					//$error_message = 'PRODUCT_ERROR_UPLOAD';echo $error_message;
				}
		      }
		}catch(\Exception $e){
                    //\Zend_Debug::dump($e);
			//$error_message = 'PRODUCT_ERROR_UPLOAD_FORMAT_PICTURE';echo $error_message;
		}
		
		
	}
	
	
	
	
	
	
	/**
	 * for linking picture to any Entity that implements EntityItemInterface
	 * - create array $aPicturesFormat as Static in Picture class. "folder" index must be set and folder create into EntityItemService::UPLOAD_DIRECTORY folder
	 * - have a look to Product->getThumb() for sample of picture retrive
	 * @param EntityItemService_EntityItem_Interface $oEntity		Picture will be attached to this $oEntity
	 * @param string $input_name							Name of input type="file"
	 * @param array $aPicturesFormat							Array format like => array(array("name"=>"" ,  "width"=>169	,	 "height"=>0		,	"folder"=>"exemple_folder/")); you can add as many format you want
	 * @param boolean $delete_item_already_linked				delete items before adding new
	 * @param boolean $crop
	 */
	
	public function addPicturesToEntity(AdministrableEntity $oEntity,		$input_name,		array $aPicturesFormat,		$delete_item_already_linked = false, $crop = false,$tag=false){

		try{

		      $adapter = new \Zend_File_Transfer_Adapter_Http();
		      $adapter->addValidator('MimeType',false,array('image/gif', 'image/jpeg', 'image/png' ),$input_name);
		      $ext ="";	
                      $file_name = $adapter->getFileName($input_name);
                      if(sizeof($file_name) == 0)
                          return false;
		      switch ($adapter->getMimeType($input_name)){
		      	case 'image/gif':
		      		$ext ="gif";
		      	break;
		      	case 'image/jpeg':
		      		$ext ="jpeg";
		      	break;
		      	case 'image/png':
		      		$ext ="png";
		      	break;	
		      }  
       
		      if($adapter->isValid($input_name)){
				$name_md5 		= md5(time().$adapter->getFileName($input_name, false).$tag);
				$name_md5_ext           = $name_md5.".".$ext;
                                $folder_full            = self::getFrontDirectory(). \Fredb\AdminBundle\Services\Row\ConcretRow\Link\ImageRow::$aFull["folder"];
                                $directory_exist        = $this->isFolderExist($folder_full);
                                if(!$directory_exist)
                                    $this->createFolder ($folder_full);
				$url_picture_full	= self::getFrontDirectory(). \Fredb\AdminBundle\Services\Row\ConcretRow\Link\ImageRow::$aFull["folder"].$name_md5_ext;
				$adapter->addFilter('Rename', $url_picture_full);
				
				if($adapter->receive($input_name)){ 
					foreach ($aPicturesFormat as  $aPictureFormat){
                                            $folder_image       = self::getFrontDirectory().$aPictureFormat["folder"];
                                            $folder_image_exist = $this->isFolderExist($folder_image);
                                            if(!$folder_image_exist)
                                                $this->createFolder ($folder_image);
						if($crop){
                                                    \Fredb\AdminBundle\Services\ToolBox::cropImage($url_picture_full, $folder_image.$name_md5_ext, $aPictureFormat["width"], $aPictureFormat["height"]);
						}else{				
                                                    \Fredb\AdminBundle\Services\ToolBox::resizeImage($url_picture_full, $folder_image.$name_md5_ext, $aPictureFormat["width"], $aPictureFormat["height"]);
						}
					}
                                 
					$oPicture = new \Fredb\AdminBundle\Entity\Picture();     
					$oPicture->setName($name_md5_ext);  
					$oPicture->setActive(\Fredb\AdminBundle\Services\ToolBox::ACTIVATED);
					//$oPicture->setCreationDate(\time());
					//$oPicture->setOwnerId($oEntity->getId());echo "fefefz1";die();
					//$oPicture->setOwnerKind($oEntity->getTag());
                                        
                                        $this->_em->persist($oPicture);  
					$this->_em->flush();
    
					$oEntityMerge = $this->_em->merge($oEntity);
					if($delete_item_already_linked)
						$this->removeRelationItemTypeFromEntity($oEntityMerge, $oPicture->getType(),$tag);
					$this->addItemsToEntity(array($oPicture), $oEntityMerge,$tag);
					
				}else{
					//$error_message = 'PRODUCT_ERROR_UPLOAD';echo $error_message;
				}
		      }
		}catch(\Exception $e){
                    \Zend_Debug::dump($e->getMessage());die();
			//$error_message = 'PRODUCT_ERROR_UPLOAD_FORMAT_PICTURE';echo $error_message;
		}	
	} 	
	
	
	
	public function isFolderExist($folder_path){
            return is_dir($folder_path);
        }
	
	public function createFolder($folder_path){
            mkdir($folder_path, 0777, true);
        }
	
	
	public function getFirstEntityLinkedToItem(AdministrableEntity $oItem){
		$dql = "SELECT j FROM FredbAdminBundle:JEntityItem j
		where j.idItem='".$oItem->getId() ."' 
		and j.typeItem='".$oItem->getTag()."'

		";
		
		try{ 
			 $query = $this->_em->createQuery($dql);
			 $query->setMaxResults(1);
			 $results = $query->getResult();

			 if(isset($results[0])){
				 $result = $results[0];
				 $oEntity = $this->_em->getRepository($result->getTypeEntity())->findOneById( $result->getIdEntity()  );
				 return $oEntity;
			 }else{
				 return "";
			 }	 
		}catch(\Exception $e){return "";}	
	}
	
	
	
	
	
}