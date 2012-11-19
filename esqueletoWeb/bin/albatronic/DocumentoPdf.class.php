<?php

/**
 * Genera un documento en formato PDF en base a las
 * especificaciones indicadas en un archivo YAML y a los
 * datos recibidos en los arrays de objetos $master y $detail
 *
 * Extiende a la clase FPDF
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @since 29-oct-2011
 *
 */



class DocumentoPdf extends FPDF {

    /**
     * Objeto de la clase Empresas, instanciado con los
     * valores de la empresa en curso.
     * @var Empresa Objeto de la clase Empresas
     */
    protected $empresa;
    /**
     * Array con los comandos pdf a ejecutar
     * para generar el documento.
     * @var array Array de comandos pdf
     */
    protected $format;
    /**
     * Objeto Cabecera
     * Aquí se almacenará el objeto a utilizar para la cabecera y el
     * pie del documento
     * @var objeto
     */
    protected $master;
    /**
     * Aqui se almacenan los objetos que se imprimirán en el body del
     * documento, las líneas de detalle.
     * @var array Array de objetos
     */
    protected $arrayDetail;
    /**
     * Objeto de la clase línea de detalle que corresponda.
     * Por ej: lineas de albaranes, de pedidos, etc.
     * 
     * @var objeto Es un objeto de línea de detalle
     */
    protected $detail;

    /**
     * Devuelve un array con los formatos posibles del tipo de documento
     * 
     * @param string $tipoDocumento
     * @return array Array del tipo Id,Value con los formatos posibles del documento 
     */
    public function getFormatos($tipoDocumento) {

        $file = "docs/docs" . $_SESSION['emp'] . "/formats/" . $tipoDocumento . ".yml";
        if (!file_exists($file))
            $file = "docs/formats/" . $tipoDocumento . ".yml";
        if (file_exists($file)) {
            $yml = sfYaml::load($file);

            $perfilUsuario = $_SESSION['USER']['user']['IDPerfil'];
            $i = 0;
            foreach ($yml[$tipoDocumento] as $formato) {
                $perfiles = $formato['idPerfil'];
                $arrayPerfiles = explode(',', $perfiles);
                if (($perfiles == '') or (in_array($perfilUsuario, $arrayPerfiles)))
                    $formatos[] = array(
                        'Id' => $i++,
                        'Value' => $formato['title']
                    );
            }
        }

        return $formatos;
    }

    /**
     * Devuelve un array con los comandos de configuracion del documento y formato
     * 
     * @param string $tipoDocumento El tipo de documento
     * @param integer $formato El numero de formato
     * @return array Array con los comandos de configuracion del formato
     */
    public function getConfigFormato($tipoDocumento, $formato=0) {

        $config = array();

        $file = "docs/docs" . $_SESSION['emp'] . "/formats/" . $tipoDocumento . ".yml";
        if (!file_exists($file))
            $file = "docs/formats/" . $tipoDocumento . ".yml";
        if (file_exists($file)) {
            $config = sfYaml::load($file);
            $config = $config[$tipoDocumento][$formato];
        } else
            echo "No existe el fichero de configuracion " . $file;

        // Valido que los valores indicados en el fichero de configuracion
        // sean correctos respecto a la orientación de página, unidad de medida
        // y tipo de papel; en caso contrario los pongo por defecto.
        $orientation = strtoupper(trim($config['orientation']));
        if (($orientation != 'P') and ($orientation != 'L'))
            $config['orientation'] = 'P';
        $unit = strtolower(trim($config['unit']));
        if (($unit != 'pt') and ($unit != 'mm') and ($unit != 'cm') and ($unit != 'in'))
            $config['unit'] = 'mm';
        $format = strtolower(trim($config['format']));
        if (($format != 'a4') and ($format != 'a3') and ($format != 'a5') and ($format != 'letter') and ($format != 'legal'))
            $config['format'] = 'A4';

        return $config;
    }

    /**
     * Generar un documento PDF utilizando el motor PDF indicado en config/config.yml
     * Lee los comandos del array $format y los ejecuta.
     * Los comandos estarán escritos con sintaxis php y de acuerdo al motor PDF elegido.
     *
     * Recibe un array de objetos $master donde está la información que normalmente se imprimirá
     * en la cabecera y pie del documento.
     *
     * Recibde un array de objetos que se imprimiran en el body del documento.
     *
     * @param array $format El array de comandos php y PDF (el template)
     * @param array $master Array de objetos master
     * @param array $arrayDetail Array de objetos detail
     * @param string $archivo El nombre del archivo a generar con la ruta completa
     */
    public function generaDocumento($format, $master, $arrayDetail, $archivo) {
        $this->empresa = new Empresas($_SESSION['emp']);
        $this->format = $format;

        // Márgenes: top,right,bottom,left
        $margenes = explode(',', trim($this->format['margins']));
        if (count($margenes) != 4)
            $margenes = array('10', '10', '15', '10');

        $this->SetTopMargin($margenes[0]);
        $this->SetRightMargin($margenes[1]);
        $this->SetLeftMargin($margenes[3]);
        $this->SetAuthor("Informatica ALBATRONIC, SL");
        $this->SetTitle($this->format['title']);
        $this->AliasNbPages();
        $this->SetFillColor(210);
        $this->SetAutoPageBreak(1, $this->format['page_break']);

        $primeraPagina = TRUE;

        foreach ($master as $key => $value) {
            if ($primeraPagina) {
                $this->master = $master[$key];
                $this->arrayDetail = $arrayDetail[$key];
                $this->AddPage();
                $primeraPagina = FALSE;
            } else {
                $this->AddPage();
                $this->master = $master[$key];
                $this->arrayDetail = $arrayDetail[$key];
            }

            // Body del documento
            $breakValue = '';
            $breakField = $this->format['break_field'];

            if ($this->arrayDetail) {
                foreach ($this->arrayDetail as $detail) {
                    $this->detail = $detail;

                    // Control de ruptura de listado dentro del body
                    if ($breakField) {
                        $objeto = $this->detail->{"get$breakField"}();
                        if (is_object($objeto))
                            $valor = $objeto->__toString();
                        else
                            $valor = $objeto;

                        if ($breakValue != $valor)
                            $this->imprime($this->format['break_print']);
                        $breakValue = $valor;
                    }

                    $this->imprime($this->format['body']);
                }
            }
        }

        $this->Output($archivo, 'F');      
    }

    /**
     * Recibe un array de comandos y los ejecuta
     * @param array $comandos
     */
    private function imprime($comandos) {
        if ($comandos)
            foreach ($comandos as $cmd)
                eval("$cmd;");
    }

    /**
     * Imprime los comandos de la cabecera
     */
    public function Header() {
        $this->imprime($this->format['header']);
    }

    /**
     * Imprime los comandos del pie
     */
    public function Footer() {
        $this->imprime($this->format['footer']);
    }

}

?>