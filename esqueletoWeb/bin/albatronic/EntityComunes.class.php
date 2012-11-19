<?php

/**
 * Description of EntityComunes
 *
 * Definicion de propiedades y métodos comunes a todas las entidades de datos
 *
 * @date 03-08-2012
 * @author Sergio Perez <sergio.perez@albatronic.com>
 */
class EntityComunes extends Entity {

    /**
     * @orm:Column(type="string")
     */
    protected $Observaciones;

    /**
     * @orm:Column(type="string")
     */
    protected $PrimaryKeyMD5;

    /**
     * @orm:Column(type="tinyint")
     */
    protected $EsPredeterminado = '0';

    /**
     * @orm:Column(type="tinyint")
     */
    protected $Revisado = '0';

    /**
     * @orm:Column(type="tinyint")
     */
    protected $Publicar = '0';

    /**
     * @orm:Column(type="datetime")
     */
    protected $VigenteDesde;

    /**
     * @orm:Column(type="datetime")
     */
    protected $VigenteHasta;

    /**
     * @orm:Column(type="integer")
     * @var entities\CoreUsuarios
     */
    protected $CreatedBy = '0';

    /**
     * @orm:Column(type="datetime")
     * @assert:NotBlank(groups="cursos")
     */
    protected $CreatedAt = '0000-00-00 00:00:00';

    /**
     * @orm:Column(type="integer")
     * @var entities\CoreUsuarios
     */
    protected $ModifiedBy = '0';

    /**
     * @orm:Column(type="datetime")
     * @assert:NotBlank(groups="cursos")
     */
    protected $ModifiedAt = '0000-00-00 00:00:00';

    /**
     * @orm:Column(type="tinyint")
     */
    protected $Deleted = '0';

    /**
     * @orm:Column(type="integer")
     * @var entities\CoreUsuarios
     */
    protected $DeletedBy = '0';

    /**
     * @orm:Column(type="datetime")
     */
    protected $DeletedAt = '0000-00-00 00:00:00';

    /**
     * @orm:Column(type="tinyint")
     */
    protected $Privacidad = '0';

    /**
     * @orm:Column(type="integer")
     */
    protected $Orden;

    /**
     * @orm:Column(type="datetime")
     */
    protected $FechaPublicacion;

    /**
     * @orm:Column(type="string")
     */
    protected $UrlAmigable;

    /**
     * @orm:Column(type="string")
     */
    protected $MetatagTitle;

    /**
     * @orm:Column(type="string")
     */
    protected $MetatagKeywords;

    /**
     * @orm:Column(type="string")
     */
    protected $MetatagDescription;

    /**
     * @orm:Column(type="tinyint")
     */
    protected $MetatagTitleSimple = '0';

    /**
     * @orm:Column(type="tinyint")
     */
    protected $MetatagTitlePosicion = '0';

    /**
     * @orm:Column(type="tinyint")
     */
    protected $MostrarEnMapaWeb = '0';

    /**
     * @orm:Column(type="string")
     */
    protected $ImportanciaMapaWeb;

    /**
     * @orm:Column(type="string")
     */
    protected $ChangeFreqMapaWeb = '';

    public function setObservaciones($Observaciones) {
        $this->Observaciones = trim($Observaciones);
    }

    public function getObservaciones() {
        return $this->Observaciones;
    }

    public function setPrimaryKeyMD5($PrimaryKeyMD5) {
        $this->PrimaryKeyMD5 = trim($PrimaryKeyMD5);
    }

    public function getPrimaryKeyMD5() {
        return $this->PrimaryKeyMD5;
    }

    public function setEsPredeterminado($EsPredeterminado) {
        $this->EsPredeterminado = $EsPredeterminado;
    }

    public function getEsPredeterminado() {
        if (!($this->EsPredeterminado instanceof ValoresSN))
            $this->EsPredeterminado = new ValoresSN($this->EsPredeterminado);
        return $this->EsPredeterminado;
    }

    public function setRevisado($Revisado) {
        $this->Revisado = $Revisado;
    }

    public function getRevisado() {
        if (!($this->Revisado instanceof ValoresSN))
            $this->Revisado = new ValoresSN($this->Revisado);
        return $this->Revisado;
    }

