<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 26.11.2012 17:23:42
 */

/**
 * @orm:Entity(VisitVisitasTemporal)
 */
class VisitVisitasTemporalEntity extends EntityComunes {

    /**
     * @orm GeneratedValue
     * @orm Id
     * @var integer
     * @assert NotBlank(groups="VisitVisitasTemporal")
     */
    protected $Id;

    /**
     * @var string
     * @assert NotBlank(groups="VisitVisitasTemporal")
     */
    protected $Sesion;

    /**
     * @var integer
     * @assert NotBlank(groups="VisitVisitasTemporal")
     */
    protected $IdUrlAmigable;

    /**
     * @var integer
     * @assert NotBlank(groups="VisitVisitasTemporal")
     */
    protected $TiempoUnix = '0';

    /**
     * Nombre de la conexion a la BD
     * @var string
     */
    protected $_conectionName = '';

    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'VisitVisitasTemporal';

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

    public function setSesion($Sesion) {
        $this->Sesion = trim($Sesion);
    }

    public function getSesion() {
        return $this->Sesion;
    }

    public function setIdUrlAmigable($IdUrlAmigable) {
        $this->IdUrlAmigable = $IdUrlAmigable;
    }

    public function getIdUrlAmigable() {
        return $this->IdUrlAmigable;
    }

    public function setTiempoUnix($TiempoUnix) {
        $this->TiempoUnix = $TiempoUnix;
    }

    public function getTiempoUnix() {
        return $this->TiempoUnix;
    }

}

// END class VisitVisitasTemporal
?>