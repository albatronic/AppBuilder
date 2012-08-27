<?php

/**
 * Description of columnasComunes a todas las entidades de datos
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 25-ago-2012 22:41:15
 */
class columnasComunes {
    /**
     * Array con las columnas comunes a todas la entidades de datos
     * @var array
     */
    static $columnasExcepcion = array(
        'Observaciones',
        'PrimaryKeyMD5',
        'EsPredeterminado',
        'Revisado',
        'Publicar',
        'VigenteDesde',
        'VigenteHasta',
        'CreatedBy',
        'CreatedAt',
        'ModifiedBy',
        'ModifiedAt',
        'Deleted',
        'DeletedBy',
        'DeletedAt',
        'Privacidad',
        'Orden',
        'FechaPublicacion',
        'UrlAmigable',
        'MetatagTitle',
        'MetatagKeywords',
        'MetatagDescription',
        'MetatagTitleSimple',
        'MetatagTitlePosicion',
        'MostrarEnMapaWeb',
        'ImportanciaMapaWeb',
        'ChangeFreqMapaWeb',
    );
}

?>
