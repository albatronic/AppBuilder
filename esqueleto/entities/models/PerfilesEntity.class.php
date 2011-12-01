<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 12.06.2011 19:20:36
 */

/**
 * @orm:Entity(perfiles)
 */
class PerfilesEntity extends Entity {

    /**
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="perfiles")
     */
    protected $IDPerfil;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="perfiles")
     */
    protected $Perfil;
    /**
     * @orm:Column(type="string")
     */
    protected $Descripcion;
    /**
     * @orm:Column(type="")
     * @assert:NotBlank(groups="perfiles")
     */
    protected $Administrador = '0';
    /**
     * Nombre de la conexion a la DB
     * @var string
     */
    protected $_conectionName = 'empresas';
    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'perfiles';
    /**
     * Nombre de la primaryKey
     * @var string
     */
    protected $_primaryKeyName = 'IDPerfil';
    /**
     * Relacion de entidades que dependen de esta
     * @var array
     */
    protected $_parentEntities = array(
        array('SourceColumn' => 'IDPerfil', 'ParentEntity' => 'Permisos', 'ParentColumn' => 'IDPerfil'),
    );

    /**
     * GETTERS Y SETTERS
     */
    public function setIDPerfil($IDPerfil) {
        $this->IDPerfil = $IDPerfil;
    }

    public function getIDPerfil() {
        return $this->IDPerfil;
    }

    public function setPerfil($Perfil) {
        $this->Perfil = trim($Perfil);
    }

    public function getPerfil() {
        return $this->Perfil;
    }

    public function setDescripcion($Descripcion) {
        $this->Descripcion = trim($Descripcion);
    }

    public function getDescripcion() {
        return $this->Descripcion;
    }

    public function setAdministrador($Administrador) {
        $this->Administrador = $Administrador;
    }

    public function getAdministrador() {
        if (!($this->Administrador instanceof ValoresSN))
            $this->Administrador = new ValoresSN($this->Administrador);
        return $this->Administrador;
    }

}

// END class perfiles
?>