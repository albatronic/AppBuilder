<?php

/**
 * Description of ValoresPrivacy
 *
 * INDICA SI UN CONTENIDO ES PRIVADO, PÚBLICO O AMBOS CASOS
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @since 03-08-2012
 *
 */

/**
 * VALORES PRIVADO, PÚBLICO, AMBOS
 */
class ValoresPrivacy extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'Público'),
        array('Id' => '1', 'Value' => 'Privado'),
        array('Id' => '2', 'Value' => 'Ambos'),
    );

}

?>
