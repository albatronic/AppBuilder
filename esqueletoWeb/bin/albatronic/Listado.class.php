<?php

/**
 * Class Listado
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC, SL
 * @since 05.06.2011 11:52:30
 */
class Listado {

    /**
     * Array con los parámatros del filtro del listado:
     * columnas y valores por los que filtrar, registros por página, etc
     * @var array
     */
    public $filter = array();

    /**
     * Columnas que se monstraran en el listado:
     * títulos, columna física y posibles links
     * @var array
     */
    private $titles = array();

    /**
     * Datos que componen el listado
     * @var array Array de objetos
     */
    private $data = array();

    /**
     * Valores del config.xml del modulo en curso
     * @var form Objeto form
     */
    private $form;

    /**
     * Valores del request
     * @var request El objeto request
     */
    private $request;

    /**
     * La sentencia SQL generadora del listado
     * @var string La sentencia SQL
     */
    private $query = '';

    /**
     * La entidad sobre la que se va a generar el listado
     * @var string La entidad
     */
    private $entity;

    /**
     * El nombre de la clave primaria de la entidad
     * @var string La clave primaria
     */
    private $primaryKey;

    public function __construct(Form $form, $request) {

        $this->form = $form;
        $this->request = $request;
        $this->entity = $this->form->getEntity();
        $this->primaryKey = $this->form->getPrimaryKey();

        $this->filter['columns'] = $this->form->getListArrayColumns();

        switch ($this->request['METHOD']) {
            case 'POST':
                $this->filter['columnsSelected'] = $this->request['filter']['columnsSelected'];
                $this->filter['valuesSelected'] = $this->request['filter']['valuesSelected'];
                $this->filter['flags'] = $this->request['filter']['flags'];
                break;
            case 'GET':
                $this->filter['columnsSelected'] = array();
                $this->filter['valuesSelected'] = array();
                $this->filter['flags'] = array();
                break;
        }

        // El criterio de ordenacion concreto seleccionado en el request
        // Si no se ha seleccionado ninguno (cuando se entra al controlador por el método listAction con GET)
        // se pone el primer criterio de ordenación indicado en el config.yml. Y si tampoco hubiera nada
        // se pone la primaryKey.
        $this->filter['orderBy'] = $this->request['filter']['orderBy'];
        if ($this->filter['orderBy'] == '') {
            $criteriosOrden = $this->form->getListOrderBy();
            if (is_array($criteriosOrden) and (count($criteriosOrden) > 0))
                $this->filter['orderBy'] = $criteriosOrden[0]['criteria'];
            else
                $this->filter['orderBy'] = $form->getPrimaryKey() . " ASC";
        }

        // Criterios de ordenacion definidos en config.yml de cada modulo
        $this->filter['columnsOrder'] = $this->form->getListOrderBy();

        // Número de página a mostrar
        $this->filter['page'] = $this->request['filter']['page'];
        if ($this->filter['page'] <= 0)
            $this->filter['page'] = 1;

        // Número de resgistros por página a mostrar
        $this->filter['recordsPerPage'] = $this->request['filter']['recordsPerPage'];
        if ($this->filter['recordsPerPage'] <= 0)
            $this->filter['recordsPerPage'] = $this->form->getListRecordsPerPage();

        // Filtros adicionales
        $this->filter['aditional'] = $this->form->getFilters();
        foreach ($this->filter['aditional'] as $key => $value) {
            if (($value['entity'] != '') and ($value['type'] == 'select')) {
                $claseConId = explode(',', $value['entity']);
                $objeto = new $claseConId[0]($claseConId[1]);
                $this->filter['aditional'][$key]['values'] = $objeto->{$value['method']}($value['params']);
                //$this->filter['aditional'][$key]['values'][] = array('Id' => '', 'Value' => '** Todo **');
            }
        }

        // Los títulos de las columnas a mostrar en el listado
        $this->titles = $this->form->getListTitleColumns();
    }

    /**
     * Devuelve un array con los parametros del filtro
     * @return array
     */
    public function getFilter() {
        return $this->filter;
    }

    /**
     * Devuelve un array con los titulos de las columnas del listado
     * @return array
     */
    public function getTitles() {
        return $this->titles;
    }

    /**
     * Devuelve un array con los formatos de listado disponibles
     * para el perfil de usuario y controller en curso.
     * @return array $formatosListados
     */
    public function getFormatos() {

        $form = new Form($this->form->getEntity(), 'listados.yml');
        $formatosListados = $form->getFormatosListados();
        unset($form);

        return $formatosListados;
    }

    public function setQuery($query) {
        $this->query = $query;
    }

    public function getQuery() {
        return $this->query;
    }

