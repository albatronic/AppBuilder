<?php

/**
 * Description of Reports
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @since 06-jun-2012
 *
 */
class Reports extends Controller {

    protected $entity = "Reports";
    protected $parentEntity = "";
    protected $request;
    protected $form;
    protected $listado;
    protected $permisos;
    protected $values;
    protected $reports;
    protected $query;
    protected $filter;
    protected $idReport;
    protected $breakFields = array();
    protected $totales = array(); //Array multidimensional para los subtotales y totales

    public function __construct($request) {

        // Cargar lo que viene en el request
        $this->request = $request;

        // Cargar la configuracion del modulo (modules/moduloName/config.yaml)
        $this->form = new Form($this->entity);

        // Cargar los permisos.
        // Si la entidad no está sujeta a control de permisos, se habilitan todos
        if ($this->form->getPermissionControl()) {
            if ($this->parentEntity == '')
                $this->permisos = new ControlAcceso($this->entity);
            else
                $this->permisos = new ControlAcceso($this->parentEntity);
        } else
            $this->permisos = new ControlAcceso();

        $this->values['titulo'] = $this->form->getTitle();
        $this->values['ayuda'] = $this->form->getHelpFile();
        $this->values['permisos'] = $this->permisos->getPermisos();
        $this->values['request'] = $this->request;

        $file = $_SERVER['DOCUMENT_ROOT'] . $_SESSION['appPath'] . "/docs/docs{$_SESSION['emp']}/reports/reports.yml";
        $existe = file_exists($file);
        if (!$existe) {
            $file = $_SERVER['DOCUMENT_ROOT'] . $_SESSION['appPath'] . "/docs/reports/reports.yml";
            $existe = file_exists($file);
        }

        if ($existe) {
            $this->reports = sfYaml::load($file);
            $this->reports = $this->getFormatsReports();
            $this->values['reports'] = $this->reports;
        }

        // QUITAR LOS COMENTARIOS PARA Actualizar los favoritos para el usuario
        //if ($this->form->getFavouriteControl())
        //    $this->actualizaFavoritos();
    }

    public function IndexAction() {
        return array('template' => $this->entity . '/index.html.twig', 'values' => $this->values);
    }

    /**
     * Devuelve la configuracion del informe seleccionado
     * @param integer $idReport El id del informe seleccionado
     * @return <type>
     */
    public function SelectAction($idReport = '') {

        if ($this->idReport == '')
            $this->idReport = $this->request[2];

        // Construir los Filtros
        $filtros = $this->getFilters($this->idReport);
        foreach ($filtros as $key => $value) {
            if (($value['entity'] != '') and ($value['type'] == 'select')) {
                $claseConId = explode(',', $value['entity']);
                $objeto = new $claseConId[0]($claseConId[1]);
                $filtros[$key]['values'] = $objeto->{$value['method']}($value['params']);
            }
        }

        $this->values['report'] = array(
            'idReport' => $this->idReport,
            'title' => $this->getTitle($this->idReport),
            'comment' => $this->getComment($this->idReport),
            'filters' => $filtros,
        );

        return $this->IndexAction();
    }

    public function makeReportAction() {

        if ($this->values['permisos']['L']) {

            $this->idReport = $this->request['idReport'];
            $this->breakFields = explode(",", trim($this->reports[$this->idReport]['break_fields']));

            $this->query = $this->reports[$this->idReport]['query'];
            $formato = $this->reports[$this->idReport];

            // Reemplazar en el query los valores del filtro
            $this->filter = $this->request['filter'];
            foreach ($this->filter['columnsSelected'] as $key => $value) {
                $valor = $this->filter['valuesSelected'][$key];
                if ($formato['filters'][$key]['type'] == 'date') {
                    $fecha = new Fecha($valor);
                    $valor = $fecha->getaaaammdd();
                    unset($fecha);
                }
                $this->query = str_replace($value, $valor, $this->query);
            }

            $this->values['archivo'] = $this->getPdf($formato);
            $template = '_global/listadoPdf.html.twig';
        } else {
            $template = "_global/forbiden.html.twig";
        }

        return array('template' => $template, 'values' => $this->values);
    }

    /**
     * Devuelve un array con los parámetros de configuración de TODOS los informes
     * a los que TIENE ACCESO el id de perfil del usuario en curso
     *
     * @return array
     */
    private function getFormatsReports() {
        $formatos = array();

        if (is_array($this->reports['reports'])) {
            $perfilUsuario = $_SESSION['USER']['user']['IDPerfil'];
            foreach ($this->reports['reports'] as $value) {
                $perfiles = (string) $value['idPerfil'];
                $arrayPerfiles = explode(',', $perfiles);
                if (($perfiles == '') or (in_array($perfilUsuario, $arrayPerfiles)))
                    $formatos[] = $value;
            }
        }

        return $formatos;
    }

