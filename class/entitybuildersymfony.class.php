<?php

class EntityBuilderSymfony
{
  private $buffer;
  private $validate;
  private $table_descriptor;
  private $bundle;
  private $variable_types = array(
    "int"       => "integer",
    "text"      => "string",
    "bool"      => "bool",
    "date"      => "integer",
    "blob"      => "integer",
    "float"     => "integer",
    "decimal"   => "integer",
    "double"    => "integer",
    "bigint"    => "integer",
    "tinyint"   => "integer",
    "longint"   => "integer",
    "varchar"   => "string",
    "smallint"  => "integer",
    "datetime"  => "integer",
    "timestamp" => "integer"
  );

  public function __construct($table,$bundle,$validate=false)
  {
    $this->table_descriptor = new TableDescriptor(DB_BASE,$table);
    $this->validate = $validate;
    $this->bundle=$bundle;
    $this->Load();
  }

  private function Load()
  {
    $buf = "";
    if( Settings::$validator_written == false )
    {
      $buf .= "class validate\n";
      $buf .= "{\n";
      $buf .= "\tpublic function isstring(\$string)\n";
      $buf .= "\t{\n";
      $buf .= "\t\treturn (is_string(\$string));\n";
      $buf .= "\t}\n\n";

      $buf .= "\tpublic function isint(\$int)\n";
      $buf .= "\t{\n";
      $buf .= "\t\treturn (preg_match(\"/^([0-9.,-]+)$/\", \$int) > 0);\n";
      $buf .= "\t}\n\n";

      $buf .= "\tpublic function isbool(\$bool)\n";
      $buf .= "\t{\n";
      $buf .= "\t\t\$b = 1 * \$bool;\n";
      $buf .= "\t\treturn (\$b == 1 || \$b == 0);\n";
      $buf .= "\t}\n";
      $buf .= "}\n\n";

      Settings::$validator_written = true;
    }

    $entityname=str_replace("_", " ", strtolower($this->table_descriptor->getTable()));
    $entityname=str_replace(" ","",ucwords($entityname));
    $buf .= "/**\n";
    $buf .= " * @author Sergio Perez\n * @copyright INFORMATICA ALBATRONIC SL\n * @date ".date('d.m.Y H:i:s')."\n";
    $buf .= " */\n\n";
    $buf .= "namespace ".$this->bundle."\Entity;\n\n";
    $buf .= "/**\n";
    $buf .= " * @orm:Entity\n";
    $buf .= " */\n";
    $buf .= "class {$entityname}\n{\n";

    foreach($this->table_descriptor->getColumns() as $column)
    {
      $column_name = str_replace('-','_',$column['Field']);
      $buf .= "\t/**\n";
      if( $column['Field'] == $this->table_descriptor->getPrimaryKey() )
      {
        if ($column['Extra'] == 'auto_increment')
        {
            $buf .= "\t * @orm:GeneratedValue\n";
        }
        $buf .= "\t * @orm:Id\n";
      }
      $buf .= "\t * @orm:Column(type=\"{$this->variable_types[$column['Type']]}\")\n";
      if($column['Null']=='NO')
      {
          $buf .= "\t * @assert:NotBlank(groups=\"{$this->table_descriptor->getTable()}\")\n";
      }
      $buf .= "\t */\n";
      $buf .= "\tprivate \$$column_name;\n\n";
    }


    $buf .= "\t/**\n";
    $buf .= "\t * GETTERS Y SETTERS\n";
    $buf .= "\t */\n";

    foreach($this->table_descriptor->getColumns() as $column)
    {
      $column_name = str_replace('-','_',$column['Field']);
      $buf .= "\tpublic function set$column_name(\$$column_name=''){ ";
      if( $this->validate )
      {
        $buf .= "\t\tif(validate::is{$this->variable_types[$column['Type']]}(\$$column_name))\n";
        $buf .= "\t\t{\n";
        $buf .= "\t\t\t\$this->$column_name = \$$column_name;\n";
        $buf .= "\t\t\treturn true;\n";
        $buf .= "\t\t}\n";
        $buf .= "\t\treturn false;\n";
      }
      else
      {
        $buf .= "\$this->$column_name = \$$column_name; ";
        $buf .= "return true;";
      }
      $buf .= " }\n";

      $buf .= "\tpublic function get$column_name(){ return \$this->$column_name; }\n\n";
    }

    $buf .= "} // END class {$this->table_descriptor->getTable()}\n\n";
    $this->buffer = $buf;
  }

  public function Get() { return "<?php\n".$this->buffer."\n?>"; }
}

?>