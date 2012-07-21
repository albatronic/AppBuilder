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

    private $auditoriaColumns = array('CreatedBy', 'CreatedAt', 'ModifiedBy', 'ModifiedAt');

    public function __construct($table='') {
        $this->td = new TableDescriptor(DB_BASE, $table);

        $this->filename = str_replace("_", " ", $this->td->getTable());
        $this->filename = str_replace(" ", "", ucwords($this->filename));

        $this->indexTemplate();
        $this->filtroTemplate();
        $this->editTemplate();
        $this->newTemplate();
        $this->formTemplate();
        $this->listTemplate();
        $this->helpTemplate();
    }

    /**
     * Genera el templata "list"
     */
    private function listTemplate() {
        $tmp = "{# Template list.html.twig for " . $this->filename . " #}\n";
        $tmp .= "{# -------------------------------------------------------#}\n";
        $tmp .= "{% extends values.controller  ~ '/index.html.twig' %}\n\n";
        $tmp .= "{% block listado %}\n";
        $tmp .= "<div class='Listado'>\n";
        $tmp .= "\t{% include '_global/paginacion.html.twig' with {'filter': values.listado.filter, 'controller': values.controller, 'position': 'izq'}%}\n\n";
        $tmp .= "\t{% include '_global/listGenerico.html.twig' with {'listado': values.listado, 'controller': values.controller} %}\n\n";
        //$tmp .= "\t{% include '_global/paginacion.html.twig' with {'filter': values.listado.filter, 'controller': values.controller, 'position': 'der'}%}\n";
        $tmp .= "</div>\n";
        $tmp .= "{% endblock %}";

        $this->templates['list'] = $tmp;
    }

    /**
     * Generar el template "help"
     */
    private function helpTemplate() {
        $tmp = "{# Template " . $this->filename . ".html.twig for " . $this->filename . " #}\n";
        $tmp .= "{# -------------------------------------------------------#}\n";
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
        $tmp = "{# Template index.html.twig for " . $this->filename . " #}\n";
        $tmp .= "{# ----------------------------------------------------#}\n";
        $tmp .= "{% extends layout %}\n\n";

        $tmp .= "{% block title parent() ~ ' - '  ~ values.titulo %}\n\n";

        $tmp .= "{% block content %}\n";
        $tmp .= "\t{% include '_global/TituloGenerico.html.twig' with {'controller': values.controller, 'linkValue': values.linkBy.value} %}\n";

        $tmp .= "\t{% block filtro %}\n";
        $tmp .= "\t{% if values.permisos['C'] %}\n";
        $tmp .= "\t\t{% include values.controller  ~ '/filtro.html.twig' with {'filter': values.listado.filter} %}\n";
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
        $tmp .= "\t\t<input name=\"{{ values.controller }}[" . $this->td->getPrimaryKey() ."]\" value=\"{{ values.datos." . $this->td->getPrimaryKey() . " }}\" type=\"hidden\" />\n";
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
        $labelClass = "Etiqueta";

        $tmp = "{# TEMPLATE " . $this->filename . "/form.html.twig #}\n";
        $tmp .= "{# Muestra los campos editables de la entidad #}\n\n";
        //$tmp .= "{% import '_global/macros.html.twig' as macro %}\n\n";

        foreach ($this->td->getColumns() as $column) {
            // NO SE MUESTRA NI LA PRIMARI KEY NI LAS COLUMNAS DE AUDITORIA
            if ( ($column['Field'] != $this->td->getPrimaryKey()) and (!in_array($column['Field'], $this->auditoriaColumns)) ) {
                $column_name = str_replace('-', '_', $column['Field']);

                $label = ucwords($column_name);
                $labelClass = $labelClass;
                $name = $this->filename . "[" . $column_name . "]";
                $id = $this->filename . "_" . $column_name;
                $value = "datos." . $column_name;

                if ($column['ReferencedSchema'] != '') {
                    // El campo es un ID de referencia a otra tabla. Se muestra una lista desplegable
                    $macro = "select";
                    $tagClass = "Select";
                    $value .= "." . $column_name;
                    $opciones = "datos." . $column_name . ".fetchAll('" . $column['ReferencedColumn'] . "')";
                } else {
                    switch ($column['Type']) {
                        case 'datetime':
                            $macro = "fecha";
                            $tagClass = "LiteralFechaHora";
                            $maxLong = 19;
                            break;

                        case 'date':
                            $macro = "fecha";
                            $tagClass = "CampoFecha";
                            $maxLong = 10;
                            break;

                        case 'varchar':
                        case 'char':
                            $macro = "input";
                            $type = "text";
                            if ($column['Length'] >= 30)
                                $tagClass = "CampoTextoLargo";
                            else
                                $tagClass="CampoTextoCorto";
                            $maxLong = $column['Length'];
                            break;

                        case 'tinyint':
                            $macro = "select";
                            $tagClass = "Select";
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
                                $tagClass="CampoUnidades";
                            $maxLong = $column['Length'];
                            break;

                        case 'text':
                        case 'longtext':
                            $macro = "textarea";
                            $tagClass = "TextArea";
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
                        $tmp .= "{{ macro.input('" . $label . "','" . $labelClass . "','" . $type . "','" . $name . "','" . $id . "'," . $value . ",'" . $maxLong . "','" . $tagClass . "') }}\n";
                        break;

                    case 'textarea':
                        $tmp .= "{{ macro.textarea('" . $label . "','" . $labelClass . "','" . $name . "','" . $id . "'," . $value . ",none,none,'" . $tagClass . "')}}\n";
                        break;

                    case 'fecha':
                        $tmp .= "{{ macro.fecha('" . $label . "','" . $labelClass . "','" . $name . "','" . $id . "'," . $value . ",'" . $maxLong . "','" . $tagClass . "') }}\n";
                        break;

                    case 'select':
                        $tmp .= "{{ macro.select('" . $label . "','" . $labelClass . "','" . $name . "','" . $id . "',none," . $value . "," . $opciones . ",'" . $tagClass . "')}}\n";
                        break;
                }
            } // end if
        } // end foreach

        $this->templates['form'] = $tmp;
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