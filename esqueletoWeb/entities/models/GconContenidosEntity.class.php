<?php
/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 23:55:15
 */

/**
 * @orm:Entity(GconContenidos)
 */
class GconContenidosEntity extends EntityComunes {
	/**
	 * @orm GeneratedValue
	 * @orm Id
	 * @var integer
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $Id;
	/**
	 * @var entities\GconSecciones
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $IdSeccion;
	/**
	 * @var string
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $Titulo;
	/**
	 * @var string
	 */
	protected $Subtitulo;
	/**
	 * @var string
	 */
	protected $Resumen;
	/**
	 * @var string
	 */
	protected $Desarrollo;
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $MostrarTituloPortada = '1';
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $MostrarTituloContenido = '1';
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $MostrarSubtituloPortada = '1';
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $MostrarSubtituloContenido = '1';
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $MostrarResumenPortada = '1';
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $MostrarResumenContenido = '1';
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $BlogPublicar = '0';
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $BlogMostrarEnPortada = '1';
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $BlogPermitirComentarios = '0';
	/**
	 * @var integer
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $BlogOrden = '0';
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $NoticiaPublicar = '0';
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $NoticiaMostrarEnPortada = '1';
	/**
	 * @var integer
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $NoticiaOrden = '0';
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="GconContenidos")
	 */
	protected $EsEvento = '0';
	/**
	 * Nombre de la conexion a la BD
	 * @var string
	 */
	protected $_conectionName = '';
	/**
	 * Nombre de la tabla física
	 * @var string
	 */
	protected $_tableName = 'GconContenidos';
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
			'GconSecciones',
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

	public function setIdSeccion($IdSeccion){
		$this->IdSeccion = $IdSeccion;
	}
	public function getIdSeccion(){
		if (!($this->IdSeccion instanceof GconSecciones))
			$this->IdSeccion = new GconSecciones($this->IdSeccion);
		return $this->IdSeccion;
	}

	public function setTitulo($Titulo){
		$this->Titulo = trim($Titulo);
	}
	public function getTitulo(){
		return $this->Titulo;
	}

	public function setSubtitulo($Subtitulo){
		$this->Subtitulo = trim($Subtitulo);
	}
	public function getSubtitulo(){
		return $this->Subtitulo;
	}

	public function setResumen($Resumen){
		$this->Resumen = trim($Resumen);
	}
	public function getResumen(){
		return $this->Resumen;
	}

	public function setDesarrollo($Desarrollo){
		$this->Desarrollo = trim($Desarrollo);
	}
	public function getDesarrollo(){
		return $this->Desarrollo;
	}

	public function setMostrarTituloPortada($MostrarTituloPortada){
		$this->MostrarTituloPortada = $MostrarTituloPortada;
	}
	public function getMostrarTituloPortada(){
		if (!($this->MostrarTituloPortada instanceof ValoresSN))
			$this->MostrarTituloPortada = new ValoresSN($this->MostrarTituloPortada);
		return $this->MostrarTituloPortada;
	}

	public function setMostrarTituloContenido($MostrarTituloContenido){
		$this->MostrarTituloContenido = $MostrarTituloContenido;
	}
	public function getMostrarTituloContenido(){
		if (!($this->MostrarTituloContenido instanceof ValoresSN))
			$this->MostrarTituloContenido = new ValoresSN($this->MostrarTituloContenido);
		return $this->MostrarTituloContenido;
	}

	public function setMostrarSubtituloPortada($MostrarSubtituloPortada){
		$this->MostrarSubtituloPortada = $MostrarSubtituloPortada;
	}
	public function getMostrarSubtituloPortada(){
		if (!($this->MostrarSubtituloPortada instanceof ValoresSN))
			$this->MostrarSubtituloPortada = new ValoresSN($this->MostrarSubtituloPortada);
		return $this->MostrarSubtituloPortada;
	}

