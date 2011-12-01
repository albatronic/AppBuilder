<?php

/**
 * Description of Perfiles
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 04-nov-2011
 *
 */
class Perfiles extends PerfilesEntity {

    public function __toString() {
        return $this->getPerfil();
    }

}

?>
