<?php


namespace Fredb\AdminBundle\Services\Row\AbstractRow;

use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableEntity;
use Fredb\AdminBundle\Services\AdministrableEntity\AdministrableLangEntity;
/**
 *
 * @author fredericbourbigot
 */
abstract class RowAbstractProperty extends RowAbstract{
	
    
    const ERROR_FILL_FIELD		= "Please fill this field";
    const ERROR_PRICE_FORMAT            = "Le prix ne doit contenir que des chiffres(un point pour la décimal) et aucun espace";    

    protected $is_langueable;
    protected $lang;
    protected $property_name;
    protected $is_require;
    protected $value;
    protected $is_form_submited;
    protected $mode_edition;
    protected $template_name;
    
	abstract public function getErrorMessages();

	abstract public function prepareSave(AdministrableEntity &$oClass, AdministrableLangEntity $oEntityLang, \Doctrine\ORM\EntityManager $oEntityManager);

        
        

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

        public function getIs_require() {
            return $this->is_require;
        }

        public function setIs_require($is_require) {
            $this->is_require = $is_require;
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


        
}