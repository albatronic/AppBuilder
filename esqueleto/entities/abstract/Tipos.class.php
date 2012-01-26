<?php

/*
 * Class Tipos
 *
 * Definición de todos los valores estáticos de
 * diferentes entidades. Son los valores de tipo 'ENUM'
 * que pueden contener las propiedades de las entidades.
 *
 * El método fetchAll() devuelve los valores para que
 * los formulario rendericen los desplegables de valores
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC, SL
 * @date 08.06.2011
 */

class Tipos {

    private $IDTipo;
    private $Descripcion;

    public function __construct($IDTipo=null) {
        if (isset($IDTipo)) {
            foreach ($this->tipos as $key => $value) {
                if ($value['Id'] == $IDTipo) {
                    $this->IDTipo = $this->tipos[$key]['Id'];
                    $this->Descripcion = $this->tipos[$key]['Value'];
                    return;
                } else {
                    $this->IDTipo = null;
                    $this->Descripcion = "** NO DEFINIDO **";
                }
            }
        }
    }

    public function fetchAll() {
        return $this->tipos;
    }

    public function getIDTipo() {
        return $this->IDTipo;
    }

    public function getDescripcion() {
        return $this->Descripcion;
    }

    public function __toString() {
        return $this->getDescripcion();
    }

}
?>