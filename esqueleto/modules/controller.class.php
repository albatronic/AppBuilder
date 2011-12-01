<?php

/**
 * Controlador genérico para el mantenimiento de entidades de datos
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC SL
 * @version 1.0 26.05.2011
 */
class controller {

    /**
     * Variables enviadas en el request por POST o por GET
     * @var request
     */
    protected $request;
    /**
     * Objeto de la clase 'form' con las propiedades y métodos
     * del formulario obtenidos del fichero de configuracion
     * del formulario en curso
     * @var from
     */
    protected $form;
    /**
     * Objeto de la clase 'listado' donde se guarda y gestiona
     * toda la información relativa al listado por pantalla
     * @var listado
     */
    protected $listado;
    /**
     * Valores a devolver al controlador principal para
     * que los renderice con el twig correspondiente
     * @var array
     */
    protected $values;
    /**
     * Objeto de la clase 'controlAcceso'
     * para gestionar los permisos de acceso a los métodos del controller
     * @var ControlAcceso
     */
    protected $permisos;


    public function __construct($request) {

        $this->request = $request;
        $this->form = new form($this->entity);
        $this->listado = new listado($this->form, $this->request);

        if ($this->parentEntity == '')
            $this->permisos = new ControlAcceso($this->entity);
        else
            $this->permisos = new ControlAcceso($this->parentEntity);

        $this->values['titulo'] = $this->form->getTitle();
        $this->values['ayuda'] = $this->form->getHelpFile();
        $this->values['permisos'] = $this->permisos->getPermisos();
        $this->values['request'] = $this->request;
        $this->values['linkBy'] = array(
            'id' => $this->form->getLinkBy(),
            'value' => '',
        );

        $this->values['listado'] = array(
            'filter' => $this->listado->getFilter(),
        );

        if (!$this->form->getConection()) {
            echo "No se ha definido la conexión para la entidad " . $this->entity;
        }
    }

    public function indexAction() {
        return array('template' => $this->entity . '/index.html.twig', 'values' => $this->values);
    }

    /**
     * Edita, actualiza o borrar un registro
     *
     * Si viene por GET es editar
     * Si viene por POST puede ser actualizar o borrar
     * según el valor de $this->request['accion']
     *
     * @return array con el template y valores a renderizar
     */
    public function editAction() {

        switch ($this->request["METHOD"]) {
            case 'GET':
                if ($this->values['permisos']['C']) {
                    //SI EN LA POSICION 4 DEL REQUEST VIENE ALGO,
                    //SE ENTIENDE QUE ES EL VALOR DE LA CLAVE PARA LINKAR CON LA ENTIDAD PADRE
                    //ESTO SE UTILIZA PARA LOS FORMULARIOS PADRE->HIJO
                    if ($this->request['4'] != '')
                        $this->values['linkBy']['value'] = $this->request['4'];

                    //MOSTRAR DATOS. El ID viene en la posicion 3 del request
                    $datos = new $this->entity($this->request[3]);
                    if ($datos->getStatus()) {
                        $this->values['datos'] = $datos;
                        $this->values['errores'] = $datos->getErrores();
                        return array('template' => $this->entity . '/edit.html.twig', 'values' => $this->values);
                    } else {
                        $this->values['errores'] = array("Valor no encontrado");
                        return array('template' => $this->entity . '/new.html.twig', 'values' => $this->values);
                    }
                } else {
                    return array('template' => '_global/forbiden.html.twig');
                }
                break;

            case 'POST':
                //COGER DEL REQUEST EL LINK A LA ENTIDAD PADRE
                if ($this->values['linkBy']['id'] != '') {
                    $this->values['linkBy']['value'] = $this->request[$this->entity][$this->values['linkBy']['id']];
                }

                switch ($this->request['accion']) {
                    case 'Guardar': //GUARDAR DATOS
                        if ($this->values['permisos']['A']) {
                            $datos = new $this->entity();
                            $datos->bind($this->request[$this->entity]);
                            if ($datos->valida($this->form->getRules())) {
                                $this->values['alertas'] = $datos->getAlertas();
                                $datos->save();

                                //Recargo el objeto para refrescar las propiedas que
                                //hayan podido ser objeto de algun calculo durante el proceso
                                //de guardado.
                                $datos = new $this->entity($this->request[$this->entity][$datos->getPrimaryKeyName()]);
                            } else {
                                $this->values['errores'] = $datos->getErrores();
                                $this->values['alertas'] = $datos->getAlertas();
                            }
                            $this->values['datos'] = $datos;
                            return array('template' => $this->entity . '/edit.html.twig', 'values' => $this->values);
                        } else {
                            return array('template' => '_global/forbiden.html.twig');
                        }
                        break;

                    case 'Borrar': //BORRAR DATOS
                        if ($this->values['permisos']['B']) {
                            $datos = new $this->entity();
                            $datos->bind($this->request[$this->entity]);

                            if ($datos->erase()) {
                                $datos = new $this->entity();
                                $this->values['datos'] = $datos;
                                $this->values['errores'] = array();
                                return array('template' => $this->entity . '/new.html.twig', 'values' => $this->values);
                            } else {
                                $this->values['datos'] = $datos;
                                $this->values['errores'] = $datos->getErrores();
                                $this->values['alertas'] = $datos->getAlertas();
                                return array('template' => $this->entity . '/edit.html.twig', 'values' => $this->values);
                            }
                        } else {
                            return array('template' => '_global/forbiden.html.twig');
                        }
                        break;
                }
                break;
        }
    }

