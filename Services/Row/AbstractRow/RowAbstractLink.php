<?php


namespace Fredb\AdminBundle\Services\Row\AbstractRow;

/**
 *
 * @author fredericbourbigot
 */
abstract class RowAbstractLink extends RowAbstract{
	
    protected $is_langueable;
    protected $lang;
    protected $property_name;
    protected $value;
    protected $is_form_submited;
    protected $mode_edition;
    protected $template_name;
    protected $id;


    abstract public function prepareSave(&$oClass);
    
    public function getIs_langueable() {
        return $this->is_langueable;
    }

    public function setIs_langueable($is_langueable) {
        $this->is_langueable = $is_langueable;
    }

    public function getLang() {
        return $this->lang;
    }

    public function setLang($lang) {
        $this->lang = $lang;
    }

    public function getProperty_name() {
        return $this->property_name;
    }

    public function setProperty_name($property_name) {
        $this->property_name = $property_name;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getIs_form_submited() {
        return $this->is_form_submited;
    }

    public function setIs_form_submited($is_form_submited) {
        $this->is_form_submited = $is_form_submited;
    }

    public function getMode_edition() {
        return $this->mode_edition;
    }

    public function setMode_edition($mode_edition) {
        $this->mode_edition = $mode_edition;
    }

    public function getTemplate_name() {
        return $this->template_name;
    }

    public function setTemplate_name($template_name) {
        $this->template_name = $template_name;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }


    

}