<?php

/**
 * Description of EntityComunes
 *
 * Definicion de propiedades y métodos comunes a todas las entidades de datos
 *
 * @date 03-08-2012
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright (c) Informática ALBATRONIC, SL
 */
class EntityComunes extends Entity {

    /**
     * @orm Column(type="string")
     * @var text
     */
    protected $Observations;

    /**
     * @orm Column(type="string")
     * @var string(100)
     */
    protected $PrimaryKeyMD5;

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $IsDefault = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $Checked = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $Publish = '0';

    /**
     * @orm Column(type="int")
     * @var integer(11)
     */
    protected $BelongsTo = '0';

    /**
     * @orm Column(type="integer")
     * @var entities\CpanUsuarios
     */
    protected $CreatedBy = '0';

    /**
     * @orm Column(type="datetime")
     * @assert:NotBlank
     * @var datetime
     */
    protected $CreatedAt = '0000-00-00 00:00:00';

    /**
     * @orm Column(type="integer")
     * @var entities\CpanUsuarios
     */
    protected $ModifiedBy = '0';

    /**
     * @orm Column(type="datetime")
     * @assert:NotBlank
     * @var datetime
     */
    protected $ModifiedAt = '0000-00-00 00:00:00';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $Deleted = '0';

    /**
     * @orm Column(type="integer")
     * @var entities\CpanUsuarios
     */
    protected $DeletedBy = '0';

    /**
     * @orm Column(type="datetime")
     * @var datetime
     */
    protected $DeletedAt = '0000-00-00 00:00:00';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresPrivacy
     */
    protected $Privacy = '0';

    /**
     * @orm Column(type="integer")
     * @var integer(11)
     */
    protected $SortOrder = '0';

    /**
     * @orm Column(type="datetime")
     * @var datetime
     */
    protected $PublishedAt = '0000-00-00 00:00:00';

    /**
     * @orm Column(type="datetime")
     * @var datetime
     */
    protected $ActiveFrom = '0000-00-00 00:00:00';

    /**
     * @orm Column(type="datetime")
     * @var datetime
     */
    protected $ActiveTo = '0000-00-00 00:00:00';

    /**
     * @orm Column(type="string")
     * @var string(255)
     */
    protected $UrlPrefix;

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $LockUrlPrefix = '1';

    /**
     * @orm Column(type="string")
     * @var string(255)
     */
    protected $Slug;

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $LockSlug = '1';

    /**
     * @orm Column(type="string")
     * @var string(255)
     */
    protected $UrlFriendly;

    /**
     * @orm Column(type="string")
     * @var entities\ValoresSN
     */
    protected $UrlHeritable = '1';

    /**
     * @orm Column(type="integer")
     * @var integer(11)
     */
    protected $NumberVisits = '0';

    /**
     * @orm Column(type="string")
     * @var string(255)
     */
    protected $MetatagTitle;

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $LockMetatagTitle = '';

    /**
     * @orm Column(type="string")
     * @var string(255)
     */
    protected $MetatagKeywords;

    /**
     * @orm Column(type="string")
     * @var string(255)
     */
    protected $MetatagDescription;

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $MetatagTitleSimple = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresDchaIzq
     */
    protected $MetatagTitlePosition = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $ShowOnSitemap = '0';

    /**
     * @orm Column(type="string")
     * @var string(5)
     */
    protected $ImportanceSitemap = '0.5';

    /**
     * @orm Column(type="string")
     * @var entities\ValoresChangeFreq
     */
    protected $ChangeFreqSitemap = 'monthly';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $ShowGalery = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $ShowDocuments = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $ShowRelatedLinks = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $ShowRelatedContents = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $ShowPublishedAt = '0';

    /**
     * @orm Column(type="string")
     * @var string(100)
     */
    protected $AccessProfileList = '1,2';

    /**
     * @orm Column(type="string")
     * @var string(255)
     */
    protected $UrlTarget = NULL;

    /**
     * @orm Column(type="string")
     * @var string(255)
     */
    protected $UrlParameters = NULL;

