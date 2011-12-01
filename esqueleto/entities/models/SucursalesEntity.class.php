<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 20.06.2011 01:42:40
 */

/**
 * @orm:Entity(sucursales)
 */
class SucursalesEntity extends Entity {

    /**
     * @orm:GeneratedValue
     * @orm:IDSucursal
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $IDSucursal;
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $IDEmpresa;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $Nombre = '';
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $Direccion;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $Poblacion;
    /**
     * @orm:Column(type="")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $IDProvincia = '18';
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $CodigoPostal = '0000000000';
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $Telefono;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $Fax;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $EMail;
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $IDResponsable = '0';
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $ContadorEmitidasA = '0';
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $ContadorEmitidasB = '0';
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $ContadorEmitidasAbono = '0';
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $ContadorRecibidasA = '0';
    /**
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="sucursales")
     */
    protected $ContadorRecibidasB = '0';
    /**
     * Nombre de la conexion a la DB
     * @var string
     */
    protected $_conectionName = 'empresas';
    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'sucursales';
    /**
     * Nombre de la primaryKey
     * @var string
     */
    protected $_primaryKeyName = 'IDSucursal';
    /**
     * Relacion de entidades que dependen de esta
     * @var array
     */
    protected $_parentEntities = array(
        array('SourceColumn' => 'IDSucursal', 'ParentEntity' => 'Clientes', 'ParentColumn' => 'IDSucursal'),
        array('SourceColumn' => 'IDSucursal', 'ParentEntity' => 'Articulos', 'ParentColumn' => 'IDSucursal'),
        array('SourceColumn' => 'IDSucursal', 'ParentEntity' => 'AlbaranesCab', 'ParentColumn' => 'IDSucursal'),
    );

    /**
     * GETTERS Y SETTERS
     */
    public function setIDSucursal($IDSucursal) {
        $this->IDSucursal = $IDSucursal;
    }

    public function getIDSucursal() {
        return $this->IDSucursal;
    }

    public function setIDEmpresa($IDEmpresa) {
        $this->IDEmpresa = $IDEmpresa;
    }

    public function getIDEmpresa() {
        if (!$this->IDEmpresa instanceof Empresas)
            $this->IDEmpresa = new Empresas($this->IDEmpresa);
        return $this->IDEmpresa;
    }

    public function setNombre($Nombre) {
        $this->Nombre = trim($Nombre);
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function setDireccion($Direccion) {
        $this->Direccion = trim($Direccion);
    }

    public function getDireccion() {
        return $this->Direccion;
    }

    public function setPoblacion($Poblacion) {
        $this->Poblacion = trim($Poblacion);
    }

    public function getPoblacion() {
        return $this->Poblacion;
    }

    public function setIDProvincia($IDProvincia) {
        $this->IDProvincia = $IDProvincia;
    }

    public function getIDProvincia() {
        if (!($this->IDProvincia instanceof Provincias))
            $this->IDProvincia = new Provincias($this->IDProvincia);
        return $this->IDProvincia;
    }

    public function setCodigoPostal($CodigoPostal) {
        $this->CodigoPostal = trim($CodigoPostal);
    }

    public function getCodigoPostal() {
        return $this->CodigoPostal;
    }

    public function setTelefono($Telefono) {
        $this->Telefono = trim($Telefono);
    }

    public function getTelefono() {
        return $this->Telefono;
    }

    public function setFax($Fax) {
        $this->Fax = trim($Fax);
    }

    public function getFax() {
        return $this->Fax;
    }

    public function setEMail($EMail) {
        $this->EMail = trim($EMail);
    }

    public function getEMail() {
        return $this->EMail;
    }

    public function setIDResponsable($IDResponsable) {
        $this->IDResponsable = $IDResponsable;
    }

    public function getIDResponsable() {
        if (!($this->IDResponsable instanceof Agentes))
            $this->IDResponsable = new Agentes($this->IDResponsable);
        return $this->IDResponsable;
    }

    public function setContadorEmitidasA($ContadorEmitidasA) {
        $this->ContadorEmitidasA = $ContadorEmitidasA;
    }

    public function getContadorEmitidasA() {
        return $this->ContadorEmitidasA;
    }

    public function setContadorEmitidasB($ContadorEmitidasB) {
        $this->ContadorEmitidasB = $ContadorEmitidasB;
    }

    public function getContadorEmitidasB() {
        return $this->ContadorEmitidasB;
    }

    public function setContadorEmitidasAbono($ContadorEmitidasAbono) {
        $this->ContadorEmitidasAbono = $ContadorEmitidasAbono;
    }

    public function getContadorEmitidasAbono() {
        return $this->ContadorEmitidasAbono;
    }

    public function setContadorRecibidasA($ContadorRecibidasA) {
        $this->ContadorRecibidasA = $ContadorRecibidasA;
    }

    public function getContadorRecibidasA() {
        return $this->ContadorRecibidasA;
    }

    public function setContadorRecibidasB($ContadorRecibidasB) {
        $this->ContadorRecibidasB = $ContadorRecibidasB;
    }

    public function getContadorRecibidasB() {
        return $this->ContadorRecibidasB;
    }

}

// END class sucursales
?>