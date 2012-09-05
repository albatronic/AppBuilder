<?php

/**
 * GENERAR EL CODIGO DEL FORMULARIO DE MANTENIMIENTO DE UNA TABLA
 * LO DEVUELVE CON EL METODO GET
 *
 * GENERAN LOS ARCHIVOS: index.php, form.php, new.php, edit.php, list.php, filtro.php
 * y los templates de ayuda.
 * HTML DE PRESENTACIÓN DE LOS DATOS (template.php)
 *
 *
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC, SL 22.10.2010
 * @version 1.0
 */
class TemplateBuilder {

    private $templates = array();
    private $td;
    private $filename;

    public function __construct($table = '') {
        $this->td = new TableDescriptor(DB_BASE, $table);

        //$this->filename = str_replace("_", " ", $this->td->getTable());
        //$this->filename = str_replace(" ", "", ucwords($this->filename));
        $this->filename = $this->td->getTable();

        $this->indexTemplate();
        //$this->filtroTemplate();
        //$this->editTemplate();
        //$this->newTemplate();
        $this->formTemplate();
        $this->fieldsTemplate();
        $this->listTemplate();
        $this->helpTemplate();
        $this->fieldsVarEnv();
        $this->fieldsVarWeb();
    }

    /**
     * Genera el template "list"
     */
    private function listTemplate() {
        $tmp .= "{#\n";
        $tmp .= "  Module: " . $this->filename . "\n";
        $tmp .= "  Document : modules\\" . $this->filename . "\\list.html.twig\n\n";
        $tmp .= "  author: Sergio Pérez <sergio.perez@albatronic.com>\n";
        $tmp .= "  copyright: INFORMATICA ALBATRONIC SL\n";
        $tmp .= "  date " . date('d.m.Y H:i:s') . "\n";
        $tmp .= "#}\n\n";

        $tmp .= "{% extends values.controller  ~ '/index.html.twig' %}\n\n";
        $tmp .= "{% block listado %}\n\n";
        $tmp .= "<div class='Listado'>\n";
        $tmp .= "\t{% include '_global/paginacion.html.twig' with {'filter': values.listado.filter, 'controller': values.controller, 'position': 'izq'}%}\n";
        $tmp .= "\t{% include '_global/listGenerico.html.twig' with {'listado': values.listado, 'controller': values.controller} %}\n";
        //$tmp .= "\t{% include '_global/paginacion.html.twig' with {'filter': values.listado.filter, 'controller': values.controller, 'position': 'der'}%}\n";
        $tmp .= "</div>\n";
        $tmp .= "{% endblock %}";

        $this->templates['list'] = $tmp;
    }

    /**
     * Genera el template para las variables de ENTORNO del modulo
     */
    private function fieldsVarEnv() {
        $tmp .= "{#\n";
        $tmp .= "  Module: " . $this->filename . "\n";
        $tmp .= "  Document : modules\\" . $this->filename . "\\fieldsVarEnv.html.twig\n\n";
        $tmp .= "  author: Sergio Pérez <sergio.perez@albatronic.com>\n";
        $tmp .= "  copyright: INFORMATICA ALBATRONIC SL\n";
        $tmp .= "  date " . date('d.m.Y H:i:s') . "\n";
        $tmp .= "#}\n\n";

        $tmp .= "{% extends values.controller  ~ '/form.html.twig' %}\n\n";
        $tmp .= "{% block variables %}\n";
        $tmp .= "{% endblock %}";

        $this->templates['fieldsVarEnv'] = $tmp;
    }
    /**
     * Genera el template para las variables WEB del módulo
     */
    private function fieldsVarWeb() {
        $tmp .= "{#\n";
        $tmp .= "  Module: " . $this->filename . "\n";
        $tmp .= "  Document : modules\\" . $this->filename . "\\fieldsVarWeb.html.twig\n\n";
        $tmp .= "  author: Sergio Pérez <sergio.perez@albatronic.com>\n";
        $tmp .= "  copyright: INFORMATICA ALBATRONIC SL\n";
        $tmp .= "  date " . date('d.m.Y H:i:s') . "\n";
        $tmp .= "#}\n\n";

        $tmp .= "{% extends values.controller  ~ '/form.html.twig' %}\n\n";
        $tmp .= "{% block variables %}\n";
        $tmp .= "{% endblock %}";

        $this->templates['fieldsVarWeb'] = $tmp;
    }
    /**
     * Generar el template "help"
     */
    private function helpTemplate() {
        $tmp .= "{#\n";
        $tmp .= "  Module: " . $this->filename . "\n";
        $tmp .= "  Document : modules\\" . $this->filename . "\\help.html.twig\n\n";
        $tmp .= "  author: Sergio Pérez <sergio.perez@albatronic.com>\n";
        $tmp .= "  copyright: INFORMATICA ALBATRONIC SL\n";
        $tmp .= "  date " . date('d.m.Y H:i:s') . "\n";
        $tmp .= "#}\n\n";

        $tmp .= "{% extends '_help/layout.html.twig' %}\n\n";
        $tmp .= "{% block titulo %}<h2>{{ values.title }}</h2>{% endblock %}\n\n";
        $tmp .= "{% block contenido %}\n";
        $tmp .= "<h2>Objetivo</h2>\n\n";
        $tmp .= "<h2>Operatoria</h2>\n\n";
        $tmp .= "<h2>FAQ</h2>\n\n";
        $tmp .= "{{ macro.embedVideo(values.idVideo,none,none)}}";
        $tmp .= "\n{% endblock %}";

        $this->templates['help'] = $tmp;
    }

