<?php
/**
 * GENERA UN GRAFICO
 * 
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC
 * @since 27.05.2011
 */

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

//----------------------------------------------------------------
// ACTIVAR EL MOTOR DE GRAFICOS DE BARRAS
//----------------------------------------------------------------
if (is_array($config['config']['graph'])) {
    foreach ($config['config']['graph'] as $value) {
        $file = "../" . $value;
        if (file_exists($file))
            include_once $file;
        else
            die("NO SE PUEDE ENCONTRAR EL MOTOR DE GRAFICOS");
    }
}

// Se define el array de datos
$datosy = array(0,0,0,0,0,0,0,0,0,0,0,0);
$em = new EntityManager("datos" . $_SESSION['emp']);
if ($em->getDbLink()) {
    $query = "SELECT DATE_FORMAT(Fecha,'%m') as mes,sum(TotalBases) as base
            FROM femitidas_cab
            WHERE IDSucursal='{$_SESSION['suc']}'
            GROUP BY mes
            ORDER BY mes ASC;";
    $em->query($query);
    $rows = $em->fetchResult();
    $em->desConecta();
}
foreach ($rows as $value) $datosy[$value['mes']-1] = $value['base'];
// Creamos el grafico

$grafico = new Graph(450, 250);
$grafico->SetScale('textlin');

// Ajustamos los margenes del grafico-----    (left,right,top,bottom)
$grafico->SetMargin(40, 30, 30, 40);

// Creamos barras de datos a partir del array de datos
$bplot = new BarPlot($datosy);
// Configuramos color de las barras
$bplot->SetFillColor('#479CC9');
//Añadimos barra de datos al grafico
$grafico->Add($bplot);
// Queremos mostrar el valor numerico de la barra
$bplot->value->Show();
// Configuracion de los titulos
$grafico->title->Set('Ventas Mensuales (Facturas)');
$grafico->xaxis->title->Set('Meses');
$grafico->yaxis->title->Set('Base Imponible');
$grafico->title->SetFont(FF_FONT1, FS_BOLD);
$grafico->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$grafico->xaxis->title->SetFont(FF_FONT1, FS_BOLD);
// Se muestra el grafico
$grafico->Stroke();
?>