    /**
     * @orm Column(type="tinyint")
     * @var entities\RequestMethods
     */
    protected $UrlRequestMethod = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\RequestOrigins
     */
    protected $UrlOrigin = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $UrlTargetBlank = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\ValoresSN
     */
    protected $UrlIsHttps = '0';

    /**
     * @orm Column(type="tinyint")
     * @var entities\CpanAplicaciones
     */
    protected $CodigoAppAsociada = NULL;
    protected $IdAlbumExterno = NULL;
    protected $IdSliderAsociado = NULL;

    /**
     * METODOS ELABORADOS
     */

    /**
     * Devuelve el objeto CpanUrlAmigables asociado
     */
    public function getObjetoUrlAmigable() {

        $url = new CpanUrlAmigables();
        $rows = $url->cargaCondicion("Id", "Entity='{$this->getClassName()}' and IdEntity='{$this->getPrimaryKeyValue()}'");
        unset($url);

        return new CpanUrlAmigables($rows[0]['Id']);
    }

    /**
     * Devuelve un array con los elemementos necesarios para
     * construir un <a href=''> 
     * 
     * Tiene dos elmentos:
     * 
     *  'url'   Es la url en si con el prefijo, que puede ser: nada, http, o https)
     *  'targetBlank'   Es un flag booleano para saber si el enlace se habrirá en popup o no
     * 
     * @return array Array
     */
    public function getHref() {

        $url = $this->getUrlTarget();
        $esInterna = ($url == '');

        if ($esInterna) {
            $url = $this->getUrlFriendly();
            $prefijo = $_SESSION['appPath'];
        } else {
            if ($this->UrlIsHttps)
                $prefijo = "https://";
            else
                $prefijo = "http://";
        }

        $url = $prefijo . $url . $this->getUrlParameters();

        $array = array('url' => $url, 'targetBlank' => $this->UrlTargetBlank);


        return $array;
    }

    /**
     * GETERS Y SETERS
     */
    public function setObservations($Observations) {
        $this->Observations = trim($Observations);
    }

    public function getObservations() {
        return $this->Observations;
    }

    public function setPrimaryKeyMD5($PrimaryKeyMD5) {
        $this->PrimaryKeyMD5 = trim($PrimaryKeyMD5);
    }

    public function getPrimaryKeyMD5() {
        return $this->PrimaryKeyMD5;
    }

    public function setIsDefault($IsDefault) {
        $this->IsDefault = $IsDefault;
    }

    public function getIsDefault() {
        if (!($this->IsDefault instanceof ValoresSN))
            $this->IsDefault = new ValoresSN($this->IsDefault);
        return $this->IsDefault;
    }

    public function setChecked($Checked) {
        $this->Checked = $Checked;
    }

    public function getChecked() {
        if (!($this->Checked instanceof ValoresSN))
            $this->Checked = new ValoresSN($this->Checked);
        return $this->Checked;
    }

    public function setPublish($Publish) {
        $this->Publish = $Publish;
    }

    public function getPublish() {
        if (!($this->Publish instanceof ValoresSN))
            $this->Publish = new ValoresSN($this->Publish);
        return $this->Publish;
    }

    public function setBelongsTo($BelongsTo) {
        $this->BelongsTo = $BelongsTo;
    }

    public function getBelongsTo() {

        if (!is_object($this->BelongsTo)) {
            $clase = $this->getClassName();
            $this->BelongsTo = new $clase($this->BelongsTo);
        }

        return $this->BelongsTo;
    }

    public function setCreatedBy($CreateBy) {
        $this->CreatedBy = $CreateBy;
    }

    public function getCreatedBy() {
        if (!($this->CreatedBy instanceof CpanUsuarios))
            $this->CreatedBy = new CpanUsuarios($this->CreatedBy);
        return $this->CreatedBy;
    }

    public function setCreatedAt($CreatedAt) {
        $this->CreatedAt = $CreatedAt;
    }

    public function getCreatedAt() {
        return $this->CreatedAt;
    }

    public function setModifiedBy($ModifiedBy) {
        $this->ModifiedBy = $ModifiedBy;
    }

