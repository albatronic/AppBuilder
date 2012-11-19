<?php
/**
 * GENERAR EL DESCRIPTOR DE UNA TABLA Y LAS RELACIONES CON OTRAS
 *
 * MEDIANTE EL METODO getColumns() OBTENEMOS UN ARRAY CON LA DESCRIPCION DE TODAS LAS COLUMNAS DE LA TABLA.
 * A SABER:
 *
 * 	- Field                     Nombre de la columna
 * 	- Type                      Tipo de dato que almacena
 * 	- Null                      Si permite valores nulos (YES,NO)
 * 	- Key                       Tipo de indice (nada,PRI,UNI,MUL)
 * 	- Default                   Valor por defecto para la columna
 * 	- Extra                     Nada o auto_increment
 * 	- Length                    Longitud del campo. Sin valor para los tipos de datos: enum,text,date,datetime
 * 	- Values                    Lista de valores para el caso de que el tipo sea 'enum'
 *      - ReferencedSchema          Nombre de la base de datos extranjeta
 *      - ReferencedEntity          Nombre de la tabla extrajera
 *      - ReferencedColumn          Nombre de la columna de la clave extranjera
 *
 *
 * NOTA: Para obtener el descriptor de las columnas nos basamos en la sentencia sql SHOW COLUMNS
 *
 * NOTA: Para obtener las referencias externas a tablas y claves extranjeras usamos:
 *
 *          1) Para tablas MyISAM: La columna COLUMN_COMMENT de 'information_schema'.'columns'. En dicha columna
 *              habrá tres valores separados por coma: la base de datos, la tabla y la columna extranjera.
 *          2) Para tablas InnoDB: La tabla 'information_schema'.'key_column_usage'
 *
 * NOTA: Para recorrer el array:
 * 	foreach ($columns as $column)
 * 		foreach($column as $key=>$value) echo $value;
 *
 * @author Sergio Perez
 * @copyright Informatica ALBATRONIC, SL 22.10.2010
 * @version 1.0
 */
class TableDescriptor {

    /**
     *
     * @var string El nombre de la base de datos
     */
    private $db;
    /**
     *
     * @var string El nombre de la tabla a describir
     */
    private $table;
    /**
     *
     * @var string El tipo de motor que utiliza la tabla (MyISAM,InnoDB,..)
     */
    private $engine;
    /**
     *
     * @var int El link de conexion a la base de datos
     */
    private $dblink;
    /**
     *
     * @var array Descripcion de las columnas
     */
    private $columns = array();
    /**
     *
     * @var string Almacena el nombre de la columna que es primary_key
     */
    private $primary_key;
    /**
     *
     * @var array con las entidades referenciadas
     */
    private $referencedEntities = array();

    /**
     * Constructor
     * @param string $db      El nombre de la base de datos
     * @param string $table   El nombre de la tabla
     */
    public function __construct($db, $table) {
        $this->db = $db;
        $this->table = $table;
        if ($this->Connect())
            $this->Load();
    }

    /**
     * Desctructor. Cierra el link a la base de datos
     */
    public function __destruct() {
        if (is_resource($this->dblink))
            mysql_close($this->dblink);
    }

    private function Connect() {
        if (($this->db != '') and ($this->table != '')) {
            return $this->getDbLink();
        }
    }

    private function Query($query) {
        $result = mysql_query($query, $this->Connect());
        return $result;
    }

    private function GetRow($result) {
        return mysql_fetch_array($result);
    }

    public function getDbLink() {
        if (!is_resource($this->dblink)) {
            $dblink = mysql_connect(DB_HOST, DB_USER, DB_PASS);
            //mysql_select_db(DB_BASE);
            $this->dblink = $dblink;
        }
        return $this->dblink;
    }

    private function AddColumn($column) {
        $pattern = "([a-z]{1,})[\(]{0,}([0-9]{0,})[\)]{0,}";
        $matches = array();
        ereg($pattern, $column['COLUMN_TYPE'], $matches);
        if ($matches[1] == 'enum')
            $aux = substr($column['COLUMN_TYPE'], 5);
        else
            $aux='';

        $columna['Field'] = $column['COLUMN_NAME'];
        $columna['Type'] = $matches[1];
        $columna['Null'] = $column['IS_NULLABLE'];
        $columna['Key'] = $column['COLUMN_KEY'];
        $columna['Length'] = $matches[2];
        $columna['Values'] = substr($aux, 0, -1);
        $columna['Default'] = $column['COLUMN_DEFAULT'];
        $columna['Extra'] = $column['EXTRA'];

        if ($column['COLUMN_KEY'] == 'PRI')
            $this->primary_key = $column['COLUMN_NAME'];

        if ($column['COLUMN_KEY'] == 'MUL') { //Buscar la relacion con otra tabla
            switch ($this->getEngine()) {
                case 'MyISAM':
                    if ($column['COLUMN_COMMENT'] != '') {
                        $referencias = explode(",", $column['COLUMN_COMMENT']);
                        $columna['ReferencedSchema'] = $referencias[0];
                        $columna['ReferencedEntity'] = $referencias[1];
                        $columna['ReferencedColumn'] = $referencias[2];
                        //Pongo el nombre la la tabla refenciada en notacion entidad
                        $aux = str_replace("_", " ", $columna['ReferencedEntity']);
                        $columna['ReferencedEntity'] = str_replace(" ", "", ucwords($aux));
                        $this->referencedEntities[] = $columna['ReferencedEntity'];
                    }
                    break;

                case 'InnoDB':
                    $query = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_SCHEMA, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
                        FROM information_schema.KEY_COLUMN_USAGE
                        WHERE (TABLE_NAME='{$this->getTable()}') AND (COLUMN_NAME='{$column['Field']}') AND (NOT ISNULL( REFERENCED_TABLE_SCHEMA ))";
                    $result = $this->Query($query);
                    $row = $this->GetRow($result);
                    if ($row['TABLE_SCHEMA'] != '') {
                        $columna['ReferencedSchema'] = $row['REFERENCED_TABLE_SCHEMA'];
                        $columna['ReferencedEntity'] = $row['REFERENCED_TABLE_NAME'];
                        $columna['ReferencedColumn'] = $row['REFERENCED_COLUMN_NAME'];
                        //Pongo el nombre la la tabla refenciada en notacion entidad
                        $aux = str_replace("_", " ", $columna['ReferencedEntity']);
                        $columna['ReferencedEntity'] = str_replace(" ", "", ucwords($aux));
                        $this->referencedEntities[] = $columna['ReferencedEntity'];
                    }
                    break;
            }
        }

        $this->columns[] = $columna;
    }

    private function Load() {
        // Miro qué tipo de motor se utiliza para la tabla (MyISAM ó InnoDB)
        $query = "SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA='{$this->getDataBase()}' AND TABLE_NAME='{$this->getTable()}';";
        $result = $this->Query($query);
        $row = $this->GetRow($result);
        $this->engine = $row['ENGINE'];

        $query = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='{$this->getDataBase()}' AND TABLE_NAME='{$this->getTable()}' ORDER BY ORDINAL_POSITION ASC;";
        $result = $this->Query($query);
        while ($row = $this->GetRow($result))
            $this->AddColumn($row);
    }

    public function getEngine() {
        return $this->engine;
    }

    public function getDataBase() {
        return $this->db;
    }

    public function getTable() {
        return $this->table;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getPrimaryKey() {
        return $this->primary_key;
    }

    /**
     * Devuelve un array con las entidades referenciadas
     * @return array
     */
    public function getReferencedEntities() {
        return $this->referencedEntities;
    }

}

?>