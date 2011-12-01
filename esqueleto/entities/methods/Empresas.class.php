<?php

/**
 * Description of Empresas
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 04-nov-2011
 *
 */
class Empresas extends EmpresasEntity {

    /**
     * Devuelve el nombre del fichero jpg que contiene el logo
     * de la empresa. Con la ruta completa.
     * Si no existe devuelve el logo generico (images/logo.jpg)
     *
     * @return string Ruta completa al logo de la empresa
     */
    public function getLogo() {
        $logo = "docs/docs" . $_SESSION['emp'] . "/images/logo.jpg";
        if (!file_exists($logo))
            $logo = "images/logo.jpg";

        return $logo;
    }

    /**
     * Devuelve la Razon Social
     * @return string
     */
    public function __toString() {
        return $this->getRazonSocial();
    }

    /**
     * Devuelve un array con todas las empresas
     *
     * Cada elemento tiene la primarykey y el valor de $column
     */
    public function fetchAll($column='RazonSocial') {
        $this->conecta();

        if (is_resource($this->_dbLink)) {
            $query = "SELECT IDEmpresa as Id, $column as Value from empresas order by $column ASC;";
            $this->_em->query($query);
            $rows = $this->_em->fetchResult();
            $this->_em->desConecta();
            unset($this->_em);
        }
        $rows[] = array('Id' => '0', Value => ':: Indique un valor');
        return $rows;
    }

}

?>
