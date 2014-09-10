<?php

/**
 * Genera una base de datos y usuario en base al esquema
 * indicado en un archivo YAML
 *
 * Carga carga datos en las tablas creadas
 *
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 02-sep-2012 3:48:47
 */
class schemaBuilder
{
    protected $host;
    protected $user;
    protected $password;
    protected $engineDataBase;
    protected $dataBase;
    protected $defaultEngine = 'MyISAM';
    protected $defaultCharSet = 'latin1';
    protected $dropTablesIfExists;
    protected $dbLink = FALSE;
    protected $indices = '';
    protected $sql;
    protected $lastInsertId;
    protected $errores = array();
    protected $log = array();
    protected $nTables = 0;

    public function __construct(array $conection)
    {
        //print_r($conection);
        $this->host = $conection['host'];
        $this->user = $conection ['user'];
        $this->password = $conection['password'];
        $this->engineDataBase = $conection['engineDataBase'];
        $this->dataBase = $conection['dataBase'];
        $this->dropTablesIfExists = $conection['dropTablesIfExists'];

        define('DB_HOST', $this->host);
        define('DB_USER', $this->user);
        define('DB_PASS', $this->password);
        define('DB_BASE', $this->dataBase);
    }

    /**
     * Crea una base de datos
     *
     * @return boolean TRUE si se ha creado la base de datos
     */
    public function createDataBase()
    {
        return $this->doQuery("CREATE DATABASE {$this->dataBase};");
    }

    /**
     * Borra una base de datos
     *
     * @return boolean TRUE si se ha borrado la base de datos
     */
    public function deleteDataBase()
    {
        return $this->doQuery("DROP DATABASE {$this->dataBase};");
    }

    /**
     * Crea un usuario en la base de datos
     *
     * Los datos deben venir en el array $newUser('user' => 'el ususario', 'password' => 'la password')
     *
     *
     * @param  array   $newUser Array con el usuario y contraseña
     * @return boolean TRUE si se ha creado el usuario
     */
    public function createUser(array $newUser)
    {
        $ok = $this->doQuery("CREATE USER '{$newUser['user']}'@'%' IDENTIFIED BY '{$newUser['password']}';");
        if ($ok)
            $ok = $this->doQuery("GRANT SELECT, INSERT, UPDATE, DELETE ON `{$this->dataBase}`.* TO '{$newUser['user']}'@'%';");

        return $ok;
    }

    /**
     * Crea la tabla $name en base al esquema $schema
     *
     * @param  type    $name   El nombre de la tabla
     * @param  array   $schema El array con el esquema de la tabla
     * @return boolean TRUE si la table se creó correctamente
     */
    public function createTable($name, array $schema)
    {
        $hayColumnaId = FALSE;

        $this->indices = "";

        $engine = ($schema['engine'] != '') ? $schema['engine'] : $this->defaultEngine;
        $charSet = ($schema['charSet'] != '') ? $schema['charSet'] : $this->defaultCharSet;

        // Crear sintaxis de las columnas
        if (is_array($schema['columns'])) {
            foreach ($schema['columns'] as $columnName => $attributes) {
                $columnas .= "  " . $this->buildColumn($columnName, $attributes) . ",\n";
                $hayColumnaId = ($hayColumnaId OR $columnName == 'Id' OR strtoupper($attributes['index']) == 'PRIMARY');
            }

            if (!$hayColumnaId) {
                $columnas = "  `Id` bigint(11) NOT NULL AUTO_INCREMENT,\n" . $columnas;
                $this->indices = "\n  PRIMARY KEY (`Id`)," . $this->indices;
            }
        }
        // Crear índices adicionales
        if (is_array($schema['index']))
            foreach ($schema['index'] as $indexName => $indexAttributes) {
                $this->indices .= "\n  {$indexAttributes['type']} `{$indexName}` ({$indexAttributes['columns']}),";
            }

        // Quito las coma final de la relación de índices
        $this->indices = substr($this->indices, 0, -1);

        // Crear sintaxis de las relaciones extranjeras
        if (is_array($schema['relations']))
            foreach ($schema['relations'] as $foreignTable => $attributes) {

            }

        if ($this->dropTablesIfExists) {
            $query = "DROP TABLE IF EXISTS `{$this->dataBase}`.`{$name}`;";
            $this->doQuery($query);
        }
        $query = "CREATE TABLE `{$this->dataBase}`.`{$name}` (\n{$columnas}{$this->indices}\n) ENGINE={$engine} DEFAULT CHARSET={$charSet} COMMENT '{$schema['comment']}';";

        return $this->doQuery($query);
    }