    public function getModifiedBy() {
        if (!($this->ModifiedBy instanceof CpanUsuarios))
            $this->ModifiedBy = new CpanUsuarios($this->ModifiedBy);
        return $this->ModifiedBy;
    }

    public function setModifiedAt($ModifiedAt) {
        $this->ModifiedAt = $ModifiedAt;
    }

    public function getModifiedAt() {
        return $this->ModifiedAt;
    }

    public function setDeleted($Deleted) {
        $this->Deleted = $Deleted;
    }

    public function getDeleted() {
        if (!($this->Deleted instanceof ValoresSN))
            $this->Deleted = new ValoresSN($this->Deleted);
        return $this->Deleted;
    }

    public function setDeletedBy($DeletedBy) {
        $this->DeletedBy = $DeletedBy;
    }

    public function getDeletedBy() {
        if (!($this->DeletedBy instanceof CpanUsuarios))
            $this->DeletedBy = new CpanUsuarios($this->DeletedBy);
        return $this->DeletedBy;
    }

    public function setDeletedAt($DeletedAt) {
        $this->DeletedAt = $DeletedAt;
    }

    public function getDeletedAt() {
        return $this->DeletedAt;
    }

    public function setPrivacy($Privacy) {
        $this->Privacy = $Privacy;
    }

    public function getPrivacy() {
        if (!($this->Privacy instanceof ValoresPrivacy))
            $this->Privacy = new ValoresPrivacy($this->Privacy);
        return $this->Privacy;
    }

    public function setSortOrder($SortOrder) {
        $this->SortOrder = $SortOrder;
    }

    public function getSortOrder() {
        return $this->SortOrder;
    }

    public function setPublishedAt($PublishedAt) {
        $date = new Fecha($PublishedAt);
        $this->PublishedAt = $date->getFechaTime();
        unset($date);
    }

    public function getPublishedAt() {
        $date = new Fecha($this->PublishedAt);
        $ddmmaaaahhmmss = $date->getddmmaaaahhmmss();
        unset($date);
        return $ddmmaaaahhmmss;
    }

    public function setActiveFrom($ActiveFrom) {
        $date = new Fecha($ActiveFrom);
        $this->ActiveFrom = $date->getFechaTime();
        unset($date);
    }

    public function getActiveFrom() {
        $date = new Fecha($this->ActiveFrom);
        $ddmmaaaahhmmss = $date->getddmmaaaahhmmss();
        unset($date);
        return $ddmmaaaahhmmss;
    }

    public function setActiveTo($ActiveTo) {
        $date = new Fecha($ActiveTo);
        $this->ActiveTo = $date->getFechaTime();
        unset($date);
    }

    public function getActiveTo() {
        $date = new Fecha($this->ActiveTo);
        $ddmmaaaahhmmss = $date->getddmmaaaahhmmss();
        unset($date);
        return $ddmmaaaahhmmss;
    }

    public function setUrlPrefix($UrlPrefix) {
        $this->UrlPrefix = trim($UrlPrefix);
    }

    public function getUrlPrefix() {
        return $this->UrlPrefix;
    }

    public function setLockUrlPrefix($LockUrlPrefix) {
        $this->LockUrlPrefix = $LockUrlPrefix;
    }

    public function getLockUrlPrefix() {
        if (!($this->LockUrlPrefix instanceof ValoresSN))
            $this->LockUrlPrefix = new ValoresSN($this->LockUrlPrefix);
        return $this->LockUrlPrefix;
    }

    public function setSlug($Slug) {
        $this->Slug = trim($Slug);
    }

    public function getSlug() {
        return $this->Slug;
    }

    public function setLockSlug($LockSlug) {
        $this->LockSlug = $LockSlug;
    }

    public function getLockSlug() {
        if (!($this->LockSlug instanceof ValoresSN))
            $this->LockSlug = new ValoresSN($this->LockSlug);
        return $this->LockSlug;
    }

    public function setUrlFriendly($UrlFriendly) {
        $this->UrlFriendly = trim($UrlFriendly);
    }

    public function getUrlFriendly() {
        return $this->UrlFriendly;
    }

