<?php

/**
 * Description of ControllerWeb
 *
 * Controlador común a todos los proyectos web
 *
 * @author Sergio Pérez
 * @copyright Ártico Estudio, SL
 * @version 1.0 1-dic-2012
 */
class ControllerWeb {

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

    /**
     * Array con las variables Web del modulo
     * @var array
     */
    protected $varWeb;

    public function __construct($request) {

        // Cargar lo que viene en el request
        $this->request = $request;

        // Cargar las variables web en la variable de sesion y en $this->varWeb
        // de esta forma solo se cargaran la primera vez
        if (!is_array($_SESSION['varWeb']['Pro']))
            $_SESSION['varWeb']['Pro'] = $this->getVariables('Pro');
        $this->varWeb['Pro'] = $_SESSION['varWeb']['Pro'];



        // Borrar la tabla temporal de visitas
        if (!$_SESSION['borradoTemporalVisitas']) {
            $temp = new VisitVisitasTemporal();
            $temp->borraTemporal();
            unset($temp);
        }

        // Control de visitas UNICAS a la url amigable
        $temp = new VisitVisitasTemporal();
        $temp->anotaVisitaUrlUnica($this->request['IdUrlAmigable']);
        unset($temp);

        // Anotar en el registro de visitas
        $visita = new VisitVisitas();
        $visita->anotaVisita($this->request);
        unset($visita);

        /**
         *
         * PROCESOS PARA AUTOMATIZAR VIA CRON: BORRAR VISITAS NO HUMANAS, WS LOCALIZACION IPS, ETC
         * VOLCADOS DE LOGS
         * 
         */
        // LECTURA DE METATAGS 
    }

    /**
     * Devuelve un array con dos elementos:
     * 
     *      * 'template' => el template a devolver
     *      * 'values' => array con los valores obtenidos
     * 
     * @return array Array template y values
     */
    public function IndexAction() {

        return array(
            'template' => $this->entity . "/index.html.twig",
            'values' => $this->values,
        );
    }

    /**
     * Devuelve el array con las variables web del proyecto o del módulo
     * 
     * @param string $ambito EL ámbito de las variables: Pro ó Mod
     * @return array Array de variables
     */
    protected function getVariables($ambito) {

        switch ($ambito) {
            case 'Pro':
                $filtro = "Variable='varPro_Web'";
                break;
            case 'Mod':
                $filtro = "Variable='varMod_{$this->request['Entity']}_Web'";
                break;
        }

        $variables = new CpanVariables();
        $rows = $variables->cargaCondicion('Yml', $filtro);
        unset($variables);

        $array = sfYaml::load($rows[0]['Yml']);

        if (is_array($array))
            return $array;
        else
            return array();
    }

    /**
     * Genera el array 'firma' de forma aletoria en base
     * la variable web del proyecto 'signatures'
     * 
     * @return array Array con la firma de la web
     */
    protected function getFirma() {

        $links = explode(",", $this->varWeb['Pro']['signatures']['links']);
        $link = $links[rand(0, count($links) - 1)];

        $locations = explode(",", $this->varWeb['Pro']['signatures']['locations']);
        $location = $locations[rand(0, count($locations) - 1)];

        $idioma = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        if (!is_array($this->varWeb['Pro']['signatures']['services'][$idioma]))
            $idioma = 'es';

        $services = explode(",", $this->varWeb['Pro']['signatures']['services'][$idioma]);
        $service = $services[rand(0, count($services) - 1)];

        return array(
            'url' => $link,
            'location' => $location,
            'service' => $service,
        );
    }

    /**
     * Genera el array 'ruta' con todas las entidades
     * padre del objeto en curso
     * 
     * @return array Array con la ruta en la que está el visitante web
     */
    protected function getRuta() {

        $array = array();

        $seccion = new GconSecciones($this->request['IdEntity']);
        $ruta = $seccion->getPadres();
        foreach ($ruta as $IdPadre) {
            $seccion = new GconSecciones($IdPadre);
            $array[] = array(
                'nombre' => $seccion->getTitulo(),
                'url' => $seccion->getHref(),
            );
        }
        unset($seccion);

        return $array;
    }

    /**
     * Genera el array 'calendario' del mes y año en curso
     * incluyendo las marcas en los días que haya eventos
     * 
     * @return array Array con los elementos del calendio
     */
    protected function getCalendario() {
        return array(
            'calendario' => Calendario::showCalendario('', '', true),
            'mesTexto' => Calendario::getMes(1),
            'mesNumero' => Calendario::getMes(0),
            'ano' => Calendario::getAno(),
        );
    }

    /**
     * Genera el array 'ustedEstaEn'
     * 
     * @return array Array con los elmentos de 'ustedEntaEn'
     */
    protected function getUstedEstaEn() {

        $objeto = new $this->request['Entity']($this->request['IdEntity']);
        $array = array(
            'titulo' => $objeto->getTitulo(),
            'subsecciones' => $objeto->getArraySubsecciones(),
        );
        unset($objeto);

        return $array;
    }

    /**
     * Genera el array del menu cabecera en base
     * a las secciones que tienen a TRUE MostrarEnMenu2
     * 
     * @param integer $nItems El numero de elementos a devolver. (0=todos)
     * @return array Array con las secciones
     */
    protected function getMenuCabecera($nItems = 0) {

        $array = array();

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $seccion = new GconSecciones();
        $filtro = "MostrarEnMenu2='1' AND Publish='1'";
        $rows = $seccion->cargaCondicion("Id", $filtro, "OrdenMenu2 ASC {$limite}");

        foreach ($rows as $row) {
            $seccion = new GconSecciones($row['Id']);
            $array[] = array(
                'nombre' => $seccion->getEtiquetaWeb2(),
                'url' => $seccion->getHref(),
                'controller' => $seccion->getObjetoUrlAmigable()->getController(),
            );
        }
        unset($seccion);

        return $array;
    }

