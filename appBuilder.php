<?php
/**
 * GENERA TODOS LOS FORMULARIOS DE MANTENIMIENTO DE LA BASE DE DATOS INDICADA
 *
 * Por cada tabla se genera un formulario con el mismo nombre que esta. Para conocer
 * las tablas de la BD nos apoyamos en 'INFORMATION_SCHEMA.TABLES'
 *
 * Las etiquetas de los formularios se muestran en base a la varible de
 * sesion $_SESSION['TEXTOS'] para permitir el multiidioma.
 *
 * @author Sergio Perez
 * @copyright INFORMATICA ALBATRONIC SL 28.09.2010 20:14:08
 * @version 1.0
 */
include "class/tabledescriptor.class.php";
include "class/templatebuilder.class.php";
include "class/controllerbuilder.class.php";
include "class/configymlbuilder.class.php";
include "class/listadosymlbuilder.class.php";
include "class/entitybuilder.class.php";
include 'class/columnasComunes.class.php';
include 'class/tiposVariables.class.php';
include "class/CreaFichero.class.php";
include "class/yaml/lib/sfYaml.php";

define('DS', DIRECTORY_SEPARATOR);

$database_connection_information = "
define(DB_HOST,'" . $_POST[dbhost] . "');
define(DB_USER,'" . $_POST[dbuser] . "');
define(DB_PASS,'" . $_POST[dbpassword] . "');
define(DB_BASE,'" . $_POST[dbbase] . "');
define(CARPETA,'" . $_POST[carpeta] . "');
define(APPNAME,'" . $_POST[appname] . "');
define(CONECTION,'" . $_POST[conection] . "');";
if ($_POST['permisos'] == 'on')
    $database_connection_information .= "define(PERMISSIONCONTROL,'YES');";
else
    $database_connection_information .= "define(PERMISSIONCONTROL,'NO');";

eval($database_connection_information);


/**
 * Clase para crear en fichero con el contenido pasado
 * Si el fichero existe, hace una copia del actual anteponiéndole
 * al nombre un guión bajo.
 */