    public function setUrlHeritable($UrlHeritable) {
        $this->UrlHeritable = $UrlHeritable;
    }

    public function getUrlHeritable() {
        if (!($this->UrlHeritable instanceof ValoresSN))
            $this->UrlHeritable = new ValoresSN($this->UrlHeritable);
        return $this->UrlHeritable;
    }

    public function setNumberVisits($NumberVisits) {
        $this->NumberVisits = $NumberVisits;
    }

    public function getNumberVisits() {
        return $this->NumberVisits;
    }

    public function setMetatagTitle($MetatagTitle) {
        $this->MetatagTitle = trim($MetatagTitle);
    }

    public function getMetatagTitle() {
        return $this->MetatagTitle;
    }

    public function setLockMetatagTitle($LockMetatagTitle) {
        $this->LockMetatagTitle = $LockMetatagTitle;
    }

    public function getLockMetatagTitle() {
        if (!($this->LockMetatagTitle instanceof ValoresSN))
            $this->LockMetatagTitle = new ValoresSN($this->LockMetatagTitle);
        return $this->LockMetatagTitle;
    }

    public function setMetatagKeywords($MetatagKeywords) {
        $this->MetatagKeywords = trim($MetatagKeywords);
    }

    public function getMetatagKeywords() {
        return $this->MetatagKeywords;
    }

    public function setMetatagDescription($MetatagDescription) {
        $this->MetatagDescription = trim($MetatagDescription);
    }

    public function getMetatagDescription() {
        return $this->MetatagDescription;
    }

    public function setMetatagTitleSimple($MetatagTitleSimple) {
        $this->MetatagTitleSimple = $MetatagTitleSimple;
    }

    public function getMetatagTitleSimple() {
        if (!($this->MetatagTitleSimple instanceof ValoresSN))
            $this->MetatagTitleSimple = new ValoresSN($this->MetatagTitleSimple);
        return $this->MetatagTitleSimple;
    }

    public function setMetatagTitlePosition($MetatagTitlePosition) {
        $this->MetatagTitlePosition = $MetatagTitlePosition;
    }

    public function getMetatagTitlePosition() {
        if (!($this->MetatagTitlePosition instanceof ValoresDchaIzq))
            $this->MetatagTitlePosition = new ValoresDchaIzq($this->MetatagTitlePosition);
        return $this->MetatagTitlePosition;
    }

    public function setShowOnSitemap($ShowOnSitemap) {
        $this->ShowOnSitemap = $ShowOnSitemap;
    }

    public function getShowOnSitemap() {
        if (!($this->ShowOnSitemap instanceof ValoresSN))
            $this->ShowOnSitemap = new ValoresSN($this->ShowOnSitemap);
        return $this->ShowOnSitemap;
    }

    public function setImportanceSitemap($ImportanceSitemap) {
        $this->ImportanceSitemap = trim($ImportanceSitemap);
    }

    public function getImportanceSitemap() {
        return $this->ImportanceSitemap;
    }

    public function setChangeFreqSitemap($ChangeFreqSitemap) {
        $this->ChangeFreqSitemap = $ChangeFreqSitemap;
    }

    public function getChangeFreqSitemap() {
        if (!($this->ChangeFreqSitemap instanceof ValoresChangeFreq))
            $this->ChangeFreqSitemap = new ValoresChangeFreq($this->ChangeFreqSitemap);
        return $this->ChangeFreqSitemap;
    }

    public function setShowGalery($ShowGalery) {
        $this->ShowGalery = $ShowGalery;
    }

    public function getShowGalery() {
        if (!($this->ShowGalery instanceof ValoresSN))
            $this->ShowGalery = new ValoresSN($this->ShowGalery);
        return $this->ShowGalery;
    }

    public function setShowDocuments($ShowDocuments) {
        $this->ShowDocuments = $ShowDocuments;
    }

    public function getShowDocuments() {
        if (!($this->ShowDocuments instanceof ValoresSN))
            $this->ShowDocuments = new ValoresSN($this->ShowDocuments);
        return $this->ShowDocuments;
    }

