<?php

/**
 * Description of Menu
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 04-nov-2011
 *
 */
class Menu extends MenuEntity {

    public function __toString() {
        return $this->getTitulo();
    }

}

?>