    /**
     * Borra una tabla
     *
     * @return boolean TRUE si se ha borrado la tabla
     */
    public function deleteTable($name)
    {
        return $this->doQuery("DROP TABLE `{$this->dataBase}`.`{$name}`;");
    }

    /**
     * Vacia una tabla
     *
     * @return boolean TRUE si se ha vaciado la tabla
     */
    public function truncateTable($name)
    {
        return $this->doQuery("TRUNCATE TABLE `{$this->dataBase}`.`{$name}`;");
    }

    /**
     * Crea las tablas en base al array $schema
     *
     * @param  array   $schema Array con el esquema de la base de datos
     * @return boolean TRUE si se ha construido el esquema
     */
    public function buildTables(array $schema)
    {
        if (is_array($schema)) {
            foreach ($schema as $tableName => $tableSchema)
                if ($this->createTable($tableName, $tableSchema)) {
                    $this->log[] = "Tabla '{$tableName}' creada.";
                    $this->nTables ++;
                }
            $this->log[] = "TOTAL TABLAS CREADAS {$this->nTables}";
        } else
            $this->errores[] = "NO HAY ESQUEMA";

        return ( count($this->errores) == 0 );
    }

    /**
     * Lee la tablas existentes y genera un archivo yml
     * con el esquema de la base de datos.
     *
     * Este método solo funciona con BDs mysql
     *
     * El archivo generado tiene el nombre de la base de datos
     *
     * @return boolean TRUE si se construyo con éxito
     */
    public function buildSchema()
    {
        $ok = FALSE;
        $arrayTablas = array();

        $dblink = mysql_connect($this->host, $this->user, $this->password);
        mysql_select_db($this->dataBase, $dblink);

        $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . $this->dataBase . "'";
        $result = mysql_query($query, $dblink);
        while ($row = mysql_fetch_array($result)) {
            $entity = new EntityBuilder($row['TABLE_NAME']);
            $arrayTabla = $entity->getSchema();
            $arrayTablas[$row['TABLE_NAME']] = $arrayTabla[$row['TABLE_NAME']];
        }
        unset($entity);

        $yml = "# ESQUEMA DE LA BD " . $this->dataBase . "\n\n";
        $yml .= sfYaml::dump($arrayTablas, 2);

        $archivo = new Archivo($this->dataBase . ".yml");
        $ok = $archivo->write($yml);
        unset($archivo);

        return $ok;
    }

    /**
     * Borra físicamente los registros de todas las tablas
     * que estén marcados como Deleted='1'
     */
    public function clearTables()
    {
        $dblink = mysql_connect($this->host, $this->user, $this->password);
        mysql_select_db($this->dataBase, $dblink);

        $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . $this->dataBase . "'";
        $result = mysql_query($query, $dblink);
        while ($row = mysql_fetch_array($result)) {
            $query = "DELETE FROM {$row['TABLE_NAME']} WHERE Deleted='1';";
            $this->log[] = $query;
            $this->doQuery($query);
        }
    }