    /**
     * Crea un registro nuevo
     *
     * Si viene por GET muestra un template vacio
     * Si viene por POST crea un registro
     *
     * @return array con el template y valores a renderizar
     */
    public function newAction() {

        if ($this->values['permisos']['I']) {
            switch ($this->request["METHOD"]) {
                case 'GET': //MOSTRAR FORMULARIO VACIO
                    //SI EN LA POSICION 3 DEL REQUEST VIENE ALGO,
                    //SE ENTIENDE QUE ES EL VALOR DE LA CLAVE PARA LINKAR CON LA ENTIDAD PADRE
                    //ESTO SE UTILIZA PARA LOS FORMULARIOS PADRE->HIJO
                    if ($this->request['3'] != '')
                        $this->values['linkBy']['value'] = $this->request['3'];

                    $datos = new $this->entity();
                    $this->values['datos'] = $datos;
                    $this->values['errores'] = array();
                    return array('template' => $this->entity . '/new.html.twig', 'values' => $this->values);
                    break;

                case 'POST': //CREAR NUEVO REGISTRO
                    //COGER EL LINK A LA ENTIDAD PADRE
                    if ($this->values['linkBy']['id'] != '') {
                        $this->values['linkBy']['value'] = $this->request[$this->entity][$this->values['linkBy']['id']];
                    }

                    $datos = new $this->entity();
                    $datos->bind($this->request[$this->entity]);

                    if ($datos->valida($this->form->getRules())) {
                        $datos->create();
                        $this->values['errores'] = $datos->getErrores();
                        $this->values['alertas'] = $datos->getAlertas();

                        //Recargo el objeto para refrescar las propiedas que
                        //hayan podido ser objeto de algun calculo durante el proceso
                        //de guardado.
                        $datos = new $this->entity($datos->getPrimaryKeyValue());
                        $this->values['datos'] = $datos;

                        if ($this->values['errores']) {
                            return array('template' => $this->entity . '/new.html.twig', 'values' => $this->values);
                        } else {
                            return array('template' => $this->entity . '/edit.html.twig', 'values' => $this->values);
                        }
                    } else {
                        $this->values['datos'] = $datos;
                        $this->values['errores'] = $datos->getErrores();
                        $this->values['alertas'] = $datos->getAlertas();
                        return array('template' => $this->entity . '/new.html.twig', 'values' => $this->values);
                    }
                    break;
            }
        } else {
            return array('template' => '_global/forbiden.html.twig');
        }
    }

