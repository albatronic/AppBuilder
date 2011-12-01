<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 12.06.2011 19:20:36
 */

/**
 * @orm:Entity(empresas)
 */
class EmpresasEntity extends Entity {

    /**
     * @orm:GeneratedValue
     * @orm:Id
     * @orm:Column(type="integer")
     * @assert:NotBlank(groups="empresas")
     */
    protected $IDEmpresa;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="empresas")
     */
    protected $RazonSocial = '';
    /**
     * @orm:Column(type="string")
     */
    protected $Cif;
    /**
     * @orm:Column(type="string")
     */
    protected $Direccion;
    /**
     * @orm:Column(type="string")
     */
    protected $Poblacion;
    /**
     * @orm:Column(type="")
     * @assert:NotBlank(groups="empresas")
     */
    protected $IDProvincia = '18';
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="empresas")
     */
    protected $CodigoPostal = '0000000000';
    /**
     * @orm:Column(type="string")
     */
    protected $Telefono;
    /**
     * @orm:Column(type="string")
     */
    protected $Fax;
    /**
     * @orm:Column(type="string")
     */
    protected $EMail;
    /**
     * @orm:Column(type="string")
     */
    protected $Web;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="empresas")
     */
    protected $IDBanco = '0000';
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="empresas")
     */
    protected $IDOficina = '0000';
    /**
     * @orm:Column(type="")
     * @assert:NotBlank(groups="empresas")
     */
    protected $Digito = '00';
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="empresas")
     */
    protected $Cuenta = '0000000000';
    /**
     * @orm:Column(type="")
     * @assert:NotBlank(groups="empresas")
     */
    protected $Sufijo = '000';
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="empresas")
     */
    protected $ServidorDatos;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="empresas")
     */
    protected $BaseDatos;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="empresas")
     */
    protected $UsuarioDatos;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="empresas")
     */
    protected $PasswordDatos;
    /**
     * @orm:Column(type="")
     * @assert:NotBlank(groups="empresas")
     */
    protected $Version = 'ESTANDAR';
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="empresas")
     */
    protected $RegistroMercantil;
    /**
     * @orm:Column(type="string")
     * @assert:NotBlank(groups="empresas")
     */
    protected $EORI;
    /**
     * Nombre de la conexion a la DB
     * @var string
     */
    protected $_conectionName = 'empresas';
    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'empresas';
    /**
     * Nombre de la primaryKey
     * @var string
     */
    protected $_primaryKeyName = 'IDEmpresa';
    /**
     * Relacion de entidades que dependen de esta
     * @var array
     */
    protected $_parentEntities = array(
        array('SourceColumn' => 'IDEmpresa', 'ParentEntity' => 'Sucursales', 'ParentColumn' => 'IDEmpresa'),
    );

    /**
     * GETTERS Y SETTERS
     */
    public function setIDEmpresa($IDEmpresa) {
        $this->IDEmpresa = $IDEmpresa;
    }

    public function getIDEmpresa() {
        return $this->IDEmpresa;
    }

    public function setRazonSocial($RazonSocial) {
        $this->RazonSocial = $RazonSocial;
    }

    public function getRazonSocial() {
        return $this->RazonSocial;
    }

    public function setCif($Cif) {
        $this->Cif = $Cif;
    }

    public function getCif() {
        return $this->Cif;
    }

    public function setDireccion($Direccion) {
        $this->Direccion = $Direccion;
    }

    public function getDireccion() {
        return $this->Direccion;
    }

    public function setPoblacion($Poblacion) {
        $this->Poblacion = $Poblacion;
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
        $this->CodigoPostal = $CodigoPostal;
    }

    public function getCodigoPostal() {
        return $this->CodigoPostal;
    }

    public function setTelefono($Telefono) {
        $this->Telefono = $Telefono;
    }

    public function getTelefono() {
        return $this->Telefono;
    }

    public function setFax($Fax) {
        $this->Fax = $Fax;
    }

    public function getFax() {
        return $this->Fax;
    }

    public function setEMail($EMail) {
        $this->EMail = $EMail;
    }

    public function getEMail() {
        return $this->EMail;
    }

    public function setWeb($Web) {
        $this->Web = $Web;
    }

    public function getWeb() {
        return $this->Web;
    }

    public function setIDBanco($IDBanco) {
        $this->IDBanco = $IDBanco;
    }

    public function getIDBanco() {
        return $this->IDBanco;
    }

    public function setIDOficina($IDOficina) {
        $this->IDOficina = $IDOficina;
    }

    public function getIDOficina() {
        return $this->IDOficina;
    }

    public function setDigito($Digito) {
        $this->Digito = $Digito;
    }

    public function getDigito() {
        return $this->Digito;
    }

    public function setCuenta($Cuenta) {
        $this->Cuenta = $Cuenta;
    }

    public function getCuenta() {
        return $this->Cuenta;
    }

    public function setSufijo($Sufijo) {
        $this->Sufijo = $Sufijo;
    }

    public function getSufijo() {
        return $this->Sufijo;
    }

    public function setServidorDatos($ServidorDatos) {
        $this->ServidorDatos = $ServidorDatos;
    }

    public function getServidorDatos() {
        return $this->ServidorDatos;
    }

    public function setBaseDatos($BaseDatos) {
        $this->BaseDatos = $BaseDatos;
    }

    public function getBaseDatos() {
        return $this->BaseDatos;
    }

    public function setUsuarioDatos($UsuarioDatos) {
        $this->UsuarioDatos = $UsuarioDatos;
    }

    public function getUsuarioDatos() {
        return $this->UsuarioDatos;
    }

    public function setPasswordDatos($PasswordDatos) {
        $this->PasswordDatos = $PasswordDatos;
    }

    public function getPasswordDatos() {
        return $this->PasswordDatos;
    }

    public function setVersion($Version) {
        $this->Version = $Version;
    }

    public function getVersion() {
        return $this->Version;
    }

    public function setRegistroMercantil($RegistroMercantil) {
        $this->RegistroMercantil = $RegistroMercantil;
    }

    public function getRegistroMercantil() {
        return $this->RegistroMercantil;
    }

    public function setEORI($EORI) {
        $this->EORI = $EORI;
    }

    public function getEORI() {
        return $this->EORI;
    }

}

// END class empresas
?>