    /**
     * Devuelve un array con los elementos de la sentencia
     * SELECT SQL necesaria para realizar el listado y que
     * se ha generado en base a las condiciones del filtro.
     * El array es:
     * array (
     *      'SELECT'   =>
     *      'FROM'     =>
     *      'WHERE'    =>
     *      'ORDER BY' =>
     * )
     *
     * @return array arrayQuery Array con los elementos que componen el query
     */
    public function makeQuery($aditionalFilter = '') {
        //Recorro las columnsSelected del filter para ver
        //qué columnas se han seleccionado y construir el filtro
        $filtro = '';
        $tablas = $this->form->getDataBaseName() . "." . $this->form->getTable();
        foreach ($this->filter['columnsSelected'] as $key => $value) {
            if ($this->filter['valuesSelected'][$key] != '') {
                if ($filtro)
                    $filtro .= " AND ";

                if ($this->filter['aditional'][$key]['entity']) {
                    // Es una entidad, es una columna de la tabla que referencia a otra tabla
                    // ----------------------------------------------------------------------
                    switch ($this->filter['aditional'][$key]['type']) {
                        case 'select':
                            $filtro .= "(" . $this->form->getDataBaseName() . "." . $this->form->getTable() . "." . $value . " = '" . $this->filter['valuesSelected'][$key] . "')";
                            break;
                        case 'input': //Hay que construir join a otra tabla
                            //Buscar el nombre físico de la BD y de la Tabla y añadirlo
                            //a la lista de tablas
                            $entidadReferenciada = new $this->filter['aditional'][$key]['entity'] ( );
                            $tablaReferenciada = $entidadReferenciada->getDataBaseName() . "." . $entidadReferenciada->getTableName();
                            $tablas .= ", " . $tablaReferenciada;
                            //Construir la parte del where para el join
                            $filtro .= "(" . $this->form->getDataBaseName() . "." . $this->form->getTable() . "." . $this->filter['columnsSelected'][$key] . "=" . $tablaReferenciada . "." . $entidadReferenciada->getPrimaryKeyName() . ")";
                            //Construir el filtro de la columna
                            $filtro .= " AND (" . $tablaReferenciada . "." . $this->filter['aditional'][$key]['params'] . " LIKE '" . $this->filter['valuesSelected'][$key] . "')";
                            unset($entidadReferenciada);
                            break;
                        case 'check':
                            //No se trata porque no tiene entidad
                            break;
                    }
                } else {
                    // No es una entidad, es una columna de la tabla que no referencia a otra tabla
                    // Puede ser input, range, check. En cualquier otro caso es una de las columnas
                    // del filtro estándar.
                    $operador = $this->filter['aditional'][$key]['operator'];

                    switch ($this->filter['aditional'][$key]['type']) {
                        case "check":
                            // Es de tipo check pero no viene vacio
                            if ($this->filter['valuesSelected'][$key] == 'on') {
                                $this->filter['valuesSelected'][$key] = '1';
                            } else {
                                $this->filter['valuesSelected'][$key] = '0';
                            }
                            $filtro .= "(" . $this->form->getDataBaseName() . "." . $this->form->getTable() . "." . $value . " = '" . $this->filter['valuesSelected'][$key] . "')";
                            break;

                        case "input":
                            // Es de tipo input. Utiliza LIKE en lugar de =
                            $filtro .= "(" . $this->form->getDataBaseName() . "." . $this->form->getTable() . "." . $value . " LIKE '" . $this->filter['valuesSelected'][$key] . "')";
                            break;

                        case "range":
                            // Es un rango
                            $fecha = new Fecha($this->filter['valuesSelected'][$key]);
                            $filtro .= "(" . $this->form->getDataBaseName() . "." . $this->form->getTable() . "." . $value . " " . $operador . " '" . $fecha->getaaaammdd() . "')";
                            unset($fecha);
                            break;

                        default:
                            // Columna del filtro estándar
                            $filtro .= "(" . $this->form->getDataBaseName() . "." . $this->form->getTable() . "." . $value . " LIKE '" . $this->filter['valuesSelected'][$key] . "')";
                    }
                }
            } else {
                //El valor del filtro viene vacio pero puede ser check
                if ($this->filter['aditional'][$key]['type'] == "check") {
                    $this->filter['valuesSelected'][$key] = '0';
                    if ($filtro) {
                        $filtro .=" AND ";
                    }

                    $filtro .= "(" . $this->form->getDataBaseName() . "." . $this->form->getTable() . "." . $value . " = '" . $this->filter['valuesSelected'][$key] . "')";
                }
            }
        }


        if ($filtro == '')
            $filtro = '(1)';

        if ($aditionalFilter != '')
            $filtro .= " AND (" . $aditionalFilter . ")";

        $arrayQuery = array(
            "SELECT" => $this->form->getDataBaseName() . "." . $this->form->getTable() . ".*", // . $this->form->getPrimaryKey(),
            "FROM" => $tablas,
            "WHERE" => "({$filtro})",
            "ORDER BY" => $this->filter['orderBy'],
                //"ORDER BY" => $this->form->getDataBaseName() . "." . $this->form->getTable() . "." . $this->filter['orderBy'],
        );

        return $arrayQuery;
    }