if ($_POST['accion'] == "Generar") {

    // CREAR EL ESQUELETO DE LA APLICACION
    if (($_POST['esqueleto'] == 'on') and (CARPETA != '')) {
        $esqueleto = new Esqueleto();
        $esqueleto->copia("esqueletoWeb", CARPETA);
        // cambiar los permisos de la carpeta destino
        chmod(CARPETA, '0777');
        unset($esqueleto);
    }∫

    if ((DB_BASE != '') and (CARPETA != '')) {
        $dblink = mysql_connect(DB_HOST, DB_USER, DB_PASS);
        mysql_select_db(DB_BASE, $dblink);

        if ($_POST['table'] == '') {
            $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . DB_BASE . "'";
            $result = mysql_query($query, $dblink);
            while ($row = mysql_fetch_array($result))
                $tables[] = $row;
        } else {
            $tables[] = array('0' => $_POST['table'], 'TABLE_NAME' => $_POST['table']);
        }

        $new_classes = array();


        //Recorre todo el schema y para cada tabla genera: form.php, template.php, actions.php y config.xml
        //Los cuatro archivos los ubica en una carpeta con el nombre de la tabla.
        $pathmodel = CARPETA . DS . "entities";

        if (is_array($tables)) {
            foreach ($tables as $row) {
                $tablename = $row['TABLE_NAME'];
                //$new_classes[strtolower($tablename)] = "$tablename";
                $new_classes[$tablename] = "$tablename";

                //$filename = str_replace("_", " ", strtolower($tablename));
                //$filename = str_replace(" ", "", ucwords($filename));
                $filename = $tablename;

                // CREAR MODULO
                // ------------
                $crearModulo = (
                        $_POST['controller'] or
                        $_POST['config'] or
                        $_POST['varEntorno'] or
                        $_POST['varWeb'] or
                        $_POST['listados'] or
                        $_POST['templates'] or
                        $_POST['help']);

                if ($crearModulo) {
                    $pathmodules = CARPETA . DS . "modules" . DS . $filename;
                    if (!file_exists($pathmodules))
                        $ok = @mkdir($pathmodules);
                    else
                        echo "NO EXISTE LA CARPETA ", $pathmodules, "</br>";
                } else
                    $ok = false;


                //Crear el Controlador
                if ($ok and ($_POST['controller'] == 'on')) {
                    $controller = new ControllerBuilder($tablename, false);
                    new CreaFichero($pathmodules . DS . $filename . "Controller.class.php", $controller->Get());
                }

                //Crear el archivo config.yml
                if ($ok and ($_POST['config'] == 'on')) {
                    $config = new ConfigYmlBuilder($tablename);
                    new CreaFichero($pathmodules . DS . "config.yml", $config->getConfigYml());
                }

                //Crear el archivo yml de las variables de entorno
                if ($ok and ($_POST['varEntorno'] == 'on')) {
                    $config = new ConfigYmlBuilder($tablename);
                    new CreaFichero($pathmodules . DS . "varEnv.yml", $config->getFieldsVarEntorno());
                }

                //Crear el archivo yml de las variables web
                if ($ok and ($_POST['varWeb'] == 'on')) {
                    $config = new ConfigYmlBuilder($tablename);
                    new CreaFichero($pathmodules . DS . "varWeb.yml", $config->getFieldsVarWeb());
                }

                //Crear el archivo listados.yml
                if ($ok and ($_POST['listados'] == 'on')) {
                    $listados = new ListadosYmlBuilder($tablename);
                    new CreaFichero($pathmodules . DS . "listados.yml", $listados->Get());
                }

                // Crear templates
                if ($ok and ($_POST['templates'] == 'on')) {
                    $template = new TemplateBuilder($tablename, false);
                    $templates = $template->Get();

                    foreach ($templates as $key => $value) {
                        //Crear el fichero .html.twig de cada template
                        new CreaFichero($pathtemplates . DS . $key . ".html.twig", $value);
                    }
                }

                // Crear help
                if ($ok and ($_POST['help'] == 'on')) {
                    $template = new TemplateBuilder($tablename, false);
                    $templates = $template->Get();
                    new CreaFichero($pathtemplates . DS . "help.html.twig", $templates['help']);
                }


                // CREAR ENTIDAD DE DATOS
                // ----------------------
                if ((file_exists($pathmodel)) and (($_POST['model'] == 'on') or ($_POST['method'] == 'on'))) {
                    //$filename = str_replace("_", " ", strtolower($tablename));
                    //$filename = str_replace(" ", "", ucwords($filename));
                    $filename = $tablename;
                    $entity = new EntityBuilder($tablename);

                    // Crear la clase para el modelo de datos
                    if ($_POST['model'] == 'on')
                        new CreaFichero($pathmodel . DS . "models" . DS . $filename . "Entity.class.php", $entity->GetModel());

                    // Crear la clase para los métodos
                    if ($_POST['method'] == 'on')
                        new CreaFichero($pathmodel . DS . "methods" . DS . $filename . ".class.php", $entity->GetMethod());
                }
            }
        }
    }
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>AppBuilder</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>

    <body>
        <form action="appBuilder.php" method="post" enctype="multipart/form-data">
            <table align="center">
                <tr><td colspan="2" align="center">Generador del esqueleto de una aplicaci&oacute;n</td></tr>
                <tr><td>Servidor</td><td><input name="dbhost" type="text" value="localhost"></td></tr>
                <tr><td>Usuario</td><td><input name="dbuser" type="text" value="root"></td></tr>
                <tr><td>Contrase&ntilde;a</td><td><input name="dbpassword" type="text" value="albatronic"></td></tr>
                <tr><td>Base de datos</td><td><input name="dbbase" type="text" value="cpanel"></td></tr>
                <tr><td>Conexi&oacute;n</td><td><input name="conection" type="text" value="datos#"></td></tr>
                <tr><td>Tabla</td><td><input name="table" type="text" value=""></td></tr>
                <tr><td>Generar esqueleto</td><td><input name="esqueleto" type="checkbox"></td></tr>
                <tr><td>Carpeta destino (sin '/' al final)</td><td><input name="carpeta" type="text" size="50" value="/home/sergio/NetBeansProjects/"></td></tr>
                <tr><td>App Name</td><td><input name="appname" type="text" value="CPanel"></td></tr>
                <tr><td>Gesti&oacute;n de Permisos</td><td><input name="permisos" type="checkbox" checked></td></tr>
                <tr><td>Generar Controlador</td><td><input name="controller" type="checkbox"></td></tr>
                <tr><td>Generar config.yml</td><td><input name="config" type="checkbox"></td></tr>
                <tr><td>Generar varEntorno.yml</td><td><input name="varEntorno" type="checkbox"></td></tr>
                <tr><td>Generar varWeb.yml</td><td><input name="varWeb" type="checkbox"></td></tr>
                <tr><td>Generar listados.yml</td><td><input name="listados" type="checkbox"></td></tr>
                <tr><td>Generar Templates</td><td><input name="templates" type="checkbox"></td></tr>
                <tr><td>Generar Ayudas</td><td><input name="help" type="checkbox"></td></tr>
                <tr style="height: 10px;"><td colspan="2"></td></tr>
                <tr><td>Generar Modelo de datos</td><td><input name="model" type="checkbox"></td></tr>
                <tr><td>Generar Metodos !! CUIDADO ¡¡</td><td><input name="method" type="checkbox"></td></tr>
                <tr>
                    <td colspan="2" align="center">
                        <input name="accion" value="Generar" type="submit">&nbsp;
                        <input name="accion" value="Cancelar" type="submit">
                    </td>
                </tr>
            </table>
        </form>
        <p>NOTA: Para que se cree la lógica de integridad de datos entre las tablas referenciadas es VITAL
            que en el campo 'COMMENT' de las columnas que hacen referencia a otras tablas se indiquen los siguientes 3 valores separados por coma:
        </p>
        <ul>
            <li>nombre de la base de datos</li>
            <li>nombre <b>físico</b> de la tabla referenciada (<b>no el nombre de la entidad</b>)</li>
            <li>nombre de la columna de la tabla referenciada</li>
        </ul>
    </body>
</html>