    /**
     * Generar el template "index"
     */
    private function indexTemplate() {
        $tmp .= "{#\n";
        $tmp .= "  Module: " . $this->filename . "\n";
        $tmp .= "  Document : modules\\" . $this->filename . "\\index.html.twig\n\n";
        $tmp .= "  author: Sergio Pérez <sergio.perez@albatronic.com>\n";
        $tmp .= "  copyright: INFORMATICA ALBATRONIC SL\n";
        $tmp .= "  date " . date('d.m.Y H:i:s') . "\n";
        $tmp .= "#}\n\n";

        $tmp .= "{% extends layout %}\n\n";

        $tmp .= "{% block title parent() ~ ' - '  ~ values.titulo %}\n\n";

        $tmp .= "{% block content %}\n";
        //$tmp .= "\t{% include '_global/tituloGenerico.html.twig' with {'controller': values.controller, 'linkValue': values.linkBy.value} %}\n";

        $tmp .= "\t{% block filtro %}\n";
        $tmp .= "\t{% if values.permisos['CO'] and values.tieneListado %}\n";
        $tmp .= "\t\t{% include '_global/filtroGenericoWrapper.html.twig' with {'filter': values.listado.filter} %}\n";
        $tmp .= "\t{% endif %}\n";
        $tmp .= "\t{% endblock %}\n\n";

        $tmp .= "\t<div id='div_listado'>\n";
        $tmp .= "\t{% block listado %}\n";
        $tmp .= "\t{% endblock %}\n";
        $tmp .= "\t</div>\n\n";

        $tmp .= "\t{% block mantenimiento %}\n";
        $tmp .= "\t{% endblock %}\n";

        $tmp .= "{% endblock %}";

        $this->templates['index'] = $tmp;
    }

    /**
     * Generar el template filtro
     */
    private function filtroTemplate() {
        $tmp = "{# Template filtro.html.twig for " . $this->filename . " #}\n";
        $tmp .= "{# -------------------------------------------------------#}\n";
        $tmp .= "<div class='Filtro'>\n";
        $tmp .= "\t<form name='filtro' id='filtro' action='' method='POST'>\n";
        $tmp .= "\t\t<input name='controller' value='{{ values.controller }}' type='hidden' />\n";
        $tmp .= "\t\t<input name='action' id='actionFiltro' value='list' type='hidden' />\n";
        $tmp .= "\t\t{% include '_global/FiltroGenerico.html.twig' with {'filter': filter} %}\n";
        $tmp .= "\t</form>\n";
        $tmp .= "</div>";

        $this->templates['filtro'] = $tmp;
    }

