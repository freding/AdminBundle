<?php

namespace Fredb\AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Fred\DatasBundle\Entity\Picture
 *
 * @ORM\Table(name="TBL_picture")
 * @ORM\Entity
 */
class Picture implements \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity{

    const STR_TYPE_ENTITY	= "Picture";
    /**
     * @var integer $id
     * @ORM\Id 
     * @ORM\Column(name="PICTURE_id",type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
	
    /**
     * @var integer $creationDate
     * @ORM\Column(name="PICTURE_creation_date",type="integer")
     */
    protected $creationDate;    
    
	
    /**
     * @var string $active
     * @ORM\Column(name="PICTURE_active",type="string")
     */
    protected $active;

    /**
     * @var integer $ownerId
     * @ORM\Column(name="PICTURE_owner_id",type="integer")
     */
    protected $ownerId;
    
    /**
     * @var string $ownerKind
     * @ORM\Column(name="PICTURE_owner_kind",type="string")
     */
    protected $ownerKind;
    
    /**
     * @var integer $order
     * @ORM\Column(name="PICTURE_order",type="integer")
     */
    protected $order;  	

	
    /**
     * @var string $name
     * @ORM\Column(name="PICTURE_name",type="string")
     */
    protected $name;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function setCreationDate() {
        $this->creationDate = time();
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function getOwnerId() {
        return $this->ownerId;
    }

    public function setOwnerId(integer $ownerId) {
        $this->ownerId = $ownerId;
    }

    public function getOwnerKind() {
        return $this->ownerKind;
    }

    public function setOwnerKind($ownerKind) {
        $this->ownerKind = $ownerKind;
    }

    public function getOrder() {
        return $this->order;
    }

    public function setOrder($order) {
        $this->order = $order;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getType()
    {
        return self::STR_TYPE_ENTITY;
    }

    public function getNameIdentifier($lang) {
        return $this->getName();
    }

    public function getTag() {
        return self::STR_TYPE_ENTITY;
    }  
    
}