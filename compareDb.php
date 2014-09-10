<?php
/**
 * UTILIDAD PARA COMPARAR Y SINCRONIZAR BASES DE DATOS
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
 *     Clase class/entitybuilder.class.php
 *
 *
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 06-mar-2013 21:08:47
 *
 */
/**
 * CARGA DE LAS CLASES NECESARIAS
 */
if (file_exists("class/yaml/lib/sfYaml.php"))
    include 'class/yaml/lib/sfYaml.php';
else
    die("NO EXISTE LA CLASE PARA LEER ARCHIVOS YAML");

if (file_exists("class/Archivo.class.php"))
    include 'class/Archivo.class.php';
else
    die("NO EXISTE LA CLASE Archivo.class.php");

if (file_exists("class/entitybuilder.class.php"))
    include 'class/entitybuilder.class.php';
else
    die("NO EXISTE LA CLASE entitybuilder.class.php");

if (file_exists("class/tabledescriptor.class.php"))
    include 'class/tabledescriptor.class.php';
else
    die("NO EXISTE LA CLASE tabledescriptor.class.php");

$colores = array(
    '' => 'green',
    'Update' => 'blue',
    'Delete' => 'red',
    'Create' => 'orange',
);

class compare
{
    protected $connection;
    protected $sb;
    protected $sql;
    protected $lastConnection = "lastConnectionCompareDb.yml";
    protected $dbLinkSource;
    protected $dbLinkTarget;
    protected $log;
    protected $errores = array();

    public function __construct($connection = '')
    {
        $this->connection = $connection;

        if (is_array($this->connection)) {
            $this->dbLinkSource = $this->conecta($this->connection['SOURCE']);
            $this->dbLinkTarget = $this->conecta($this->connection['TARGET']);

            if (!$this->dbLinkSource)
                $this->errores[] = "Error conexion origen";
            if (!$this->dbLinkTarget)
                $this->errores[] = "Error conexion destino";
        }
    }

    public function conecta($conexion)
    {
        $dbLink = mysql_connect($conexion['host'], $conexion['user'], $conexion['password']);

        if ($dbLink) {
            $connnectId = mysql_select_db($conexion['dataBase']);
            if (!$connnectId)
                $dbLink = null;
        }

        return $dbLink;
    }

    public function getTables($conexion)
    {
        $database_connection_information = "
        define(DB_HOST,'" . $this->connection[$conexion]['host'] . "');
        define(DB_USER,'" . $this->connection[$conexion]['user'] . "');
        define(DB_PASS,'" . $this->connection[$conexion]['password'] . "');
        define(DB_BASE,'" . $this->connection[$conexion]['dataBase'] . "');";

        eval($database_connection_information);

        $tables = array();

        $dblink = mysql_connect($this->connection[$conexion]['host'], $this->connection[$conexion]['user'], $this->connection[$conexion]['password']);
        mysql_select_db($this->connection[$conexion]['dataBase'], $dblink);

        $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='{$this->connection[$conexion]['dataBase']}'";
        $result = mysql_query($query, $dblink);
        while ($row = mysql_fetch_array($result)) {
            $td = new TableDescriptor($this->connection[$conexion]['dataBase'], $row[0]);
            $aux = $td->getColumns();
            foreach ($aux as $value)
                $tables[$row[0]]['columns'][$value['Field']] = $value;
        }
        unset($td);

        return $tables;
    }

    public function getComparation()
    {
        $tablesSource = $this->getTables('SOURCE');
        $tablesTarget = $this->getTables('TARGET');

        foreach ($tablesSource as $table => $columns) {
            $tablesSource[$table]['status'][0] = "Not in target";
            $tablesSource[$table]['action'] = "Create";
        }

        $resultado = $tablesSource;

        foreach ($tablesTarget as $table => $columns) {
            $i = -1;
            if (isset($resultado[$table])) {
                // La tabla destino existe en el origen
                $resultado[$table]['status'][0] = "";

                // Comprobar si ambas tablas son exactamente iguales
                if (!($resultado[$table]['columns'] === $tablesTarget[$table]['columns'])) {
                    // Las tablas no son iguales, averiguar las diferencias
                    $resultado[$table]['diff'] = $this->getDiferenciaColumnas($resultado[$table]['columns'], $tablesTarget[$table]['columns']);

                    $resultado[$table]['action'] = "Update";
                } else {
                    // Las dos tablas son exactamente iguales
                    $resultado[$table]['status'][++$i] = 'Ok';
                    $resultado[$table]['action'] = '';
                }
            } else {
                // La tabla destino no existe en el origen
                $resultado[$table] = $columns;
                $resultado[$table]['status'][++$i] = "Not in source";
                $resultado[$table]['action'] = "Delete";
            }
        }

        return $resultado;
    }

