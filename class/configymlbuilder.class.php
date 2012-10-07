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
    private $primeraColumna = '';


    public function __construct($table = '') {
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

    /**
     * Devuelve un array con tantos nodos como columnas.
     * La key de cada nodo es el nombre de la columna y el valor son los atributos
     *
     * No se generan las columnas incluidas en columnasComunes::$columnasExcepcionConfig
     *
     * @return array Array con los atributos de las columnas
     */
    private function getArrayColumns() {

        $this->primeraColumna = '';
        $arrayColumns = array();
        $nfiltros = 0;

        foreach ($this->td->getColumns() as $column) {
            if (!in_array($column['Field'], columnasComunes::$columnasExcepcionConfig)) {
                if (tiposVariables::$tipos[$column['Type']] === 'date')
                    $column['Length'] = 10;

                $arrayColumns[$column['Field']]['title'] = $column['Field'];

                if ($column['Field'] == $this->td->getPrimaryKey()) {
                    $arrayColumns[$column['Field']]['visible'] = FALSE;
                    $arrayColumns[$column['Field']]['updatable'] = FALSE;
                    $arrayColumns[$column['Field']]['filter'] = 'NO';
                    $arrayColumns[$column['Field']]['list'] = 'NO';
                } else {
                    if ($this->primeraColumna == '')
                        $this->primeraColumna = $column['Field'];
                    if (
                            ($column['ReferencedColumn'] == '') and
                            ($column['Type'] != 'date') and
                            ($column['Type'] != 'tinyint') and
                            (!in_array($column['Field'], columnasComunes::$columnasExcepcion))
                    )
                        $arrayColumns[$column['Field']]['filter'] = 'YES';
                    else
                        $arrayColumns[$column['Field']]['filter'] = 'NO';
                    $arrayColumns[$column['Field']]['list'] = 'NO';
                    $arrayColumns[$column['Field']]['visible'] = TRUE;
                    $arrayColumns[$column['Field']]['updatable'] = TRUE;
                }
                $arrayColumns[$column['Field']]['default'] = $column['Default'];
                $arrayColumns[$column['Field']]['help'] = null;
                $arrayColumns[$column['Field']]['permission'] = null;

                $arrayColumns[$column['Field']]['link'] = array(
                    'route' => null,
                    'param' => null,
                    'title' => null,
                    'target' => null,
                    'link' => null,
                );

                //FILTRO ADICIONAL. SE PONE SI:
                // LA COLUMNA REFERENCIA A OTRA ENTIDAD, O
                // ES DE TIPO DATE, O
                // ES DE TIPO TINYINT (ValoresSN)
                if ($column['ReferencedColumn'] != '') {
                    $nfiltros++;
                    $arrayColumns[$column['Field']]['aditional_filter'] = array(
                        'order' => $nfiltros,
                        'caption' => $column['Field'],
                        'entity' => $column['ReferencedEntity'],
                        'method' => 'fetchAll',
                        'params' => 'Descripcion',
                        'type' => 'select',
                        'operator' => '=',
                        'event' => null,
                    );
                } else {
                    if ($column['Type'] == 'date') {
                        $nfiltros++;
                        $arrayColumns[$column['Field']]['aditional_filter'] = array(
                            'order' => $nfiltros,
                            'caption' => $column['Field'],
                            'type' => 'range',
                            'operator' => '>=',
                        );
                        $nfiltros++;
                    } elseif ($column['Type'] == 'tinyint') {
                        $nfiltros++;
                        $arrayColumns[$column['Field']]['aditional_filter'] = array(
                            'order' => $nfiltros,
                            'caption' => $column['Field'],
                            'entity' => 'ValoresSN',
                            'method' => 'fetchAll',
                            'params' => 'Descripcion',
                            'type' => 'select',
                            'operator' => '=',
                            'event' => null,
                        );
                    }
                }

                //VALIDATDOR. NO SE PONE PARA LA PRIMARYKEY
                if ($column['Field'] != $this->td->getPrimaryKey()) {
                    if ($column['ReferencedColumn'] != '')
                        $valorNullAble = "NO";
                    else
                        $valorNullAble = $column['Null'];

                    $arrayColumns[$column['Field']]['validator'] = array(
                        'nullable' => $valorNullAble,
                        'type' => tiposVariables::$tipos[$column['Type']],
                        'length' => $column['Length'],
                        'min' => null,
                        'max' => null,
                        'message' => 'Valor Requerido',
                    );
                }
            }
        }

        return $arrayColumns;
    }

    private function creaConfigYml() {

        $conexion = str_replace("#", "<?php echo \$_SESSION['emp'];?>", CONECTION);

        $cabecera  = "# Module: " . $this->filename . "\n";
        $cabecera .= "# Document : modules/" . $this->filename . "/config.yml\n#\n";
        $cabecera .= "# @author: Sergio Pérez <sergio.perez@albatronic.com>\n# @copyright: INFORMATICA ALBATRONIC SL\n# @date " . date('d.m.Y H:i:s') . "\n";
        $cabecera .= "#\n---\n";

        $arrayDeColumnas = $this->getArrayColumns();

        $array[$this->filename] = array(
            'app' => '',
            'isModuleRoot' => '0',
            'linkModule' => array(
                'fromColumn' => '',
                'toEntity' => '',
                'toColumn' => '',
            ),
            'numMaxRecords' => '',
            'withImages' => '0',
            'withGalery' => '0',
            'withDocuments' => '0',
            'withVideos' => 0,
            'withAudios' => '0',
            'maxSizes' => array(
                'image' => '400000',
                'document' => '',
                'video' => '',
                'audio' => '',
            ),
            'galery' => array(
                'maxWidthImage' => '500',
                'maxHeightImage' => '400',
                'generateThumbnail' => '0',
                'widthThumbnail' => '50',
                'heightThumbnail' => '50',
            ),
            'fieldGeneratorUrlFriendly' => $this->primeraColumna,
            'fieldGeneratorMetatagTitle' => $this->primeraColumna,
            'controller' => 'CONTROLADOR',
            'action' => 'ACTION',
            'template' => 'TEMPLATE',
            'parametros' => 'PARAMETROS',
            'includesHead' => array(
                'twigCss' => '_global/css.html.twig',
                'twigJs' => '_global/js.html.twig',
            ),
            'login_required' => 'YES',
            'permission_control' => PERMISSIONCONTROL,
            'favourite_control' => 'NO',
            'help_file' => 'help.html.twig',
            'title' => ucwords($this->filename),
            'id_video' => strtolower($this->filename),
            'url_video' => null,
            'feature_list' => 'YES',
            'conection' => $conexion,
            'entity' => $this->filename,
            'table' => $this->td->getTable(),
            'primarykey' => $this->td->getPrimaryKey(),
            'linkBy' => '',
            'records_per_page' => 15,
            'isModuleRoot' => 0,
            'order_by' => array(
                array(
                    'title' => $this->td->getPrimaryKey() . " a-z",
                    'criteria' => $this->td->getPrimaryKey() . " ASC",
                ),
                array(
                    'title' => $this->td->getPrimaryKey() . " z-a",
                    'criteria' => $this->td->getPrimaryKey() . " DESC",
                ),
            ),
            'search_default' => $this->td->getPrimaryKey(),
            'referenced_entities' => $this->td->getParentEntities(),
            'columns' => $arrayDeColumnas,
        );

        $yml = sfYaml::dump($array,4);

        $this->buffer = $cabecera . $yml;
    }

    private function creaFieldsVarWeb() {

        $buf  = "# VARIABLES WEB ESPECIFICAS DEL MODULO ". $this->filename ."\n";
        $buf .= "#\n";
        $buf .= "# Module: " . $this->filename . "\n";
        $buf .= "# author Sergio Pérez <sergio.perez@albatronic.com>\n";
        $buf .= "# copyright Informática ALBATRONIC, SL\n";
        $buf .= "# date " . date('d-m-Y H:i:s') . "\n";
        $buf .= "#\n";
        $buf .= "# ejemplo:\n";
        $buf .= "#\n";
        $buf .= "# nombreVariable: el texto del caption\n";
        $buf .= "---\n";

        $this->buffer = $buf;
    }

    private function creaFieldsVarEntorno() {

        $buf  = "# VARIABLES DE ENTORNO ESPECIFICAS DEL MODULO ". $this->filename ."\n";
        $buf .= "#\n";
        $buf .= "# Module: " . $this->filename . "\n";
        $buf .= "# author Sergio Pérez <sergio.perez@albatronic.com>\n";
        $buf .= "# copyright Informática ALBATRONIC, SL\n";
        $buf .= "# date " . date('d-m-Y H:i:s') . "\n";
        $buf .= "#\n";
        $buf .= "# ejemplo:\n";
        $buf .= "#\n";
        $buf .= "# nombreVariable: el texto del caption\n";
        $buf .= "---\n";

        $this->buffer = $buf;
    }


}

?>
