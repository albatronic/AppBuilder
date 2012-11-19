<?php

/**
 * Description of Grafico
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @since 20-may-2012
 *
 */



class Grafico {

    protected $ancho;
    protected $alto;
    protected $titulo;
    protected $tituloX;
    protected $tituloY;
    protected $columnaX;
    protected $columnaY;
    protected $titulosX;
    protected $query;

    public function __construct($params) {

        //----------------------------------------------------------------
        // ACTIVAR EL MOTOR DE GRAFICOS DE BARRAS
        //----------------------------------------------------------------
        $config = sfYaml::load('config/config.yml');
        if (is_array($config['config']['graph'])) {
            foreach ($config['config']['graph'] as $file) {
                if (file_exists($file))
                    include_once $file;
                else
                    die("NO SE PUEDE ENCONTRAR EL MOTOR DE GRAFICOS");
            }
        }

        $this->ancho = $params['ancho'];
        $this->alto = $params['alto'];
        $this->titulo = $params['titulo'];
        $this->tituloX = $params['tituloX'];
        $this->tituloY = $params['tituloY'];
        $this->columnaX = $params['columnaX'];
        $this->columnaY = $params['columnaY'];
        $this->query = $params['query'];
    }

    public function getGrafico() {

        $em = new EntityManager("datos" . $_SESSION['emp']);
        $em->query($this->query);
        $rows = $em->fetchResult();
        $nRegistros = $em->numRows();
        $em->desConecta();
        unset($em);

        foreach ($rows as $value) {
            $this->datosY[] = $value[$this->columnaY];
            $this->titulosX[] = $value[$this->columnaX];
        }

        $grafico = new Graph($this->ancho, $this->alto);
        $grafico->SetScale('textlin');

        // Ajustamos los margenes del grafico-----    (left,right,top,bottom)
        $grafico->SetMargin(40, 30, 30, 40);

        // Creamos barras de datos a partir del array de datos
        $bplot = new BarPlot($this->datosY);

        // Configuramos color de las barras
        $bplot->SetFillColor('#479CC9');

        //Añadimos barra de datos al grafico
        $grafico->Add($bplot);

        // Queremos mostrar el valor numerico de la barra
        $bplot->value->Show();

        // Configuracion de los titulos
        $grafico->title->Set($this->titulo);
        $grafico->xaxis->title->Set($this->tituloX);
        $grafico->yaxis->title->Set($this->tituloY);
        $grafico->title->SetFont(FF_FONT1, FS_BOLD);
        $grafico->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
        $grafico->xaxis->title->SetFont(FF_FONT1, FS_BOLD);
        $grafico->xaxis->SetTickLabels($this->titulosX);

        // Se generada el archivo con el gráfico
        $archivo = "docs/docs" . $_SESSION['emp'] . "/tmp/" . md5(date('d-m-Y H:i:s')) . ".png";
        $grafico->Stroke($archivo);

        return $archivo;
    }

}

?>
