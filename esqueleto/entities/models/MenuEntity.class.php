<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 21.06.2011 20:11:46
 */

/**
 * @orm:Entity(menu)
 */
class MenuEntity extends Entity {

    /**
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="menu")
     */
    protected $IDOpcion;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="menu")
     */
    protected $Script = '';
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="menu")
     */
    protected $Titulo;
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="menu")
     */
    protected $Orden = 0;
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="menu")
     */
    protected $Administrador = 0;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="menu")
     */
    protected $Icono;
    /**
     * Nombre de la conexion a la DB
     * @var string
     */
    protected $_conectionName = 'empresas';
    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'menu';
    /**
     * Nombre de la primaryKey
     * @var string
     */
    protected $_primaryKeyName = 'IDOpcion';
    /**
     * Relacion de entidades que dependen de esta
     * @var array
     */
    protected $_parentEntities = array(
        array('SourceColumn' => 'IDOpcion', 'ParentEntity' => 'Submenu', 'ParentColumn' => 'IDOpcion'),
    );

    /**
     * GETTERS Y SETTERS
     */
    public function setIDOpcion($IDOpcion) {
        $this->IDOpcion = $IDOpcion;
    }

    public function getIDOpcion() {
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

    public function setIcono($Icono) {
        $this->Icono = $Icono;
    }

    public function getIcono() {
        return $this->Icono;
    }

}

// END class menu
?>