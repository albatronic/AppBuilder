<?php

/**
 * Description of Submenu
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 04-nov-2011
 *
 */
class Submenu extends SubmenuEntity {

    public function __toString() {
        return $this->getTitulo();
    }

    /**
     * Devuelve un array con todos los registros
     * Cada elemento tiene la primarykey y el valor de $column
     */
    public function fetchAll($column="Titulo", $idOpcion='') {
        $this->conecta();

        if (is_resource($this->_dbLink)) {
            if ($idOpcion != '') {
                $filtro = "WHERE (IDOpcion='" . $idOpcion . "') ";
            } else
                $filtro = "WHERE (1) ";
            $query = "SELECT Id as Id,$column as Value FROM submenu $filtro ORDER BY $column ASC;";
            $this->_em->query($query);
            $rows = $this->_em->fetchResult();
            $this->_em->desConecta();
            unset($this->_em);
        }
        $rows[] = array('Id' => 0, 'Value' => ':: Indique un valor');
        return $rows;
    }

    /**
     * Valida antes del borrado
     * Devuelve TRUE o FALSE
     * Si hay errores carga el array $this->_errores
     * @return boolean
     */
    public function validaBorrado() {
        unset($this->_errores);

        $em = new entityManager("empresas");
        $link = $em->getDbLink();

        if (is_resource($link)) {
            //PERMISOS
            $query = "select count(Id) as N from permisos where IDOpcion='" . $this->IDOpcion . "' AND IDSubopcion='" . $this->getId() . "'";
            $row = $em->fetchResult();
            $n = $row[0]['N'];
            if ($n > 0)
                $this->_errores[] = "Imposible eliminar. Hay " . $n . " permisos relacionados";

            $em->desConecta();
        }
        else {
            $this->_errores[] = "Error conexión a la DB validando borrado de SubMenu";
        }

        return (count($this->_errores) == 0);
    }

}

?>
