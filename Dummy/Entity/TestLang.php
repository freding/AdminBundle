<?php

namespace Acme\DemoBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Fredb\AdminBundle\Annotations as FREDB;

/**
 * Acme\DemoBundle\Entity\TestLang
 *
 * @ORM\Table(name="TBL_test_lang")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Acme\DemoBundle\Repository\TestLangRepository")
 */
class TestLang {


    
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
     */
    protected $desc; 
    
    
     /**
     * @var string $lib
     * @ORM\Column(name="TEST_LANG_lib",type="string")
     */
    protected $lib;   
        
	
    
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

    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

    public function getLib() {
        return $this->lib;
    }

    public function setLib($lib) {
        $this->lib = $lib;
    }


    
    
}