    /**
     * Obtener un array con las columnas que difieren entre las
     * columnas origen y la de destino
     *
     * @param  array $columnasOrigen
     * @param  array $columnasDestino
     * @return array Array con las columnas que difieren
     */
    public function getDiferenciaColumnas($columnasOrigen, $columnasDestino)
    {
        $diferencias = array();

        // Recorro las columnas origen y las comparo con las de destinos
        foreach ($columnasOrigen as $key => $columna)
            if (!isset($columnasDestino[$key])) {
                $diferencias['add'][] = $columnasOrigen[$key];
            } elseif (!($columna === $columnasDestino[$key]))
                $diferencias['alter'][] = $columnasOrigen[$key];

        // Recorro las columnas destino y las comparo con las origen
        foreach ($columnasDestino as $key => $columna)
            if (!isset($columnasOrigen[$key]))
                $diferencias['delete'][] = $key;

        return $diferencias;
    }

    public function applyChanges()
    {
        foreach ($this->connection['tables'] as $table => $value)
            switch ($value['action']) {
                case 'Update':
                    $this->updateColumn($table,$value['diff']);
                    break;
                case 'Create':
                    $this->createTable($table);
                    break;
                case 'Delete':
                    $this->deleteTable($table);
                    break;
            }

    }

    public function updateColumn($table,$cambios)
    {
        $table = "{$this->connection['TARGET']['dataBase']}.{$table}";

        $cambios = sfYaml::load($cambios);
        echo $table," ";print_r($cambios);
        foreach ($cambios['alter'] as $cambio) {
            $query = "ALTER TABLE {$table} CHANGE {$cambio['Field']} {$cambio['Field']} {$cambio['Type']}({$cambio['Length']}) ";
            $query .= ($cambio['Default'] != '') ? "DEFAULT '{$cambio['Default']}' " : "";
            $query .= ($cambio['Null'] == 'YES') ? "NOT NULL" : "";
            $query .= ";";
            $this->log[] = $query;
        }

        foreach ($cambios['delete'] as $cambio) {
            $query = "ALTER TABLE {$table} DROP {$cambio};";
            $this->log[] = $query;
        }

    }

    public function deleteTable($table)
    {
        $query = "DROP TABLE {$this->connection['TARGET']['dataBase']}.{$table}";
        //$res = mysql_query($query,$this->dbLinkTarget);
        $this->log[] = $query;
        //if (!$res) $this->errores[] = mysql_errno() . " " .mysql_error ();
    }

    public function buildTables($arraySchema)
    {
        if (is_array($arraySchema))
            $this->sb->buildTables($arraySchema);
        else
            $this->errores[] = "No ha seleccionado el archivo con el esquema";
    }

    /**
     * Construye el esquema yml en base las las tablas existentes
     */
    public function buildSchema()
    {
        if (!$this->sb->buildSchema())
            $this->errores = $this->sb->getErrores();
    }

    /**
     * ESCRIBE EN EL FICHERO lastConnection.yml LOS DATOS DE LA
     * ULTIMA CONEXIÓN QUE ESTAN EN $_POST
     */
    public function saveCurrentParametersConnection()
    {
        $texto = sfYaml::dump($this->connection);
        $archivo = new Archivo($this->lastConnection);
        $archivo->write($texto);
        unset($archivo);
    }

    /**
     * LEE DEL FICHERO lastConnectionCompareDb.yml CON LOS DATOS DE CONEXIÓN
     * DE LA ÚLTIMA SESION
     *
     * @return array Array con los parametros $_POST de la última conexión
     */
    public function getLastParametersConnection()
    {
        $parameters = array();

        if (file_exists($this->lastConnection))
            $parameters = sfYaml::load($this->lastConnection);

        return $parameters;
    }

    public function getSql()
    {
        return $this->sql;
    }

    public function getErrores()
    {
        return $this->errores;
    }

