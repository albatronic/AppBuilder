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
 * MAS INFO: http://httpd.apache.org/docs/2.0/es/
 *
 * LAS PETICIONES DEBEN SER EN EL FORMATO:
 * http://www.sitioweb.com/apppath/controller/action/resto de valores...
 *
 * El apppath puede estar compuesto de varios subcarpetas. Ej:
 * http://www.sitioweb.com/apps/gestion/controller/action/ resto de valores...
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC
 * @since 27.05.2011
 */
session_start();

$_SESSION['IdSesion'] = session_id();

if (!$_SESSION['USER']['user']['Id'])
    $_SESSION['USER']['user']['Id'] = 0;

if (!file_exists('config/config.yml'))
    die("NO EXISTE EL FICHERO DE CONFIGURACION");

if (file_exists("../binWeb/yaml/lib/sfYaml.php"))
    include "../binWeb/yaml/lib/sfYaml.php";
else
    die("NO EXISTE LA CLASE PARA LEER ARCHIVOS YAML");

// ---------------------------------------------------------------
// CARGO LOS PARAMETROS DE CONFIGURACION.
// ---------------------------------------------------------------
$yaml = sfYaml::load('config/config.yml');
$config = $yaml['config'];

if ($config['projectId'] == '')
    die("NO SE HA DEFINIDO EL ID DE PROYECTO");
else
    $_SESSION['projectId'] = $config['projectId'];

$app = $config['app'];

$_SESSION['appPath'] = $app['path'];
$_SESSION['appUrl'] = $app['url'];
$_SESSION['frecuenciaHorasBorrado'] = $config['frecuenciaHorasBorrado'];

// ---------------------------------------------------------------
// ACTIVAR EL AUTOLOADER DE CLASES Y FICHEROS A INCLUIR
// ---------------------------------------------------------------
define(APP_PATH, $_SERVER['DOCUMENT_ROOT'] . $app['path'] . "/");
include_once $app['framework'] . "Autoloader.class.php";
Autoloader::setCacheFilePath(APP_PATH . 'tmp/class_path_cache.txt');
Autoloader::excludeFolderNamesMatchingRegex('/^CVS|\..*$/');
Autoloader::setClassPaths(array(
    $app['framework'],
    'entities/',
    'lib/',
));
spl_autoload_register(array('Autoloader', 'loadClass'));

// ---------------------------------------------------------------
// ACTIVAR EL IDIOMA.
// ---------------------------------------------------------------
/**
  include_once "lang/languages.php";

  if ($_SESSION['IDIOMA'] == '') {
  $idioma = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
  if ((file_exists('lang/' . $idioma . '.php')) and (in_array($idioma, $_SESSION['IDIOMAS']))) {
  $_SESSION['IDIOMA'] = $idioma;
  } else
  $_SESSION['IDIOMA'] = 'es';

  include "lang/" . $_SESSION['IDIOMA'] . ".php";
  }
 */
//----------------------------------------------------------------
// ACTIVAR EL MOTOR DE PDF'S
// ---------------------------------------------------------------
if (file_exists($config['pdf']))
    include_once $config['pdf'];
else
    die("NO SE PUEDE ENCONTRAR EL MOTOR PDF");

//----------------------------------------------------------------
// ACTIVAR EL MOTOR TWIG PARA LOS TEMPLATES.
//----------------------------------------------------------------
if (file_exists($config['twig']['motor'])) {
    include_once $config['twig']['motor'];
    Twig_Autoloader::register();

    $cache = $config['twig']['cache_folder'];
    if ($cache != '')
        $ops['cache'] = $cache;
    $debug = $config['twig']['debug_mode'];
    if ($debug != '')
        $ops['debug'] = $debug;
    $charset = $config['twig']['charset'];
    if ($charset != '')
        $ops['charset'] = $charset;
    $ops['autoescape'] = true;
    $loader = new Twig_Loader_Filesystem($config['twig']['templates_folder']);
    $twig = new Twig_Environment($loader, $ops);
    $twig->getExtension('core')->setNumberFormat(2, ',', '.');
} else
    die("NO SE PUEDE ENCONTRAR EL MOTOR TWIG");

// ------------------------------------------------
// COMPROBAR DISPOSITIVO DE NAVEGACION
// ------------------------------------------------
if (!$_SESSION['isMobile']) {
    $browser = new Browser ();
    $_SESSION['isMobile'] = $browser->isMobile();
    unset($browser);
}

// ----------------------------------------------------------------
// CARGAR LO QUE VIENE EN EL REQUEST
// ----------------------------------------------------------------
$rq = new Request();

// ----------------------------------------------------------------
// DETERMINAR ENTORNO DE DESARROLLO O DE PRODUCCION
// ----------------------------------------------------------------
$_SESSION['EntornoDesarrollo'] = $rq->isDevelopment();

// ----------------------------------------------------------------
// EN ENTORNO DE PRODUCCION, OBTENER EL ORIGEN DE LA PETICION PARA
// LA GESTION DE VISITAS
// ----------------------------------------------------------------
if ((!$_SESSION['EntornoDesarrollo']) and (!$_SESSION['origen'])) {
    $_SESSION['origen'] = WebService::getOrigenVisitante($config['wsControlVisitas'] . $rq->getRemoteAddr());
}

// ----------------------------------------------------------------
// ACTIVAR EL FORMATO DE LA MONEDA
// ----------------------------------------------------------------
setlocale(LC_MONETARY, $rq->getLanguage());

