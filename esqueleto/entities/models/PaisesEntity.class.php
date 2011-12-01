<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 12.06.2011 18:39:47
 */

/**
 * @orm:Entity(paises)
 */
class PaisesEntity extends Entity {

    /**
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="paises")
     */
    protected $IDPais;
    /**
     * @orm:Column(type="integer")
     */
    protected $IsoNum;
    /**
     * @orm:Column(type="")
     */
    protected $Iso2;
    /**
     * @orm:Column(type="")
     */
    protected $Iso3;
    /**
     * @orm:Column(type="string")
     */
    protected $Pais;
    /**
     * Nombre de la conexion a la DB
     * @var string
     */
    protected $_conectionName = 'empresas';
    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'paises';
    /**
     * Nombre de la primaryKey
     * @var string
     */
    protected $_primaryKeyName = 'IDPais';
    /**
     * Relacion de entidades que dependen de esta
     * @var array
     */
    protected $_parentEntities = array(
        array('SourceColumn' => 'IDPais', 'ParentEntity' => 'Clientes', 'ParentColumn' => 'IDPais'),
        array('SourceColumn' => 'IDPais', 'ParentEntity' => 'Proveedores', 'ParentColumn' => 'IDPais'),
    );

    /**
     * GETTERS Y SETTERS
     */
    public function setIDPais($IDPais) {
        $this->IDPais = $IDPais;
    }

    public function getIDPais() {
        return $this->IDPais;
    }

    public function setIsoNum($IsoNum) {
        $this->IsoNum = $IsoNum;
    }

    public function getIsoNum() {
        return $this->IsoNum;
    }

    public function setIso2($Iso2) {
        $this->Iso2 = $Iso2;
    }

    public function getIso2() {
        return $this->Iso2;
    }

    public function setIso3($Iso3) {
        $this->Iso3 = $Iso3;
    }

    public function getIso3() {
        return $this->Iso3;
    }

    public function setPais($Pais) {
        $this->Pais = trim($Pais);
    }

    public function getPais() {
        return $this->Pais;
    }

}

// END class paises
?>