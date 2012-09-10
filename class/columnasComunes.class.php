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
        'Observations',
        'PrimaryKeyMD5',
        'IsDefault',
        'Checked',
        'Publish',
        'BelongsTo',
        'CreatedBy',
        'CreatedAt',
        'ModifiedBy',
        'ModifiedAt',
        'Deleted',
        'DeletedBy',
        'DeletedAt',
        'Privacy',
        'Order',
        'PublishedAt',
        'ActiveFrom',
        'ActiveTo',
        'UrlPrefix',
        'LockUrlPrefix',
        'Slug',
        'LockSlug',
        'UrlFriendly',
        'UrlHeritable',
        'NumberVisits',
        'MetatagTitle',
        'MetatagKeywords',
        'MetatagDescription',
        'MetatagTitleSimple',
        'MetatagTitlePosition',
        'ShowOnSitemap',
        'ImportanceSitemap',
        'ChangeFreqSitemap',
    );

    /**
     * Columnas a ignorar cuando se genera el config.yml de cada módulo
     * @var array
     */
    static $columnasExcepcionConfig = array (

    );
}

?>