    public function setPublicar($Publicar) {
        $this->Publicar = $Publicar;
    }

    public function getPublicar() {
        if (!($this->Publicar instanceof ValoresSN))
            $this->Publicar = new ValoresSN($this->Publicar);
        return $this->Publicar;
    }

    public function setVigenteDesde($VigenteDesde) {
        $this->VigenteDesde = $VigenteDesde;
    }

    public function getVigenteDesde() {
        return $this->VigenteDesde;
    }

    public function setVigenteHasta($VigenteHasta) {
        $this->VigenteHasta = $VigenteHasta;
    }

    public function getVigenteHasta() {
        return $this->VigenteHasta;
    }

    public function setCreatedBy($CreateBy) {
        $this->CreatedBy = $CreateBy;
    }

    public function getCreatedBy() {
        if (!($this->CreatedBy instanceof CoreUsuarios))
            $this->CreatedBy = new CoreUsuarios($this->CreatedBy);
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
        if (!($this->ModifiedBy instanceof CoreUsuarios))
            $this->ModifiedBy = new CoreUsuarios($this->ModifiedBy);
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
        if (!($this->DeletedBy instanceof CoreUsuarios))
            $this->DeletedBy = new CoreUsuarios($this->DeletedBy);
        return $this->DeletedBy;
    }

    public function setDeletedAt($DeletedAt) {
        $this->DeletedAt = $DeletedAt;
    }

    public function getDeletedAt() {
        return $this->DeletedAt;
    }

    public function setPrivacidad($Privacidad) {
        $this->Privacidad = $Privacidad;
    }

    public function getPrivacidad() {
        if (!($this->Privacidad instanceof ValoresPrivacidad))
            $this->Privacidad = new ValoresPrivacidad($this->Privacidad);
        return $this->Privacidad;
    }

    public function setOrden($Orden) {
        $this->Orden = $Orden;
    }

    public function getOrden() {
        return $this->Orden;
    }

    public function setFechaPublicacion($FechaPublicacion) {
        $this->FechaPublicacion = $FechaPublicacion;
    }

    public function getFechaPublicacion() {
        return $this->FechaPublicacion;
    }

    public function setUrlAmigable($UrlAmigable) {
        $this->UrlAmigable = trim($UrlAmigable);
    }

    public function getUrlAmigable() {
        return $this->UrlAmigable;
    }

    public function setMetatagTitle($MetatagTitle) {
        $this->MetatagTitle = trim($MetatagTitle);
    }

    public function getMetatagTitle() {
        return $this->MetatagTitle;
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

    public function setMetatagTitlePosicion($MetatagTitlePosicion) {
        $this->MetatagTitlePosicion = $MetatagTitlePosicion;
    }

    public function getMetatagTitlePosicion() {
        if (!($this->MetatagTitlePosicion instanceof ValoresDchaIzq))
            $this->MetatagTitlePosicion = new ValoresDchaIzq($this->MetatagTitlePosicion);
        return $this->MetatagTitlePosicion;
    }

    public function setMostrarEnMapaWeb($MostrarEnMapaWeb) {
        $this->MostrarEnMapaWeb = $MostrarEnMapaWeb;
    }

    public function getMostrarEnMapaWeb() {
        if (!($this->MostrarEnMapaWeb instanceof ValoresSN))
            $this->MostrarEnMapaWeb = new ValoresSN($this->MostrarEnMapaWeb);
        return $this->MostrarEnMapaWeb;
    }

    public function setImportanciaMapaWeb($ImportanciaMapaWeb) {
        $this->ImportanciaMapaWeb = trim($ImportanciaMapaWeb);
    }

    public function getImportanciaMapaWeb() {
        return $this->ImportanciaMapaWeb;
    }

    public function setChangeFreqMapaWeb($ChangeFreqMapaWeb) {
        $this->ChangeFreqMapaWeb = trim($ChangeFreqMapaWeb);
    }

    public function getChangeFreqMapaWeb() {
        if (!($this->ChangeFreqMapaWeb instanceof ValoresChangeFreq))
            $this->ChangeFreqMapaWeb = new ValoresChangeFreq($this->ChangeFreqMapaWeb);
        return $this->ChangeFreqMapaWeb;
    }

    public function getNumeroVisitas() {

    }

}

?>
