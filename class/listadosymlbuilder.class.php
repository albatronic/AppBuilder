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
class ListadosYmlBuilder
{
    private $buffer;
    private $filename;
    private $td;

    public function __construct($table='')
    {
        $this->td = new TableDescriptor(DB_BASE, $table);
        //$this->filename = str_replace("_", " ", $this->td->getTable());
        //$this->filename = str_replace(" ", "", ucwords($this->filename));
        $this->filename = $this->td->getTable();
        $this->creaYAML();
    }

    /**
     * Devuelve el código xml de configuracion del formulario de mantenimiento
     * @return text
     */
    public function Get()
    {
        return $this->buffer;
    }

    private function creaYAML()
    {
        $array = array();

        $sinPrefijo = str_replace(PREFIJO, "", $this->filename);

        $cabecera  = "# Module: " . $sinPrefijo . "\n";
        $cabecera .= "# Document : modules\\" . $sinPrefijo . "\listados.yml\n#\n";
        $cabecera .= "# @author: Sergio Pérez <sergio.perez@albatronic.com>\n# @copyright: INFORMATICA ALBATRONIC SL\n# @date " . date('d.m.Y H:i:s') . "\n";
        $cabecera .= "#\n---\n";

        $array['listados'][] = array(
            'title' => ucwords($sinPrefijo),
            'order_by' => $this->td->getPrimaryKey(),
            'break_field' => null,
            'idPerfil' => null,
            'orientation' => 'P',
            'unit' => 'mm',
            'format' => 'A4',
            'margins' => '10, 10, 15, 10',
            'body_font' => 'Courier, , 8',
            'line_height' => 4,
            'print_interline' => null,
            'legend_bottom' => null,
            'columns' => $this->getArrayColumns(),
        );

        $yml = sfYaml::dump($array,4);

        $this->buffer = $cabecera . $yml;
    }

    private function getArrayColumns()
    {
        $columnas = array();

        foreach ($this->td->getColumns() as $column) {
            // NO SE MUESTRA LA PRIMARYKEY NI LAS COLUMNAS COMUNES
            if ( ($column['Field'] != $this->td->getPrimaryKey()) and (!in_array($column['Field'], columnasComunes::$columnasExcepcion)) ) {
                switch (tiposVariables::$tipos[$column['Type']]) {
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

                $columnas[$column['Field']] = array(
                    'field' => $column['Field'],
                    'title' => $column['Field'],
                    'length' => $column['Length'],
                    'align' => $align,
                    'type' => tiposVariables::$tipos[$column['Type']],
                    'total' => 'NO',
                    'formula' => null,
                    'format' => null,
                 );
            }
        }

        return $columnas;
    }

}
