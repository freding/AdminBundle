<?php
namespace Fredb\AdminBundle\Services\AdministrableEntity;

/**
 *
 * @author fredericbourbigot
 */
interface AdministrableLangEntity extends AdministrableEntity {
   
    public function getNamespaceLangEntity();
    public function getLangFieldId();
    public function getLangFieldLang();
    
}

?>
