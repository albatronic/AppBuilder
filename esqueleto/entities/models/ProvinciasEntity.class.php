<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 12.06.2011 18:39:47
 */

/**
 * @orm:Entity(provincias)
 */
class ProvinciasEntity extends Entity {

    /**
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="provincias")
     */
    protected $IDProvincia;
    /**
     * @orm:Column(type="")
     * @assert:NotBlank(groups="provincias")
     */
    protected $Codigo;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="provincias")
     */
    protected $Provincia = '';
    /**
     * @orm:Column(type="integer")
     */
    protected $IDZona = '0';
    /**
     * Nombre de la conexion a la DB
     * @var string
     */
    protected $_conectionName = 'empresas';
    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'provincias';
    /**
     * Nombre de la primaryKey
     * @var string
     */
    protected $_primaryKeyName = 'IDProvincia';
    /**
     * Relacion de entidades que dependen de esta
     * @var array
     */
    protected $_parentEntities = array(
        array('SourceColumn' => 'IDProvincia', 'ParentEntity' => 'Clientes', 'ParentColumn' => 'IDProvincia'),
        array('SourceColumn' => 'IDProvincia', 'ParentEntity' => 'ClientesDentrega', 'ParentColumn' => 'IDProvincia'),
        array('SourceColumn' => 'IDProvincia', 'ParentEntity' => 'Proveedores', 'ParentColumn' => 'IDProvincia'),
        array('SourceColumn' => 'IDProvincia', 'ParentEntity' => 'Almacenes', 'ParentColumn' => 'IDProvincia'),
    );

    /**
     * GETTERS Y SETTERS
     */
    public function setIDProvincia($IDProvincia) {
        $this->IDProvincia = $IDProvincia;
    }

    public function getIDProvincia() {
        return $this->IDProvincia;
    }

    public function setCodigo($Codigo) {
        $this->Codigo = $Codigo;
    }

    public function getCodigo() {
        return $this->Codigo;
    }

    public function setProvincia($Provincia) {
        $this->Provincia = trim($Provincia);
    }

    public function getProvincia() {
        return $this->Provincia;
    }

    public function setIDZona($IDZona) {
        $this->IDZona = $IDZona;
    }

    public function getIDZona() {
        if (!($this->IDZona instanceof ZonasTransporte))
            $this->IDZona = new ZonasTransporte($this->IDZona);
        return $this->IDZona;
    }

}

// END class provincias
?>