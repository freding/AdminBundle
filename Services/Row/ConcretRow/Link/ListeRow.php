<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\Link;

use Fredb\AdminBundle\Services\Row\AbstractRow\RowAbstractLink;
/**
 * @author fredericbourbigot
 */
class ListeRow extends RowAbstractLink {
    
    protected $class_item_linked;
    /** @var \Doctrine\ORM\EntityManager $oEm  */
    private $oEm;
    /** @var \Fredb\AdminBundle\Services\AdministrableEntity\EntityItemService $oEntityItemService */
    protected $oEntityItemService;    
    
    /** @var \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity $oClass */
    
    public function __construct(\Fredb\AdminBundle\Annotations\AbstractAnnotations\AbstractAnnotation $oAnnotation,\Doctrine\ORM\EntityManager $oEm, \Fredb\AdminBundle\Services\AdministrableEntity\EntityItemService $oEntityItemService, \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity $oClass) {
        $this->oEm                  =   $oEm;
        $this->setClass_item_linked($oAnnotation->class_item_linked);
        $this->oEntityItemService   = $oEntityItemService;
        $this->oClass               = $oClass;
    }	
    
    
    public function prepareSave(&$oClass) {
        
    }    
    
    public function getClass_item_linked() {
        return $this->class_item_linked;
    }

    public function getUrlClass_item_linked() {
         return urlencode($this->getClass_item_linked());
    }   
    
    
    public function setClass_item_linked($class_item_linked) {
        $this->class_item_linked = $class_item_linked;
    }

    
    
    
    
    
    
    
        public function getaItemToLink(){
            $aItemsAlreadyLinked = $this->getaItems();
            $type_class_linked   = $this->class_item_linked;        
            $aItems = $this->oEm->getRepository($type_class_linked)->findAll();
            foreach ($aItems as $key_item =>$oItem) {
                foreach ($aItemsAlreadyLinked as $oItemAlreadyLink) {
                    if($oItem->getId() == $oItemAlreadyLink->getId())
                        unset ($aItems[$key_item]);
                }
            }
            return $aItems;        
        }


        public function getaItems(){
            $type_class_linked = $this->class_item_linked;
            $oClassLinked = new $type_class_linked(); 
            return $this->oEntityItemService->getItemsFromEntity($oClassLinked, $this->oClass);
            
        }
    
    
    
    
    
    
    
    
    
    
    
    

    
}

?>