    /**
     * Carga datos en las tablas en base al array $fixtures
     *
     * La tabla puede ser vaciada o no antes de la carga, dependiendo
     * del valor del parámetro $truncateTables.
     *
     * Pone en $this->errores[] los posibles errores y además
     * la estadística de la tablas creadas y filas insertadas
     *
     * @param  array   $fixtures       Array con los datos a cargar
     * @param  boolean $truncateTables Si TRUE, vacía la tabla antes de cargarle datos
     * @return boolean TRUE si la carga se hizo correctamente
     */
    public function loadFixtures(array $fixtures, $truncateTables = FALSE)
    {
        if (is_array($fixtures)) {
            foreach ($fixtures as $table => $rows) {
                // Cada Tabla
                $tb = new TableDescriptor($this->dataBase, $table);
                $primaryKeyColumn = $tb->getPrimaryKey();
                unset($tb);

                $nRows = 0;
                if ($truncateTables) {
                    $this->truncateTable($table);
                }

                foreach ($rows as $row)
                // Cada Fila
                    $nRows += $this->insertRow($table, $primaryKeyColumn, $row);

                $this->log[] = "Tabla '{$table}', {$nRows} filas insertadas";
            }
        } else
            $this->errores[] = "NO HAY DATOS QUE CARGAR";

        return ( count($this->errores) == 0 );
    }

    /**
     * Inserta el registro  $row en la tabla $table
     * y pone valores por defecto
     *
     * @param  string  $table El nombre de la tabla
     * @param  array   $row   Array correspondiente a una fila ('columnName' => 'Value')
     * @return boolean TRUE si se insertó correctamente
     */
    private function insertRow($table, $primaryKeyColumn, array $row)
    {
        $columns = '';
        $values = '';

        foreach ($row as $column => $value) {
            $columns .= "`{$column}`,";
            $values .= "'" . addslashes($value) . "',";
            //$values .= "'" . mysql_real_escape_string($value) . "',";
        }
        // Añado valores por defecto
        $columns .= "`CreatedBy`,`CreatedAt`";
        $values .= "'1','" . date('Y-m-d H:i:s') . "'";

        $query = "INSERT INTO `{$this->dataBase}`.`{$table}` ({$columns}) VALUES ({$values});";

        $ok = $this->doQuery($query);

        // Despues de insertar actualizo algunas columnas
        // Se si ha indicado 'SortOrder' lo respeto
        if ($ok) {
            $orden = (isset($row['SortOrder'])) ? $row['SortOrder'] : $this->lastInsertId;
            $updates = "`PrimaryKeyMD5` = '" . md5($this->lastInsertId) . "', `SortOrder` = '" . $orden . "'";
            $query = "UPDATE `{$this->dataBase}`.`{$table}` SET {$updates} WHERE `{$primaryKeyColumn}` = '{$this->lastInsertId}';";
            $ok = $this->doQuery($query);
        }

        return $ok;
    }

