<?php

/*
 * Genera el codigo HTML para mostrar los documentos de una entidad
 * 
 * Es llamado por AJAX
 * 
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC
 * @since 27.05.2011
 */

session_start();

if (!file_exists('../config/config.yml')) {
    echo "NO EXISTE EL FICHERO DE CONFIGURACION";
    exit;
}

if (file_exists("../../../app/bin/yaml/lib/sfYaml.php")) {
    include "../../../app/bin/yaml/lib/sfYaml.php";
} else {
    echo "NO EXISTE LA CLASE PARA LEER ARCHIVOS YAML";
    exit;
}

// ---------------------------------------------------------------
// CARGO LOS PARAMETROS DE CONFIGURACION.
// ---------------------------------------------------------------
$config = sfYaml::load('../config/config.yml');
$app = $config['config']['app'];

// ---------------------------------------------------------------
// ACTIVAR EL AUTOLOADER DE CLASES Y FICHEROS A INCLUIR
// ---------------------------------------------------------------
define(APP_PATH, $_SERVER['DOCUMENT_ROOT'] . $app['path'] . "/");
include_once "../" . $app['framework'] . "Autoloader.class.php";
Autoloader::setCacheFilePath(APP_PATH . 'tmp/class_path_cache.txt');
Autoloader::excludeFolderNamesMatchingRegex('/^CVS|\..*$/');
Autoloader::setClassPaths(array(
    '../' . $app['framework'],
    '../entities/',
    '../lib/',
));
spl_autoload_register(array('Autoloader', 'loadClass'));

$id = $_GET['id'];
$entidad = $_GET['entidad'];

$objeto = new $entidad($id);
$arrayDocs = $objeto->getDocuments();
unset($objeto);

$tag = '';

if (is_array($arrayDocs)) {
    foreach ($arrayDocs as $doc) {
        if ($doc->getRelativePath()) {
            $fileName = $app['path'] . "/" . $doc->getRelativePath();
            $pathImage = "../" . $doc->getRelativePath();
            $tag .= "<div style='float: left; width: 103px;'>";
            $tag .= "<div>";
            $tag .= "<a target='_blank' title='Documento' href='{$fileName}'>";
            $tag .= "<img src='" . $app['path'] . "/lib/product_thumb.php?img={$pathImage}&amp;w=100&amp;h=100' />";
            $tag .= "</a>";
            $tag .= "</div>";
            $tag .= "<div>";
            $tag .= "<input name='accion' value='Quitar' type='submit' class='Comando' style='width: 100px;' onclick=\"$('#action').val('Documento');$('#documentoBorrar').val('" . $doc->getBaseName() . "')\" />";
            $tag .= "</div>";
            $tag .= "</div>";
        }
    }
    unset($doc);
}
echo $tag;
?>
