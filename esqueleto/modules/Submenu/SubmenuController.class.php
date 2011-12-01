<?php
/**
* CONTROLLER FOR Submenu
* @author: Sergio Perez <sergio.perez@albatronic.com>
* @copyright: INFORMATICA ALBATRONIC SL 
* @date 07.06.2011 19:41:33

* Extiende a la clase controller
*/

class SubmenuController extends controller {

	protected $entity = "Submenu";
        protected $parentEntity = "Menu";

    /**
     * Devuelve todas las subopciones de menu de la
     * opcion indicada en la posicion 3 del request.
     * @return array
     */
    public function listAction($idOpcion='') {

        if ($idOpcion == '')
            $idOpcion = $this->request[3];

        $tabla = $this->form->getDataBaseName() . "." . $this->form->getTable();
        $filtro = $tabla . ".IDOpcion='" . $this->request[3] . "'";

        $this->values['linkBy']['value'] = $idOpcion;

        return parent::listAction($filtro);
    }
}
?>