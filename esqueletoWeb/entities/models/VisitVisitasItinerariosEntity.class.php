<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 26.11.2012 17:23:06
 */

/**
 * @orm:Entity(VisitVisitasItinerarios)
 */
class VisitVisitasItinerariosEntity extends EntityComunes {

    /**
     * @orm GeneratedValue
     * @orm Id
     * @var integer
     * @assert NotBlank(groups="VisitVisitasItinerarios")
     */
    protected $Id;

    /**
     * @var entities\VisitVisitas
     * @assert NotBlank(groups="VisitVisitasItinerarios")
     */
    protected $IdVisita;

    /**
     * @var integer
     * @assert NotBlank(groups="VisitVisitasItinerarios")
     */
    protected $IdUsuario;

    /**
     * @var string
     * @assert NotBlank(groups="VisitVisitasItinerarios")
     */
    protected $Entidad;

    /**
     * @var integer
     * @assert NotBlank(groups="VisitVisitasItinerarios")
     */
    protected $IdEntidad;

    /**
     * @var integer
     * @assert NotBlank(groups="VisitVisitasItinerarios")
     */
    protected $TiempoUnix = '0';

    /**
     * @var integer
     * @assert NotBlank(groups="VisitVisitasItinerarios")
     */
    protected $SegundosVisita = '0';

    /**
     * Nombre de la conexion a la BD
     * @var string
     */
    protected $_conectionName = '';

    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'VisitVisitasItinerarios';

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
    );

    /**
     * Relacion de entidades de las que esta depende
     * @var string
     */
    protected $_childEntities = array(
        'VisitVisitas',
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

    public function setIdVisita($IdVisita) {
        $this->IdVisita = $IdVisita;
    }

    public function getIdVisita() {
        if (!($this->IdVisita instanceof VisitVisitas))
            $this->IdVisita = new VisitVisitas($this->IdVisita);
        return $this->IdVisita;
    }

    public function setIdUsuario($IdUsuario) {
        $this->IdUsuario = $IdUsuario;
    }

    public function getIdUsuario() {
        return $this->IdUsuario;
    }

    public function setEntidad($Entidad) {
        $this->Entidad = trim($Entidad);
    }

    public function getEntidad() {
        return $this->Entidad;
    }

    public function setIdEntidad($IdEntidad) {
        $this->IdEntidad = $IdEntidad;
    }

    public function getIdEntidad() {
        return $this->IdEntidad;
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

}

// END class VisitVisitasItinerarios
?>