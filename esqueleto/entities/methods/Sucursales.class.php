<?php

/**
 * Description of Sucursales
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 04-nov-2011
 *
 */
class Sucursales extends SucursalesEntity {

    /**
     * Devuelve el nombre de la empresa
     * @return string
     */
    public function __toString() {
        return $this->getNombre();
    }

    /**
     * Devuelve un array con todas las sucursales de la empresa indicada
     *
     * Cada elemento tiene la primarykey y el valor de $column
     */
    public function fetchAll($idEmpresa, $column='Nombre') {
        $this->conecta();

        if (is_resource($this->_dbLink)) {
            $filtro = "WHERE (IDEmpresa='" . $idEmpresa . "') ";
            $query = "SELECT IDSucursal as Id,$column as Value FROM sucursales $filtro ORDER BY $column ASC;";
            $this->_em->query($query);
            $rows = $this->_em->fetchResult();
            $this->_em->desConecta();
            unset($this->_em);
        }
        $rows[] = array('Id' => '0', 'Value' => '** Todas **');
        return $rows;
    }

}

?>
