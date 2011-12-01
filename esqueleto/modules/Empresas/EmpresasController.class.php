<?php

/**
 * CONTROLLER FOR Empresas
 * @author: Sergio Perez <sergio.perez@albatronic.com>
 * @copyright: INFORMATICA ALBATRONIC SL 
 * @date 07.06.2011 19:41:33

 * Extiende a la clase controller
 */


class EmpresasController extends controller {

    protected $entity = "Empresas";
    protected $parentEntity = "";

    /**
     * Renderiza los templates de almacenes
     * y sucursales en formato iframe
     * con dos solapas tipo tab.
     * @return array
     */
    public function SolapasAction() {
        $template = $this->entity . '/solapas.html.twig';

        $this->values['idEmpresa'] = $this->request[3];

        return array('template' => $template, 'values' => $this->values);
    }

}


?>