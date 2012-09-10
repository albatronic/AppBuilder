<?php

class EntityBuilder {

    private $className;
    private $cabecera;
    private $methods;
    private $buffer;
    private $validate;
    private $td;

    public function __construct($table = '', $validate = false) {
        $this->td = new TableDescriptor(DB_BASE, $table);
        $this->validate = $validate;

        //$this->className = str_replace("_", " ", strtolower($this->td->getTable()));
        //$this->className = str_replace(" ", "", ucwords($this->className));
        $this->className = $this->td->getTable();
        $this->Load();
    }

    private function Load() {

        $aux = $this->td->getColumns();
        $columnToString = $aux[1]['Field'];

        $this->cabecera = "/**\n";
        $this->cabecera .= " * @author Sergio Perez <sergio.perez@albatronic.com>\n * @copyright INFORMATICA ALBATRONIC SL\n * @date " . date('d.m.Y H:i:s') . "\n";
        $this->cabecera .= " */\n\n";
        $this->cabecera .= "/**\n";
        $this->cabecera .= " * @orm:Entity(" . $this->td->getTable() . ")\n";
        $this->cabecera .= " */\n";
        $buf = $this->cabecera . "class {$this->className}Entity extends EntityComunes {\n";

        foreach ($this->td->getColumns() as $column) {
            if (!in_array($column['Field'], columnasComunes::$columnasExcepcion)) {
                $column_name = str_replace('-', '_', $column['Field']);
                $buf .= "\t/**\n";
                if ($column['Field'] == $this->td->getPrimaryKey()) {
                    if ($column['Extra'] == 'auto_increment') {
                        $buf .= "\t * @orm GeneratedValue\n";
                    }
                    $buf .= "\t * @orm Id\n";
                }
                if ($column['ReferencedSchema'] != '')
                    $buf .= "\t * @var entities\\" . $column['ReferencedEntity'] . "\n";
                else
                    $buf .= "\t * @var ". tiposVariables::$tipos[$column['Type']] ."\n";
                if ($column['Null'] == 'NO') {
                    $buf .= "\t * @assert NotBlank(groups=\"{$this->td->getTable()}\")\n";
                }
                $buf .= "\t */\n";
                if (!is_null($column['Default']) and ($column['Default'] != ''))
                    $valorpordefecto = " = '" . $column['Default'] . "'";
                else
                    $valorpordefecto = '';
                $buf .= "\tprotected \$" . $column_name . $valorpordefecto . ";\n";
            }
        }

        $buf .= "\t/**\n";
        $buf .= "\t * Nombre de la conexion a la BD\n";
        $buf .= "\t * @var string\n";
        $buf .= "\t */\n";
        $buf .= "\tprotected \$_conectionName = '" . CONECTION . "';\n";
        $buf .= "\t/**\n";
        $buf .= "\t * Nombre de la tabla física\n";
        $buf .= "\t * @var string\n";
        $buf .= "\t */\n";
        $buf .= "\tprotected \$_tableName = '" . $this->td->getTable() . "';\n";
        $buf .= "\t/**\n";
        $buf .= "\t * Nombre de la PrimaryKey\n";
        $buf .= "\t * @var string\n";
        $buf .= "\t */\n";
        $buf .= "\tprotected \$_primaryKeyName = '" . $this->td->getPrimaryKey() . "';\n";
        $buf .= "\t/**\n";
        $buf .= "\t * Relacion de entidades que dependen de esta\n";
        $buf .= "\t * @var string\n";
        $buf .= "\t */\n";
        $buf .= "\tprotected \$_parentEntities = " . $this->getChildEntities() . ";\n";
        $buf .= "\t/**\n";
        $buf .= "\t * Relacion de entidades de las que esta depende\n";
        $buf .= "\t * @var string\n";
        $buf .= "\t */\n";
        $buf .= "\tprotected \$_childEntities = " . $this->getParentEntities() . ";\n";


// GETTERS Y SETTERS
// ---------------------------------------------------------------------
        $buf .= "\t/**\n";
        $buf .= "\t * GETTERS Y SETTERS\n";
        $buf .= "\t */\n";


        foreach ($this->td->getColumns() as $column) {
            if (!in_array($column['Field'], columnasComunes::$columnasExcepcion)) {
                $column_name = str_replace('-', '_', $column['Field']);
                $relEntity = "";
                $valor = "";

// METODO SET: hago tres tramientos distintos, segun el tipo de la columna:
//      STRING: quito espacios en blanco (trim)
//      DATE:   instancio un objeto del tipo fecha
//      Resto de tipos: lo almaceno tal cual
                switch (tiposVariables::$tipos[$column['Type']]) {
                    case 'string':
                        $valor = "\t\t\$this->$column_name = trim(\$$column_name);";
                        break;
                    case 'date':
                        $valor = "\t\t\$date = new Fecha(\$$column_name);\n";
                        $valor .= "\t\t\$this->$column_name = \$date->getFecha();\n";
                        $valor .= "\t\tunset(\$date);";
                        break;
                    default:
                        $valor = "\t\t\$this->$column_name = \$$column_name;";
                }
                $buf .= "\tpublic function set$column_name(\$$column_name){\n$valor\n\t}\n";

// METODO GET: hago tres tramientos distintos, segun el tipo de la columna:
//      DATE: Devuelo la fecha en formato ddmmaaaa
//      ES UNA LLAVE EXTRANJERA: Devuelvo un objeto de la clase a la que hace referencia
//      TINYINT: Devuelvo un objeto de la clase ValoresSN
//      RESTO: Devuelvo el valor tal cual.
                if (($column['Key'] == 'MUL') and ($column['ReferencedColumn'] != '')) {
                    $relEntity = $column['ReferencedEntity'];
                    $valor = "\t\tif (!(\$this->$column_name instanceof $relEntity))\n";
                    $valor .= "\t\t\t\$this->$column_name = new $relEntity(\$this->$column_name);\n";
                    $valor .= "\t\treturn \$this->$column_name;";
                } elseif (tiposVariables::$tipos[$column['Type']] == 'date') {
                    $valor = "\t\t\$date = new Fecha(\$this->$column_name);\n";
                    $valor .= "\t\t\$ddmmaaaa = \$date->getddmmaaaa();\n";
                    $valor .= "\t\tunset(\$date);\n";
                    $valor .= "\t\treturn \$ddmmaaaa;";
                } elseif (tiposVariables::$tipos[$column['Type']] == 'tinyint') {
                    $relEntity = "ValoresSN";
                    $valor = "\t\tif (!(\$this->$column_name instanceof $relEntity))\n";
                    $valor .= "\t\t\t\$this->$column_name = new $relEntity(\$this->$column_name);\n";
                    $valor .= "\t\treturn \$this->$column_name;";
                } else
                    $valor = "\t\treturn \$this->$column_name;";
                $buf .= "\tpublic function get$column_name(){\n$valor\n\t}\n\n";
            }
        }

        $this->methods = "\tpublic function __toString() {\n\t\treturn \$this->get{$this->td->getPrimaryKey()}();\n\t}\n";

        $buf .= "} // END class {$this->td->getTable()}\n";
        $this->buffer = $buf;
    }

    /**
     * Devuelve el codigo php del array que contiene las entidades padre
     * @return string
     */
    private function getParentEntities() {
        $buf = "array(\n";

        foreach ($this->td->getParentEntities() as $entity) {
            $buf .= "\t\t\t'" . $entity . "',\n";
        }
        $buf .= "\t\t)";

        return $buf;
    }

    /**
     * Devuelve el codigo php del array que contiene las entidades hijas
     * @return string
     */
    private function getChildEntities() {
        $buf = "array(\n";

        foreach ($this->td->getChildEntities() as $entity) {
            $buf .= "\t\t\tarray('SourceColumn' => '" . $entity['OrignColumn'] . "', 'ParentEntity' => '" . $entity['Entity'] . "', 'ParentColumn' => '" . $entity['Column'] . "'),\n";
        }
        $buf .= "\t\t)";

        return $buf;
    }

    public function GetModel() {
        return "<?php\n" . $this->buffer . "\n?>";
    }

    public function GetMethod() {
        $buf = $this->cabecera . "class {$this->className} extends {$this->className}Entity {\n" . $this->methods;
        return "<?php\n" . $buf . "}\n?>";
    }

}

?>