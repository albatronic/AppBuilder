<?php

/**
 * CONTROLADOR DE PROYECTO. EXTIENDE AL CONTROLADOR WEB
 * 
 * El constructor realiza las tareas comunes al proyecto como por ej.
 * construir la ruta de navegación y los menús
 *
 * @author Sergio Pérez
 * @copyright Ártico Estudio, SL
 * @version 1.0 26-nov-2012
 */
class ControllerProject extends ControllerWeb {

    public function __construct($request) {

        parent::__construct($request);

        $this->values['firma'] = $this->getFirma();
        $this->values['ruta'] = $this->getRuta();
        $this->values['calendario'] = $this->getCalendario();
        $this->values['ustedEstaEn'] = $this->getUstedEstaEn();
        $this->values['menuCabecera'] = $this->getMenuCabecera();
        $this->values['menuDesplegable'] = $this->getMenuDesplegable();
        $this->values['menuPie'] = $this->getMenuPie();
    }

}
?>