    /**
     * Devuelve la sintaxis SQL de definición de una columna
     *
     * Hace conversiones de tipos de datos
     *
     * @param  string $name       Nombre de la columna
     * @param  array  $attributes Array con los atributos de la columna
     * @return string La sintaxis de una columna
     */
    private function buildColumn($name, array $attributes)
    {
        // VALIDAR LOS TIPOS DE DATOS. AQUI HAY QUE ACTUAR
        // DE UNA FORMA U OTRA DEPENDIENDO DEL TIPO DE BASE DE DATOS
        $arrayTipo = explode("(", $attributes['type']);
        $tipo = strtoupper($arrayTipo[0]);
        $precision = str_replace(")", "", $arrayTipo[1]);
        switch ($tipo) {
            case 'TEXT':
                $tipo = 'TEXT';
                break;
            case 'INT':
            case 'INTEGER':
                if (!$precision)
                    $precision = '4';
                $tipo = "INTEGER({$precision})";
                break;
            case 'BIGINT':
                if (!$precision)
                    $precision = '4';
                $tipo = "BIGINT({$precision})";
                break;
            case 'DECIMAL':
                if (!$precision)
                    $precision = '2';
                $tipo = "DECIMAL(10,{$precision})";
                break;
            case 'CHAR':
                if (!$precision)
                    $precision = '1';
                $tipo = "CHAR({$precision})";
                break;
            case 'VARCHAR':
            case 'STRING':
                if (!$precision)
                    $precision = '255';
                $tipo = "VARCHAR({$precision})";
                break;
            case 'TINYINT':
                if (!$precision)
                    $precision = '1';
                $tipo = "TINYINT({$precision})";
                break;
            case 'FLOAT':
                $tipo = "FLOAT";
                break;
            case 'BOOLEAN':
                $tipo = "TINYINT(1)";
                break;
            case 'TIMESTAMP':
                $tipo = "TIMESTAMP";
                break;
            case 'DATETIME':
                $tipo = 'DATETIME';
                break;
            case 'DATE':
                $tipo = "DATE";
                break;
            case 'TIME':
                $tipo = "TIME";
                break;
            default:
                $tipo = "** TIPO NO RECONOCIDO EN LA COLUMNA {$name}: " . $tipo . " " . $precision;
        }

        $column = "`{$name}` {$tipo}";

        if ($attributes['notnull'])
            $column .= " NOT NULL";

        if (isset($attributes['default']))
            $column .= " DEFAULT \"{$attributes['default']}\"";

        if ($attributes['autoIncrement'])
            $column .= " AUTO_INCREMENT";

        if ($attributes['comment'])
            $column .= " COMMENT '{$attributes['comment']}'";

        if ($attributes['index']) {
            if (strtoupper($attributes['index']) == 'PRIMARY')
                $this->indices .= "\n  PRIMARY KEY (`{$name}`),";
            else
                $this->indices .= "\n  {$attributes['index']} `{$name}` (`{$name}`),";
        }

        return $column;
    }

    /**
     * Realiza la conexión a la BD y activa $this->dbLink
     *
     * @return boolean TRUE si la conexión se ha realizado
     */
    private function connect()
    {

        switch ($this->engineDataBase) {
            case 'mysql':
                $this->dbLink = @mysql_connect($this->host, $this->user, $this->password);
                if (!$this->dbLink)
                    $this->errores[] = "ERROR DE CONEXION: " . mysql_errno() . " " . mysql_error();
                break;
            case 'postgres':
                $conexion = "host={$this->host} dbname={$this->dataBase} user={$this->user} password={$this->password}";
                $this->dbLink = pg_connect($conexion);
                if (!$this->dbLink)
                    $this->errores[] = "ERROR DE CONEXION: " . pg_errormessage();
                break;
        }

        return $this->dbLink;
    }

    /**
     * Cierra la conexión a la BD
     */
    private function close()
    {
        if ($this->dbLink) {
            switch ($this->engineDataBase) {
                case 'mysql':
                    mysql_close($this->dbLink);
                    break;
                case 'postgres':
                    pg_close($this->dbLink);
                    break;
            }
        }
    }

    /**
     * Ejecuta la sentencia SQL $query
     *
     * Pone en $this->sql la sentencia ejecutada
     *
     * @param  string  $query Sentencia SQL
     * @return boolean TRUE si se ejecutró con éxito
     */
    private function doQuery($query)
    {
        $ok = false;
        
        $this->sql .= $query . "\n\n";

        if ($this->connect()) {
            $ok = mysql_query($query, $this->dbLink);

            if ($ok)
                $this->lastInsertId = mysql_insert_id($this->dbLink);
            else
                $this->errores[] = "ERROR QUERY: " . mysql_errno($this->dbLink) . " " . mysql_error($this->dbLink) . " " . $query;

            $this->close();
        }

        return $ok;
    }

    /**
     * Devuelve el array con los mensajes de error
     *
     * @return array Array con los errores
     */
    public function getErrores()
    {
        return $this->errores;
    }

    /**
     * Devuelve el array con los mensajes log
     *
     * @return array Array con los texto logs
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Devuelve las sentencias SQL generadas durante todo el proceso
     *
     * @return string Sentencia SQL
     */
    public function getSql()
    {
        return $this->sql;
    }

}
