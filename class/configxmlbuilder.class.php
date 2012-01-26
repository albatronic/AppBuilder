<?php

/**
 * GENERAR EL ARCHIVO DE CONFIGURACION XML DE UNA TABLA
 * PARA SU POSTERIOR USO EN EL FORMULARIO DE MANTENIMIENTO
 *
 * NECESITA APOYARSE EN LA CLASE 'TableDescriptor'
 *
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC, SL 15.03.2011
 * @version 1.0
 */
class ConfigXmlBuilder {

    private $buffer;
    private $filename;
    private $td;
    private $variable_types = array(
        "int" => "integer",
        "text" => "string",
        "longtext" => "string",
        "bool" => "bool",
        "date" => "date",
        "blob" => "integer",
        "float" => "decimal",
        "decimal" => "decimal",
        "double" => "decimal",
        "bigint" => "integer",
        "tinyint" => "tinyint",
        "longint" => "integer",
        "varchar" => "string",
        "smallint" => "integer",
        "datetime" => "datetime",
        "timestamp" => "datetime",
    );
    private $auditoriaColumns = array('CreatedBy', 'CreatedAt', 'ModifiedBy', 'ModifiedAt');

    public function __construct($table='') {
        $this->td = new TableDescriptor(DB_BASE, $table);
        $this->filename = str_replace("_", " ", $this->td->getTable());
        $this->filename = str_replace(" ", "", ucwords($this->filename));
        $this->creaYAML();
    }

    private function creaYAML() {
        $nfiltros = 0;

        $conexion = str_replace("#", "<?php echo \$_SESSION['emp'];?>", CONECTION);

        $buf .= "# Module: " . $this->filename . "\n";
        $buf .= "# Document : modules\\" . $this->filename . "\config.yml\n#\n";
        $buf .= "# @author: Sergio Pérez <sergio.perez@albatronic.com>\n# @copyright: INFORMATICA ALBATRONIC SL\n# @date " . date('d.m.Y H:i:s') . "\n";
        $buf .= "#\n---\n";
        $buf .= $this->filename . ":\n";
        $buf .= "  login_required: YES\n";
        $buf .= "  permission_control: " . PERMISSIONCONTROL . "\n";
        $buf .= "  favourite_control: NO\n";
        $buf .= "  help_file: help.html.twig\n";
        $buf .= "  title: " . ucwords($this->filename) . "\n";
        $buf .= "  id_video: " . strtolower($this->filename) . "\n";
        $buf .= "  url_video: null\n";
        $buf .= "  conection: '" . $conexion . "'\n";
        $buf .= "  entity: " . $this->filename . "\n";
        $buf .= "  table: " . $this->td->getTable() . "\n";
        $buf .= "  primarykey: " . $this->td->getPrimaryKey() . "\n";
        $buf .= "  records_per_page: 15\n";
        $buf .= "  order_by: " . $this->td->getPrimaryKey() . "\n";
        $buf .= "  search_default: " . $this->td->getPrimaryKey() . "\n";
        $buf .= "  referenced_entities:\n";
        foreach ($this->td->getParentEntities() as $entity) {
            $buf .= "    -\n";
            $buf .= "      entity: " . $entity . "\n";
        }

        $buf .= "  columns:\n";
        // NO SE MUESTRAN LAS COLUMNAS DE AUDITORIA
        foreach ($this->td->getColumns() as $column) {
            if (!in_array($column['Field'], $this->auditoriaColumns)) {
                if ($this->variable_types[$column['Type']] == 'date')
                    $column['Length'] = 10;

                $buf .= "    -\n";
                $buf .= "      title: " . $column['Field'] . "\n";
                $buf .= "      field: " . $column['Field'] . "\n";
                if ($column['Field'] == $this->td->getPrimaryKey()) {
                    $buf .= "      filter: NO\n";
                    $buf .= "      list: NO\n";
                } else {
                    if (($column['ReferencedColumn'] == '') and ($column['Type'] != 'date') and ($column['Type'] != 'tinyint'))
                        $buf .= "      filter: YES\n";
                    else
                        $buf .= "      filter: NO\n";
                    $buf .= "      list: YES\n";
                }
                $buf .= "      form: YES\n";
                $buf .= "      link:\n";
                $buf .= "        route: null\n";
                $buf .= "        param: null\n";
                $buf .= "        title: null\n";
                $buf .= "        target: null\n";
                $buf .= "        link: null\n";
                $buf .= "      default: " . $column['Default'] . "\n";

                //FILTRO ADICIONAL. SE PONE SI:
                // LA COLUMNA REFERENCIA A OTRA ENTIDAD, O
                // ES DE TIPO DATE, O
                // ES DE TIPO TINYINT (ValoresSN)
                if ($column['ReferencedColumn'] != '') {
                    $nfiltros++;
                    $buf .= "      aditional_filter:\n";
                    $buf .= "        order: " . $nfiltros . "\n";
                    $buf .= "        caption: " . $column['Field'] . "\n";
                    $buf .= "        entity: {$column['ReferencedEntity']}\n";
                    $buf .= "        method: fetchAll\n";
                    $buf .= "        params: null\n";
                    $buf .= "        type: input\n";
                    $buf .= "        operator: =\n";
                    $buf .= "        event: null\n";
                } else {
                    if ($column['Type'] == 'date') {
                        $nfiltros++;
                        $buf .= "      aditional_filter:\n";
                        $buf .= "        order: " . $nfiltros . "\n";
                        $buf .= "        caption: " . $column['Field'] . "\n";
                        $buf .= "        type: range\n";
                        $buf .= "        operator: >=\n";
                        $nfiltros++;
                    } elseif ($column['Type'] == 'tinyint') {
                        $nfiltros++;
                        $buf .= "      aditional_filter:\n";
                        $buf .= "        order: " . $nfiltros . "\n";
                        $buf .= "        caption: " . $column['Field'] . "\n";
                        $buf .= "        entity: ValoresSN\n";
                        $buf .= "        method: fetchAll\n";
                        $buf .= "        params: null\n";
                        $buf .= "        type: select\n";
                        $buf .= "        operator: =\n";
                        $buf .= "        event: null\n";
                    }
                }

                //VALIDADDOR. NO SE PONE PARA LA PRIMARYKEY
                if ($column['Field'] != $this->td->getPrimaryKey()) {
                    $buf .= "      validator:\n";
                    $buf .= "        nullable: " . $column['Null'] . "\n";
                    $buf .= "        type: " . $this->variable_types[$column['Type']] . "\n";
                    $buf .= "        length: " . $column['Length'] . "\n";
                    $buf .= "        min: null\n";
                    $buf .= "        max: null\n";
                    $buf .= "        message: Valor Requerido\n";
                }
            }
        }
        $this->buffer = $buf;
    }

