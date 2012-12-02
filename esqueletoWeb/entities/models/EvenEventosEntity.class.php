<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 26.11.2012 17:52:26
 */

/**
 * @orm:Entity(EvenEventos)
 */
class EvenEventosEntity extends EntityComunes {

    /**
     * @orm GeneratedValue
     * @orm Id
     * @var integer
     * @assert NotBlank(groups="EvenEventos")
     */
    protected $Id;

    /**
     * @var string
     * @assert NotBlank(groups="EvenEventos")
     */
    protected $Entidad;

    /**
     * @var integer
     * @assert NotBlank(groups="EvenEventos")
     */
    protected $IdEntidad;

    /**
     * @var date
     * @assert NotBlank(groups="EvenEventos")
     */
    protected $Fecha = '0000-00-00';

    /**
     * @var 
     * @assert NotBlank(groups="EvenEventos")
     */
    protected $HoraInicio = '00:00:00';

    /**
     * @var 
     * @assert NotBlank(groups="EvenEventos")
     */
    protected $HoraFin = '00:00:00';

    /**
     * Nombre de la conexion a la BD
     * @var string
     */
    protected $_conectionName = '';

    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'EvenEventos';

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

    public function setFecha($Fecha) {
        $date = new Fecha($Fecha);
        $this->Fecha = $date->getFecha();
        unset($date);
    }

    public function getFecha() {
        $date = new Fecha($this->Fecha);
        $ddmmaaaa = $date->getddmmaaaa();
        unset($date);
        return $ddmmaaaa;
    }

    public function setHoraInicio($HoraInicio) {
        $this->HoraInicio = $HoraInicio;
    }

    public function getHoraInicio() {
        return $this->HoraInicio;
    }

    public function setHoraFin($HoraFin) {
        $this->HoraFin = $HoraFin;
    }

    public function getHoraFin() {
        return $this->HoraFin;
    }

}

// END class EvenEventos
?>