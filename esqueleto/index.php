<?php

/**
 * CONTROLADOR FRONTAL. Recibe todas las peticiones y renderiza el resultado
 *
 * UTILIZA URLS AMIGABLES. DEBE EXISTIR UN '.htaccess' EN EL DIRECTORIO
 * RAIZ DEL SITIO WEB CON UNA REGLA QUE DERIVA TODAS LAS PETICIONES
 * A ESTE SCRIPT (CONTROLADOR FRONTAL)
 *
 * EJEMPLO .htaccess:
 * <IfModule mod_rewrite.c>
 *   RewriteEngine On
 *   RewriteCond %{REQUEST_FILENAME} !-f
 *   RewriteRule ^(.*)$ index.php [QSA,L]
 * </IfModule>
 *
 * LAS PETICIONES DEBEN SER EN EL FORMATO:
 * http://www.sitioweb.com/appname/controller/action/resto de valores...
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC
 * @date 27.05.2011
 */
session_start();

if (!isset($_SESSION['USER'])) {
    echo "USUARIO NO REGISTRADO";
    exit;
}

if (!file_exists('config/config.xml')) {
    echo "NO EXISTE EL FICHERO DE CONFIGURACION";
    exit;
}

// ---------------------------------------------------------------
// ACTIVAR EL AUTOLOADER DE CLASES Y FICHEROS A INCLUIR
// ---------------------------------------------------------------
define(APP_PATH, "");
include_once "../lib/Autoloader.class.php";
Autoloader::setCacheFilePath(APP_PATH . 'tmp/class_path_cache.txt');
Autoloader::excludeFolderNamesMatchingRegex('/^CVS|\..*$/');
Autoloader::setClassPaths(array(
            'entities/',
            //'modules/',
            'lib/',
        ));
spl_autoload_register(array('Autoloader', 'loadClass'));

// ---------------------------------------------------------------
// CARGO LOS PARAMETROS DE CONFIGURACION.
// ---------------------------------------------------------------
$config = simplexml_load_file('config/config.xml');

$app = array(
    'name' => $config->app->name,
    'url' => $config->app->url,
    'path' => $config->app->path
);

include_once "../lib/pdf/fpdf.class.php";
include_once "../lib/request.class.php";
include_once "../lib/entityManager.class.php";
include_once "../lib/entity.class.php";
include_once "../lib/xmlBuilder.class.php";
include_once "../lib/xmlRead.class.php";
include_once "../lib/form.class.php";
include_once "../lib/listado.class.php";
include_once "../lib/mail.class.php";
include_once "../lib/fecha.class.php";
include_once "../lib/documentoPdf.class.php";
include_once "../lib/controlAcceso.class.php";

include_once "entities/_Tipos.class.php";
include_once "modules/controller.class.php";

// ---------------------------------------------------------------
// ACTIVAR EL IDIOMA.
// ---------------------------------------------------------------
include_once "lang/languages.php";

if ($_SESSION['IDIOMA'] == '') {
    $idioma = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if ((file_exists('lang/' . $idioma . '.php')) and (in_array($idioma, $_SESSION['IDIOMAS']))) {
        $_SESSION['IDIOMA'] = $idioma;
    } else
        $_SESSION['IDIOMA'] = 'es';

    include "lang/" . $_SESSION['IDIOMA'] . ".php";
}

//----------------------------------------------------------------
// ACTIVAR EL MOTOR TWIG PARA LOS TEMPLATES.
//----------------------------------------------------------------
require_once $config->twig->motor;
Twig_Autoloader::register();

$cache = $config->twig->cache_folder;
if ($cache != '')
    $ops['cache'] = $cache;
$debug = $config->twig->debug_mode;
if ($debug != '')
    $ops['debug'] = $debug;
$charset = $config->twig->charset;
if ($charset != '')
    $ops['charset'] = $charset;
$ops['autoescape'] = true;
$loader = new Twig_Loader_Filesystem($config->twig->templates_folder);
$twig = new Twig_Environment($loader, $ops);

//-----------------------------------------------------------------
// INSTANCIAR UN OBJETO DE LA CLASE REQUEST PARA TENER DISPONIBLES
// TODOS LOS VALORES QUE CONSTITUYEN LA PETICION E IDENTIFICAR
// SI LA PETICION ES 'GET' O 'POST', ASI COMO EL CONTROLADOR Y
// ACCION SOLICITADA.
//-----------------------------------------------------------------
$rq = new request();
switch ($rq->getMethod()) {
    case 'GET':
        $request = $rq->getParameters();
        $request['METHOD'] = "GET";
        $controller = ucfirst($request[1]);
        $action = $request[2];
        break;

    case 'POST':
        $request = $rq->getRequest();
        $request['METHOD'] = "POST";
        $controller = ucfirst($request['controller']);
        $action = $request['action'];
        break;
}

// Si en la peticion no viene controller ni action, las pongo a 'Index'
if ($controller == '')
    $controller = 'Index';
if ($action == '')
    $action = "Index";


// Si no existe el controller lo pongo a 'Index'
$fileController = "modules/" . $controller . "/" . $controller . "Controller.class.php";
if (!file_exists($fileController)) {
    $controller = "Index";
    $fileController = "modules/Index/IndexController.class.php";
}

$clase = $controller . "Controller";
$metodo = $action . "Action";

//---------------------------------------------------------------
// INSTANCIAR EL CONTROLLER REQUERIDO
// SI EL METODO SOLICITADO EXISTE, LO EJECUTO, SI NO EJECUTO EL METODO INDEX
// RENDERIZAR EL RESULTADO CON EL TEMPLATE Y DATOS DEVUELTOS
// SI NO EXISTE EL TEMPLATE DEVUELTO, MUESTRO UNA PAGINA DE ERROR
//---------------------------------------------------------------
include_once $fileController;
$con = new $clase($request);
if (!method_exists($con, $metodo))
    $metodo = "IndexAction";
$result = $con->{$metodo}();

$result['values']['controller'] = $controller;

if ($config->debug_mode == 'true') {
    $result['values']['_debugMode'] = true;
    $result['values']['_session'] = print_r(array('emp' => $_SESSION['emp'], 'suc' => $_SESSION['suc'],), true);
    $result['values']['_user'] = print_r($_SESSION['USER'], true);
    $result['values']['_debugValues'] = print_r($result['values'], true);
}

if (!file_exists($config->twig->templates_folder . '/' . $result['template']) or ($result['template'] == '')) {
    $error = 'NO EXISTE EL TEMPLATE: "' . $result['template'] . '" DEVUELTO POR EL METODO "' . $clase . ':' . $action . 'Action"';
    $twig->loadTemplate('_global/error.html.twig')
            ->display(array(
                'error' => $error,
                'user' => $_SESSION['USER'],
                'emp' => $_SESSION['emp'],
                'suc' => $_SESSION['suc'],
            ));
} else {
    $twig->loadTemplate($result['template'])
            ->display(array(
                'values' => $result['values'],
                'app' => $app,
                'user' => $_SESSION['USER'],
                'emp' => $_SESSION['emp'],
                'suc' => $_SESSION['suc'],
            ));
}
//------------------------------------------------------------

unset($rq);
unset($con);
unset($loader);
unset($twig);
unset($config);
?>