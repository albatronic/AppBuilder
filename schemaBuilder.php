<?php
/**
 * UTILIDAD PARA CREAR/BORRAR BASES DE DATOS Y TABLAS
 * EN BASE A ARCHIVOS DE CONFIGURACION YAML
 *
 *  * Crea una base de datos y sus tablas a partir del esquema yml
 *  * Carga datos en las tablas a partir de los fixtures yml
 *  * Crea y da permisos a usuarios
 *
 *
 *  * DEPENDENCIAS:
 *
 *     Clase para leer archivos YAML: class/yaml/lib/sfYaml.php
 *     Clase class/schemaBuilder.class.php
 *     Clase class/Archivo.class.php
 *
 *
 *  * EJEMPLO DEL ESQUEMA DE UNA TABLA EN FORMATO YAML:
 *
 *    IMPORTANTE: No hay que indicar la columna primarykey.
 *                Siempre se creará una columna de nombre 'id' que será primarykey
 *
  clientes:
  engine: EL TIPO DE TABLA: InnoDB, MyISAM, MEMORY, ETC. POR DEFECTO MyISAM
  charSet: EL JUEGO DE CARACTERES, POR DEFECTO latin1
  comment: TEXTO CON EL COMENTARIO PARA LA TABLA
  columns:
  category_id:  { type: integer, notnull: true }
  type:         { type: string(255) }
  company:      { type: string(255), notnull: true }
  logo:         { type: string(255) }
  url:          { type: string(255) }
  position:     { type: string(255), notnull: true }
  location:     { type: string(255), notnull: true }
  description:  { type: string(4000), notnull: true }
  how_to_apply: { type: string(4000), notnull: true }
  token:        { type: string(255), notnull: true, index: unique }
  is_public:    { type: boolean, notnull: true, default: 1 }
  is_activated: { type: boolean, notnull: true, default: 0 }
  email:        { type: string(255), notnull: true }
  expires_at:   { type: timestamp, notnull: true }
  relations:
  tablaRelacionada: { onDelete: CASCADE, local: category_id, foreign: id, foreignAlias: JobeetJobs }
 *
 *
 *  * EJEMPLO DE ARCHIVO FIXTURES EN FORMATO YAML:
 *
 * # data/fixtures/clientes.yml
  clientes:
  cliente1:
  JobeetCategory: programming
  type:         full-time
  company:      Sensio Labs
  logo:         sensio-labs.gif
  url:          http://www.sensiolabs.com/
  position:     Web Developer
  location:     Paris, France
  description:  |
  You've already developed websites with symfony and you want to work
  with Open-Source technologies. You have a minimum of 3 years
  experience in web development with PHP or Java and you wish to
  participate to development of Web 2.0 sites using the best
  frameworks available.
  how_to_apply: |
  Send your resume to fabien.potencier [at] sensio.com
  is_public:    true
  is_activated: true
  token:        job_sensio_labs
  email:        job@example.com
  expires_at:   '2010-10-10'

  cliente2:
  JobeetCategory:  design
  type:         part-time
  company:      Extreme Sensio
  logo:         extreme-sensio.gif
  url:          http://www.extreme-sensio.com/
  position:     Web Designer
  location:     Paris, France
  description:  |
  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
  eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
  enim ad minim veniam, quis nostrud exercitation ullamco laboris
  nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
  in reprehenderit in.

  Voluptate velit esse cillum dolore eu fugiat nulla pariatur.
  Excepteur sint occaecat cupidatat non proident, sunt in culpa
  qui officia deserunt mollit anim id est laborum.
  how_to_apply: |
  Send your resume to fabien.potencier [at] sensio.com
  is_public:    true
  is_activated: true
  token:        job_extreme_sensio
  email:        job@example.com
  expires_at:   '2010-10-10'

  clienteN:
  ..........
 *
 *
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 02-sep-2012 3:48:47
 *
 */
/**
 * CARGA DE LAS CLASES NECESARIAS
 */
if (file_exists("class/yaml/lib/sfYaml.php"))
    include "class/yaml/lib/sfYaml.php";
else
    die("NO EXISTE LA CLASE PARA LEER ARCHIVOS YAML");

