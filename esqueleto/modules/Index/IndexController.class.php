<?php
/**
 * Description of IndexController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 28-may-2011
 *
 */

class IndexController extends controller {

    protected $entity="Index";
    protected $parentEntity = "";
 
    public function __construct($request)
    {
        $this->request = $request;
        $this->form = new form($this->entity);

        $this->values=array(
            'request' => $this->request,
            );
    }

    public function IndexAction()
    {
        $this->values = array();
        return array('template' => 'Index/index.html.twig', 'values' => $this->values);
    }

    /**
     * Acciones a realizar cuando se selecciona otra empresa
     * Se cambia el valor de la variable de session 'emp'
     * y se recargan las sucursales de la nueva empresa.
     * @return
     */
    public function EmpresaAction()
    {
        //Activo la empresa nueva
        $_SESSION['emp'] = $this->request['Empresa'];

        //Buscar las sucursales de la nueva empresa seleccionada
        $user = new Agentes($_SESSION['USER']['user']['id']);
        $_SESSION['USER']['sucursales'] = $user->getSucursales($_SESSION['emp']);

        //Activo la sucursal nueva
        $_SESSION['suc'] = $_SESSION['USER']['sucursales'][0]['Id'];

        return array('template' => 'Index/index.html.twig', 'values' => $this->values);
    }

    /**
     * Acciones a realizar cuando se selecciona otra sucursal
     * Se cambia el valor de la variable de session 'suc'
     * @return
     */
    public function SucursalAction()
    {
        $_SESSION['suc'] = $this->request['Sucursal'];
        return array('template' => 'Index/index.html.twig', 'values' => $this->values);
    }
}
?>
