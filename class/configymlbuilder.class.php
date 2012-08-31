<?php

/**
 * GENERAR EL ARCHIVO DE CONFIGURACION YML DE UNA TABLA
 * PARA SU POSTERIOR USO EN EL FORMULARIO DE MANTENIMIENTO
 *
 * NECESITA APOYARSE EN LA CLASE 'TableDescriptor'
 *
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC, SL 15.03.2011
 * @version 1.0
 */
class ConfigYmlBuilder {

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

    private $columnasExcepcion = array(
        'PrimaryKeyMD5',
        'CreatedBy',
        'CreatedAt',
        'ModifiedBy',
        'ModifiedAt',
        'Deleted',
        'DeletedBy',
        'DeletedAt',
    );

    public function __construct($table='') {
        $this->td = new TableDescriptor(DB_BASE, $table);
        $this->filename = str_replace("_", " ", $this->td->getTable());
        $this->filename = str_replace(" ", "", ucwords($this->filename));
    }

    /**
     * Devuelve el código yml de configuracion del formulario de mantenimiento
     * @return text
     */
    public function getConfigYml() {

        $this->creaConfigYml();
        return $this->buffer;
    }

    public function getFieldsVarWeb() {

        $this->creaFieldsVarWeb();
        return $this->buffer;
    }

    public function getFieldsVarEntorno() {

        $this->creaFieldsVarEntorno();
        return $this->buffer;
    }

    private function creaConfigYml() {
        $nfiltros = 0;

        $conexion = str_replace("#", "<?php echo \$_SESSION['emp'];?>", CONECTION);

        $buf .= "# Module: " . $this->filename . "\n";
        $buf .= "# Document : modules\\" . $this->filename . "\config.yml\n#\n";
        $buf .= "# @author: Sergio Pérez <sergio.perez@albatronic.com>\n# @copyright: INFORMATICA ALBATRONIC SL\n# @date " . date('d.m.Y H:i:s') . "\n";
        $buf .= "#\n---\n";
        $buf .= $this->filename . ":\n";
        $buf .= "  includesHead:\n";
        $buf .= "    twigCss: _global/css.html.twig\n";
        $buf .= "    twigJs: _global/js.html.twig\n";
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
        $buf .= "  order_by:\n";
        $buf .= "    -\n";
        $buf .= "      title: " . $this->td->getPrimaryKey() . " a-z\n";
        $buf .= "      criteria: " . $this->td->getPrimaryKey() . " ASC\n";
        $buf .= "    -\n";
        $buf .= "      title: " . $this->td->getPrimaryKey() . " z-a\n";
        $buf .= "      criteria: " . $this->td->getPrimaryKey() . " DESC\n";
        $buf .= "  search_default: " . $this->td->getPrimaryKey() . "\n";
        $buf .= "  referenced_entities:\n";
        foreach ($this->td->getParentEntities() as $entity) {
            $buf .= "    -\n";
            $buf .= "      entity: " . $entity . "\n";
        }

        $primeraColumna = '';

        $cols = "  columns:\n";
        // NO SE MUESTRAN LAS COLUMNAS COMUNES
        foreach ($this->td->getColumns() as $column) {
            if (!in_array($column['Field'], $this->columnasExcepcion)) {
                if ($this->variable_types[$column['Type']] == 'date')
                    $column['Length'] = 10;

                $cols .= "    -\n";
                $cols .= "      title: " . $column['Field'] . "\n";
                $cols .= "      field: " . $column['Field'] . "\n";
                if ($column['Field'] == $this->td->getPrimaryKey()) {
                    $cols .= "      filter: NO\n";
                    $cols .= "      list: NO\n";
                } else {
                    if ($primeraColumna == '') $primeraColumna = $column['Field'];
                    if (
                         ($column['ReferencedColumn'] == '') and
                         ($column['Type'] != 'date') and
                         ($column['Type'] != 'tinyint') and
                         (!in_array($column['Field'], columnasComunes::$columnasExcepcion))
                       )
                        $cols .= "      filter: YES\n";
                    else
                        $cols .= "      filter: NO\n";
                    $cols .= "      list: NO\n";
                }
                $cols .= "      form: YES\n";
                $cols .= "      link:\n";
                $cols .= "        route: null\n";
                $cols .= "        param: null\n";
                $cols .= "        title: null\n";
                $cols .= "        target: null\n";
                $cols .= "        link: null\n";
                $cols .= "      default: " . $column['Default'] . "\n";

                //FILTRO ADICIONAL. SE PONE SI:
                // LA COLUMNA REFERENCIA A OTRA ENTIDAD, O
                // ES DE TIPO DATE, O
                // ES DE TIPO TINYINT (ValoresSN)
                if ($column['ReferencedColumn'] != '') {
                    $nfiltros++;
                    $cols .= "      aditional_filter:\n";
                    $cols .= "        order: " . $nfiltros . "\n";
                    $cols .= "        caption: " . $column['Field'] . "\n";
                    $cols .= "        entity: {$column['ReferencedEntity']}\n";
                    $cols .= "        method: fetchAll\n";
                    $cols .= "        params: Descripcion\n";
                    $cols .= "        type: select\n";
                    $cols .= "        operator: =\n";
                    $cols .= "        event: null\n";
                } else {
                    if ($column['Type'] == 'date') {
                        $nfiltros++;
                        $cols .= "      aditional_filter:\n";
                        $cols .= "        order: " . $nfiltros . "\n";
                        $cols .= "        caption: " . $column['Field'] . "\n";
                        $cols .= "        type: range\n";
                        $cols .= "        operator: >=\n";
                        $nfiltros++;
                    } elseif ($column['Type'] == 'tinyint') {
                        $nfiltros++;
                        $cols .= "      aditional_filter:\n";
                        $cols .= "        order: " . $nfiltros . "\n";
                        $cols .= "        caption: " . $column['Field'] . "\n";
                        $cols .= "        entity: ValoresSN\n";
                        $cols .= "        method: fetchAll\n";
                        $cols .= "        params: Descripcion\n";
                        $cols .= "        type: select\n";
                        $cols .= "        operator: =\n";
                        $cols .= "        event: null\n";
                    }
                }

                //VALIDATDOR. NO SE PONE PARA LA PRIMARYKEY
                if ($column['Field'] != $this->td->getPrimaryKey()) {
                    $cols .= "      validator:\n";
                    $cols .= "        nullable: " . $column['Null'] . "\n";
                    $cols .= "        type: " . $this->variable_types[$column['Type']] . "\n";
                    $cols .= "        length: " . $column['Length'] . "\n";
                    $cols .= "        min: null\n";
                    $cols .= "        max: null\n";
                    $cols .= "        message: Valor Requerido\n";
                }
            }
        }

        $buf .= "  fieldGeneratorUrlFriendly: {$primeraColumna}\n";
        $buf .= "  fieldGeneratorMetatagTitle: {$primeraColumna}\n";

        $this->buffer = $buf . $cols;
    }

