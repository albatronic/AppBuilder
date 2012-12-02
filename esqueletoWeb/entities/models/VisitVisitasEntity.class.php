<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 26.11.2012 17:22:25
 */

/**
 * @orm:Entity(VisitVisitas)
 */
class VisitVisitasEntity extends EntityComunes {

    /**
     * @orm GeneratedValue
     * @orm Id
     * @var integer
     * @assert NotBlank(groups="VisitVisitas")
     */
    protected $Id;

    /**
     * @var string
     * @assert NotBlank(groups="VisitVisitas")
     */
    protected $Sesion;

    /**
     * @var integer
     * @assert NotBlank(groups="VisitVisitas")
     */
    protected $TiempoUnix = '0';

    /**
     * @var integer
     * @assert NotBlank(groups="VisitVisitas")
     */
    protected $SegundosVisita = '0';

    /**
     * @var integer
     * @assert NotBlank(groups="VisitVisitas")
     */
    protected $NClicks = '0';

    /**
     * @var integer
     * @assert NotBlank(groups="VisitVisitas")
     */
    protected $NUrlsUnicas = '0';

    /**
     * @var string
     */
    protected $Host;

    /**
     * @var string
     * @assert NotBlank(groups="VisitVisitas")
     */
    protected $IpAddress;

    /**
     * @var string
     */
    protected $CodigoPais;

    /**
     * @var string
     */
    protected $NombrePais;

    /**
     * @var string
     */
    protected $CodigoRegion;

    /**
     * @var string
     */
    protected $NombreRegion;

    /**
     * @var string
     */
    protected $Ciudad;

    /**
     * @var string
     */
    protected $CodigoPostal;

    /**
     * @var integer
     */
    protected $Latitud = '0';

    /**
     * @var integer
     */
    protected $Longitud = '0';

    /**
     * @var string
     */
    protected $ISP;

    /**
     * @var string
     */
    protected $Organizacion;

    /**
     * @var string
     */
    protected $UrlOrigen;

    /**
     * @var string
     */
    protected $q;

    /**
     * @var string
     */
    protected $Browser;

    /**
     * @var string
     */
    protected $BrowserVersion;

    /**
     * @var string
     */
    protected $Platform;

    /**
     * @var string
     */
    protected $UserAgent;

    /**
     * @var tinyint
     * @assert NotBlank(groups="VisitVisitas")
     */
    protected $IsMobile = '0';

    /**
     * @var tinyint
     * @assert NotBlank(groups="VisitVisitas")
     */
    protected $IsRobot = '0';

    /**
     * @var tinyint
     * @assert NotBlank(groups="VisitVisitas")
     */
    protected $IsAol = '0';

    /**
     * @var string
     */
    protected $AolVersion;

    /**
     * @var tinyint
     * @assert NotBlank(groups="VisitVisitas")
     */
    protected $IsChromeFrame = '0';

    /**
     * @var string
     */
    protected $Resolution;

    /**
     * Nombre de la conexion a la BD
     * @var string
     */
    protected $_conectionName = '';

    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'VisitVisitas';

    /**
     * Nombre de la PrimaryKey
     * @var string
     */
    protected $_primaryKeyName = 'Id';

    /**
     * Relacion de entidades que dependen de esta
     * @var string
     */
    protected $_parentEntities = array(
        array('SourceColumn' => 'Id', 'ParentEntity' => 'VisitVisitasItinerarios', 'ParentColumn' => 'IdVisita'),
    );

    /**
     * Relacion de entidades de las que esta depende
     * @var string
     */
    protected $_childEntities = array(
        'ValoresSN',
        'ValoresPrivacy',
        'ValoresDchaIzq',
        'ValoresChangeFreq',
        'RequestMethods',
        'RequestOrigins',
        'CpanAplicaciones',
    );

    /**
     * GETTERS Y SETTERS
     */
    public function setId($Id) {
        $this->Id = $Id;
    }

    public function getId() {
        return $this->Id;
    }

    public function setSesion($Sesion) {
        $this->Sesion = trim($Sesion);
    }

    public function getSesion() {
        return $this->Sesion;
    }

    public function setTiempoUnix($TiempoUnix) {
        $this->TiempoUnix = $TiempoUnix;
    }

    public function getTiempoUnix() {
        return $this->TiempoUnix;
    }

    public function setSegundosVisita($SegundosVisita) {
        $this->SegundosVisita = $SegundosVisita;
    }

    public function getSegundosVisita() {
        return $this->SegundosVisita;
    }

    public function setNClicks($NClicks) {
        $this->NClicks = $NClicks;
    }

    public function getNClicks() {
        return $this->NClicks;
    }

    public function setNUrlsUnicas($NUrlsUnicas) {
        $this->NUrlsUnicas = $NUrlsUnicas;
    }

