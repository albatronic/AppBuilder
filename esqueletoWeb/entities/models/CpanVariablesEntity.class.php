<?php
/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 23:55:15
 */

/**
 * @orm:Entity(CpanVariables)
 */
class CpanVariablesEntity extends EntityComunes {
	/**
	 * @orm GeneratedValue
	 * @orm Id
	 * @var integer
	 * @assert NotBlank(groups="CpanVariables")
	 */
	protected $Id;
	/**
	 * @var integer
	 * @assert NotBlank(groups="CpanVariables")
	 */
	protected $IdProyectosApps;
	/**
	 * @var string
	 * @assert NotBlank(groups="CpanVariables")
	 */
	protected $Variable;
	/**
	 * @var string
	 */
	protected $Yml;
	/**
	 * Nombre de la conexion a la BD
	 * @var string
	 */
	protected $_conectionName = '';
	/**
	 * Nombre de la tabla física
	 * @var string
	 */
	protected $_tableName = 'CpanVariables';
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
	public function setId($Id){
		$this->Id = $Id;
	}
	public function getId(){
		return $this->Id;
	}

	public function setIdProyectosApps($IdProyectosApps){
		$this->IdProyectosApps = $IdProyectosApps;
	}
	public function getIdProyectosApps(){
		return $this->IdProyectosApps;
	}

	public function setVariable($Variable){
		$this->Variable = trim($Variable);
	}
	public function getVariable(){
		return $this->Variable;
	}

	public function setYml($Yml){
		$this->Yml = trim($Yml);
	}
	public function getYml(){
		return $this->Yml;
	}

} // END class CpanVariables

?>