    private function creaFieldsVarWeb() {

    }

    private function creaFieldsVarEntorno() {

        $buf .= "{# Module: " . $this->filename . "\n";
        $buf .= "   Document : modules\\" . $this->filename . "\\fieldsvarEnv.html.twig\n";
        $buf .= "   author: Sergio Pérez <sergio.perez@albatronic.com>\n";
        $buf .= "   copyright: INFORMATICA ALBATRONIC SL\n";
        $buf .= "   date " . date('d.m.Y H:i:s') . "\n";
        $buf .= "#}\n\n";
        $buf .= "  numMaxRegistros: 100\n";
        $buf .= "\n";
        $buf .= "  image1:\n";
        $buf .= "    visible: TRUE\n";
        $buf .= "    caption: image1\n";
        $buf .= "    width: \n";
        $buf .= "    height: \n";
        $buf .= "  image2:\n";
        $buf .= "    visible: FALSE\n";
        $buf .= "    caption: image2\n";
        $buf .= "    width: \n";
        $buf .= "    height: \n";
        $buf .= "  image3:\n";
        $buf .= "    visible: FALSE\n";
        $buf .= "    caption: image3\n";
        $buf .= "    width: \n";
        $buf .= "    height: \n";
        $buf .= "  image4:\n";
        $buf .= "    visible: FALSE\n";
        $buf .= "    caption: image4\n";
        $buf .= "    width: \n";
        $buf .= "    height: \n";
        $buf .= "  image5:\n";
        $buf .= "    visible: FALSE\n";
        $buf .= "    caption: image5\n";
        $buf .= "    width: \n";
        $buf .= "    height: \n";
        $buf .= "\n";
        $buf .= "  mostrarGestionSlug: FALSE\n";
        $buf .= "\n";
        $buf .= "  mostrarUrlAmigable: TRUE\n";
        $buf .= "\n";
        $buf .= "  mostrarGestionMapaWeb:\n";
        $buf .= "    mostrar: FALSE\n";
        $buf .= "    mostrarEnMapaWeb: TRUE\n";
        $buf .= "    mostrarImportanciaMapaWeb: 0,5\n";
        $buf .= "    frecuenciaCambio: monthly\n";
        $buf .= "\n";
        $buf .= "  mostrarNumeroVisitas: TRUE\n";
        $buf .= "\n";
        $buf .= "  mostrarGestionMeta:\n";
        $buf .= "    mostrar: TRUE\n";
        $buf .= "    titlePosition: \n";
        $buf .= "    titleSimple: \n";
        $buf .= "\n";
        $buf .= "  columns:\n";
        // NO SE MUESTRAN LAS COLUMNAS COMUNES
        foreach ($this->td->getColumns() as $column) {
            if  ( ($column['Field'] != $this->td->getPrimaryKey()) and (!in_array($column['Field'], columnasComunes::$columnasExcepcion)) ) {
                $buf .= "    -\n";
                $buf .= "      field: " . $column['Field'] . "\n";
                $buf .= "      mostrar: TRUE\n";
                $buf .= "      default: " . $column['Default'] . "\n";
                $buf .= "      caption: " . $column['Field'] . "\n";
                $buf .= "      permiso: \n";
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


}

?>
