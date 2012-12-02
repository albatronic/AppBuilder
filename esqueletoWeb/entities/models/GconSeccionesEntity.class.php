<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 30.10.2012 18:44:57
 */

/**
 * @orm:Entity(GconSecciones)
 */
class GconSeccionesEntity extends EntityComunes {

    /**
     * @orm GeneratedValue
     * @orm Id
     * @var integer
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $Id;

    /**
     * @var string
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $Titulo;

    /**
     * @var string
     */
    protected $Subtitulo;

    /**
     * @var string
     */
    protected $Introduccion;

    /**
     * @var entities\ValoresSN
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $MostrarTitulo = '1';

    /**
     * @var entities\ValoresSN
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $MostrarSubtitulo = '1';

    /**
     * @var entities\ValoresSN
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $MostrarIntroduccion = '1';

    /**
     * @var entities\ValoresSN
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $MostrarEnMenu1 = '1';

    /**
     * @var entities\ValoresSN
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $MostrarEnMenu2 = '0';

    /**
     * @var entities\ValoresSN
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $MostrarEnMenu3 = '0';

    /**
     * @var entities\ValoresSN
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $MostrarEnMenu4 = '0';

    /**
     * @var entities\ValoresSN
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $MostrarEnMenu5 = '0';

    /**
     * @var string
     */
    protected $EtiquetaWeb1;

    /**
     * @var string
     */
    protected $EtiquetaWeb2;

    /**
     * @var string
     */
    protected $EtiquetaWeb3;

    /**
     * @var string
     */
    protected $EtiquetaWeb4;

    /**
     * @var string
     */
    protected $EtiquetaWeb5;

    /**
     * @var integer
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $OrdenMenu1 = '0';

    /**
     * @var integer
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $OrdenMenu2 = '0';

    /**
     * @var integer
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $OrdenMenu3 = '0';

    /**
     * @var integer
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $OrdenMenu4 = '0';

    /**
     * @var integer
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $OrdenMenu5 = '0';

    /**
     * @var entities\ModosMostrarContenidos
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $ModoMostrarContenidos = '0';

    /**
     * @var entities\CriteriosOrdenContenidosHijos
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $CriterioOrdenContenidosHijos = 'SortOrder ASC';

    /**
     * @var entities\ValoresSN
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $MostrarSubsecciones = '1';

    /**
     * @var integer
     * @assert NotBlank(groups="GconSecciones")
     */
    protected $NivelJerarquico = '1';

