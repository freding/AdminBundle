<?php

namespace Fredb\AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Fredb\AdminBundle\Entity\JEntityItem
 *
 * @ORM\Table(name="JNT_entity_item")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Fredb\AdminBundle\Repository\JEntityItemRepository")
 */
class JEntityItem {


    /**
     * @var integer $idEntity
     * @ORM\Id 
     * @ORM\Column(name="ENTITY_id",type="integer")
     */
    protected $idEntity;
	

     /**
     * @var string $typeEntity
     * @ORM\Id 
     * @ORM\Column(name="ENTITY_type",type="string")
     */
    protected $typeEntity;   
    
    
    
     /**
     * @var integer $idItem
     * @ORM\Id  
     * @ORM\Column(name="LINKED_ITEM_id",type="integer")
     */
    protected $idItem;
	

     /**
     * @var string $typeItem
     * @ORM\Id 
     * @ORM\Column(name="LINKED_ITEM_type",type="string")
     */
    protected $typeItem;     
    
   
    
    /**
     * @var integer $orderId
     * @ORM\Column(name="ENTITY_ITEM_order_id",type="integer", nullable=true)
     */
    protected $orderId;    
    

     /**
     * @var string $tag
     * @ORM\Column(name="ENTITY_ITEM_tag",type="string", nullable=true)
     */
    protected $tag;     
	
	
	
    
    
    /**
     * Get idEntity
     *
     * @return integer $idEntity
     */
    public function getIdEntity()
    {
        return $this->idEntity;
    }

    /**
     * Set idEntity
     *
     * @param integer $idEntity
     */
    public function setIdEntity($idEntity)
    {
        $this->idEntity = $idEntity;
    }   
    
    
    
    
    
    
    /**
     * Get typeEntity
     *
     * @return string $typeEntity
     */
    public function getTypeEntity()
    {
        return $this->typeEntity;
    }

    /**
     * Set typeEntity
     *
     * @param string $typeEntity
     */
    public function setTypeEntity($typeEntity)
    {
        $this->typeEntity = $typeEntity;
    }    
    
    
    
    
    
  
    
    
     /**
     * Get idItem
     *
     * @return integer $idItem
     */
    public function getIdItem()
    {
        return $this->idItem;
    }

    /**
     * Set idItem
     *
     * @param integer $idItem
     */
    public function setIdItem($idItem)
    {
        $this->idItem = $idItem;
    }   
    
    
    
    
    
    
    /**
     * Get typeItem
     *
     * @return string $typeItem
     */
    public function getTypeItem()
    {
        return $this->typeItem;
    }

    /**
     * Set typeItem
     *
     * @param string $typeItem
     */
    public function setTypeItem($typeItem)
    {
        $this->typeItem = $typeItem;
    }      
    
    
    
    
    
    
       /**
     * Get orderId
     *
     * @return integer $orderId
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set orderId
     *
     * @param integer $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }   
      
    
    public function getTag() {
		return $this->tag;
	}

	public function setTag($tag) {
		$this->tag = $tag;
	}


    
    
    
    
}