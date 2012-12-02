<?php
/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 23:55:15
 */

/**
 * @orm:Entity(GconContenidosRelacionados)
 */
class GconContenidosRelacionadosEntity extends EntityComunes {
	/**
	 * @orm GeneratedValue
	 * @orm Id
	 * @var integer
	 * @assert NotBlank(groups="GconContenidosRelacionados")
	 */
	protected $Id;
	/**
	 * @var integer
	 * @assert NotBlank(groups="GconContenidosRelacionados")
	 */
	protected $IdOrigen;
	/**
	 * @var integer
	 * @assert NotBlank(groups="GconContenidosRelacionados")
	 */
	protected $IdRelacionado;
	/**
	 * Nombre de la conexion a la BD
	 * @var string
	 */
	protected $_conectionName = '';
	/**
	 * Nombre de la tabla física
	 * @var string
	 */
	protected $_tableName = 'GconContenidosRelacionados';
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

	public function setIdOrigen($IdOrigen){
		$this->IdOrigen = $IdOrigen;
	}
	public function getIdOrigen(){
		return $this->IdOrigen;
	}

	public function setIdRelacionado($IdRelacionado){
		$this->IdRelacionado = $IdRelacionado;
	}
	public function getIdRelacionado(){
		return $this->IdRelacionado;
	}

} // END class GconContenidosRelacionados

?>