    /**
     * Nombre de la conexion a la BD
     * @var string
     */
    protected $_conectionName = '';

    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'GconSecciones';

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
        array('SourceColumn' => 'Id', 'ParentEntity' => 'GconContenidos', 'ParentColumn' => 'IdSeccion'),
    );

    /**
     * Relacion de entidades de las que esta depende
     * @var string
     */
    protected $_childEntities = array(
        'ValoresSN',
        'ModosMostrarContenidos',
        'CriteriosOrdenContenidosHijos',
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

    public function setTitulo($Titulo) {
        $this->Titulo = trim($Titulo);
    }

    public function getTitulo() {
        return $this->Titulo;
    }

    public function setSubtitulo($Subtitulo) {
        $this->Subtitulo = trim($Subtitulo);
    }

    public function getSubtitulo() {
        return $this->Subtitulo;
    }

    public function setIntroduccion($Introduccion) {
        $this->Introduccion = trim($Introduccion);
    }

    public function getIntroduccion() {
        return $this->Introduccion;
    }

    public function setMostrarTitulo($MostrarTitulo) {
        $this->MostrarTitulo = $MostrarTitulo;
    }

    public function getMostrarTitulo() {
        if (!($this->MostrarTitulo instanceof ValoresSN))
            $this->MostrarTitulo = new ValoresSN($this->MostrarTitulo);
        return $this->MostrarTitulo;
    }

    public function setMostrarSubtitulo($MostrarSubtitulo) {
        $this->MostrarSubtitulo = $MostrarSubtitulo;
    }

    public function getMostrarSubtitulo() {
        if (!($this->MostrarSubtitulo instanceof ValoresSN))
            $this->MostrarSubtitulo = new ValoresSN($this->MostrarSubtitulo);
        return $this->MostrarSubtitulo;
    }

    public function setMostrarIntroduccion($MostrarIntroduccion) {
        $this->MostrarIntroduccion = $MostrarIntroduccion;
    }

    public function getMostrarIntroduccion() {
        if (!($this->MostrarIntroduccion instanceof ValoresSN))
            $this->MostrarIntroduccion = new ValoresSN($this->MostrarIntroduccion);
        return $this->MostrarIntroduccion;
    }

    public function setMostrarEnMenu1($MostrarEnMenu1) {
        $this->MostrarEnMenu1 = $MostrarEnMenu1;
    }

    public function getMostrarEnMenu1() {
        if (!($this->MostrarEnMenu1 instanceof ValoresSN))
            $this->MostrarEnMenu1 = new ValoresSN($this->MostrarEnMenu1);
        return $this->MostrarEnMenu1;
    }

    public function setMostrarEnMenu2($MostrarEnMenu2) {
        $this->MostrarEnMenu2 = $MostrarEnMenu2;
    }

    public function getMostrarEnMenu2() {
        if (!($this->MostrarEnMenu2 instanceof ValoresSN))
            $this->MostrarEnMenu2 = new ValoresSN($this->MostrarEnMenu2);
        return $this->MostrarEnMenu2;
    }

    public function setMostrarEnMenu3($MostrarEnMenu3) {
        $this->MostrarEnMenu3 = $MostrarEnMenu3;
    }

    public function getMostrarEnMenu3() {
        if (!($this->MostrarEnMenu3 instanceof ValoresSN))
            $this->MostrarEnMenu3 = new ValoresSN($this->MostrarEnMenu3);
        return $this->MostrarEnMenu3;
    }

    public function setMostrarEnMenu4($MostrarEnMenu4) {
        $this->MostrarEnMenu4 = $MostrarEnMenu4;
    }

    public function getMostrarEnMenu4() {
        if (!($this->MostrarEnMenu4 instanceof ValoresSN))
            $this->MostrarEnMenu4 = new ValoresSN($this->MostrarEnMenu4);
        return $this->MostrarEnMenu4;
    }

    public function setMostrarEnMenu5($MostrarEnMenu5) {
        $this->MostrarEnMenu5 = $MostrarEnMenu5;
    }

    public function getMostrarEnMenu5() {
        if (!($this->MostrarEnMenu5 instanceof ValoresSN))
            $this->MostrarEnMenu5 = new ValoresSN($this->MostrarEnMenu5);
        return $this->MostrarEnMenu5;
    }

    public function setEtiquetaWeb1($EtiquetaWeb1) {
        $this->EtiquetaWeb1 = trim($EtiquetaWeb1);
    }

    public function getEtiquetaWeb1() {
        return $this->EtiquetaWeb1;
    }

    public function setEtiquetaWeb2($EtiquetaWeb2) {
        $this->EtiquetaWeb2 = trim($EtiquetaWeb2);
    }

    public function getEtiquetaWeb2() {
        return $this->EtiquetaWeb2;
    }

    public function setEtiquetaWeb3($EtiquetaWeb3) {
        $this->EtiquetaWeb3 = trim($EtiquetaWeb3);
    }

    public function getEtiquetaWeb3() {
        return $this->EtiquetaWeb3;
    }

    public function setEtiquetaWeb4($EtiquetaWeb4) {
        $this->EtiquetaWeb4 = trim($EtiquetaWeb4);
    }

    public function getEtiquetaWeb4() {
        return $this->EtiquetaWeb4;
    }

    public function setEtiquetaWeb5($EtiquetaWeb5) {
        $this->EtiquetaWeb5 = trim($EtiquetaWeb5);
    }

    public function getEtiquetaWeb5() {
        return $this->EtiquetaWeb5;
    }

    public function setOrdenMenu1($OrdenMenu1) {
        $this->OrdenMenu1 = $OrdenMenu1;
    }

    public function getOrdenMenu1() {
        return $this->OrdenMenu1;
    }

    public function setOrdenMenu2($OrdenMenu2) {
        $this->OrdenMenu2 = $OrdenMenu2;
    }

    public function getOrdenMenu2() {
        return $this->OrdenMenu2;
    }

    public function setOrdenMenu3($OrdenMenu3) {
        $this->OrdenMenu3 = $OrdenMenu3;
    }

    public function getOrdenMenu3() {
        return $this->OrdenMenu3;
    }

    public function setOrdenMenu4($OrdenMenu4) {
        $this->OrdenMenu4 = $OrdenMenu4;
    }

    public function getOrdenMenu4() {
        return $this->OrdenMenu4;
    }

    public function setOrdenMenu5($OrdenMenu5) {
        $this->OrdenMenu5 = $OrdenMenu5;
    }

    public function getOrdenMenu5() {
        return $this->OrdenMenu5;
    }

    public function setModoMostrarContenidos($ModoMostrarContenidos) {
        $this->ModoMostrarContenidos = $ModoMostrarContenidos;
    }

    public function getModoMostrarContenidos() {
        if (!($this->ModoMostrarContenidos instanceof ModosMostrarContenidos))
            $this->ModoMostrarContenidos = new ModosMostrarContenidos($this->ModoMostrarContenidos);
        return $this->ModoMostrarContenidos;
    }

    public function setCriterioOrdenContenidosHijos($CriterioOrdenContenidosHijos) {
        $this->CriterioOrdenContenidosHijos = trim($CriterioOrdenContenidosHijos);
    }

    public function getCriterioOrdenContenidosHijos() {
        if (!($this->CriterioOrdenContenidosHijos instanceof CriteriosOrdenContenidosHijos))
            $this->CriterioOrdenContenidosHijos = new CriteriosOrdenContenidosHijos($this->CriterioOrdenContenidosHijos);
        return $this->CriterioOrdenContenidosHijos;
    }

    public function setMostrarSubsecciones($MostrarSubsecciones) {
        $this->MostrarSubsecciones = $MostrarSubsecciones;
    }

    public function getMostrarSubsecciones() {
        if (!($this->MostrarSubsecciones instanceof ValoresSN))
            $this->MostrarSubsecciones = new ValoresSN($this->MostrarSubsecciones);
        return $this->MostrarSubsecciones;
    }

    public function setNivelJerarquico($NivelJerarquico) {
        $this->NivelJerarquico = $NivelJerarquico;
    }

    public function getNivelJerarquico() {
        return $this->NivelJerarquico;
    }

}

// END class GconSecciones
?>