    /**
     * Muestra el template de ayuda asociado al controlador
     * El nombre del template de ayuda está definido en el
     * nodo <help_file> del config.xml del controlador
     * Si no existiera, se muestra un template indicando esta
     * circunstancia
     * 
     * @return array con el template a renderizar
     */
    public function helpAction() {
        $template = '_help/contents/' . $this->form->getHelpFile();
        $file = "modules/" . $template;
        if (!file_exists($file))
            $template = "_help/_global/noFound.html.twig";

        return array('template' => $template);
    }

    /**
     * Genera una listado por pantalla en base al filtro.
     * Puede recibir un filtro adicional
     *
     * @param string $aditionalFilter
     * @return array con el template y valores a renderizar
     */
    public function listAction($aditionalFilter='') {
        if ($this->values['permisos']['L']) {
            $this->values['listado'] = $this->listado->getAll($aditionalFilter);
            $template = $this->entity . '/list.html.twig';
        } else {
            $template = "_global/forbiden.html.twig";
        }

        return array('template' => $template, 'values' => $this->values);
    }

    /**
     * Genera un listado en formato PDF en base a los parametros obtenidos
     * del fichero listados.xml de cada controlador y los datos filtrados
     * segun el request
     * @return array Template y valores
     */
    public function listadoAction($aditionalFilter='') {
        if ($this->values['permisos']['L']) {
            $this->values['archivo'] = $this->listado->getPdf($this->request['formatoListado'], $aditionalFilter);
            $template = '_global/listadoPdf.html.twig';
        } else {
            $template = "_global/forbiden.html.twig";
        }

        return array('template' => $template, 'values' => $this->values);
    }

    /**
     * Renderiza el documento indicado en $this->values['archivo']
     * y que debe ser generado por el método imprimePdf() de cada controlador
     * @return array Template y valores
     */
    public function imprimirAction() {
        if ($this->values['permisos']['L']) {
            
            if ($this->request['METHOD'] == 'GET')
                $idDocumento = $this->request['3'];
            else
                $idDocumento = $this->request['idDocumento'];
            
            $this->values['archivo'] = $this->imprimePdf($idDocumento);
            $template = '_global/documentoPdf.html.twig';
            
        } else {
            $template = "_global/forbiden.html.twig";
        }

        return array('template' => $template, 'values' => $this->values,);
    }

    /**
     * Enviar por email el documento indicado en $this->values['archivo']
     * @return array Template y valores
     */
    public function enviarAction() {
        return array('template' => $this->entity . '/mail.html.twig', 'values' => $this->values,);
    }

    /**
     * Realiza el proceso de exportación de información en base a
     * los datos que le pasa cada controlador en $this->values['export']
     *
     * Puede generar distintos tipos de archivos (xml, excel).
     * Despues de generar el archivo, muestra un template para descargarlo
     *
     * @return array
     */
    public function exportarAction($aditionalFilter='') {

        if ($this->values['permisos']['E']) {
            $arrayQuery = $this->listado->getQuery($aditionalFilter);

            $this->values['export']['query'] =
                    "SELECT " . $arrayQuery['SELECT'] .
                    " FROM " . $arrayQuery['FROM'] .
                    " WHERE " . $arrayQuery['WHERE'] .
                    " ORDER BY " . $arrayQuery['ORDER BY'];

            if ($this->values['export']['type'] == '')
                $this->values['export']['type'] = 'xml';

            if ($this->values['export']['title'] == '')
                $this->values['export']['title'] = $this->entity;

            switch ($this->values['export']['type']) {
                case 'xml':
                    $this->values['export']['file'] = 'docs/docs' . $_SESSION['emp'] . '/export/xmls/' . $this->entity . '.xml';
                    $xml = new xmlBuilder(
                                    $this->form->getConection(),
                                    $this->values['export']['query'],
                                    $this->values['export']['file'],
                                    'root',
                                    $this->entity
                    );
                    $xml->writeXml();
                    unset($xml);
                    break;

                case 'xls':
                    break;

                default :
            }

            $template = '_global/exportar.html.twig';
        } else {
            $template = "_global/forbiden.html.twig";
        }
        return array('template' => $template, 'values' => $this->values,);
    }

}

?>