<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 23:55:15
 */

/**
 * @orm:Entity(CpanUrlAmigables)
 */
class CpanUrlAmigablesEntity extends EntityComunes {

    /**
     * @orm GeneratedValue
     * @orm Id
     * @var integer
     * @assert NotBlank(groups="CpanUrlAmigables")
     */
    protected $Id;

    /**
     * @var string
     * @assert NotBlank(groups="CpanUrlAmigables")
     */
    protected $Controller;

    /**
     * @var string
     * @assert NotBlank(groups="CpanUrlAmigables")
     */
    protected $Action;

    /**
     * @var string
     */
    protected $Template;

    /**
     * @var string
     */
    protected $Parameters;

    /**
     * @var string
     * @assert NotBlank(groups="CpanUrlAmigables")
     */
    protected $Entity;

    /**
     * @var integer
     * @assert NotBlank(groups="CpanUrlAmigables")
     */
    protected $IdEntity;

    /**
     * Nombre de la conexion a la BD
     * @var string
     */
    protected $_conectionName = '';

    /**
     * Nombre de la tabla física
     * @var string
     */
    protected $_tableName = 'CpanUrlAmigables';

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

    public function setController($Controller) {
        $this->Controller = trim($Controller);
    }

    public function getController() {
        return $this->Controller;
    }

    public function setAction($Action) {
        $this->Action = trim($Action);
    }

    public function getAction() {
        return $this->Action;
    }

    public function setTemplate($Template) {
        $this->Template = trim($Template);
    }

    public function getTemplate() {
        return $this->Template;
    }

    public function setParameters($Parameters) {
        $this->Parameters = trim($Parameters);
    }

    public function getParameters() {
        return $this->Parameters;
    }

    public function setEntity($Entity) {
        $this->Entity = trim($Entity);
    }

    public function getEntity() {
        return $this->Entity;
    }

    public function setIdEntity($IdEntity) {
        $this->IdEntity = $IdEntity;
    }

    public function getIdEntity() {
        return $this->IdEntity;
    }

}

// END class CpanUrlAmigables
?>