    public function getNUrlsUnicas() {
        return $this->NUrlsUnicas;
    }

    public function setHost($Host) {
        $this->Host = trim($Host);
    }

    public function getHost() {
        return $this->Host;
    }

    public function setIpAddress($IpAddress) {
        $this->IpAddress = trim($IpAddress);
    }

    public function getIpAddress() {
        return $this->IpAddress;
    }

    public function setCodigoPais($CodigoPais) {
        $this->CodigoPais = trim($CodigoPais);
    }

    public function getCodigoPais() {
        return $this->CodigoPais;
    }

    public function setNombrePais($NombrePais) {
        $this->NombrePais = trim($NombrePais);
    }

    public function getNombrePais() {
        return $this->NombrePais;
    }

    public function setCodigoRegion($CodigoRegion) {
        $this->CodigoRegion = trim($CodigoRegion);
    }

    public function getCodigoRegion() {
        return $this->CodigoRegion;
    }

    public function setNombreRegion($NombreRegion) {
        $this->NombreRegion = trim($NombreRegion);
    }

    public function getNombreRegion() {
        return $this->NombreRegion;
    }

    public function setCiudad($Ciudad) {
        $this->Ciudad = trim($Ciudad);
    }

    public function getCiudad() {
        return $this->Ciudad;
    }

    public function setCodigoPostal($CodigoPostal) {
        $this->CodigoPostal = trim($CodigoPostal);
    }

    public function getCodigoPostal() {
        return $this->CodigoPostal;
    }

    public function setLatitud($Latitud) {
        $this->Latitud = $Latitud;
    }

    public function getLatitud() {
        return $this->Latitud;
    }

    public function setLongitud($Longitud) {
        $this->Longitud = $Longitud;
    }

    public function getLongitud() {
        return $this->Longitud;
    }

    public function setISP($ISP) {
        $this->ISP = trim($ISP);
    }

    public function getISP() {
        return $this->ISP;
    }

    public function setOrganizacion($Organizacion) {
        $this->Organizacion = trim($Organizacion);
    }

    public function getOrganizacion() {
        return $this->Organizacion;
    }

    public function setUrlOrigen($UrlOrigen) {
        $this->UrlOrigen = trim($UrlOrigen);
    }

    public function getUrlOrigen() {
        return $this->UrlOrigen;
    }

    public function setq($q) {
        $this->q = trim($q);
    }

    public function getq() {
        return $this->q;
    }

    public function setBrowser($Browser) {
        $this->Browser = trim($Browser);
    }

    public function getBrowser() {
        return $this->Browser;
    }

    public function setBrowserVersion($BrowserVersion) {
        $this->BrowserVersion = trim($BrowserVersion);
    }

    public function getBrowserVersion() {
        return $this->BrowserVersion;
    }

    public function setPlatform($Platform) {
        $this->Platform = trim($Platform);
    }

    public function getPlatform() {
        return $this->Platform;
    }

    public function setUserAgent($UserAgent) {
        $this->UserAgent = trim($UserAgent);
    }

    public function getUserAgent() {
        return $this->UserAgent;
    }

    public function setIsMobile($IsMobile) {
        $this->IsMobile = $IsMobile;
    }

    public function getIsMobile() {
        if (!($this->IsMobile instanceof ValoresSN))
            $this->IsMobile = new ValoresSN($this->IsMobile);
        return $this->IsMobile;
    }

    public function setIsRobot($IsRobot) {
        $this->IsRobot = $IsRobot;
    }

    public function getIsRobot() {
        if (!($this->IsRobot instanceof ValoresSN))
            $this->IsRobot = new ValoresSN($this->IsRobot);
        return $this->IsRobot;
    }

    public function setIsAol($IsAol) {
        $this->IsAol = $IsAol;
    }

    public function getIsAol() {
        if (!($this->IsAol instanceof ValoresSN))
            $this->IsAol = new ValoresSN($this->IsAol);
        return $this->IsAol;
    }

    public function setAolVersion($AolVersion) {
        $this->AolVersion = trim($AolVersion);
    }

    public function getAolVersion() {
        return $this->AolVersion;
    }

    public function setIsChromeFrame($IsChromeFrame) {
        $this->IsChromeFrame = $IsChromeFrame;
    }

    public function getIsChromeFrame() {
        if (!($this->IsChromeFrame instanceof ValoresSN))
            $this->IsChromeFrame = new ValoresSN($this->IsChromeFrame);
        return $this->IsChromeFrame;
    }

    public function setResolution($Resolution) {
        $this->Resolution = trim($Resolution);
    }

    public function getResolution() {
        return $this->Resolution;
    }

}

// END class VisitVisitas
?>