    public function getTitle($idReport) {
        return $this->reports[$idReport]['title'];
    }

    public function getComment($idReport) {
        return $this->reports[$idReport]['comment'];
    }

    public function getFilters($idReport) {
        $filters = array();

        if (is_array($this->reports[$idReport]['filters'])) {
            foreach ($this->reports[$idReport]['filters'] as $index => $filter) {
                $type = strtolower(trim((string) $filter['type']));
                if (!$type)
                    $type = "input";
                if (($type != 'input') and ($type != 'select') and ($type != 'check') and ($type != 'date'))
                    $type = 'input';
                $event = trim((string) $filter['event']);
                $default = trim((string) $filter['default']);
                $operator = trim((string) $filter['operator']);
                if ($operator == '')
                    $operator = '=';

                $filters[$index]['field'] = trim((string) $filter['field']);
                $filters[$index]['caption'] = trim((string) $filter['caption']);
                $filters[$index]['entity'] = trim((string) $filter['entity']);
                $filters[$index]['method'] = trim((string) $filter['method']);
                $filters[$index]['params'] = trim((string) $filter['params']);
                $filters[$index]['type'] = $type;
                $filters[$index]['event'] = $event;
                $filters[$index]['default'] = $default;
                $filters[$index]['operator'] = $operator;
            }
        }

        return $filters;
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

        // Construir la leyenda del filtro
        $leyendaFiltro = array();

        if (is_array($this->filter['columnsSelected'])) {
            foreach ($this->filter['columnsSelected'] as $key => $column) {
                if ($this->filter['valuesSelected'][$key] != '') {
                    $entidad = $this->reports[$this->idReport]['filters'][$key]['entity'];
                    if ($entidad) {
                        $aux = explode(",", $entidad);
                        $entidad = $aux[0];
                        $idEntidad = $this->filter['valuesSelected'][$key];
                        $objeto = new $entidad($idEntidad);
                        $valor = $objeto->__toString();
                    } else
                        $valor = $this->filter['valuesSelected'][$key];

                    $leyendaFiltro[] = array('Column' => $parametros['filters'][$key]['caption'], 'Value' => $valor);
                }
            }
        }

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
        $pdf->SetAutoPageBreak(true, $margenes[2]);

        // CUERPO
        $pdf->SetFont($bodyFont[0], $bodyFont[1], $bodyFont[2]);

        $em = new EntityManager($this->form->getConection());
        $em->query($this->query);
        $rows = $em->fetchResult();
        $nRegistros = $em->numRows();
        $em->desConecta();
        unset($em);

        $breakPage = ( strtoupper(trim((string) $parametros['break_page'])) == 'YES' );

        // ----------------------------------------------
        // Cargo la configuración de la línea del listado
        // En el array $columnasMulticell guardo el nombre de los
        // campos que se imprimirán en Multicell y su anchura en la unidad de medida
        // establecida para calcular la altura máxima y controlar el salto de página
        // ----------------------------------------------
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

            $configLinea[$value['field']] = array(
                'field' => $value['field'],
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

        $valorAnterior = array();
        $subtotalRegistros = -1;

        // Itero el array con los datos para generar cada renglón del listado
        $totales = array();
        $subTotales = array();
        foreach ($rows as $row) {

            $subtotalRegistros++;

            // Control (si se ha definido) del(los) campo(s) de ruptura
            if (count($this->breakFields)) {
                // Recorro en orden inverso el array de campos de ruptura para
                // comprobar si ha cambiado el valor actual respecto al anterior.
                for ($i = 0; $i < count($this->breakFields); $i++) {
                    //for ($i = count($breakField)-1; $i >= 0 ; $i--) {
                    $columnaRuptura = $this->breakFields[$i];
                    $valorActual[$columnaRuptura] = $row[$columnaRuptura];
                    if ($valorAnterior[$columnaRuptura] != $valorActual[$columnaRuptura]) {
                        if ($valorAnterior[$columnaRuptura] != '') {
                            $this->pintaTotales($pdf, $parametros['columns'], $subTotales);
                            $subTotales = array();
                            // Pinta el subtotal de registos
                            if ($parametros['print_total_records']) {
                                $pdf->Cell(0, 4, 'Subtotal Registos ' . $subtotalRegistros, 0, 1);
                                $subtotalRegistros = 0;
                            }
                            // Cambio de página si procede
                            if ($breakPage)
                                $pdf->AddPage();
                        }
                        // Pinto el valor del campo de ruptura
                        $pdf->SetFont($bodyFont[0], 'B', $bodyFont[2]);
                        $pdf->Cell(0, 10, $valorActual[$columnaRuptura]);
                        $pdf->Ln();
                        $pdf->SetFont($bodyFont[0], $bodyFont[1], $bodyFont[2]);
                    }
                    $valorAnterior[$columnaRuptura] = $valorActual[$columnaRuptura];
                }
            }

            $pdf->CheckLinePageBreak($lineHeight, $row, $columnsMulticell);

            // Coordenadas X e Y del renglón
            $x0 = $pdf->GetX();
            $y0 = $pdf->GetY();
            // Para controlar el desplazamiento vertical de los multicell
            $y1 = 0;

            // Recorro las columnas que componen cada renglón
            foreach ($configLinea as $value) {

                $texto = trim($row[$value['field']]);
                if ($value['formato']) {
                    if ($value['type'] == 'money')
                        $texto = money_format($value['formato'], $texto);
                    else
                        $texto = sprintf($value['formato'], $texto);
                }

                if ($value['type'] == 'text') {
                    // Pinto un multicell sin recortar el texto
                    $x = $pdf->GetX() + $value['ancho'];
                    $pdf->MultiCell($value['ancho'], $lineHeight, $texto, 0, $value['align']);
                    if ($pdf->GetY() > $y1)
                        $y1 = $pdf->GetY();
                    $pdf->SetXY($x, $y0);
                } else {
                    // Pinto una celda normal
                    $pdf->Cell($value['ancho'], $lineHeight, $pdf->DecodificaTexto($texto, $value['caracteres']), 0, 0, $value['align']);
                }

                // Calcular Eventuales totales y subtotales de cada columna
                if ($value['total']) {
                    $totales[(string) $value['field']] += (float) trim($row[$value['field']]);
                    $subTotales[(string) $value['field']] += (float) trim($row[$value['field']]);
                }
            }
            // Si ha habido algun multicell, cambio la coordenada Y
            // al desplazamiento vertical mayor producido ($y1)
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
            if (count($this->breakFields)) {
                $this->pintaTotales($pdf, $parametros['columns'], $subTotales);
            }
            $pdf->Ln();
            $this->pintaTotales($pdf, $parametros['columns'], $totales);
        } elseif (count($this->breakFields)) {
            // Pinta el subtotal de registos
            $pdf->Cell(0, 4, 'Subtotal Registos ' . $subtotalRegistros, 0, 1);
        }

        if ($parametros['print_total_records']) {
            if (count($this->breakFields)) {
                // Pinta el subtotal de registos
                $subtotalRegistros++;
                $pdf->Cell(0, 4, 'Subtotal Registos ' . $subtotalRegistros, 0, 1);
            }

            // Total de registros impresos
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', '8');
            $pdf->Cell(0, 4, "Total Registros: " . $nRegistros);
        }

        // Pintar el gráfico
        if (is_array($parametros['grafico']))
            $this->pintaGrafico($pdf, $query, $parametros);

        // Leyenda a pie de la última página
        if ($parametros['comment']) {
            $pdf->SetY(-25);
            $pdf->Write(4, $parametros['comment']);
        }

        $fichero = Archivo::getTemporalFileName();
        if ($fichero)
            $pdf->Output($fichero, 'F');

        unset($objeto);
        unset($pdf);

        return $fichero;
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
                if ($formato) {
                    if ($tipo == 'money')
                        $texto = money_format($formato, $texto);
                    else
                        $texto = sprintf($formato, $texto);
                }

                $pdf->Cell($ancho, 4, $pdf->DecodificaTexto($texto, $caracteres), 0, 0, $align);
            }
            $pdf->SetFont($bodyFont[0], $bodyFont[1], $bodyFont[2]);
            $pdf->Ln();
        }
    }

    private function pintaGrafico($pdf, $query, $parametros) {
        $paramsGrafico = array(
            'ancho' => $parametros['grafico']['ancho'],
            'alto' => $parametros['grafico']['alto'],
            'titulo' => $parametros['title'],
            'tituloX' => $parametros['grafico']['tituloX'],
            'tituloY' => $parametros['grafico']['tituloY'],
            'columnaX' => $parametros['grafico']['columnaX'],
            'columnaY' => $parametros['grafico']['columnaY'],
            'query' => $this->query,
        );

        $grafico = new Grafico($paramsGrafico);
        $imagen = $grafico->getGrafico();
        $pdf->Image($imagen, 10, $pdf->GetY() + 5);
    }

}

