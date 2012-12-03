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
     * Cada elemento del array es:
     * 
     *      * titulo => El titulo de la seccion
     *      * url => array(url => La url, targetBlank => boolean)
     * 
     * @return array Array de subsecciones
     */
    public function getArraySubsecciones() {

        $array = array();

        $subseccion = new GconSecciones();
        $filtro = "BelongsTo='{$this->Id}'";
        $rows = $subseccion->cargaCondicion("Id", $filtro, "SortOrder ASC");

        foreach ($rows as $row) {
            $subseccion = new GconSecciones($row['Id']);
            $array[] = array(
                'titulo' => $subseccion->getTitulo(),
                'url' => $subseccion->getHref(),
            );
        }
        unset($subseccion);
        
        return $array;
    }

}

?>