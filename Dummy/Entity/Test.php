<?php

namespace Acme\DemoBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\ClassRow as CLASS_ROW;

/**
 * Acme\DemoBundle\Entity\Test
 *
 * @ORM\Table(name="TBL_test")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Acme\DemoBundle\Repository\TestRepository")
 * @CLASS_ROW\ManageByBo(user_name={"fr":"Test name","en":"Test en"},order=3,lang_class_namespace="\Acme\DemoBundle\Entity\TestLang",mother_node={"fr":"Parent","en":"Parent en"})
 */
class Test implements \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity {

	/**
	 * @var integer $id
	 * @ORM\Id 
	 * @ORM\Column(name="TEST_id",type="integer")
	 * @ORM\GeneratedValue
	 */
	 protected $id;
	
    /**
     * @var integer $chaine
     * @ORM\Column(name="TEST_chaine",type="string")
     */
    protected $chaine;    
    
    
    
    /**
     * @var float $price
     * @ORM\Column(name="TEST_price",type="float")
     */
    protected $price;  
    
    
    
    /**
     * @var integer $name
     * @ORM\Column(name="TEST_name",type="string")
     */
    protected $name; 
    
    
    
    /**
     * @var integer $name_url
     * @ORM\Column(name="TEST_name_url",type="string")
     */
    protected $name_url; 
    
    
    /**
     * @var integer $desc
     * @ORM\Column(name="TEST_desc",type="string")
     */
    protected $desc; 
    
	
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getChaine() {
        return $this->chaine;
    }

    public function setChaine($chaine) {
        $this->chaine = $chaine;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName_url() {
        return $this->name_url;
    }

    public function setName_url($name_url) {
        $this->name_url = $name_url;
    }

    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

        
    
    
    public function getCreationDate() {
        return 11222;
    }

    public function getTag() {
        return "Test";
    }

    public function setCreationDate() {
        
    }


    public function getNameIdentifier($lang) {
        return $this->getName();
    }
    
    
    
    
    
	
}