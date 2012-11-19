<?php

/**
 * Description of ControllerWeb
 *
 * Controlador común a todos los módulos
 *
 * @author Administrador
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

        // Cargar la configuracion del modulo (modules/moduloName/config.yml)
        $this->form = new Form($this->entity);


        /**
         * CONTROL DE VISITAS
         *
         * 1. TABLA DE CONTROL DE SESION (sesion, entity, identity, fecha)
         * 2. SE BORRAN (SI NO SE HAN BORRADO ANTES, VAR SESISON DE BORRADO)
         *    LOS REGISTROS DE LA TABLA QUE SEAN ANTERIORES A HOY
         * 3. COMPRUEBO QUE ES UNICO EL TRIO SESION, ENTIDAD, ID.; SIN NO HAGO INSERT
         * 4. INCREMENTAR EL N. VISITAS EN URL AMIGABLES ( SI HE HECHO EL INSERT)
         *
         * 5. CONTROL DETALLE VISITA APOYANDONOS EN LA TABLA ITINERARIO VISITAS
         *
         *
         * PROCESOS PARA AUTOMATIZAR VIA CRON: BORRAR VISITAS NO HUMANAS, WS LOCALIZACION IPS, ETC
         * VOLCADOS DE LOGS
         */


        // LECTURA DE METATAGS

        /* MENÚ DESPLEGABLE */
         $this->values['menuDesplegable'][] = array(
            'seccion' => 'Enlaces',
            'subseccion' => array(
                'Sub pepito' => 'http://asdfasdf',
                'Sub pepito2' => 'http://asdfasdf',
                'Sub pepito3' => 'http://asdfasdf',
            )
           );
         
         $this->values['menuDesplegable'][] = array(
            'seccion' => 'Contenido3',
            'url' => 'http://adfadf', 
            ); 
          
          $this->values['menuDesplegable'][] = array(
            'seccion' => 'Contenido4',
            'subseccion' => array(
                'Sub pepito7' => 'http://asdfasdf',
                'Sub pepito8' => 'http://asdfasdf',
                'Sub pepito9' => 'http://asdfasdf',
                'Sub pepito10' => 'http://asdfasdf',
                'Sub pepito11' => 'http://asdfasdf',
            )
           );          
       
          
        /* RUTA // CONSTRUIR AQUÍ EL ARRAY DE LAS RUTAS */
         $this->values['ruta'] = array(
            'seccion1' => array (
                'nombre' => 'Inicio',
                'url' => 'app.path',
            ),
            'seccion2' => array (
                'nombre' => 'Contenido Actual',
                'url' => ''
            ),

           );          
          
         
        /* MENU CABECERA */
         $this->values['menuCabecera'][] = array (
            'nombre' => 'INICIO',
            'url' => '',
             'controller' => 'Index',
         );

         $this->values['menuCabecera'][] = array (
            'nombre' => 'Enlaces',
            'url' => 'enlaces',
             'controller' => 'Enlaces',
             
         );
         
         $this->values['menuCabecera'][] = array (
            'nombre' => 'NOTICIAS',
            'url' => 'Noticias',
             'controller' => 'Noticias',
             
         );
         
         $this->values['menuCabecera'][] = array (
            'nombre' => 'EVENTOS',
            'url' => 'Eventos',
             'controller' => 'Eventos',
             
         );
         
         $this->values['menuCabecera'][] = array (
            'nombre' => 'GALERIA',
            'url' => 'Galeria',
             'controller' => 'Galeria',
            
         ); 
         
         $this->values['menuCabecera'][] = array (
            'nombre' => 'VÍDEOS',
            'url' => 'Videos',
             'controller' => 'Videos',
             
         ); 
         
         $this->values['menuCabecera'][] = array (
            'nombre' => 'CONTACTO',
            'url' => 'Contacto',
             'controller' => 'Contacto',
             
         );          

         
        /* MENU PIE */
         $this->values['menuPie'][left][] = array (
            'nombre' => 'Inicio',
            'url' => '',
             'controller' => 'Index',
         );

         $this->values['menuPie'][left][] = array (
            'nombre' => 'Quiénes somos',
            'url' => 'somos',
             'controller' => 'Somos',
             
         );
         
         $this->values['menuPie'][left][] = array (
            'nombre' => 'Noticias',
            'url' => 'Noticias',
             'controller' => 'Noticias',
             
         );
         
         $this->values['menuPie'][left][] = array (
            'nombre' => 'Eventos',
            'url' => 'Eventos',
             'controller' => 'Eventos',
             
         );
         
         $this->values['menuPie'][right][] = array (
            'nombre' => 'Galería',
            'url' => 'Galeria',
             'controller' => 'Galeria',
            
         ); 
         
         $this->values['menuPie'][right][] = array (
            'nombre' => 'Vídeos',
            'url' => 'Videos',
             'controller' => 'Videos',
             
         ); 
         
         $this->values['menuPie'][right][] = array (
            'nombre' => 'Contacto',
            'url' => 'Contacto',
             'controller' => 'Contacto',
             
         );            
        
    }

    public function IndexAction() {

        return array(
            'template' => $this->entity . "/Index.html.twig",
            'values' => $this->values,
        );
    }

}

?>