    /**
     * Devuelve un array con los datos obtenidos en el listado
     *
     * Puede recibir un filtro adicional al propio obtenido por el
     * indicado en el config.yml del controller.
     *
     * Puede recibir una query elaborada, en cuyo caso se aplica esta y no
     * la que normalmente se construiría en base a los filtros
     *
     * @param string $aditionalFiltro Filtro adicional en formato SQL
     * @return array
     */
    public function getData($aditionalFilter = '') {

        if ($this->getQuery() == '') {
            $arrayQuery = $this->makeQuery($aditionalFilter);
            $this->setQuery("SELECT {$arrayQuery['SELECT']} FROM {$arrayQuery['FROM']} WHERE {$arrayQuery['WHERE']} ORDER BY {$arrayQuery['ORDER BY']}");
        }

        $em = new EntityManager($this->form->getConection());
        $em->query($this->getQuery());

        $this->filter['query'] = $this->getQuery();
        $this->filter['records'] = $em->numRows();
        $this->filter['pages'] = floor($this->filter['records'] / $this->filter['recordsPerPage']);
        if (($this->filter['records'] % $this->filter['recordsPerPage']) > 0)
            $this->filter['pages']++;
        $offset = ($this->filter['page'] - 1) * $this->filter['recordsPerPage'];

        $rows = $em->fetchResultLimit($this->filter['recordsPerPage'], $offset);
        $em->desConecta();
        unset($em);

        // CREO UN ARRAY DE OBJETOS PARA TENER DISPONIBLES
        // LOS DATOS DE LAS ENTIDADES REFERENCIADAS
        foreach ($rows as $row) {
            $objeto = new $this->entity();
            $objeto->bind($row);
            $this->data[] = $objeto;
        }
        unset($objeto);
        return $this->data;
    }

    /**
     * Devuelve un array con todos los componentes del listado:
     *
     *   'data' => array de objetos de datos obtenidos
     *   'filter' => array con los componentes del filtro
     *   'titles' => array con los titulos de las columnas
     *   'formatos' => array con los formatos de impresion
     *   'export_types' => array con los tipos de exportacion
     *
     * @param string $aditionalFilter Filtro adicional en formato SQL
     * @return array Los componentes del listado
     */
    public function getAll($aditionalFilter = '') {
        return array(
            'data' => $this->getData($aditionalFilter),
            'filter' => $this->getFilter(),
            'titles' => $this->getTitles(),
            'formatos' => $this->getFormatos(),
            'export_types' => $_SESSION['export_types'],
        );
    }