// Si el navagador es antiguo muestro template especial
$url = new CpanUrlAmigables();
if ($rq->isOldBrowser()) {
    $rows = $url->cargaCondicion("*", "UrlFriendly='/oldbrowser'");
} else {
    // Localizar la url amigable
    $rows = $url->cargaCondicion("*", "UrlFriendly='{$rq->getUrlFriendly($app['path'])}'");

    if (count($url->getErrores()) == 0) {
        if (!$rows)
            $rows = $url->cargaCondicion("*", "UrlFriendly='/error404'");
    } else {
        print_r($url->getErrores());
        die("Error de conexión a la BD");
    }
}

unset($url);
$row = $rows[0];

//-----------------------------------------------------------------
// INSTANCIAR UN OBJETO DE LA CLASE REQUEST PARA TENER DISPONIBLES
// TODOS LOS VALORES QUE CONSTITUYEN LA PETICION E IDENTIFICAR
// SI LA PETICION ES 'GET' O 'POST', ASI COMO EL CONTROLADOR Y
// ACCION SOLICITADA.
//-----------------------------------------------------------------
switch ($rq->getMethod()) {
    case 'GET':
        $request = $rq->getParameters($app['path']);
        $request['METHOD'] = "GET";
        //$controller = ucfirst($request[0]);
        //$action = $request[1];
        $controller = ucfirst($row['Controller']);
        $action = $row['Action'];
        $request['IdUrlAmigable'] = $row['Id'];
        $request['Parameters'] = $row['Parameters'];
        $request['Entity'] = $row['Entity'];
        $request['IdEntity'] = $row['IdEntity'];
        break;

    case 'POST':
        $request = $rq->getRequest();
        $request['METHOD'] = "POST";
        $controller = ucfirst($request['controller']);
        $action = $request['action'];
        //$controller = $row['Controller'];
        //$action = $row['Action'];
        break;
}

// Si no se ha localizado el controlador, lo pongo a Error404
if ($controller == '')
    $controller = 'Error404';
// Si no se ha localizado la action, la pongo a Index
if ($action == '')
    $action = "Index";

// Si no existe el controller lo pongo a 'Error404'
$fileController = "modules/" . $controller . "/" . $controller . "Controller.class.php";
if (!file_exists($fileController)) {
    $controller = "Error404";
    $fileController = "modules/Error404/Error404Controller.class.php";
}

$clase = $controller . "Controller";
$metodo = $action . "Action";

//------------------------------------------------------------------------------
// INSTANCIAR EL CONTROLLER REQUERIDO
// SI EL METODO SOLICITADO EXISTE, LO EJECUTO, SI NO EJECUTO EL METODO INDEX
// RENDERIZAR EL RESULTADO CON EL TEMPLATE Y DATOS DEVUELTOS
// SI NO EXISTE EL TEMPLATE DEVUELTO, MUESTRO UNA PAGINA DE ERROR
//------------------------------------------------------------------------------
include_once $fileController;
$con = new $clase($request);
if (!method_exists($con, $metodo))
    $metodo = "IndexAction";
$result = $con->{$metodo}();

$result['values']['controller'] = $controller;

$result['values']['archivoCss'] = getArchivoCss($result['template']);
$result['values']['archivoJs'] = getArchivoJs($result['template']);

// Cargo los valores para el modo debuger
if ($config['debug_mode']) {
    $result['values']['_debugMode'] = true;
    $result['values']['_auditMode'] = (string) $config['audit_mode'];
    $result['values']['_user'] = print_r($_SESSION['USER'], true);
    $result['values']['_debugValues'] = print_r($result['values'], true);
}

// Si el método no devuelve template o no exite, muestro un template de error.
if (!file_exists($config['twig']['templates_folder'] . '/' . $result['template']) or ($result['template'] == '')) {
    $result['values']['error'] = 'No existe el template: "' . $result['template'] . '" devuelto por el método "' . $clase . ':' . $action . 'Action"';
    $result['template'] = '_global/error.html.twig';
}

// Establecer el layout segun el dispositivo de navegación
if ($_SESSION['isMobile']) {
    $layout = "_global/layoutMobile.html.twig";
} else {
    $layout = "_global/layoutLaptop.html.twig";
}

// Renderizo el template y los valores devueltos por el método
$twig->addGlobal('appPath', $app['path']);
$twig->loadTemplate($result['template'])
        ->display(array(
            'layout' => $layout,
            'values' => $result['values'],
            'app' => $app,
            'chequeadaResolucionVisitante' => isset($_SESSION['resolucionVisitante']),
            'user' => $_SESSION['USER']['user'],
            'menu' => $_SESSION['USER']['menu'],
            'projects' => $_SESSION['projects'],
            'project' => $_SESSION['project'],
        ));

//------------------------------------------------------------

unset($rq);
unset($con);
unset($loader);
unset($twig);
unset($config);

/**
 * Devuelve el nombre del archivo css asociado al template
 * @param string $template
 * @return string
 */
function getArchivoCss($template) {

    $archivoTemplate = str_replace('html', 'css', $template);

    if (!file_exists('modules/' . $archivoTemplate)) {
        $archivoTemplate = "_global/css.twig";
    }

    return $archivoTemplate;
}

/**
 * Devuelve el nombre del archivo js asociado al template
 * @param string $template
 * @return string
 */
function getArchivoJs($template) {

    $archivoTemplate = str_replace('html', 'js', $template);

    if (!file_exists('modules/' . $archivoTemplate)) {
        $archivoTemplate = "_global/js.twig";
    }

    return $archivoTemplate;
}

?>