class ListadoPDF extends FPDF {

    //Cabecera de página
    function Header() {
        $empresa = new Empresas($_SESSION['emp']);
        $sucursal = new Sucursales($_SESSION['suc']);

        $this->Image($empresa->getLogo(), 10, 8, 23);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 5, $empresa->getRazonSocial(), 0, 1, "R");
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 5, $sucursal->getNombre(), 0, 1, "R");
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 5, $this->opciones['title'], 0, 1, "C");

        // Pintar la leyenda del filtro en la primera página
        if ($this->page == 1) {
            $this->Ln(5);
            $this->SetFont('Arial', '', '8');
            $this->Line($this->GetX(), $this->GetY(), $this->getPrintablePageWidth(), $this->GetY());
            foreach ($this->opciones['leyendaFiltro'] as $filtro) {
                $this->Cell(20, 4, $filtro['Column'], 0, 0);
                $this->Cell(0, 4, $filtro['Value'], 0, 1);
            }
            $this->Line($this->GetX(), $this->GetY(), $this->getPrintablePageWidth(), $this->GetY());           
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

if (!function_exists('money_format')) {

    function money_format($format, $number) {
        $regex = array('/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?(?:#([0-9]+))?',
            '(?:\.([0-9]+))?([in%])/'
        );
        $regex = implode('', $regex);
        if (setlocale(LC_MONETARY, null) == '') {
            setlocale(LC_MONETARY, '');
        }
        $locale = localeconv();
        $number = floatval($number);
        if (!preg_match($regex, $format, $fmatch)) {
            trigger_error("No format specified or invalid format", E_USER_WARNING);
            return $number;
        }
        $flags = array('fillchar' => preg_match('/\=(.)/', $fmatch[1], $match) ? $match[1] : ' ',
            'nogroup' => preg_match('/\^/', $fmatch[1]) > 0,
            'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ? $match[0] : '+',
            'nosimbol' => preg_match('/\!/', $fmatch[1]) > 0,
            'isleft' => preg_match('/\-/', $fmatch[1]) > 0
        );
        $width = trim($fmatch[2]) ? (int) $fmatch[2] : 0;
        $left = trim($fmatch[3]) ? (int) $fmatch[3] : 0;
        $right = trim($fmatch[4]) ? (int) $fmatch[4] : $locale['int_frac_digits'];
        $conversion = $fmatch[5];
        $positive = true;
        if ($number < 0) {
            $positive = false;
            $number *= - 1;
        }
        $letter = $positive ? 'p' : 'n';
        $prefix = $suffix = $cprefix = $csuffix = $signal = '';
        if (!$positive) {
            $signal = $locale['negative_sign'];
            switch (true) {
                case $locale['n_sign_posn'] == 0 || $flags['usesignal'] == '(':
                    $prefix = '(';
                    $suffix = ')';
                    break;
                case $locale['n_sign_posn'] == 1:
                    $prefix = $signal;
                    break;
                case $locale['n_sign_posn'] == 2:
                    $suffix = $signal;
                    break;
                case $locale['n_sign_posn'] == 3:
                    $cprefix = $signal;
                    break;
                case $locale['n_sign_posn'] == 4:
                    $csuffix = $signal;
                    break;
            }
        }
        if (!$flags['nosimbol']) {
            $currency = $cprefix;
            $currency .= ( $conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']);
            $currency .= $csuffix;
            $currency = iconv('ISO-8859-1', 'UTF-8', $currency);
        } else {
            $currency = '';
        }
        $space = $locale["{$letter}_sep_by_space"] ? ' ' : '';

        $number = number_format($number, $right, $locale['mon_decimal_point'], $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
        $number = explode($locale['mon_decimal_point'], $number);

        $n = strlen($prefix) + strlen($currency);
        if ($left > 0 && $left > $n) {
            if ($flags['isleft']) {
                $number[0] .= str_repeat($flags['fillchar'], $left - $n);
            } else {
                $number[0] = str_repeat($flags['fillchar'], $left - $n) . $number[0];
            }
        }
        $number = implode($locale['mon_decimal_point'], $number);
        if ($locale["{$letter}_cs_precedes"]) {
            $number = $prefix . $currency . $space . $number . $suffix;
        } else {
            $number = $prefix . $number . $space . $currency . $suffix;
        }
        if ($width > 0) {
            $number = str_pad($number, $width, $flags['fillchar'], $flags['isleft'] ? STR_PAD_RIGHT : STR_PAD_LEFT);
        }
        $format = str_replace($fmatch[0], $number, $format);
        return $format;
    }

//	function money_format()
}
?>
