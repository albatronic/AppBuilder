<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
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

$fileName = "../docs/docs" . $_SESSION['emp'] . "/catalog/" . $_GET['img'];
if (file_exists($fileName)) {
    $thumb = new Thumb();
    $thumb->loadImage($fileName);
    $thumb->resize($_GET['w'],'width');
    $thumb->show();
}
?>
