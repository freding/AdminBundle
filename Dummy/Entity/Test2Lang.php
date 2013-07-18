<?php

namespace Acme\DemoBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Fredb\AdminBundle\Annotations\ConcretAnnotations\Property as PROPERTY_ROW;
use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableLangEntity;
/**
 * Acme\DemoBundle\Entity\Test2Lang
 *
 * @ORM\Table(name="TBL_test2_lang")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Acme\DemoBundle\Repository\Test2LangRepository")
 */
class Test2Lang implements AdministrableLangEntity {


    
    /**
     * @var integer $id
     * @ORM\Id 
     * @ORM\Column(name="id",type="integer")
     */
    protected $id;
	


    /**
     * @var string $lang
     * @ORM\Id 
     * @ORM\Column(name="lang",type="string")
     */
    protected $lang;       
    
    
    
    
    
    
    
    
    
     /**
     * @var string $name
     * @ORM\Column(name="TEST_LANG_name",type="string")
     * @PROPERTY_ROW\Text(user_name={"fr":"fr test2 lang","en":"en test2 lang"},length=70, require=true)
     */
    protected $name;      
    
    
    /**
     * @var string $name_url
     * @ORM\Column(name="TEST_LANG_name_url",type="string")
     */
    protected $name_url; 
    
    
    
     /**
     * @var string $desc
     * @ORM\Column(name="TEST_LANG_desc",type="string")
     * @PROPERTY_ROW\Text\LongText(user_name={"fr":"Descriptif lang","en":"desc lang"},length=70,default_value={"fr":"Chaine default","en":"default"},require=true) 
     */
    protected $desc_lang; 
    
    
     /**
     * @var string $lib
     * @ORM\Column(name="TEST_LANG_lib",type="string")
     */
    protected $lib;   
        
    
    
    /**
     * @var integer $active
     * @ORM\Column(name="TEST_LANG_active",type="integer")
     * @PROPERTY_ROW\CheckBox(user_name={"fr":"Activé pour la langue","en":"activated for lang"})
     */
    protected $active_lang;  
    
	
    
    
    
    /**
     * @var integer $date
     * @ORM\Column(name="TEST_LANG_date",type="integer")
     * @PROPERTY_ROW\Text\Date(user_name={"fr":"Date lang","en":"Date lang"},length=10)
     */
    protected $date_lang;  
    
    
    
    /**
     * @var string $color
     * @ORM\Column(name="TEST_LANG_color",type="string")
     * @PROPERTY_ROW\Text\Color(user_name={"fr":"Color lang","en":"Color lang"},length=10)
     */
    protected $color_lang;   
    
    
 
    /**
     * @var string $key
     * @ORM\Column(name="TEST_LANG_key_name",type="string")
     * @PROPERTY_ROW\Text\TextToUrl(user_name={"fr":"Nom pour url lang","en":"name for url lang"},link_field_url="keyUrl",require=true)
     */
    protected $key;  
    
    /**
     * @var string $keyUrl
     * @ORM\Column(name="TEST_LANG_key_url",type="string")
     */
    protected $keyUrl;  
    
    
    
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLang() {
        return $this->lang;
    }

    public function setLang($lang) {
        $this->lang = $lang;
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

    public function getDesc_lang() {
        return $this->desc_lang;
    }

    public function setDesc_lang($desc_lang) {
        $this->desc_lang = $desc_lang;
    }

    
    public function getLib() {
        return $this->lib;
    }

    public function setLib($lib) {
        $this->lib = $lib;
    }


    public function getActive_lang() {
        return $this->active_lang;
    }

    public function setActive_lang($active_lang) {
        $this->active_lang = $active_lang;
    }

    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function getKeyUrl() {
        return $this->keyUrl;
    }

    public function setKeyUrl($keyUrl) {
        $this->keyUrl = $keyUrl;
    }



    
}