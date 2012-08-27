<?php

/**
 * GENERAR EL ARCHIVO DE CONFIGURACION de listados.yml DE UNA TABLA
 *
 * NECESITA APOYARSE EN LA CLASE 'TableDescriptor'
 *
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC, SL 30.07.2011
 * @version 1.0
 */
class ListadosYmlBuilder {

    private $buffer;
    private $filename;
    private $td;
    private $variable_types = array(
        "int" => "integer",
        "text" => "text",
        "longtext" => "text",
        "bool" => "bool",
        "blob" => "integer",
        "float" => "decimal",
        "decimal" => "decimal",
        "double" => "decimal",
        "bigint" => "integer",
        "tinyint" => "tinyint",
        "longint" => "integer",
        "char" => "string",
        "varchar" => "string",
        "smallint" => "integer",
        "date" => "date",
        "datetime" => "datetime",
        "timestamp" => "datetime",
    );

    public function __construct($table='') {
        $this->td = new TableDescriptor(DB_BASE, $table);
        $this->filename = str_replace("_", " ", $this->td->getTable());
        $this->filename = str_replace(" ", "", ucwords($this->filename));
        $this->creaYAML();
    }

    private function creaYAML() {
        $buf .= "# Module: " . $this->filename . "\n";
        $buf .= "# Document : modules\\" . $this->filename . "\listados.yml\n#\n";
        $buf .= "# @author: Sergio Pérez <sergio.perez@albatronic.com>\n# @copyright: INFORMATICA ALBATRONIC SL\n# @date " . date('d.m.Y H:i:s') . "\n";
        $buf .= "#\n---\n";
        $buf .= "listados:\n";
        $buf .= "  -\n";
        $buf .= "    title: " . ucwords($this->filename) . "\n";
        $buf .= "    order_by: " . $this->td->getPrimaryKey() . " ASC\n";
        $buf .= "    break_field: null\n";
        $buf .= "    idPerfil: null\n";
        $buf .= "    orientation: P\n";
        $buf .= "    unit: mm\n";
        $buf .= "    format: A4\n";
        $buf .= "    margins: 10, 10, 15, 10\n";
        $buf .= "    body_font: Courier, ,8\n";
        $buf .= "    columns:\n";

        foreach ($this->td->getColumns() as $column) {
            // NO SE MUESTRA LA PRIMARYKEY NI LAS COLUMNAS DE AUDITORIA
            if ( ($column['Field'] != $this->td->getPrimaryKey()) and (!in_array($column['Field'], columnasComunes::$columnasExcepcion)) ) {
                switch ($this->variable_types[$column['Type']]) {
                    case 'integer' :
                    case 'decimal' :
                        $align = "R";
                        break;

                    case 'date' :
                    case 'datetime' :
                        $column['Length'] = 10;
                        $align = "R";
                        break;

                    case 'string' :
                    case 'text':
                    case 'tinyint':
                        if ($column['Length'] == '')
                            $column['Length'] = 20;
                        $align = "L";
                        break;
                }

                $buf .= "      -\n";
                $buf .= "        title: " . $column['Field'] . "\n";
                $buf .= "        field: " . $column['Field'] . "\n";
                $buf .= "        length: " . $column['Length'] . "\n";
                $buf .= "        align: " . $align . "\n";
                $buf .= "        type: " . $this->variable_types[$column['Type']] . "\n";
                $buf .= "        total: NO\n";
                $buf .= "        formula: null\n";
                $buf .= "        format: null\n";
            }
        }
        $this->buffer = $buf;
    }

    private function creaXML() {
        $buf = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n\n";
        $buf .= "<!--\n";
        $buf .= "  Document : " . $this->filename . "\listados.xml\n";
        $buf .= "  @author: Sergio Pérez <sergio.perez@albatronic.com>\n* @copyright: INFORMATICA ALBATRONIC SL\n* @date " . date('d.m.Y H:i:s') . "\n";
        $buf .= "-->\n\n";

        $buf .= "<" . $this->filename . ">\n";
        $buf .= "<listado>\n";
        $buf .= "  <title>" . ucwords($this->filename) . "</title>\n";
        $buf .= "  <order_by>" . $this->td->getPrimaryKey() . " ASC</order_by>\n";
        $buf .= "  <break_field></break_field>\n";
        $buf .= "  <idPerfil></idPerfil>\n";
        $buf .= "  <orientation>P</orientation>\n";
        $buf .= "  <unit>mm</unit>\n";
        $buf .= "  <format>A4</format>\n";
        $buf .= "  <margins>10,10,15,10</margins>\n";
        $buf .= "  <body_font>Courier, ,8</body_font>\n\n";

        $buf .= "  <columns>\n";
        foreach ($this->td->getColumns() as $column) {
            // NO SE MUESTRA LA PRIMARYKEY
            if ($column['Field'] != $this->td->getPrimaryKey()) {
                switch ($this->variable_types[$column['Type']]) {
                    case 'integer' :
                    case 'decimal' :
                        $align = "R";
                        break;

                    case 'date' :
                    case 'datetime' :
                        $column['Length'] = 10;
                        $align = "R";
                        break;

                    case 'string' :
                    case 'text':
                    case 'tinyint':
                        if ($column['Length'] == '')
                            $column['Length'] = 20;
                        $align = "L";
                        break;
                }

                $buf .= "    <column>\n";
                $buf .= "      <title>" . $column['Field'] . "</title>\n";
                $buf .= "      <field>" . $column['Field'] . "</field>\n";
                $buf .= "      <length>" . $column['Length'] . "</length>\n";
                $buf .= "      <align>" . $align . "</align>\n";
                $buf .= "      <type>" . $this->variable_types[$column['Type']] . "</type>\n";
                $buf .= "      <total>NO</total>\n";
                $buf .= "      <formula></formula>\n";
                $buf .= "      <format></format>\n";
                $buf .= "    </column>\n\n";
            }
        }
        $buf .= "  </columns>\n";

        $buf .= "</listado>\n";
        $buf .= "</" . $this->filename . ">";
        $this->buffer = $buf;
    }

    /**
     * Devuelve el código xml de configuracion del formulario de mantenimiento
     * @return text
     */
    public function Get() {
        return $this->buffer;
    }

}

?>