    private function creaXML() {
        $nfiltros = 0;

        $conexion = str_replace("#", "<?php echo \$_SESSION['emp'];?>", CONECTION);

        $buf = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n\n";
        $buf .= "<!--\n";
        $buf .= "  Document : " . $this->filename . "\config.xml\n";
        $buf .= "  @author: Sergio Pérez <sergio.perez@albatronic.com>\n* @copyright: INFORMATICA ALBATRONIC SL\n* @date " . date('d.m.Y H:i:s') . "\n";
        $buf .= "-->\n\n";

        $buf .= "<" . $this->filename . ">\n";
        $buf .= "  <login_required>YES</login_required>\n";
        $buf .= "  <permission_control>" . PERMISSIONCONTROL . "</permission_control>\n";
        $buf .= "  <help_file>help.html.twig</help_file>\n";
        $buf .= "  <title>" . ucwords($this->filename) . "</title>\n";
        $buf .= "  <id_video>" . strtolower($this->filename) . "</id_video>\n";
        $buf .= "  <url_video></url_video>\n";
        $buf .= "  <conection>" . $conexion . "</conection>\n";
        $buf .= "  <entity>" . $this->filename . "</entity>\n";
        $buf .= "  <table>" . $this->td->getTable() . "</table>\n";
        $buf .= "  <primarykey>" . $this->td->getPrimaryKey() . "</primarykey>\n";
        $buf .= "  <records_per_page>15</records_per_page>\n";
        $buf .= "  <order_by>" . $this->td->getPrimaryKey() . "</order_by>\n";
        $buf .= "  <search_default>" . $this->td->getPrimaryKey() . "</search_default>\n";

        // Referenced Entities
        // Miro las columnas que son referenciadas por otras entidades e incluyo
        // las clases de esas tablas.
        $buf .= "  <referenced_entities>\n";
        foreach ($this->td->getParentEntities() as $entity) {
            $buf .= "    <entity>" . $entity . "</entity>\n";
        }
        $buf .= "  </referenced_entities>\n\n";

        $buf .= "  <columns>\n";
        foreach ($this->td->getColumns() as $column) {
            if ($this->variable_types[$column['Type']] == 'date')
                $column['Length'] = 10;

            $buf .= "    <column>\n";
            $buf .= "      <title>" . $column['Field'] . "</title>\n";
            $buf .= "      <field>" . $column['Field'] . "</field>\n";
            if ($column['Field'] == $this->td->getPrimaryKey()) {
                $buf .= "      <filter>NO</filter>\n";
                $buf .= "      <list>NO</list>\n";
            } else {
                if (($column['ReferencedColumn'] == '') and ($column['Type'] != 'date') and ($column['Type'] != 'tinyint'))
                    $buf .= "      <filter>YES</filter>\n";
                else
                    $buf .= "      <filter>NO</filter>\n";
                $buf .= "      <list>YES</list>\n";
            }
            $buf .= "      <form>YES</form>\n";
            $buf .= "      <link><route/><param/><title/><target/></link>\n";
            $buf .= "      <default>" . $column['Default'] . "</default>\n\n";

            //FILTRO ADICIONAL. SE PONE SI:
            // LA COLUMNA REFERENCIA A OTRA ENTIDAD, O
            // ES DE TIPO DATE, O
            // ES DE TIPO TINYINT (ValoresSN)
            if ($column['ReferencedColumn'] != '') {
                $nfiltros++;
                $buf .= "      <aditional_filter>\n";
                $buf .= "        <order>" . $nfiltros . "</order>\n";
                $buf .= "        <caption>" . $column['Field'] . "</caption>\n";
                $buf .= "        <entity>{$column['ReferencedEntity']}</entity>\n";
                $buf .= "        <method>fetchAll</method>\n";
                $buf .= "        <params></params>\n";
                $buf .= "        <type>input</type>\n";
                $buf .= "        <operator>=</operator>\n";
                $buf .= "        <event></event>\n";
                $buf .= "        <default></default>\n";
                $buf .= "      </aditional_filter>\n\n";
            } else {
                if ($column['Type'] == 'date') {
                    $nfiltros++;
                    $buf .= "      <aditional_filter>\n";
                    $buf .= "        <order>" . $nfiltros . "</order>\n";
                    $buf .= "        <caption>" . $column['Field'] . "</caption>\n";
                    $buf .= "        <type>range</type>\n";
                    $buf .= "        <operator>>=</operator>\n";
                    $buf .= "      </aditional_filter>\n\n";
                    $nfiltros++;
                } elseif ($column['Type'] == 'tinyint') {
                    $nfiltros++;
                    $buf .= "      <aditional_filter>\n";
                    $buf .= "        <order>" . $nfiltros . "</order>\n";
                    $buf .= "        <caption>" . $column['Field'] . "</caption>\n";
                    $buf .= "        <entity>ValoresSN</entity>\n";
                    $buf .= "        <method>fetchAll</method>\n";
                    $buf .= "        <params></params>\n";
                    $buf .= "        <type>select</type>\n";
                    $buf .= "        <operator>=</operator>\n";
                    $buf .= "        <event></event>\n";
                    $buf .= "        <default></default>\n";
                    $buf .= "      </aditional_filter>\n\n";
                }
            }

            //VALIDADDOR. NO SE PONE PARA LA PRIMARYKEY
            if ($column['Field'] != $this->td->getPrimaryKey()) {
                $buf .= "      <validator>\n";
                $buf .= "        <null>" . $column['Null'] . "</null>\n";
                $buf .= "        <type>" . $this->variable_types[$column['Type']] . "</type>\n";
                $buf .= "        <length>" . $column['Length'] . "</length>\n";
                $buf .= "        <min></min>\n";
                $buf .= "        <max></max>\n";
                $buf .= "        <message>Valor Requerido</message>\n";
                $buf .= "      </validator>\n\n";
            }

            $buf .= "    </column>\n\n";
        }
        $buf .= "  </columns>\n";
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
