<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 20:33:07
 */

/**
 * @orm:Entity(GconSecciones)
 */
class GconSecciones extends GconSeccionesEntity {

    public function __toString() {
        return $this->getId();
    }

    /**
     * Devuelve un array con las subsecciones de la sección en curso
     * 
     * El índice del array es el título de la subsección y el valor es la url amigable
     * 
     * @return array Array de subsecciones
     */
    public function getArraySubsecciones() {
    
        $array = array();
        
        $subseccion = new GconSecciones();
        $filtro = "BelongsTo='{$this->Id}'";
        $rows = $subseccion->cargaCondicion("Titulo,UrlFriendly",$filtro,"SortOrder ASC");
        unset($subseccion);
        foreach ($rows as $row) {
            $array[$row['Titulo']] = $row['UrlFriendly'];
        }
        return $array;
    }

}

?>