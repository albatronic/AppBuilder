<?php

/**
 * Genera una base de datos y usuario en base al esquema
 * indicado en un archivo YAML
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 02-sep-2012 3:48:47
 */
class schemaBuilder {

    protected $errores = array();
    protected $host;
    protected $user;
    protected $password;
    protected $dataBase;
    protected $engine = 'MyISAM';
    protected $charSet = 'latin1';
    protected $dbLink = FALSE;

    public function __construct(array $conection) {
        $this->host = $conection['host'];
        $this->user = $conection ['user'];
        $this->password = $conection['password'];
        $this->dataBase = $conection['dataBase'];
    }

    /**
     * Crea una base de datos
     *
     * @return boolean TRUE si se ha creado la base de datos
     */
    public function createDataBase() {

        $ok = FALSE;

        if ($this->connect()) {
            $ok = $this->doQuery("CREATE DATABASE `{$this->dataBase}`;");
            $this->close();
        }

        return $ok;
    }

    /**
     * Crea un usuario en la base de datos
     *
     * @return boolean TRUE si se ha creado el usuario
     */
    public function createUser() {

        $ok = FALSE;

        if ($this->connect()) {

            $this->close();
        }

        return $ok;
    }

    /**
     * Crea las tablas en base al array $schema
     *
     * @param array $schema
     * @return array Array de errores
     */
    public function buildSchema(array $schema) {

        if ($this->connect()) {
            foreach ($schema as $tableName => $tableSchema) {
                $this->createTable($tableName, $tableSchema);
            }
        }

        return $this->errores;
    }

    /**
     * Crea la tabla $name en base al esquema $schema
     *
     * @param type $name El nombre de la tabla
     * @param array $schema El array con el esquema de la tabla
     * @return boolean TRUE si la table se creó correctamente
     */
    private function createTable($name, array $schema) {

        $columnas = "`id` bigint(11) NOT NULL AUTO_INCREMENT,";
        $indices = "PRIMARY KEY (`id`)";
        $query = "CREATE TABLE `{$this->dataBase}`.`{$name}` ({$columnas} {$indices}) ENGINE={$this->engine} DEFAULT CHARSET={$this->charSet};";

        if ($ok) {
            // Crear las columnas
            if (is_array($schema['columns']))
                foreach ($schema['columns'] as $column) {

                }

            // Crear las relaciones extranjeras
            if (is_array($schema['relations']))
                foreach ($schema['relations'] as $relation) {

                }
        }

        echo $query;
        $ok = $this->doQuery($query);

        return $ok;
    }

    /**
     * Realiza la conexión a la BD y activa $this->dbLink
     *
     * @return boolean TRUE si la conexión se ha realizado
     */
    public function connect() {

        if (!$this->dbLink)
            $this->dbLink = mysql_connect($this->host, $this->user, $this->password);


        return $this->dbLink;
    }

    /**
     * Cierra la conexión a la BD
     */
    public function close() {
        if ($this->dbLink)
            mysql_close($this->dbLink);
    }

    /**
     * Devuelve el dbLink
     *
     * @return integer
     */
    public function getDbLink() {
        return $this->dbLink;
    }

    /**
     * Devuelve el array con los mensajes de error
     *
     * @return array Array con los errores
     */
    public function getErrores() {
        return $this->errores;
    }

    private function doQuery($query) {

        $ok = mysql_query($query, $this->dbLink);

        if (!$ok)
            $this->errores[] = "ERROR QUERY: " . $query;

        return $ok;
    }

}

?>
