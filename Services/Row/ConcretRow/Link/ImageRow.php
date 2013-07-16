<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\Link;

use Fredb\AdminBundle\Services\Row\AbstractRow\RowAbstractLink;
/**
 * @author fredericbourbigot
 */
class ImageRow extends RowAbstractLink {
    
    protected $constant_format_pictures;
    protected $tag;
    protected $crop;
    protected $id_fo_image;
    
    /** @var \Doctrine\ORM\EntityManager $oEm  */
    private $oEm;
    /** @var \Fredb\AdminBundle\Services\AdministrableEntity\EntityItemService $oEntityItemService */
    protected $oEntityItemService;    
    protected $oClass;
    protected $aFormat;
    const FULL_SIZE = "full";
    static $aFull   = array("name"=>self::FULL_SIZE	,"folder"=>"full/");
 
    
    public function __construct(\Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractAnnotation $oAnnotation, \Doctrine\ORM\EntityManager $oEm, \Fredb\AdminBundle\Services\AdministrableEntity\EntityItemService $oEntityItemService, \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity $oClass) {
        $this->setConstant_format_pictures($oAnnotation->constant_format_pictures);
        $this->setCrop($oAnnotation->crop);
        $this->setId_fo_image($oAnnotation->id_fo_image);
        $this->setTag($oAnnotation->tag);
        $this->oEntityItemService   = $oEntityItemService;
        $this->oClass               = $oClass;
        $format                     = $this->constant_format_pictures;
        $classname                  = get_class($this->oClass);
        $this->aFormat              = $classname::$$format;
        $this->oEm                  =   $oEm;
    }    
    
    
    public function getFormatLib(){
        $format = "";
        $i       = $this->getId_fo_image();
        $format  = $this->aFormat[$i]["width"]."*".$this->aFormat[$i]["height"];        
        return $format;
    }
    
    public function isImageSet(){
        $return                 = false;
        $oPictureType		= new \Fredb\AdminBundle\Entity\Picture;
        $id_current_entity	= $this->getId();
        if(!empty($id_current_entity)){
            $oCurrentEntity = $this->oEm->getRepository($this->getClass_namespace())->findOneById($this->getId());
            try{ 		
                $aPictures = $this->oEntityItemService->getItemsFromEntity($oPictureType, $oCurrentEntity,$this->getTag());	
                if(count($aPictures)>0)
                    $return = true;
            }catch (\Exception $e){}
        }
        return $return;
    }
    
    public function getImgAtIndex($index = 0){
        $oPictureType		= new \Fredb\AdminBundle\Entity\Picture;
        $id_current_entity	= $this->getId();

        $return = "<img src='";
        if(!empty($id_current_entity)){
                $oCurrentEntity = $this->oEm->getRepository($this->getClass_namespace())->findOneById($this->getId());
                try{ 		
                        $aPictures = $this->oEntityItemService->getItemsFromEntity($oPictureType, $oCurrentEntity,$this->getTag());	
                        if(count($aPictures)>0){ 
                                $oPicture = $aPictures[0];
                                $return .=\Fredb\AdminBundle\Services\AdministrableEntity\EntityItemService::UPLOAD_DIRECTORY.  $this->aFormat[$index]["folder"].$oPicture->getName();
                        }else{
                                $return .="/image/no_item.png";
                        }	
                }catch (\Exception $e){			
                        $return .="/image/no_item.png";
                }
        }else{
                $return .="/image/no_item.png";
        }
        if($this->aFormat[$index]['height'] == 0){
                $return .="' width='".$this->aFormat[$index]['width']."'>";
        }else{
                $return .="' height='".$this->aFormat[$index]['height']."' width='".$this->aFormat[$index]['width']."'>";
        }	
        return $return;
    }
    
    public function prepareSave(&$oClass) {
	$this->oEntityItemService->addPicturesToEntity($oClass,	$this->getTag(), $this->aFormat, true, $this->getCrop(), $this->getTag());
    }  
    
    public function getConstant_format_pictures() {
        return $this->constant_format_pictures;
    }

    public function setConstant_format_pictures($constant_format_pictures) {
        $this->constant_format_pictures = $constant_format_pictures;
    }

    public function getTag() {
        return $this->tag;
    }

    public function setTag($tag) {
        $this->tag = $tag;
    }

    public function getCrop() {
        return $this->crop;
    }

    public function setCrop($crop) {
        $this->crop = $crop;
    }

    public function getId_fo_image() {
        return $this->id_fo_image;
    }

    public function setId_fo_image($id_fo_image) {
        $this->id_fo_image = $id_fo_image;
    }


    
    
}

