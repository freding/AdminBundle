<?php

namespace Fredb\AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\ClassRow as CLASS_ROW;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\Property as PROPERTY_ROW;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\Link as LINK_ROW;

/**
 * @ORM\Table(name="TBL_test2")
 * @ORM\Entity
 * @CLASS_ROW\ManageByBo(user_name={"fr":"Test2 name","en":"Test2 en"},order=1,lang_class_namespace="\Fredb\AdminBundle\Entity\Test2Lang",mother_node={"fr":"Parent","en":"Parent en"})
 */
class Test2 implements \Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity, \Fredb\AdminBundle\Services\AdministrableEntity\SortableEntity {

    
	/** @LINK_ROW\Liste(user_name={"fr":"lier entity test","en":"link entity test"},class_item_linked="Fredb\AdminBundle\Entity\Test2" ) */
	protected $link_test;  
    

	static $aImageTest= array(
            array("name"=>"image1" , "width"=>85  , "height"=>120 , "folder"=>"mode/produit/big-thumb/"),
            array("name"=>"image2" , "width"=>342 , "height"=>482 , "folder"=>"mode/produit/big/"),
            array("name"=>"image3" , "width"=>684 , "height"=>964 , "folder"=>"mode/produit/bigest/"),
	);  

	/** @LINK_ROW\Image(user_name={"fr":"image test","en":"image test"},constant_format_pictures="aImageTest",tag="tag1",crop="false",id_fo_image="0") */
	protected $link_image;
    
	/** @LINK_ROW\Image(user_name={"fr":"image test2","en":"image test2"},constant_format_pictures="aImageTest",tag="tag2",crop="false",id_fo_image="0") */
	protected $link_image1;
    
    
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
     * @PROPERTY_ROW\Text(user_name={"fr":"Chaine name","en":"chaine name"},length=70,default_value={"fr":"Chaine default","en":"default"},require=true)
     */
    protected $chaine;    
    
    
    
    /**
     * @var float $price
     * @PROPERTY_ROW\Text\Price(user_name={"fr":"Prix","en":"price"},length=10,require=true)
     * @ORM\Column(name="TEST_price",type="float")
     */
    protected $price;  
    
    
    /**
     * @var integer $order
     * @ORM\Column(name="TEST_order",type="integer")
     */
    protected $order;      
    
    
    /**
     * @var integer $name
     * @ORM\Column(name="TEST_name",type="string")
     */
    protected $name; 
    
    
    

    
    
    /**
     * @var integer $desc
     * @ORM\Column(name="TEST_desc",type="string")
     * @PROPERTY_ROW\Text\LongText(user_name={"fr":"Descriptif","en":"description"},length=70,height=10,default_value={"fr":"Chaine default","en":"default"},require=true,rich=true)
     */
    protected $desc; 
    
    
    /**
     * @var integer $active
     * @ORM\Column(name="TEST_active",type="integer")
     * @PROPERTY_ROW\CheckBox(user_name={"fr":"Activé","en":"activated"})
     */
    protected $active;     
    
        
    
    
    
    /**
     * @var integer $date
     * @ORM\Column(name="TEST_date",type="integer")
     * @PROPERTY_ROW\Text\Date(user_name={"fr":"Date","en":"date"},length=10)
     */
    protected $date;  
    
    
    
    /**
     * @var string $color
     * @ORM\Column(name="TEST_color",type="string")
     * @PROPERTY_ROW\Text\Color(user_name={"fr":"Color","en":"color"},length=10)
     */
    protected $color;     
    
    
    
    
    /**
     * @var integer $name
     * @ORM\Column(name="TEST_name_url",type="string")
     * @PROPERTY_ROW\Text\TextToUrl(user_name={"fr":"Nom pour url","en":"name for url"},length=70,default_value={"fr":"Chaine default","en":"default"},link_field_url="urlName",require=true)
     */
    protected $nameUrl; 
    
    
    /**
     * @var integer $name
     * @ORM\Column(name="TEST_url_name",type="string")
     */
    protected $urlName; 
    
    
    
	
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

 

    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

    public function getOrder() {
        return $this->order;
    }

    public function setOrder($order) {
        $this->order = $order;
    }

    
    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }

        
    public function getCreationDate() {
        return 111111;
    }

    public function getTag() {
        return "Test2";
    }

    public function setCreationDate() {
        
    }

    public function getOrderId() {
        return $this->getOrder();
    }

    public function setOrderId($id) {
        $this->setOrder($id);
    }

    public function getNameIdentifier($lang) {
        return $this->getName();
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function getNameUrl() {
        return $this->nameUrl;
    }

    public function setNameUrl($nameUrl) {
        $this->nameUrl = $nameUrl;
    }

    public function getUrlName() {
        return $this->urlName;
    }

    public function setUrlName($urlName) {
        $this->urlName = $urlName;
    }


	
	
}