    public function getLog()
    {
        return $this->log;
    }

}

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        $compare = new compare();
        $_POST = $compare->getLastParametersConnection();
        unset($compare);
        break;

    case 'POST':
        switch ($_POST['action']) {
            case 'Compare':
                $compare = new compare($_POST);
                $compare->saveCurrentParametersConnection();
                $resultado = $compare->getComparation();
                $errores = $compare->getErrores();
                break;

            case 'Apply changes':
                $compare = new compare($_POST);
                $resultado = $compare->applyChanges();
                $errores = $compare->getErrores();
                $log = $compare->getLog();
                break;
        }
        unset($compare);
        break;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Compare Data Bases</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <script src="http://code.jquery.com/jquery-latest.js"></script>
    </head>

    <body>

        <p style="text-align: center;">Compara y sincroniza dos bases de datos</p>
        <p style="text-align: center;">Los eventuales cambios se realizar&aacute;n sobre la base de datos TARGET</p>
        <p style="text-align: center; font-weight: bold;">BE CAREFUL, YOU CAN ALTER THE DATA BASE DID NOT WANT</p>

        <div style="width: 40%; float: left;">
            <div style="">
                <form name="formCompare" action="compareDb.php" method="post">
                    <div style="float: left;">
                        <table>
                            <tr><td colspan="2" align="center">SOURCE DATA BASE</td></tr>
                            <tr><td>Server</td><td><input name="SOURCE[host]" type="text" value="<?php echo $_POST['SOURCE']['host']; ?>" onblur="if ($('#target_host').val() == '') $('#target_host').val(this.value);"></td></tr>
                            <tr><td>User</td><td><input name="SOURCE[user]" type="text" value="<?php echo $_POST['SOURCE']['user']; ?>" onblur="if ($('#target_user').val() == '') $('#target_user').val(this.value);"></td></tr>
                            <tr><td>Password</td><td><input name="SOURCE[password]" type="text" value="<?php echo $_POST['SOURCE']['password']; ?>" onblur="if ($('#target_password').val() == '') $('#target_password').val(this.value);"></td></tr>
                            <tr><td>Data Base</td><td><input name="SOURCE[dataBase]" type="text" value="<?php echo $_POST['SOURCE']['dataBase']; ?>" onblur="$('#target_dataBase').focus();"></td></tr>
                        </table>
                    </div>
                    <div style="float: left;">
                        <table>
                            <tr><td colspan="2" align="center">TARGET DATA BASE</td></tr>
                            <tr><td>Server</td><td><input name="TARGET[host]" id="target_host" type="text" value="<?php echo $_POST['TARGET']['host']; ?>"></td></tr>
                            <tr><td>User</td><td><input name="TARGET[user]" id="target_user" type="text" value="<?php echo $_POST['TARGET']['user']; ?>"></td></tr>
                            <tr><td>Password</td><td><input name="TARGET[password]" id="target_password" type="text" value="<?php echo $_POST['TARGET']['password']; ?>"></td></tr>
                            <tr><td>Data Base</td><td><input name="TARGET[dataBase]" id="target_dataBase" type="text" value="<?php echo $_POST['TARGET']['dataBase']; ?>"></td></tr>
                        </table>
                    </div>
                    <div style="clear: both; width: 100%; text-align: center;"><input name="action" value="Compare" type="submit" title="COMPARA las dos bases de datos"/></div>
                </form>
            </div>

            <div style="margin-top: 5px; text-align: center; float: left;">
                <div style="text-align: center;">ERRORES</div>
                <textarea cols="56" rows="9"><?php foreach ($errores as $error) echoln($error);?></textarea>
            </div>

            <div style="margin-top: 5px; text-align: center; float: left;">
                <div style="text-align: center;">LOG</div>
                <textarea cols="56" rows="9"><?php foreach ($log as $texto) echoln($texto);?></textarea>
            </div>
        </div>

        <?php if (($_SERVER['REQUEST_METHOD'] == 'POST') and (count($errores) == 0)) { ?>
            <div style="width: 59%; float: right; text-align: center;">
                <div style="text-align: center;">RESULT</div>
                <form name="formActualiza" action="compareDb.php" method="post">
                    <input name="SOURCE[host]" type="hidden" value="<?php echo $_POST['SOURCE']['host']; ?>"/>
                    <input name="SOURCE[user]" type="hidden" value="<?php echo $_POST['SOURCE']['user']; ?>"/>
                    <input name="SOURCE[password]" type="hidden" value="<?php echo $_POST['SOURCE']['password']; ?>"/>
                    <input name="SOURCE[dataBase]" type="hidden" value="<?php echo $_POST['SOURCE']['dataBase']; ?>"/>
                    <input name="TARGET[host]" type="hidden" value="<?php echo $_POST['TARGET']['host']; ?>"/>
                    <input name="TARGET[user]" type="hidden" value="<?php echo $_POST['TARGET']['user']; ?>"/>
                    <input name="TARGET[password]" type="hidden" value="<?php echo $_POST['TARGET']['password']; ?>"/>
                    <input name="TARGET[dataBase]" type="hidden" value="<?php echo $_POST['TARGET']['dataBase']; ?>"/>
                <table style="width: 100%; border: 1px solid;">
                    <tr style="background-color: black; color: white;"><th>Table</th><th>Status</th><th>Action</th></tr>
                    <?php foreach ($resultado as $key => $tabla) {?>
                        <tr style="color:<?php echo $colores[$tabla['action']];?>">
                            <td><?php echo $key; ?></td>
                            <td><?php foreach ($tabla['status'] as $status) echo "{$status}<br/>";?></td>
                            <td>
                                <?php
                                if ($tabla['action'] != '') {
                                    $valueCheck = ($tabla['action'] != 'Delete');
                                ?>
                                    <input name="tables[<?php echo $key;?>][diff]" value="<?php echo sfYaml::dump($tabla['diff'],3);?>" type="hidden"/>
                                    <input name="tables[<?php echo $key;?>][action]" value="<?php echo $tabla['action'];?>" type="checkbox" <?php if ($valueCheck) echo "checked";?>/>
                                <?php }
                                echo $tabla['action'];
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3" style="text-align: center; border-top: 1px solid;">
                            <input name="action" value="Apply changes" type="submit"/>
                        </td>
                    </tr>
                </table>
                </form>
            </div>

            <div style="clear: both;"></div>
        <?php } ?>
    </body>
</html>