    /**
     * Genera el array del menu desplegable en base
     * a las secciones que tienen a TRUE MostrarEnMenu1
     * 
     * @param integer $nItems El numero de elementos a devolver. (0=todos)
     * @return array Array con las secciones
     */
    protected function getMenuDesplegable($nItems = 0) {

        $array = array();

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $menu = new GconSecciones();
        $filtro = "MostrarEnMenu1='1' AND BelongsTo='0' AND Publish='1'";
        $rows = $menu->cargaCondicion("Id", $filtro, "OrdenMenu1 ASC {$limite}");
        unset($menu);

        foreach ($rows as $row) {
            $subseccion = new GconSecciones($row['Id']);
            $array[] = array(
                'seccion' => $subseccion->getEtiquetaWeb1(),
                'url' => $subseccion->getHref(),
                'subsecciones' => $subseccion->getArraySubsecciones(),
            );
        }
        unset($subseccion);

        return $array;
    }

    /**
     * Genera el array del menu del pie en base
     * a las secciones que tienen a TRUE MostrarEnMenu3
     * 
     * @param integer $nItems El numero de elementos a devolver. (0=todos)
     * @return array Array con las secciones
     */
    protected function getMenuPie($nItems = 0) {

        $array = array();

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $seccion = new GconSecciones();
        $filtro = "MostrarEnMenu3='1' AND Publish='1'";
        $rows = $seccion->cargaCondicion("Id", $filtro, "OrdenMenu3 ASC {$limite}");

        foreach ($rows as $row) {
            $seccion = new GconSecciones($row['Id']);
            $array[] = array(
                'nombre' => $seccion->getEtiquetaWeb3(),
                'url' => $seccion->getHref(),
                'controller' => $seccion->getObjetoUrlAmigable()->getController(),
            );
        }
        unset($seccion);

        return $array;
    }

    /**
     * Genera el array con las noticias
     * 
     * @param boolean $enPortada Si TRUE se devuleven solo las que están marcadas como portada, 
     * en caso contrario se devuelven todas las noticias
     * @param integer $nItems El numero de elementos a devolver. (0=todos)
     * @return array Array con las noticias
     */
    protected function getNoticias($enPortada = true, $nItems = 0) {

        $array = array();

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $noticia = new GconContenidos();
        $filtro = "NoticiaPubilicar='1' AND Publish='1'";
        if ($enPortada)
            $filtro .= " AND NoticiaMostrarEnPortada='1'";

        $rows = $noticia->cargaCondicion("Id", $filtro, "NoticiaOrden ASC {$limite}");

        foreach ($rows as $row) {
            $noticia = new GconContenidos($row['Id']);
            $array[] = array(
                'titulo' => $noticia->getTitulo(),
                'subtitulo' => $noticia->getSubtitulo(),
                'url' => $noticia->getObjetoUrlAmigable()->getHref(),
                'descripcion' => $noticia->getResumen(),
                'imagen' => $noticia->getDocuments('image1'),
            );
        }
        unset($noticia);

        return $array;
    }

    /**
     * Genera el array con las noticias más leidas
     * 
     * Las noticias se ordenan descendentemente por número de visitas
     * 
     * @param integer $nItems El numero de elementos a devolver. (0=todos)
     * @return array Array con las noticias
     */
    protected function getNoticiasMasLeidas($nItems = 0) {

        $array = array();
        
        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $noticia = new GconContenidos();
        $filtro = "NoticiaPubilicar='1' AND Publish='1'";

        $rows = $noticia->cargaCondicion("Id", $filtro, "NumberVisits DESC {$limite}");

        foreach ($rows as $row) {
            $noticia = new GconContenidos($row['Id']);
            $array[] = array(
                'fecha' => $noticia->getPublishedAt(),
                'titulo' => $noticia->getTitulo(),
                'subtitulo' => $noticia->getSubtitulo(),
                'url' => $noticia->getObjetoUrlAmigable()->getHref(),
                'descripcion' => $noticia->getResumen(),
                'imagen' => $noticia->getDocuments('image1'),
            );
        }
        unset($noticia);
        
        return $array;
    }

    /**
     * Devuelve un array con contenidos que son eventos.
     * 
     * Están ordenados DESCENDENTEMENTE por Fecha y Hora de inicio
     * 
     * @param integer $nItems El numero de elementos a devolver. (0=todos)
     * @return array Array con los eventos
     */
    protected function getEventos($nItems = 0) {

        $array = array();

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $evento = new EvenEventos();
        $filtro = "EsEvento='1' AND Publish='1'";

        $rows = $evento->cargaCondicion("Entidad,IdEntidad,Fecha,HoraInicio,HoraFin", $filtro, "Fecha DESC, HoraInicio DESC {$limite}");
        unset($evento);

        foreach ($rows as $row) {
            $evento = new $row['Entidad']($row['IdEntidad']);
            $array[] = array(
                'fecha' => $row['Fecha'],
                'horaInicio' => $row['HoraInicio'],
                'horaFin' => $row['HoraFin'],
                'titulo' => $evento->getTitulo(),
                'subtitulo' => $evento->getSubtitulo(),
                'url' => $evento->getObjetoUrlAmigable()->getHref(),
                'descripcion' => $evento->getResumen(),
                'imagen' => $evento->getDocuments('image1'),
            );
        }
        unset($evento);

        return $array;
    }

}

?>
