<?php

/**
 * Description of IndexController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @date 06-nov-2012
 *
 */
class IndexController extends ControllerWeb {

    protected $entity = "Index";

    public function IndexAction() {

        /**
         * PONER AQUI LA LÓGICA NECESARIA Y CONSTRUIR
         * EL ARRAY DE VALORES '$this->values'
         */
        return array(
            'template' => $this->entity . '/index.html.twig',
            'values' => $this->values
        );
    }

}

?>
