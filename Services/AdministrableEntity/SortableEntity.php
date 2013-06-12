<?php
namespace Fredb\AdminBundle\Services\AdministrableEntity;

/**
 *
 * @author fredericbourbigot
 */
interface SortableEntity {
   
    public function getOrderId();
    public function setOrderId($id);
    
    
}

?>
