<?php
/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 23:55:15
 */

/**
 * @orm:Entity(CpanDocs)
 */
class CpanDocsEntity extends EntityComunes {
	/**
	 * @orm GeneratedValue
	 * @orm Id
	 * @var integer
	 * @assert NotBlank(groups="CpanDocs")
	 */
	protected $Id;
	/**
	 * @var string
	 * @assert NotBlank(groups="CpanDocs")
	 */
	protected $Entity;
	/**
	 * @var integer
	 * @assert NotBlank(groups="CpanDocs")
	 */
	protected $IdEntity;
	/**
	 * @var entities\TiposDocs
	 * @assert NotBlank(groups="CpanDocs")
	 */
	protected $Type;
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="CpanDocs")
	 */
	protected $IsThumbnail = '0';
	/**
	 * @var string
	 * @assert NotBlank(groups="CpanDocs")
	 */
	protected $PathName;
	/**
	 * @var string
	 * @assert NotBlank(groups="CpanDocs")
	 */
	protected $Name;
	/**
	 * @var string
	 */
	protected $Extension;
	/**
	 * @var string
	 */
	protected $Title;
	/**
	 * @var entities\ValoresSN
	 * @assert NotBlank(groups="CpanDocs")
	 */
	protected $ShowCaption = '0';
	/**
	 * @var string
	 */
	protected $MimeType;
	/**
	 * @var integer
	 * @assert NotBlank(groups="CpanDocs")
	 */
	protected $Size = '0';
	/**
	 * @var integer
	 * @assert NotBlank(groups="CpanDocs")
	 */
	protected $Height = '0';
	/**
	 * @var integer
	 * @assert NotBlank(groups="CpanDocs")
	 */
	protected $Width = '0';
	/**
	 * Nombre de la conexion a la BD
	 * @var string
	 */
	protected $_conectionName = '';
	/**
	 * Nombre de la tabla física
	 * @var string
	 */
	protected $_tableName = 'CpanDocs';
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
			'TiposDocs',
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

	public function setEntity($Entity){
		$this->Entity = trim($Entity);
	}
	public function getEntity(){
		return $this->Entity;
	}

	public function setIdEntity($IdEntity){
		$this->IdEntity = $IdEntity;
	}
	public function getIdEntity(){
		return $this->IdEntity;
	}

	public function setType($Type){
		$this->Type = trim($Type);
	}
	public function getType(){
		if (!($this->Type instanceof TiposDocs))
			$this->Type = new TiposDocs($this->Type);
		return $this->Type;
	}

	public function setIsThumbnail($IsThumbnail){
		$this->IsThumbnail = $IsThumbnail;
	}
	public function getIsThumbnail(){
		if (!($this->IsThumbnail instanceof ValoresSN))
			$this->IsThumbnail = new ValoresSN($this->IsThumbnail);
		return $this->IsThumbnail;
	}

	public function setPathName($PathName){
		$this->PathName = trim($PathName);
	}
	public function getPathName(){
		return $this->PathName;
	}

	public function setName($Name){
		$this->Name = trim($Name);
	}
	public function getName(){
		return $this->Name;
	}

	public function setExtension($Extension){
		$this->Extension = trim($Extension);
	}
	public function getExtension(){
		return $this->Extension;
	}

	public function setTitle($Title){
		$this->Title = trim($Title);
	}
	public function getTitle(){
		return $this->Title;
	}

	public function setShowCaption($ShowCaption){
		$this->ShowCaption = $ShowCaption;
	}
	public function getShowCaption(){
		if (!($this->ShowCaption instanceof ValoresSN))
			$this->ShowCaption = new ValoresSN($this->ShowCaption);
		return $this->ShowCaption;
	}

	public function setMimeType($MimeType){
		$this->MimeType = trim($MimeType);
	}
	public function getMimeType(){
		return $this->MimeType;
	}

	public function setSize($Size){
		$this->Size = $Size;
	}
	public function getSize(){
		return $this->Size;
	}

	public function setHeight($Height){
		$this->Height = $Height;
	}
	public function getHeight(){
		return $this->Height;
	}

	public function setWidth($Width){
		$this->Width = $Width;
	}
	public function getWidth(){
		return $this->Width;
	}

} // END class CpanDocs

?>