if (file_exists("class/schemaBuilder.class.php"))
    include "class/schemaBuilder.class.php";
else
    die("NO EXISTE LA CLASE schemaBuilder.class.php");

if (file_exists("class/Archivo.class.php"))
    include "class/Archivo.class.php";
else
    die("NO EXISTE LA CLASE schemaBuilder.class.php");

class schema {

    protected $connection;
    protected $sb;
    protected $sql;
    protected $errores = array();

    public function __construct($connection = '') {

        $this->connection = $connection;

        if (is_array($this->connection['POST'])) {
            $this->sb = new schemaBuilder($this->connection['POST']);
        }
    }

    public function build($arraySchema) {

        if (is_array($arraySchema))
            $ok = $this->sb->buildSchema($arraySchema);
        else
            $this->errores[] = "No ha seleccionado el archivo con el esquema";
    }

    public function loadFixtures($arrayFixtures) {

        if (is_array($arrayFixtures))
            $ok = $this->sb->loadFixtures($arrayFixtures);
        else
            $this->errores[] = "No ha seleccionado el archivo con los datos";

    }

    public function createDataBase() {

        return $this->sb->createDataBase();
    }

    public function deleteDataBase() {

        return $this->sb->deleteDataBase();
    }

    public function createUser(array $user) {

        return $this->sb->createUser($user);
    }

    /**
     * ESCRIBE EN EL FICHERO lastConnection.yml LOS DATOS DE LA
     * ULTIMA CONEXIÓN QUE ESTAN EN $_POST
     */
    public function saveCurrentParametersConnection() {
        $texto = sfYaml::dump($this->connection);
        $archivo = new Archivo("lastConnection.yml");
        $archivo->write($texto);
        unset($archivo);
    }

    /**
     * LEE DEL FICHERO lastConnection.yml CON LOS DATOS DE CONEXIÓN
     * DE LA ÚLTIMA SESION
     *
     * @return array Array con los parametros $_POST de la última conexión
     */
    public function getLastParametersConnection() {

        $parameters = array();

        if (file_exists("lastConnection.yml")) {
            $lastConnection = sfYaml::load('lastConnection.yml');
            $parameters = $lastConnection['POST'];
        }

        return $parameters;
    }

    public function valida() {

        $errores = array();

        if ($_FILES['fileNameSchema']['name'] != '') {
            if (!is_uploaded_file($_FILES['fileNameSchema']['tmp_name']))
                $errores[] = "El archivo {$_FILES['fileNameSchema']['name']} no se ha cargado";
        }

        if ($_FILES['fileNameFixtures']['name'] != '') {
            if (!is_uploaded_file($_FILES['fileNameFixtures']['tmp_name']))
                $errores[] = "El archivo {$_FILES['fileNameFixtures']['name']} no se ha cargado";
        }

        if ($_POST['dataBase'] == '')
            $errores[] = "Debe indicar una base de datos";

        return $errores;
    }

    public function getSql() {
        return $this->sb->getSql();
    }

    public function getErrores() {

        return array_merge($this->errores, $this->sb->getErrores());
    }

