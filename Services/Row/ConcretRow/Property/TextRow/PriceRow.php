<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;

use Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;


/**
 * @author fredericbourbigot
 */
class PriceRow extends TextRow {
    
   const ERROR_PRICE_FORMAT            = "Le prix ne doit contenir que des chiffres(un point pour la décimal) et aucun espace"; 
    
    public function getErrorMessages() {
        $message =parent::getErrorMessages();
        if($this->is_form_submited){
            if((!is_numeric($this->getValue()))){
                 $aErrors[] = self::ERROR_PRICE_FORMAT;
                 $message = $aErrors;
            }
        }
        return $message;
    }

    
    
    
}