    /**
     * Genera un archivo pdf con el listado
     * @param array $parametros Array con los parámetros de configuración del listado
     * @param string $aditionalFilter
     * @return string $archivo El nombre completo (con la ruta) del archivo pdf generado
     */
    public function getPdf($parametros, $aditionalFilter = '') {

        set_time_limit(0);

        // Orientación de página, unidad de medida y tipo de papel
        $orientation = strtoupper(trim($parametros['orientation']));
        if (($orientation != 'P') and ($orientation != 'L'))
            $orientation = 'P';
        $unit = strtolower(trim($parametros['unit']));
        if (($unit != 'pt') and ($unit != 'mm') and ($unit != 'cm') and ($unit != 'in'))
            $unit = 'mm';
        $format = strtolower(trim($parametros['format']));
        if (($format != 'a4') and ($format != 'a3') and ($format != 'a5') and ($format != 'letter') and ($format != 'legal'))
            $format = 'A4';

        // Márgenes: top,right,bottom,left
        $margenes = explode(',', trim($parametros['margins']));
        if (count($margenes) != 4)
            $margenes = array('10', '10', '15', '10');

        // Tipo y tamaño de letra para el cuerpo del listado
        $bodyFont = explode(',', trim($parametros['body_font']));
        if (count($bodyFont) != 3)
            $bodyFont = array('Courier', '', '8');
        else {
            $bodyFont[0] = trim($bodyFont[0]);
            $bodyFont[1] = trim($bodyFont[1]);
            $bodyFont[2] = trim($bodyFont[2]);
        }

        // Altura de la línea. Por defecto 4 mm.
        $lineHeight = trim($parametros['line_height']);
        if ($lineHeight <= 0)
            $lineHeight = 4;

        // Construir la leyenda del filtro del listado
        $leyendaFiltro = array();
        if (is_array($this->filter['columnsSelected'])) {
            foreach ($this->filter['columnsSelected'] as $key => $column) {
                if ($this->filter['valuesSelected'][$key]) {
                    $objeto = new $this->entity();
                    $objeto->{"set$column"}($this->filter['valuesSelected'][$key]);
                    $valor = "";
                    $valor = trim($objeto->{"get$column"}());
                    if (!$valor)
                        $valor = $this->filter['valuesSelected'][$key];
                    $leyendaFiltro[] = array('Column' => $this->form->getTitleColumn($column), 'Value' => $valor);
                }
            }
        }
        //$leyendaFiltro[] = array('Column' => 'Orden', 'Value' => $parametros['order_by']);
        unset($objeto);

        // CREAR EL DOCUMENTO
        $pdf = new ListadoPDF(
                        $orientation,
                        $unit,
                        $format,
                        array(
                            'title' => $parametros['title'],
                            'titleFont' => $bodyFont,
                            'columns' => $parametros['columns'],
                            'leyendaFiltro' => $leyendaFiltro,
                        )
        );
        $pdf->SetTopMargin($margenes[0]);
        $pdf->SetRightMargin($margenes[1]);
        $pdf->SetLeftMargin($margenes[3]);
        $pdf->SetAuthor("Informatica ALBATRONIC, SL");
        $pdf->SetTitle($parametros['title']);
        $pdf->AliasNbPages();
        $pdf->SetFillColor(210);
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(1, $margenes[2]);

        // CUERPO
        $pdf->SetFont($bodyFont[0], $bodyFont[1], $bodyFont[2]);

        // Construyo el array con los datos a listar
        if ($this->getQuery() == '') {
            $arrayQuery = $this->makeQuery($aditionalFilter);
            $this->setQuery("
                SELECT {$arrayQuery['SELECT']}
                FROM {$arrayQuery['FROM']}
                WHERE {$arrayQuery['WHERE']}
                ORDER BY {$parametros['order_by']}");
        }

        $em = new EntityManager($this->form->getConection());
        $em->query($this->getQuery());
        $rows = $em->fetchResult();
        $nRegistros = $em->numRows();
        $em->desConecta();
        unset($em);

        $breakField = trim((string) $parametros['break_field']);
        if ($breakField)
            $breakField = explode(",", $breakField);
        else
            $breakField = array();

        $breakPage = ( strtoupper(trim((string) $parametros['break_page'])) == 'YES' );

        // ----------------------------------------------
        // Cargo la configuracion de la línea del listado
        $configLinea = array();
        $columnsMulticell = array();
        $caracteresLinea = 0;
        foreach ($parametros['columns'] as $key => $value) {
            $caracteres = (int) $value['length'];
            $anchoColumna = $pdf->getStringWidth(str_pad(" ", $caracteres)) + 1; //Le sumo 1 para que haya 1 mm de separación entre cada columna
            $caracteresLinea += $caracteres;
            $tipo = trim((string) $value['type']);
            $align = strtoupper(trim((string) $value['align']));
            if (($align != 'R') and ($align != 'C') and ($align != 'L') and ($align != 'J'))
                $align = "L";
            $formato = trim((string) $value['format']);
            $total = ( strtoupper(trim((string) $value['total'])) == 'YES' );

            $params = explode(",",trim($value['params']));
            $parametrosMetodo = "";
            foreach ($params as $valor)
                $parametrosMetodo .= "{$valor},";

            $parametrosMetodo = substr($parametrosMetodo, 0, -1);

            $configLinea[$value['field']] = array(
                'field' => $value['field'],
                'params' => $parametrosMetodo,
                'caracteres' => $caracteres,
                'ancho' => $anchoColumna,
                'align' => $align,
                'formato' => $formato,
                'type' => $tipo,
                'total' => $total,
            );
            if ($tipo == "text")
                $columnsMulticell[] = array('field' => $value['field'], 'width' => $anchoColumna);
        }
        // -----------------

        $valorAnterior = '';
        $subtotalRegistros = -1;

        // Itero el array con los datos para generar cada renglón del listado
        $totales = array();
        $subTotales = array();
        $objeto = new $this->entity();
        foreach ($rows as $row) {

            $subtotalRegistros++;

            $objeto->bind($row);

            // Control (si se ha definido) del campo de ruptura
            if (count($breakField)) {
                // Instancio el objeto por el que se hace el break
                $objetoBreak = $objeto->{"get$breakField[0]"}();
                $valorActual = $objetoBreak->__toString();
                if ($valorAnterior != $valorActual) {
                    if ($valorAnterior != '') {
                        $this->pintaTotales($pdf, $parametros['columns'], $subTotales);
                        $subTotales = array();

                        // Pinta el subtotal de registos
                        $pdf->Cell(0, 4, 'Subtotal Registos ' . $subtotalRegistros, 0, 1);
                        $subtotalRegistros = 0;
                        // Cambio de página si procede
                        if ($breakPage)
                            $pdf->AddPage();
                    }

                    $pdf->SetFont($bodyFont[0], 'B', $bodyFont[2]);
                    // Pinto el valor del campo de ruptura y los eventuales valores
                    // adicionales que se hayan indicado en el nodo yml <break_field>
                    $texto = $valorActual;
                    for ($i = 1; $i < count($breakField); $i++) {
                        $texto .= " " . $objetoBreak->{"get$breakField[$i]"}();
                    }
                    $pdf->Cell(0, 10, $texto);
                    $pdf->Ln();
                    $pdf->SetFont($bodyFont[0], $bodyFont[1], $bodyFont[2]);
                }
                $valorAnterior = $valorActual;
                unset($objetoBreak);
            }

            $pdf->CheckLinePageBreak($lineHeight, $row, $columnsMulticell);

            // Coordenadas X e Y del renglón
            $x0 = $pdf->GetX();
            $y0 = $pdf->GetY();
            // Para controlar los multicell
            $y1 = 0;

            // Recorro las columnas que componen cada renglón
            foreach ($configLinea as $value) {
                if ($value['params'])
                    $texto = trim($objeto->{"get$value[field]"}($value['params']));
                else
                    $texto = trim($objeto->{"get$value[field]"}());
                if ($value['formato'])
                    $texto = sprintf($value['formato'], $texto);

                if ($value['type'] == 'text') {
                    // Pinto un multicell sin recortar el texto
                    $x = $pdf->GetX() + $value['ancho'];
                    $pdf->MultiCell($value['ancho'], $lineHeight, $pdf->DecodificaTexto($texto), 0, $value['align']);
                    if ($pdf->GetY() > $y1)
                        $y1 = $pdf->GetY();
                    $pdf->SetXY($x, $y0);
                } else {
                    // Pinto una celda normal
                    $pdf->Cell($value['ancho'], $lineHeight, $pdf->DecodificaTexto($texto, $value['caracteres']), 0, 0, $value['align']);
                }

                // Calcular Eventuales totales y subtotales de cada columna
                if ($value['total']) {
                    $totales[(string) $value['field']] += (float) $texto;
                    $subTotales[(string) $value['field']] += (float) $texto;
                }
            }
            // Si ha habido algun multicell, cambio la coordenada Y
            if ($y1 != 0)
                $pdf->SetXY($margenes[3], $y1);
            else
                $pdf->Ln();

            // Si se ha definido interlinea, se imprime a todo lo ancho
            if ($parametros['print_interline'])
                $pdf->Cell(0, $lineHeight, str_repeat($parametros['print_interline'], $caracteresLinea + 5), 0, 1);
        }
        unset($objeto);

        // Pintar los subtotales y totales si hay
        if (count($totales)) {
            if ($breakField) {
                $this->pintaTotales($pdf, $parametros['columns'], $subTotales);
            }
            $pdf->Ln();
            $this->pintaTotales($pdf, $parametros['columns'], $totales);
        } elseif ($breakField) {
            // Pinta el subtotal de registos
            $subtotalRegistros++;
            $pdf->Cell(0, 4, 'Subtotal Registos ' . $subtotalRegistros, 0, 1);
        }

        // Total de registros impresos
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', '8');
        $pdf->Cell(0, 4, "Total Registros: " . $nRegistros);

        // Leyenda a pie de la última página
        if ($parametros['legend_text']) {
            $pdf->SetY(-25);
            $pdf->Write(4, $parametros['legend_text']);
        }

        $archivo = Archivo::getTemporalFileName();
        if ($archivo) $pdf->Output ($archivo, 'F');

        unset($objeto);
        unset($pdf);

        return $archivo;
    }

    /**
     * Genera un archivo XML con el listado
     * @param integer $idFormatoListado
     * @param string $aditionalFilter
     * @return string $archivo El nombre completo (con la ruta) del archivo xml generado
     */
    public function getXml($idFormatoListado, $aditionalFilter = '') {
        set_time_limit(0);

        // Lee la configuracion del listado $idFormatoListado y
        // la guarda en $parametros
        $formato = new Form($this->entity, 'listados.yml');
        $parametros = $formato->getFormatoListado($idFormatoListado);
        unset($formato);

        // Construyo el array con los datos a listar
        if ($this->getQuery() == '') {
            $arrayQuery = $this->makeQuery($aditionalFilter);
            $this->setQuery("
                SELECT {$arrayQuery['SELECT']}
                FROM {$arrayQuery['FROM']}
                WHERE {$arrayQuery['WHERE']}
                ORDER BY {$parametros['order_by']}");
        }

        $em = new EntityManager($this->form->getConection());
        $em->query($this->getQuery());
        $rows = $em->fetchResult();
        $nRegistros = $em->numRows();
        $em->desConecta();
        unset($em);

        $xmlString = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<root>\n";

        // Itero el array con los datos para generar cada renglón del listado
        $objeto = new $this->entity();
        foreach ($rows as $row) {
            $xmlString .= "  <{$this->entity}>\n";

            $objeto->bind($row);

            // Recorro las columnas que componen cada renglón
            foreach ($parametros['columns'] as $value) {

                $formato = trim((string) $value['format']);

                $texto = trim($objeto->{"get$value[field]"}());
                if ($formato)
                    $texto = sprintf($formato, $texto);

                $xmlString .= "    <{$value['field']}>{$texto}</{$value['field']}>\n";
            }
            $xmlString .= "  </{$this->entity}>\n";
        }
        $xmlString .= "</root>\n";
        unset($objeto);

        $archivo = "docs/docs" . $_SESSION['emp'] . "/xml/" . md5(date('d-m-Y H:i:s')) . ".xml";
        $fp = @fopen($archivo, "w");
        if ($fp) {
            fwrite($fp, $xmlString);
            fclose($fp);
        }

        return $archivo;
    }

    /**
     * Genera un archivo YAML con el listado
     * @param integer $idFormatoListado
     * @param string $aditionalFilter
     * @return string $archivo El nombre completo (con la ruta) del archivo xml generado
     */
    public function getYaml($idFormatoListado, $aditionalFilter = '') {
        set_time_limit(0);

        // Lee la configuracion del listado $idFormatoListado y
        // la guarda en $parametros
        $formato = new Form($this->entity, 'listados.yml');
        $parametros = $formato->getFormatoListado($idFormatoListado);
        unset($formato);

        // Construyo el array con los datos a listar
        if ($this->getQuery() == '') {
            $arrayQuery = $this->makeQuery($aditionalFilter);
            $this->setQuery("
                SELECT {$arrayQuery['SELECT']}
                FROM {$arrayQuery['FROM']}
                WHERE {$arrayQuery['WHERE']}
                ORDER BY {$parametros['order_by']}");
        }

        $em = new EntityManager($this->form->getConection());
        $em->query($this->getQuery());
        $rows = $em->fetchResult();
        $em->desConecta();
        unset($em);

        $arrayYml = array();

        // Itero el array con los datos para generar cada renglón del listado
        $objeto = new $this->entity();
        foreach ($rows as $row) {
            $item = array();

            $objeto->bind($row);

            // Recorro las columnas que componen cada renglón
            foreach ($parametros['columns'] as $value) {
                $formato = trim((string) $value['format']);
                $texto = trim($objeto->{"get$value[field]"}());
                if ($formato)
                    $texto = sprintf($formato, $texto);

                $item[$value['field']] = $texto;
            }
            $arrayYml[$this->entity][] = $item;
        }
        unset($objeto);

        $YamlString = Yaml::dump($arrayYml);

        $archivo = "docs/docs" . $_SESSION['emp'] . "/yml/" . md5(date('d-m-Y H:i:s')) . ".yml";
        $fp = @fopen($archivo, "w");
        if ($fp) {
            fwrite($fp, $YamlString);
            fclose($fp);
        }

        return $archivo;
    }

    /**
     * Genera un archivo TXT con el listado
     * @param integer $idFormatoListado
     * @param string $aditionalFilter
     * @return string $archivo El nombre completo (con la ruta) del archivo xml generado
     */
    public function getCvs($idFormatoListado, $aditionalFilter = '') {
        set_time_limit(0);

        // Lee la configuracion del listado $idFormatoListado y
        // la guarda en $parametros
        $formato = new Form($this->entity, 'listados.yml');
        $parametros = $formato->getFormatoListado($idFormatoListado);
        unset($formato);

        // Construyo el array con los datos a listar
        if ($this->getQuery() == '') {
            $arrayQuery = $this->makeQuery($aditionalFilter);
            $this->setQuery("
                SELECT {$arrayQuery['SELECT']}
                FROM {$arrayQuery['FROM']}
                WHERE {$arrayQuery['WHERE']}
                ORDER BY {$parametros['order_by']}");
        }

        $em = new EntityManager($this->form->getConection());
        $em->query($this->getQuery());
        $rows = $em->fetchResult();
        $nRegistros = $em->numRows();
        $em->desConecta();
        unset($em);

        // Primer Renglón con los títulos de las columnas
        $cvsString = "";
        foreach ($parametros['columns'] as $column)
            $cvsString .= '"' . $column['title'] . '",';
        // Quito la última coma
        $cvsString = substr($cvsString, 0, -1);
        $cvsString .= "\n";

        // Itero el array con los datos para generar cada renglón del listado
        $objeto = new $this->entity();
        foreach ($rows as $row) {

            $objeto->bind($row);

            // Recorro las columnas que componen cada renglón
            foreach ($parametros['columns'] as $value) {

                $formato = trim((string) $value['format']);

                $texto = trim($objeto->{"get$value[field]"}());
                if ($formato)
                    $texto = sprintf($formato, $texto);

                $cvsString .= '"' . $texto . '",';
            }
            // Quito la última coma
            $cvsString = substr($cvsString, 0, -1);
            $cvsString .= "\n";
        }
        unset($objeto);

        $archivo = "docs/docs" . $_SESSION['emp'] . "/cvs/" . md5(date('d-m-Y H:i:s')) . ".txt";
        $fp = @fopen($archivo, "w");
        if ($fp) {
            fwrite($fp, $cvsString);
            fclose($fp);
        }

        return $archivo;
    }

    /**
     * Genera un archivo XLSX con el listado
     * @param integer $idFormatoListado
     * @param string $aditionalFilter
     * @return string $archivo El nombre completo (con la ruta) del archivo xlsx generado
     */
    public function getXls($idFormatoListado, $aditionalFilter = '') {

        // CARGAR EL MOTOR PARA GENERAR ARCHIVOS EXCELS
        $config = sfYaml::load('config/config.yml');
        $config = $config['config'];
        if (file_exists($config['excel']))
            include_once $config['excel'];
        else
            die("NO SE PUEDE ENCONTRAR EL MOTOR EXCEL");

        set_time_limit(0);

        // Lee la configuracion del listado $idFormatoListado y
        // la guarda en $parametros
        $formato = new Form($this->entity, 'listados.yml');
        $parametros = $formato->getFormatoListado($idFormatoListado);
        unset($formato);

        // CREAR EL DOCUMENTO
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("ERP Albatronic")->setTitle($parametros['title']);
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->setTitle($parametros['title']);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', $parametros['title'])
                ->setCellValue('A3', 'Generado por ' . $_SESSION['USER']['user']['Nombre'])
                ->setCellValue('A4', 'Fecha ' . date('d/m/Y H:i:s'));
        // Fila de titulos
        $columna = 'A';
        foreach ($parametros['columns'] as $column) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columna . '6', $column['title']);
            $columna++;
        }

        // Construyo el array con los datos a listar
        if ($this->getQuery() == '') {
            $arrayQuery = $this->makeQuery($aditionalFilter);
            $this->setQuery("
                SELECT {$arrayQuery['SELECT']}
                FROM {$arrayQuery['FROM']}
                WHERE {$arrayQuery['WHERE']}
                ORDER BY {$parametros['order_by']}");
        }

        $em = new EntityManager($this->form->getConection());
        $em->query($this->getQuery());
        $rows = $em->fetchResult();
        $nRegistros = $em->numRows();
        $em->desConecta();
        unset($em);

        $breakField = trim((string) $parametros['break_field']);
        if ($breakField)
            $breakField = explode(",", $breakField);
        else
            $breakField = array();

        $valorAnterior = '';


        // Itero el array con los datos para generar cada renglón del listado
        $totales = array();
        $subTotales = array();
        $fila = 7;
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
        $objeto = new $this->entity();
        foreach ($rows as $row) {
            $columna = 'A';

            $objeto->bind($row);

            // Control (si se ha definido) del campo de ruptura
            if (count($breakField)) {
                // Instancio el objeto por el que se hace el break
                $objetoBreak = $objeto->{"get$breakField[0]"}();
                $valorActual = $objetoBreak->__toString();
                if ($valorAnterior != $valorActual) {
                    if ($valorAnterior != '') {
                        $this->pintaTotalesExcel($objPHPExcel, $fila, $parametros['columns'], $subTotales);
                        $fila++;
                        $columna = 'A';
                        $subTotales = array();
                    }

                    // Pinto el valor del campo de ruptura y los eventuales valores
                    // adicionales que se hayan indicado en el nodo xml <break_field>
                    $texto = $valorActual;
                    for ($i = 1; $i < count($breakField); $i++) {
                        $texto .= " " . $objetoBreak->{"get$breakField[$i]"}();
                    }
                    $fila++;
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columna . $fila, $texto);
                }
                $valorAnterior = $valorActual;
                unset($objetoBreak);
            }

            // Recorro las columnas que componen cada renglón
            $fila++;
            foreach ($parametros['columns'] as $value) {

                $formato = trim((string) $value['format']);

                $texto = trim($objeto->{"get$value[field]"}());
                if ($formato)
                    $texto = sprintf($formato, $texto);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columna . $fila, $texto);

                // Calcular Eventuales totales y subtotales de cada columna
                if (strtoupper($value['total']) == 'YES') {
                    $totales[(string) $value['field']] += (float) $texto;
                    $subTotales[(string) $value['field']] += (float) $texto;
                }

                $columna++;
            }
        }
        unset($objeto);

        // Pintar los subtotales y totales si hay
        if (count($totales)) {
            if ($breakField)
                $this->pintaTotalesExcel($objPHPExcel, $fila, $parametros['columns'], $subTotales);
            $fila++;
            $this->pintaTotalesExcel($objPHPExcel, $fila, $parametros['columns'], $totales);
        }

        $objPHPExcel->getActiveSheet()->setTitle($parametros['title']);
        $objPHPExcel->setActiveSheetIndex(0);
        $archivo = "docs/docs" . $_SESSION['emp'] . "/xls/" . md5(date('d-m-Y H:i:s')) . ".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($archivo);

        unset($objPHPExcel);

        return $archivo;
    }

    /**
     * Imprime en el documento pdf los totales o subtotales
     * en base a los valores pasados en el array $totales y para
     * aquellas columnas que lo requieran
     * @param FPDF $pdf         Documento PDF
     * @param array $columns    Parametros de cada columna del listado
     * @param array $totales    Array que contiene los valores totalizados de las columnas
     */
    protected function pintaTotales($pdf, $columns, $totales) {

        if (count($totales)) {
            $pdf->SetFont($bodyFont[0], 'B', $bodyFont[2]);

            foreach ($columns as $value) {
                $caracteres = (int) $value['length'];
                $ancho = $pdf->getStringWidth(str_pad(" ", $caracteres)) + 1; //Le sumo 1 para que haya 1 mm de separación entre cada columna
                $tipo = trim((string) $value['type']);
                $align = strtoupper(trim((string) $value['align']));
                if (($align != 'R') and ($align != 'C') and ($align != 'L'))
                    $align = "L";
                $formato = trim((string) $value['format']);

                $texto = trim($totales[(string) $value['field']]);
                if ($formato)
                    $texto = sprintf($formato, $texto);

                $pdf->Cell($ancho, 4, $pdf->DecodificaTexto($texto, $caracteres), 0, 0, $align);
            }
            $pdf->SetFont($bodyFont[0], $bodyFont[1], $bodyFont[2]);
            $pdf->Ln();
        }
    }

    protected function pintaTotalesExcel($objPHPExcel, $fila, $columns, $totales) {
        $columna = 'A';
        $fila++;
        foreach ($columns as $value) {
            $formato = trim((string) $value['format']);

            $texto = trim($totales[(string) $value['field']]);
            if ($formato)
                $texto = sprintf($formato, $texto);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columna . $fila, $texto);
            $columna++;
        }
    }

}