    /**
     * Generar el template edit
     */
    private function editTemplate() {
        $tmp = "{# Template edit.html.twig for " . $this->filename . " #}\n";
        $tmp .= "{# -------------------------------------------------------#}\n";
        $tmp .= "{# EDITAR UN REGISTRO. ACCIONES: GUARDAR Y BORRAR         #}\n";
        $tmp .= "{# -------------------------------------------------------#}\n";
        $tmp .= "{% extends values.controller  ~ '/index.html.twig' %}\n\n";

        $tmp .= "{% block mantenimiento %}\n";
        $tmp .= "<div class=\"FormManto\">\n";
        $tmp .= "\t<form name=\"manto\" id=\"manto_{{ values.controller }}\" action=\"\" enctype=\"multipart/form-data\" method=\"POST\">\n";
        $tmp .= "\t\t<input name=\"controller\" value=\"{{ values.controller }}\" type=\"hidden\" />\n";
        $tmp .= "\t\t<input name=\"action\" id=\"action\" value=\"edit\" type=\"hidden\" />\n";
        $tmp .= "\t\t<input name=\"{{ values.controller }}[" . $this->td->getPrimaryKey() . "]\" value=\"{{ values.datos." . $this->td->getPrimaryKey() . " }}\" type=\"hidden\" />\n";
        $tmp .= "\t\t{% include \"_global/comandosSaveDelete.html.twig\" %}\n\n";

        $tmp .= "\t\t<div class='Cuerpo'>\n";
        $tmp .= "\t\t\t{% include \"_global/FormErrores.html.twig\" with {'errores': values.errores} %}\n";
        $tmp .= "\t\t\t{% include \"_global/alertas.html.twig\" with {'alertas': values.alertas} %}\n";
        $tmp .= "\t\t\t{% include values.controller ~ \"/form.html.twig\" with {'datos': values.datos} %}\n";
        $tmp .= "\t\t</div>\n";
        $tmp .= "\t</form>\n";
        $tmp .= "</div>\n";
        $tmp .= "{% endblock %}";

        $this->templates['edit'] = $tmp;
    }

    /**
     * Generar el template new
     */
    private function newTemplate() {
        $tmp = "{# Template new.html.twig for " . $this->filename . " #}\n";
        $tmp .= "{# -------------------------------------------------------#}\n";
        $tmp .= "{# CREAR UN REGISTRO NUEVO                                #}\n";
        $tmp .= "{# -------------------------------------------------------#}\n";
        $tmp .= "{% extends values.controller ~ '/index.html.twig' %}\n\n";

        $tmp .= "{% block navegador %}{% endblock %}\n\n";

        $tmp .= "{% block mantenimiento %}\n";
        $tmp .= "<div class=\"FormManto\">\n";
        $tmp .= "\t<form name=\"manto\" action=\"\" method=\"POST\">\n";
        $tmp .= "\t\t<input name=\"controller\" value=\"{{ values.controller }}\" type=\"hidden\" />\n";
        $tmp .= "\t\t<input name=\"action\" id=\"action\" value=\"new\" type=\"hidden\" />\n";
        $tmp .= "\t\t<input name=\"{{ values.controller }}[" . $this->td->getPrimaryKey() . "]\" value=\"{{ values.datos." . $this->td->getPrimaryKey() . " }}\" type=\"hidden\" />\n";
        $tmp .= "\t\t{% include '_global/comandosCreate.html.twig' %}\n";

        $tmp .= "\t\t<div class=\"Cuerpo\">\n";
        $tmp .= "\t\t\t{% include '_global/FormErrores.html.twig' with {'errores': values.errores} %}\n";
        $tmp .= "\t\t\t{% include '_global/alertas.html.twig' with {'alertas': values.alertas} %}\n";
        $tmp .= "\t\t\t{% include values.controller ~ \"/form.html.twig\" with {'datos': values.datos} %}\n";
        $tmp .= "\t\t</div>\n";
        $tmp .= "\t</form>\n";
        $tmp .= "</div>\n";
        $tmp .= "{% endblock %}";

        $this->templates['new'] = $tmp;
    }