	public function setMostrarSubtituloContenido($MostrarSubtituloContenido){
		$this->MostrarSubtituloContenido = $MostrarSubtituloContenido;
	}
	public function getMostrarSubtituloContenido(){
		if (!($this->MostrarSubtituloContenido instanceof ValoresSN))
			$this->MostrarSubtituloContenido = new ValoresSN($this->MostrarSubtituloContenido);
		return $this->MostrarSubtituloContenido;
	}

	public function setMostrarResumenPortada($MostrarResumenPortada){
		$this->MostrarResumenPortada = $MostrarResumenPortada;
	}
	public function getMostrarResumenPortada(){
		if (!($this->MostrarResumenPortada instanceof ValoresSN))
			$this->MostrarResumenPortada = new ValoresSN($this->MostrarResumenPortada);
		return $this->MostrarResumenPortada;
	}

	public function setMostrarResumenContenido($MostrarResumenContenido){
		$this->MostrarResumenContenido = $MostrarResumenContenido;
	}
	public function getMostrarResumenContenido(){
		if (!($this->MostrarResumenContenido instanceof ValoresSN))
			$this->MostrarResumenContenido = new ValoresSN($this->MostrarResumenContenido);
		return $this->MostrarResumenContenido;
	}

	public function setBlogPublicar($BlogPublicar){
		$this->BlogPublicar = $BlogPublicar;
	}
	public function getBlogPublicar(){
		if (!($this->BlogPublicar instanceof ValoresSN))
			$this->BlogPublicar = new ValoresSN($this->BlogPublicar);
		return $this->BlogPublicar;
	}

	public function setBlogMostrarEnPortada($BlogMostrarEnPortada){
		$this->BlogMostrarEnPortada = $BlogMostrarEnPortada;
	}
	public function getBlogMostrarEnPortada(){
		if (!($this->BlogMostrarEnPortada instanceof ValoresSN))
			$this->BlogMostrarEnPortada = new ValoresSN($this->BlogMostrarEnPortada);
		return $this->BlogMostrarEnPortada;
	}

	public function setBlogPermitirComentarios($BlogPermitirComentarios){
		$this->BlogPermitirComentarios = $BlogPermitirComentarios;
	}
	public function getBlogPermitirComentarios(){
		if (!($this->BlogPermitirComentarios instanceof ValoresSN))
			$this->BlogPermitirComentarios = new ValoresSN($this->BlogPermitirComentarios);
		return $this->BlogPermitirComentarios;
	}

	public function setBlogOrden($BlogOrden){
		$this->BlogOrden = $BlogOrden;
	}
	public function getBlogOrden(){
		return $this->BlogOrden;
	}

	public function setNoticiaPublicar($NoticiaPublicar){
		$this->NoticiaPublicar = $NoticiaPublicar;
	}
	public function getNoticiaPublicar(){
		if (!($this->NoticiaPublicar instanceof ValoresSN))
			$this->NoticiaPublicar = new ValoresSN($this->NoticiaPublicar);
		return $this->NoticiaPublicar;
	}

	public function setNoticiaMostrarEnPortada($NoticiaMostrarEnPortada){
		$this->NoticiaMostrarEnPortada = $NoticiaMostrarEnPortada;
	}
	public function getNoticiaMostrarEnPortada(){
		if (!($this->NoticiaMostrarEnPortada instanceof ValoresSN))
			$this->NoticiaMostrarEnPortada = new ValoresSN($this->NoticiaMostrarEnPortada);
		return $this->NoticiaMostrarEnPortada;
	}

	public function setNoticiaOrden($NoticiaOrden){
		$this->NoticiaOrden = $NoticiaOrden;
	}
	public function getNoticiaOrden(){
		return $this->NoticiaOrden;
	}

	public function setEsEvento($EsEvento){
		$this->EsEvento = $EsEvento;
	}
	public function getEsEvento(){
		if (!($this->EsEvento instanceof ValoresSN))
			$this->EsEvento = new ValoresSN($this->EsEvento);
		return $this->EsEvento;
	}

} // END class GconContenidos

?>