// FIN CLASE listado


class listadoPDF extends FPDF {

    //Cabecera de página
    function Header() {
        /**
        $empresa = new Empresas($_SESSION['emp']);
        $sucursal = new Sucursales($_SESSION['suc']);

        $this->Image($empresa->getLogo(), 10, 8, 23);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 5, $empresa->getRazonSocial(), 0, 1, "R");
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 5, $sucursal->getNombre(), 0, 1, "R");
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 5, $this->opciones['title'], 0, 1, "C");
         */

        // Pintar la leyenda del filtro en la primera pagina
        if ($this->page == 1) {
            $this->Ln(5);
            $this->SetFont('Arial', '', '8');
            foreach ($this->opciones['leyendaFiltro'] as $filtro) {
                $this->Cell(25, 4, $filtro['Column'], 0, 0);
                $this->Cell(0, 4, $filtro['Value'], 0, 1);
            }
        }

        // Para los títulos pongo el mismo font que para el cuerpo del listado
        $this->Ln(5);
        $this->SetFont($this->opciones['titleFont'][0], $this->opciones['titleFont'][1], $this->opciones['titleFont'][2]);
        //PINTAR LOS TITULOS DE LAS COLUMNAS
        foreach ($this->opciones['columns'] as $value) {
            $caracteres = (integer) $value['length'];
            $texto = trim((string) $value['title']);
            $ancho = $this->getStringWidth(str_pad(" ", $caracteres)) + 1;
            $this->Cell($ancho, 4, $this->DecodificaTexto($texto, $caracteres), 0, 0, "C", 1);
        }
        $this->Ln();
        //$this->Line($this->GetX(), $this->GetY(), $this->GetX() + 190, $this->GetY());
    }

}

?>
