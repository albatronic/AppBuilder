<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 21.06.2011 20:11:58
 */

/**
 * @orm:Entity(submenu)
 */
class SubmenuEntity extends Entity {

    /**
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="submenu")
     */
    protected $Id;
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="submenu")
     */
    protected $IDOpcion = '0';
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="submenu")
     */
    protected $Script;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="submenu")
     */
    protected $Titulo;
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="submenu")
     */
    protected $Orden = '0';
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="submenu")
     */
    protected $Administrador = '0';
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="submenu")
     */
    protected $Emergente = '0';
    /**
     * Nombre de la conexion a la DB
     * @var string
     */
    protected $_conectionName = 'empresas';
    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'submenu';
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

    public function setIDOpcion($IDOpcion) {
        $this->IDOpcion = $IDOpcion;
    }

    public function getIDOpcion() {
        if (!($this->IDOpcion instanceof Menu))
            $this->IDOpcion = new Menu($this->IDOpcion);
        return $this->IDOpcion;
    }

    public function setScript($Script) {
        $this->Script = trim($Script);
    }

    public function getScript() {
        return $this->Script;
    }

    public function setTitulo($Titulo) {
        $this->Titulo = trim($Titulo);
    }

    public function getTitulo() {
        return $this->Titulo;
    }

    public function setOrden($Orden) {
        $this->Orden = $Orden;
    }

    public function getOrden() {
        return $this->Orden;
    }

    public function setAdministrador($Administrador) {
        $this->Administrador = $Administrador;
    }

    public function getAdministrador() {
        if (!($this->Administrador instanceof ValoresSN))
            $this->Administrador = new ValoresSN($this->Administrador);
        return $this->Administrador;
    }

    public function setEmergente($Emergente) {
        $this->Emergente = $Emergente;
    }

    public function getEmergente() {
        if (!($this->Emergente instanceof ValoresSN))
            $this->Emergente = new ValoresSN($this->Emergente);
        return $this->Emergente;
    }

}

// END class submenu
?>