    /**
     * Generar el template form
     */
    private function formTemplate() {
        $tmp .= "{#\n";
        $tmp .= "  Module: " . $this->filename . "\n";
        $tmp .= "  Document : modules\\" . $this->filename . "\\form.html.twig\n\n";
        $tmp .= "  author: Sergio Pérez <sergio.perez@albatronic.com>\n";
        $tmp .= "  copyright: INFORMATICA ALBATRONIC SL\n";
        $tmp .= "  date " . date('d.m.Y H:i:s') . "\n";
        $tmp .= "#}\n\n";

        $tmp .= "{% extends values.controller ~ '/index.html.twig' %}\n\n";

        $tmp .= "{% if values.datos.getPrimaryKeyValue == '' %} {% set action = 'new' %} {% else %} {% set action = 'edit' %} {% endif %}\n";
        //$tmp .= "{% if action == 'new' %} {% block navegador %}{% endblock %} {% endif %}\n\n";

        $tmp .= "{% block mantenimiento %}\n";
        $tmp .= "<div class=\"grid_container\">\n";
        $tmp .= "\t<div class=\"grid_12 full_block\">\n";
        $tmp .= "\t\t<div class=\"widget_wrap\">\n";
        $tmp .= "\t\t<div class=\"widget_content\">\n";
        $tmp .= "\t\t<form name=\"manto_{{ values.controller}}\" id=\"manto_{{ values.controller }}\" action=\"\" method=\"POST\" enctype=\"multipart/form-data\" class=\"form_container left_label\">\n";
        $tmp .= "\t\t\t<input name=\"controller\" value=\"{{ values.controller }}\" type=\"hidden\" />\n";
        $tmp .= "\t\t\t<input name=\"action\" id=\"action_{{ values.controller }}\" value=\"{{action}}\" type=\"hidden\" />\n";
        $tmp .= "\t\t\t<input name=\"accion\" id=\"accion_{{ values.controller }}\" value=\"\" type=\"hidden\" />\n";
        $tmp .= "\t\t\t<input name=\"{{ values.controller }}[{{values.datos.getPrimaryKeyName}}]\" value=\"{{values.datos.getPrimaryKeyValue}}\" type=\"hidden\" />\n\n";
        //$tmp .= "\t\t\t{% if action == 'new' %} {% include '_global/comandosCreate.html.twig' %} {% endif %}\n";
        //$tmp .= "\t\t\t{% if action == 'edit' %} {% include '_global/comandosSaveDelete.html.twig' %} {% endif %}\n\n";
        $tmp .= "\t\t\t{% include '_global/formErrores.html.twig' with {'errores': values.errores} %}\n";
        $tmp .= "\t\t\t{% include '_global/alertas.html.twig' with {'alertas': values.alertas} %}\n\n";
        $tmp .= "\t\t\t<ul>\n";
        $tmp .= "\t\t\t\t{% include values.controller ~ \"/fields.html.twig\" with {'datos': values.datos} %}\n";
        $tmp .= "\t\t\t</ul>\n";
        $tmp .= "\t\t</form>\n";
        $tmp .= "\t\t</div>\n";
        $tmp .= "\t\t</div>\n";
        $tmp .= "\t</div>\n";
        $tmp .= "</div>\n";
        $tmp .= "{% endblock %}";

        $this->templates['form'] = $tmp;
    }

