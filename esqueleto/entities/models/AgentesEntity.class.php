<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 12.06.2011 19:20:35
 */

/**
 * @orm:Entity(agentes)
 */
class AgentesEntity extends Entity {

    /**
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="agentes")
     */
    protected $IDAgente;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="agentes")
     */
    protected $Login;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="agentes")
     */
    protected $Nombre;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="agentes")
     */
    protected $Password;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="agentes")
     */
    protected $Quien;
    /**
     * @orm:Column(type="integer")
     */
    protected $NLogin = '0';
    /**
     * @orm:Column(type="datetime")
     */
    protected $UltimoLogin;
    /**
     * @orm:Column(type="string")
     */
    protected $EMail;
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="agentes")
     */
    protected $Activo = '1';
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="agentes")
     */
    protected $IDPerfil = '0';
    /**
     * @orm:Column(type="integer")
     */
    protected $IDEmpresa = '0';
    /**
     * @orm:Column(type="integer")
     */
    protected $IDSucursal = '0';
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="agentes")
     */
    protected $Rol = '0';
    /**
     * @orm:Column(type="integer")
     */
    protected $IDAlmacen = '0';
    /**
     * Para almacenar temporalmente la
     * repeticion de la password
     * @var string
     */
    protected $_repitePassword;
    /**
     * Nombre de la conexion a la DB
     * @var string
     */
    protected $_conectionName = 'empresas';
    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'agentes';
    /**
     * Nombre de la primaryKey
     * @var string
     */
    protected $_primaryKeyName = 'IDAgente';
    /**
     * Relacion de entidades que dependen de esta
     * @var array
     */
    protected $_parentEntities = array(
        array('SourceColumn' => 'IDAgente', 'ParentEntity' => 'ClientesDentrega', 'ParentColumn' => 'IDComercial'),
        array('SourceColumn' => 'IDAgente', 'ParentEntity' => 'Clientes', 'ParentColumn' => 'IDComercial'),
        array('SourceColumn' => 'IDAgente', 'ParentEntity' => 'AlbaranesCab', 'ParentColumn' => 'IDAgente'),
        array('SourceColumn' => 'IDAgente', 'ParentEntity' => 'AlbaranesCab', 'ParentColumn' => 'IDComercial'),
        array('SourceColumn' => 'IDAgente', 'ParentEntity' => 'PstoCab', 'ParentColumn' => 'IDAgente'),
        array('SourceColumn' => 'IDAgente', 'ParentEntity' => 'PstoCab', 'ParentColumn' => 'IDComercial'),
        array('SourceColumn' => 'IDAgente', 'ParentEntity' => 'Sucursales', 'ParentColumn' => 'IDResponsable'),
        array('SourceColumn' => 'IDAgente', 'ParentEntity' => 'MvtosAlmacen', 'ParentColumn' => 'IDAgente'),
        array('SourceColumn' => 'IDAgente', 'ParentEntity' => 'TraspasosCab', 'ParentColumn' => 'IDAgenteEnvia'),
        array('SourceColumn' => 'IDAgente', 'ParentEntity' => 'TraspasosCab', 'ParentColumn' => 'IDAgenteRecibe'),
    );

    /**
     * GETTERS Y SETTERS
     */
    public function setIDAgente($IDAgente) {
        $this->IDAgente = $IDAgente;
    }

    public function getIDAgente() {
        return $this->IDAgente;
    }

    public function setLogin($Login) {
        $this->Login = $Login;
    }

    public function getLogin() {
        return $this->Login;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function setPassword($Password) {
        $this->Password = $Password;
    }

    public function getPassword() {
        return $this->Password;
    }

    public function setQuien($Quien) {
        $this->Quien = $Quien;
    }

    public function getQuien() {
        return $this->Quien;
    }

    public function setNLogin($NLogin) {
        $this->NLogin = $NLogin;
    }

    public function getNLogin() {
        return $this->NLogin;
    }

    public function setUltimoLogin($UltimoLogin) {
        $this->UltimoLogin = $UltimoLogin;
    }

    public function getUltimoLogin() {
        return $this->UltimoLogin;
    }

    public function setEMail($EMail) {
        $this->EMail = trim($EMail);
    }

    public function getEMail() {
        return $this->EMail;
    }

    public function setActivo($Activo) {
        $this->Activo = $Activo;
    }

    public function getActivo() {
        if (!($this->Activo instanceof ValoresSN))
            $this->Activo = new ValoresSN($this->Activo);
        return $this->Activo;
    }

    public function setIDPerfil($IDPerfil) {
        $this->IDPerfil = $IDPerfil;
    }

    public function getIDPerfil() {
        if (!($this->IDPerfil instanceof Perfiles))
            $this->IDPerfil = new Perfiles($this->IDPerfil);
        return $this->IDPerfil;
    }

    public function setIDEmpresa($IDEmpresa) {
        $this->IDEmpresa = $IDEmpresa;
    }

    public function getIDEmpresa() {
        if (!($this->IDEmpresa instanceof Empresas))
            $this->IDEmpresa = new Empresas($this->IDEmpresa);
        return $this->IDEmpresa;
    }

    public function setIDSucursal($IDSucursal) {
        $this->IDSucursal = $IDSucursal;
    }

    public function getIDSucursal() {
        if (!($this->IDSucursal instanceof Sucursales))
            $this->IDSucursal = new Sucursales($this->IDSucursal);
        return $this->IDSucursal;
    }

    public function setRol($Rol) {
        $this->Rol = $Rol;
    }

    public function getRol() {
        if (!($this->Rol instanceof Roles))
            $this->Rol = new Roles($this->Rol);
        return $this->Rol;
    }

    public function setIDAlmacen($IDAlmacen) {
        $this->IDAlmacen = $IDAlmacen;
    }

    public function getIDAlmacen() {
        if (!($this->IDAlmacen instanceof Almacenes))
            $this->IDAlmacen = new Almacenes($this->IDAlmacen);
        return $this->IDAlmacen;
    }

    public function setRepitePassword($repitePassword) {
        $this->_repitePassword = $repitePassword;
    }

    public function getRepitePassword() {
        return $this->_repitePassword;
    }

    public function getEsComercial() {
        return ($this->Rol == '1');
    }

    public function getEsRepartidor() {
        return ($this->Rol == '2');
    }

    public function getEsAlmacenero() {
        return ($this->Rol == '3');
    }

}

// END class agentes
?>