<?php

//*************************************************
// CLASS ControlAcceso
// Author: Sergio Pérez Sánchez
// Company: Informática ALBATRONIC, SL
// Date: 17-10-2010
//-------------------------------------------------
// CONTROL DE ACCESO A LOS CONTROLADORES SEGUN EL
// PERFIL DE USUARIO Y CONTROLLER RECIBIDOS COMO PARAMETROS
// LA VALIDACION SE HACE CONTRA LA TABLA DE PERFILES DE USUARIOS.
//
// SI NO SE INDICA NINGUN CONTROLER SE PONEN TODOS LOS PERMISOS A TRUE
//
// DEVUELVE UN ARRAY ASOCIATIVO. EL INDICE INDICA EL
// TIPO DE PERMISO, EL VALOR '0' DENIEGA Y '1' CONCEDE ACCESO
//
// LOS VALORES DEL INDICE SON:
//
//	C	= Consulta
//	I	= Inserción
//	B	= Borrado
//	A	= Actualización
//	L	= Listado
//	E	= Exportar información a Excel, XML, etc.

class ControlAcceso {

    /**
     * El ID del usuario logeado
     * @var integer
     */
    private $idPerfil;
    /**
     * El nombre del Controller
     * @var string
     */
    private $controller;
    /**
     * Array asociativo con los tipos de permisos.
     * Inicializo los valores a 0 negándolos
     * @var array
     */
    private $permisos = array(
        'C' => '0', //Consulta
        'I' => '0', //Inserción
        'B' => '0', //Borrado
        'A' => '0', //Actualización
        'L' => '0', //Listado
        'E' => '0', //Exportar a excel, xml, etc.
    );

    public function __construct($controller='', $idPerfil='') {
        if ($idPerfil == '') {
            $this->idPerfil = $_SESSION['USER']['user']['IDPerfil'];
        } else {
            $this->idPerfil = $idPerfil;
        }

        $this->controller = $controller;

        // Si se ha indicado un controlador, se cargan sus permisos
        // en caso contrario se ponen todos los permisos a true
        if ($this->controller)
            $this->load();
        else
            $this->setPermisos(1);
    }

    private function load() {
        $em = new EntityManager('empresas');
        $query = "select t1.Permisos from permisos as t1, submenu as t2 where (t2.Script='" . $this->controller . "') and (t1.IDPerfil='" . $this->idPerfil . "') and (t1.IDSubopcion=t2.Id);";
        $em->query($query);
        $rows = $em->fetchResult();
        $em->desConecta();

        $row = $rows[0];
        $this->permisos = array(
            'C' => substr($row['Permisos'], 0, 1),
            'I' => substr($row['Permisos'], 1, 1),
            'B' => substr($row['Permisos'], 2, 1),
            'A' => substr($row['Permisos'], 3, 1),
            'L' => substr($row['Permisos'], 4, 1),
            'E' => substr($row['Permisos'], 5, 1),
        );
    }

    /**
     * Devuelve un array asociativo con los permisos
     * @return array
     */
    public function getPermisos() {
        return $this->permisos;
    }

    /**
     * Cambia todos los permisos a verdadero o falso
     * @param boolean $onOff
     */
    public function setPermisos($onOff) {
        $this->permisos['C'] = $onOff;
        $this->permisos['I'] = $onOff;
        $this->permisos['B'] = $onOff;
        $this->permisos['A'] = $onOff;
        $this->permisos['L'] = $onOff;
        $this->permisos['E'] = $onOff;
    }

}

?>