    public function setShowRelatedLinks($ShowRelatedLinks) {
        $this->ShowRelatedLinks = $ShowRelatedLinks;
    }

    public function getShowRelatedLinks() {
        if (!($this->ShowRelatedLinks instanceof ValoresSN))
            $this->ShowRelatedLinks = new ValoresSN($this->ShowRelatedLinks);
        return $this->ShowRelatedLinks;
    }

    public function setShowRelatedContents($ShowRelatedContents) {
        $this->ShowRelatedContents = $ShowRelatedContents;
    }

    public function getShowRelatedContents() {
        if (!($this->ShowRelatedContents instanceof ValoresSN))
            $this->ShowRelatedContents = new ValoresSN($this->ShowRelatedContents);
        return $this->ShowRelatedContents;
    }

    public function setShowPublishedAt($ShowPublishedAt) {
        $this->ShowPublishedAt = $ShowPublishedAt;
    }

    public function getShowPublishedAt() {
        if (!($this->ShowPublishedAt instanceof ValoresSN))
            $this->ShowPublishedAt = new ValoresSN($this->ShowPublishedAt);
        return $this->ShowPublishedAt;
    }

    public function setAccessProfileList($AccessProfileList) {
        $this->AccessProfileList = trim($AccessProfileList);
    }

    public function getAccessProfileList() {
        return $this->AccessProfileList;
    }

    public function setUrlTarget($UrlTarget) {
        $this->UrlTarget = trim($UrlTarget);
    }

    public function getUrlTarget() {
        return $this->UrlTarget;
    }

    public function setUrlParameters($UrlParameters) {
        $this->UrlParameters = trim($UrlParameters);
    }

    public function getUrlParameters() {
        return $this->UrlParameters;
    }

    public function setUrlRequestMethod($UrlRequestMethod) {
        $this->UrlRequestMethod = $UrlRequestMethod;
    }

    public function getUrlRequestMethod() {
        if (!($this->UrlRequestMethod instanceof RequestMethods))
            $this->UrlRequestMethod = new RequestMethods($this->UrlRequestMethod);
        return $this->UrlRequestMethod;
    }

    public function setUrlOrigin($UrlOrigin) {
        $this->UrlOrigin = $UrlOrigin;
    }

    public function getUrlOrigin() {
        if (!($this->UrlOrigin instanceof RequestOrigins))
            $this->UrlOrigin = new RequestOrigins($this->UrlOrigin);
        return $this->UrlOrigin;
    }

    public function setUrlTargetBlank($UrlTargetBlank) {
        $this->UrlTargetBlank = $UrlTargetBlank;
    }

    public function getUrlTargetBlank() {
        if (!($this->UrlTargetBlank instanceof ValoresSN))
            $this->UrlTargetBlank = new ValoresSN($this->UrlTargetBlank);
        return $this->UrlTargetBlank;
    }

    public function setUrlIsHttps($UrlIsHttps) {
        $this->UrlIsHttps = $UrlIsHttps;
    }

    public function getUrlIsHttps() {
        if (!($this->UrlIsHttps instanceof ValoresSN))
            $this->UrlIsHttps = new ValoresSN($this->UrlIsHttps);
        return $this->UrlIsHttps;
    }

    public function setCodigoAppAsociada($CodigoAppAsociada) {
        $this->CodigoAppAsociada = $CodigoAppAsociada;
    }

    public function getCodigoAppAsociada() {
        if (!($this->CodigoAppAsociada instanceof CpanAplicaciones)) {
            $app = new CpanAplicaciones();
            $this->CodigoAppAsociada = $app->find('CodigoApp', $this->CodigoAppAsociada);
        }
        return $this->CodigoAppAsociada;
    }

    public function setIdAlbumExterno($IdAlbumExterno) {
        $this->IdAlbumExterno = $IdAlbumExterno;
    }

    public function getIdAlbumExterno() {
        return $this->IdAlbumExterno;
    }

    public function setIdSliderAsociado($IdSliderAsociado) {
        $this->IdSliderAsociado = $IdSliderAsociado;
    }

    public function getIdSliderAsociado() {
        return $this->IdSliderAsociado;
    }

}

?>