    public function getLog() {
        return $this->sb->getLog();
    }

}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $schema = new schema();
        $_POST = $schema->getLastParametersConnection();
        unset($schema);
        break;

    case 'POST':

        $connection = array(
            'POST' => array(
                'host' => $_POST['host'],
                'user' => $_POST['user'],
                'password' => $_POST['password'],
                'dataBase' => $_POST['dataBase'],
                'dropTablesIfExists' => ($_POST['dropTablesIfExists'] == 'on'),
            ),
            'FILES' => $_FILES,
        );

        $schema = new schema($connection);
        $schema->saveCurrentParametersConnection();

        $errores = $schema->valida();

        if (!count($errores)) {
            $ok = TRUE;

            if ($_POST['dropDataBase'] == 'on')
                $ok = $schema->deleteDataBase();

            if ($_POST['createDataBase'] == 'on')
                $ok = $schema->createDataBase();

            if (($ok) and ($_POST['createUser'] == 'on'))
                $ok = $schema->createUser($_POST['newUser']);

            if ($ok) {
                switch ($_POST['action']) {
                    case 'BUILD':
                        $schema->build(sfYaml::load($_FILES['fileNameSchema']['tmp_name']));
                        break;
                    case 'LOAD FIXTURES':
                        $schema->loadFixtures(sfYaml::load($_FILES['fileNameFixtures']['tmp_name']));
                        break;
                    case 'BUILD AND LOAD':
                        $schema->build(sfYaml::load($_FILES['fileNameSchema']['tmp_name']));
                        $schema->loadFixtures(sfYaml::load($_FILES['fileNameFixtures']['tmp_name']));
                        break;
                }
            }

            $errores = $schema->getErrores();
            $log = $schema->getLog();
            $sql = $schema->getSql();
        }

        unset($schema);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Schema Builder</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>

    <body>

        <p style="text-align: center;">Crea la base de datos a partir de la definición del esquema en sintaxis YAML indicada en el archivo 'YAML file Schema'</p>
        <p style="text-align: center;">Si se indica el archivo 'YAML file Fixtures', se cargarán los datos contenidos en el.</p>
        <p style="text-align: center; font-weight: bold;">MUCHO CUIDADO QUE PUEDES BORRAR LA BASE DE DATOS QUE NO QUERÍAS</p>

        <div style="width: 49%; float: left;">
            <form action="schemaBuilder.php" method="post" enctype="multipart/form-data">
                <table align="center">
                    <tr><td colspan="2" align="center">SCHEMA BUILDER</td></tr>
                    <tr><td>Server</td><td><input name="host" type="text" value="<?php echo $_POST['host']; ?>"></td></tr>
                    <tr><td>User</td><td><input name="user" type="text" value="<?php echo $_POST['user']; ?>"></td></tr>
                    <tr><td>Password</td><td><input name="password" type="text" value="<?php echo $_POST['password']; ?>"></td></tr>
                    <tr><td>Data Base</td><td><input name="dataBase" type="text" value="<?php echo $_POST['dataBase']; ?>"></td></tr>
                    <tr><td>YAML file Schema</td><td><input name="fileNameSchema" type="file" size="50" /></td></tr>
                    <tr><td>YAML file Fixtures</td><td><input name="fileNameFixtures" type="file" size="50" /></td></tr>
                    <tr><td>Create Data Base </td><td><input name="createDataBase" type="checkbox"></td></tr>
                    <tr><td>Create User</td>
                        <td>
                            <input name="createUser" type="checkbox">
                            User: <input name="newUser[user]" type="text" size="10"/>
                            Password: <input name="newUser[password]" type="text" size="10"/>
                        </td>
                    </tr>
                    <tr><td>Drop Data Base </td><td><input name="dropDataBase" type="checkbox" title="¡¡¡ BORRA la base de datos !!!!"></td></tr>
                    <tr><td>Drop Tables</td><td><input name="dropTablesIfExists" type="checkbox" title="AÑADE 'DROP TABLE IF EXISTS'"></td></tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input name="action" value="BUILD" type="submit" title="CREA las tablas en base al esquema">&nbsp;
                            <input name="action" value="LOAD FIXTURES" type="submit" title="VACIA las tablas y CARGA los datos">&nbsp;
                            <input name="action" value="BUILD AND LOAD" type="submit" title="CREA las tablas y CARGA los datos">&nbsp;
                            <input name="action" value="CANCEL" type="submit">
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
            <div style="width: 49%; float: right; text-align: center;">
                <div style="text-align: center;">SENTENCIAS SQL</div>
                <textarea cols="70" rows="19"><?php echo $sql; ?></textarea>
            </div>

            <div style="clear: both;"></div>

            <div style="margin-top: 5px; width: 49%; text-align: center; float: left;">
                <div style="text-align: center;">ERRORES</div>
                <textarea cols="75" rows="9">
                    <?php
                    foreach ($errores as $error)
                        echoln($error);
                    ?>
                </textarea>
            </div>

            <div style="margin-top: 5px; width: 49%; text-align: center; float: right;">
                <div style="text-align: center;">LOG</div>
                <textarea cols="75" rows="9">
                    <?php
                    foreach ($log as $texto)
                        echoln($texto);
                    ?>
                </textarea>
            </div>
        <?php } ?>
    </body>
</html>