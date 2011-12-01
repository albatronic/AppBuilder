<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 22.06.2011 00:43:35
 */

/**
 * @orm:Entity(permisos)
 */
class PermisosEntity extends Entity {

    /**
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="permisos")
     */
    protected $Id;
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="permisos")
     */
    protected $IDPerfil;
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="permisos")
     */
    protected $IDOpcion = '0';
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="permisos")
     */
    protected $IDSubopcion = '0';
    /**
     * @orm:Column(type="string")
     */
    protected $Permisos = '111111';
    /**
     * Nombre de la conexion a la DB
     * @var string
     */
    protected $_conectionName = 'empresas';
    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'permisos';
    /**
     * Nombre de la primaryKey
     * @var string
     */
    protected $_primaryKeyName = 'Id';

    /**
     * GETTERS Y SETTERS
     */
    public function setId($Id) {
        $this->Id = $Id;
    }

    public function getId() {
        return $this->Id;
    }

    public function setIDPerfil($IDPerfil) {
        $this->IDPerfil = $IDPerfil;
    }

    public function getIDPerfil() {
        return $this->IDPerfil;
    }

    public function setIDOpcion($IDOpcion) {
        $this->IDOpcion = $IDOpcion;
    }

    public function getIDOpcion() {
        if (!($this->IDOpcion instanceof Menu))
            $this->IDOpcion = new Menu($this->IDOpcion);
        return $this->IDOpcion;
    }

    public function setIDSubopcion($IDSubopcion) {
        $this->IDSubopcion = $IDSubopcion;
    }

    public function getIDSubopcion() {
        if (!($this->IDSubopcion instanceof Submenu))
            $this->IDSubopcion = new Submenu($this->IDSubopcion);
        return $this->IDSubopcion;
    }

    public function setPermisos($Permisos) {
        $this->Permisos = $Permisos;
    }

    public function getPermisos() {
        return $this->Permisos;
    }

}

// END class permisos
?>