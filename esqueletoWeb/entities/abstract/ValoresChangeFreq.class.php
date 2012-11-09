<?php

/**
 * Description of ValoresChangeFreq
 * 
 * INDICA LA FRECUENCIA DE CAMBIO DEL MAPA WEB:
 * 
 *   always (siempre)
 *   hourly (cada hora)
 *   daily (diariamente)
 *   weekly (semanalmente)
 *   monthly (mensualmente)
 *   yearly (anualmente)
 *   never (nunca) 
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @since 03-08-2012
 *
 */
class ValoresChangeFreq extends Tipos {

    protected $tipos = array(
        array('Id' => 'always', 'Value' => 'always'),
        array('Id' => 'hourly', 'Value' => 'hourly'),
        array('Id' => 'daily', 'Value' => 'daily'),
        array('Id' => 'weekly', 'Value' => 'weekly'),
        array('Id' => 'monthly', 'Value' => 'monthly'),
        array('Id' => 'yearly', 'Value' => 'yearly'),
        array('Id' => 'never', 'Value' => 'never'),
    );

}

?>