    /**
     * Generar el template de los campos
     */
    private function fieldsTemplate() {

        $labelClass = "field_title";

        $tmp .= "{#\n";
        $tmp .= "  Module: " . $this->filename . "\n";
        $tmp .= "  Document : modules\\" . $this->filename . "\\fields.html.twig\n\n";
        $tmp .= "  author: Sergio Pérez <sergio.perez@albatronic.com>\n";
        $tmp .= "  copyright: INFORMATICA ALBATRONIC SL\n";
        $tmp .= "  date " . date('d.m.Y H:i:s') . "\n";
        $tmp .= "#}\n\n";

        $tabindex = 0;
        $campoFoco = '';

        foreach ($this->td->getColumns() as $column) {
            // NO SE GENERA NI LA PRIMARIKEY NI LAS COLUMNAS DE COMUNES
            if (($column['Field'] != $this->td->getPrimaryKey()) and (!in_array($column['Field'], columnasComunes::$columnasExcepcion))) {

                if ($campoFoco == '')
                    $campoFoco = $column['Field'];

                $tabindex++;

                $column_name = str_replace('-', '_', $column['Field']);

                $label = ucwords($column_name);
                $labelClass = $labelClass;
                $name = "values.controller ~ '[" . $column_name . "]'";
                $id = "values.controller ~ '_" . $column_name . "'";
                $value = "datos." . $column_name;

                if ($column['ReferencedSchema'] != '') {
                    // El campo es un ID de referencia a otra tabla. Se muestra una lista desplegable
                    $macro = "select";
                    $tagClass = "Select";
                    if (strtoupper($column['ReferencedEntity']) == 'ABSTRACT') {
                        $value = ".IDTipo";
                        $opciones = "datos." . $column_name . ".fetchAll('0')";
                    } else {
                        $value .= "." . $column_name;
                        $opciones = "datos." . $column_name . ".fetchAll('" . $column['ReferencedColumn'] . "')";
                    }
                } else {
                    switch ($column['Type']) {
                        case 'datetime':
                            $macro = "fecha";
                            $tagClass = "datepicker";
                            $maxLong = 19;
                            break;

                        case 'date':
                            $macro = "fecha";
                            $tagClass = "datepicker";
                            $maxLong = 10;
                            break;

                        case 'varchar':
                        case 'char':
                            $macro = "input";
                            $type = "text";
                            if ($column['Length'] >= 30)
                                $tagClass = "CampoTextoLargo";
                            else
                                $tagClass = "CampoTextoCorto";
                            $maxLong = $column['Length'];
                            break;

                        case 'tinyint':
                            $macro = "select";
                            $tagClass = "chzn-select";
                            $value .= "." . $column_name;
                            $opciones = "datos." . $column_name . ".fetchAll()";
                            break;

                        case 'bigint':
                        case 'int':
                        case 'smallint':
                        case 'decimal':
                            $macro = "input";
                            $type = "text";
                            if ($column['Length'] >= 8)
                                $tagClass = "CampoImporte";
                            else
                                $tagClass = "CampoUnidades";
                            $maxLong = $column['Length'];
                            break;

                        case 'text':
                        case 'longtext':
                            $macro = "textarea";
                            $tagClass = "input_grow";
                            break;

                        case 'enum': // NO SE RECOMIENDA EL USO DE ENUM
                            //Desplegable de array
                            //Los valores posibles vienen como un string, cada uno entre comillas simples
                            //y separados por comas. EL string lo convierto a un array para luego tratarlo
                            $valores = '';
                            $aux = array();
                            $aux = split(",", $column['Values']);

                            foreach ($aux as $value) {
                                if ($valores != '')
                                    $valores.=",";
                                $valores.="$value=>$value";
                            }
                            $tmp .="<div><?php desplegableArray('" . $column_name . "',array(" . $valores . "),\$dat->get" . $column_name . "());?></div>\n";
                            break;

                        default:
                            $macro = "input";
                            $type = "text";
                            $tagClass = "";
                    } // end switch
                } // end del else

                switch ($macro) {
                    case 'input':
                        $tmp .= "{{ macro.input('" . $label . "','" . $labelClass . "','" . $type . "'," . $name . "," . $id . "," . $value . ",'" . $maxLong . "','" . $tagClass . "','" . $tabindex . "') }}\n";
                        break;

                    case 'textarea':
                        $tmp .= "{{ macro.textarea('" . $label . "','" . $labelClass . "'," . $name . "," . $id . "," . $value . ",none,none,'" . $tagClass . "','" . $tabindex . "')}}\n";
                        break;

                    case 'fecha':
                        $tmp .= "{{ macro.fecha('" . $label . "','" . $labelClass . "'," . $name . "," . $id . "," . $value . ",'" . $maxLong . "','" . $tagClass . "','" . $tabindex . "')}}\n";
                        break;

                    case 'select':
                        $tmp .= "{{ macro.select('" . $label . "','" . $labelClass . "'," . $name . "," . $id . ",none," . $value . "," . $opciones . ",'" . $tagClass . "','" . $tabindex . "')}}\n";
                        break;
                }
            } // end if
        } // end foreach
        // Añado el include de los campos comunes
        $tmp .= "\n{% include '_global/fieldsComunes.html.twig' %}\n\n";

        // Añado la macro para situar el foco
        $tmp .= "{{ macro.foco(values.controller ~ '_{$campoFoco}') }}\n";

        $this->templates['fields'] = $tmp;
    }

    /**
     * Devuelve el código html con el formulario de mantenimiento
     * @return text
     */
    public function Get() {
        return $this->templates;
    }

}

?>