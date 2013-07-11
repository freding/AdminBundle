<?php
namespace Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;

use Fredb\AdminBundle\Services\Row\ConcretRow\Property\TextRow;


/**
 * @author fredericbourbigot
 */
class LongTextRow extends TextRow {
    
	protected $height;
        protected $rich;
    
    
        public function getHeight() {
            return $this->height;
        }

        public function setHeight($height) {
            $this->height = $height;
        }

        public function getRich() {
            return $this->rich;
        }

        public function setRich($rich) {
            $this->rich = $rich;
        }

    
    
}


