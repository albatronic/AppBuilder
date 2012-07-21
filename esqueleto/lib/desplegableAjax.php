<?php

/**
 * GENERA DESPLEGABLES A PETICION DEL SCRIPT AJAX QUE LO LLAMA
 * Y DEVUELVE UN TEXTO PLANO CON EL CODIGO HTML
 *
 * LOS PARAMETROS POST QUE RECIBE SON:
 *
 * t          -> EL TIPO DE DESPLEGABLE, O SEA SOBRE QUE TABLA SE GENERARA EL DESPLEGABLE
 * idselect   -> EL ID QUE TENDRA EL DESPLEGABLE
 * nameselect -> EL NAME QUE TENDRA EL DESPLEGABLE
 * filtro     -> VALOR PARA LA CLAUSULA 'WHERE' DE LA SENTENCIA SQL
 *
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC
 * @since 27.05.2011
 */
session_start();

if (!file_exists('../config/config.yml')) {
    echo "NO EXISTE EL FICHERO DE CONFIGURACION";
    exit;
}

if (file_exists("../../../app/bin/yaml/lib/sfYaml.php")) {
    include "../../../app/bin/yaml/lib/sfYaml.php";
} else {
    echo "NO EXISTE LA CLASE PARA LEER ARCHIVOS YAML";
    exit;
}

// ---------------------------------------------------------------
// CARGO LOS PARAMETROS DE CONFIGURACION.
// ---------------------------------------------------------------
$config = sfYaml::load('../config/config.yml');
$app = $config['config']['app'];

// ---------------------------------------------------------------
// ACTIVAR EL AUTOLOADER DE CLASES Y FICHEROS A INCLUIR
// ---------------------------------------------------------------
define(APP_PATH, $_SERVER['DOCUMENT_ROOT'] . $app['path'] . "/");
include_once "../" . $app['framework'] . "Autoloader.class.php";
Autoloader::setCacheFilePath(APP_PATH . 'tmp/class_path_cache.txt');
Autoloader::excludeFolderNamesMatchingRegex('/^CVS|\..*$/');
Autoloader::setClassPaths(array(
    '../' . $app['framework'],
    '../entities/',
    '../lib/',
));
spl_autoload_register(array('Autoloader', 'loadClass'));


switch ($_GET['t']) {
    // Construye un tag html <select> con las series de contadores de una sucursal. Se usa en albaranes.
    case 'contadorAlbaranes':
        $tag = '<div class="Item" id="div_AlbaranesCab_IDContador">' . getContadoresSucursal($_GET['filtro'], 1, 'AlbaranesCab[IDContador]', 'AlbaranesCab_IDContador') . '</div>';
        break;

    // Construye un tag html <select> con las series de contadores de una sucursal. Se usa en presupuestos.
    case 'contadorPstos':
        $tag = '<div class="Item" id="div_PstoCab_IDContador">' . getContadoresSucursal($_GET['filtro'], 0, 'PstoCab[IDContador]', 'PstoCab_IDContador') . '</div>';
        break;

    // Construye un tag html <select> con las series de contadores de una sucursal. Se usa en traspasos entre almacenes.
    case 'contadorTraspasos':
        $tag = '<div class="Item" id="div_TraspasosCab_IDContador">' . getContadoresSucursal($_GET['filtro'], 3, 'TraspasosCab[IDContador]', 'TraspasosCab_IDContador') . '</div>';
        break;

    // Construye un tag html <select> con los comerciales de una sucursal. Se usa en albaranes.
    case 'comercialAlbaranes':
        $tag = '<div class="Item" id="div_AlbaranesCab_IDComercial">' . getComercialesSucursal($_GET['filtro'], 'AlbaranesCab[IDComercial]', 'AlbaranesCab_IDComercial') . '</div>';
        break;

    // Construye un tag html <select> con los comerciales de una sucursal. Se usa en presupuestos.
    case 'comercialPstos':
        $tag = '<div class="Item" id="div_PstoCab_IDComercial">' . getComercialesSucursal($_GET['filtro'], 'PstoCab[IDComercial]', 'PstoCab_IDComercial') . '</div>';
        break;

    // Construye en cascada 3 tag html <select> vinculados según la sucursal que se elija:
    // Clientes, direcciones de entrega y formas de pago
    case 'clientealbaran':
        //$tag  = '<div class="Item" id="div_AlbaranesCab_IDCliente">' . clientesSucursalAgente($_GET['filtro'],'', $_GET['nameselect'], $_GET['idselect']) . '</div>';
        $tag = '<div class="Item" id="div_AlbaranesCab_IDComercial">' . getComercial($_GET['filtro'], 'AlbaranesCab[IDComercial]', 'AlbaranesCab_IDComercial') . '</div>';
        $tag .= '<div class="Item" id="div_AlbaranesCab_IDDirec">' . dEntregaCliente($_GET['filtro'], 'AlbaranesCab[IDDirec]', 'AlbaranesCab_IDDirec') . '</div>';
        $tag .= '<div class="Item" id="div_AlbaranesCab_IDFP">' . formasPagoCliente($_GET['filtro'], 'AlbaranesCab[IDFP]', 'AlbaranesCab_IDFP') . '</div>';
        break;

    // Construye en cascada 3 tag html <select> vinculados según la sucursal que se elija:
    // Clientes, direcciones de entrega y formas de pago
    case 'clientepresupuesto':
        //$tag  = '<div class="Item" id="div_AlbaranesCab_IDCliente">' . clientesSucursalAgente($_GET['filtro'],'', $_GET['nameselect'], $_GET['idselect']) . '</div>';
        $tag = '<div class="Item" id="div_PstoCab_IDComercial">' . getComercial($_GET['filtro'], 'PstoCab[IDComercial]', 'PstoCab_IDComercial') . '</div>';
        $tag .= '<div class="Item" id="div_PstoCab_IDDirec">' . dEntregaCliente($_GET['filtro'], 'PstoCab[IDDirec]', 'PstoCab_IDDirec') . '</div>';
        $tag .= '<div class="Item" id="div_PstoCab_IDFP">' . formasPagoCliente($_GET['filtro'], 'PstoCab[IDFP]', 'PstoCab_IDFP') . '</div>';
        break;

    // Construye en cascada el tag de direcciones de entrega, las formas de pago y el comercial
    // asociado a cliente
    case 'comercialcliente':
        $tag = getComercial($_GET['filtro']);
        $tag .= '<div class="Item" id="div_AlbaranesCab_IDDirec">' . dEntregaCliente($_GET['filtro'], 'AlbaranesCab[IDDirec]', 'AlbaranesCab_IDDirec') . '</div>';
        $tag .= '<div class="Item" id="div_AlbaranesCab_IDFP">' . formasPagoCliente($_GET['filtro'], 'AlbaranesCab[IDDirec]', 'AlbaranesCab_IDDirec') . '</div>';
        break;

    // Construye un tag html <select> con todas las sucursales de un comercial dado.
    case 'sucursal':
        $tag = sucursalesComercial($_GET['filtro']);
        break;

    // Construye un tag html <select> con todos los almacenes de un comercial dado.
    case 'almacen':
        $tag = almacenesComercial($_GET['filtro']);
        break;

    // Construye un tag html <select> con todas las direcciones de entrega de un cliente dado.
    case 'dentrega':
        $tag = dEntregaCliente($_GET['filtro']);
        break;

    // Construye un tag html <select> con las formas de pago y propone como seleccionada
    // la habitual de la ficha del cliente.
    case 'formaspagocliente':
        $tag = formasPagoCliente($_GET['filtro']);
        break;

    // Construye un tag html <select> con las zonas comerciales de la sucursal
    case 'zonassucursal':
        $tag = zonasSucursal($_GET['filtro']);
        break;

    // Construye un tag html <select> con los comerciales de la sucursal
    case 'comercialessucursal':
        $tag = getComercialesSucursal($_GET['filtro']);
        break;

    // Construye un tag html <select> con las formas de pago y propone como seleccionada
    // la habitual de la ficha del proveedor.
    case 'formaspagoproveedor':
        $tag = formasPagoProveedor($_GET['filtro']);
        break;

    // Construye un tag html <select> con todas las subfamilias de una familia dada.
    // Le añade una opcion para todas la sucursales.
    case 'subfamilias':
        $tag = subfamilias($_GET['filtro']);
        break;

    // Construye un tag html <select> con todas las SUCURSALES de una empresa dada.
    // Le añade una opcion para todas la sucursales.
    case 'sucursales':
        $tag = sucursalesEmpresa($_GET['filtro']);
        break;

    // Construye un tag html <select> con todos los ALMACENES de una empresa dada.
    // Le añade una opcion para todos los almacenes.
    case 'almacenes':
        $tag = almacenesEmpresa($_GET['filtro']);
        break;

    // Contruye un tag html <select> con todas las ubicaciones de almacen donde
    // haya existencias de un lote
    case 'ubicacionesLote':
        $tag = ubicacionesLote($_GET['filtro']);
        break;

    // Contruye un tag html <select> con todas las ubicaciones de almacen
    case 'ubicacionesAlmacen':
        $tag = ubicacionesAlmacen($_GET['filtro']);
        break;

    // Contruye un tag html <select> con todos los clientes de una sucursal que tienen
    // albaranes pendientes de facturar entre un rango de fechas
    case 'clientesFacturacion':
        $tag = clientesFacturacion($_GET['filtro']);
        break;

    // Contruye un tag html <select> con todos los proveedores de una sucursal que tienen
    // pedidos pendientes de facturar entre un rango de fechas
    case 'proveedoresFacturacion':
        $tag = proveedoresFacturacion($_GET['filtro']);
        break;

    // Contruye un tag html <select> con todos los tpvs de una sucursal
    case 'tpvs':
        $tag = tpvs($_GET['filtro']);
        break;

    case 'mvtosAlmacenLote':
        $tag = lotesAlmacenArticulo($_GET['filtro']);
        break;

    case 'mvtosAlmacenUbicacion':
        $tag = "<div class='Etiqueta'>Ubicación</div>";
        $tag .= ubicacionesLoteStock($_GET['filtro']);
        break;

    case 'mvtosAlmacenInternosUbicacionDestino':
        $tag = "<div class='Etiqueta'>Ubicación Destino</div>";
        $tag .= ubicacionesAlmacen($_GET['filtro']);
        break;    
}

/**
 * DEVUELVE EL SELECT CONSTRUIDO
 */
echo $tag;
//------------------------------------------------------------------------------

/**
 * Construye un tag html <select> con todos los almacenes de una empresa dada.
 * @param integer $idEmpresa ID de la empresa
 * @return string Codigo html con el tag select 
 */
function almacenesEmpresa($idEmpresa) {
    $almacen = new Almacenes();
    $rows = $almacen->fetchAll($idEmpresa);
    unset($almacen);

    $ch = "<div class='Etiqueta'>Almacen</div>";
    $ch .= "<select name='" . $_GET['nameselect'] . "' id='" . $_GET['idselect'] . "' class='Select'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag html <select> con todas las sucursales de una empresa dada.
 * @param integer $idEmpresa ID de la empresa
 * @return string Codigo html con el tag select 
 */
function sucursalesEmpresa($idEmpresa) {

    $sucursal = new Sucursales();
    $rows = $sucursal->fetchAll($idEmpresa);
    unset($sucursal);

    $ch = "<div class='Etiqueta'>Sucursal</div>";
    $ch .= "<select name='" . $_GET['nameselect'] . "' id='" . $_GET['idselect'] . "' class='Select'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag html <select> con todas las sucursales de un comercial dado.
 * @param integer $idComercial ID del comercial
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select 
 */
function sucursalesComercial($idComercial, $nameSelect = '', $idSelect = '') {

    $comercial = new Agentes($idComercial);
    $rows = $comercial->getSucursales();
    unset($comercial);

    if ($nameSelect == '')
        $nameSelect = $_SESSION['nameselect'];
    if ($idSelect == '')
        $idSelect = $_SESSION['idselect'];

    $ch = "<div class='Etiqueta'>Sucursal</div>";
    $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag html <select> con todos los almacenes de un comercial dado.
 * @param integer $idComercial ID del comercial
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function almacenesComercial($idComercial, $nameSelect = '', $idSelect = '') {

    $comercial = new Agentes($idComercial);
    $rows = $comercial->getAlmacenes();
    unset($comercial);

    if ($nameSelect == '')
        $nameSelect = $_SESSION['nameselect'];
    if ($idSelect == '')
        $idSelect = $_SESSION['idselect'];

    $ch = "<div class='Etiqueta'>Almacen</div>";
    $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag html <select> con todas las direcciones de entrega de un cliente dado.
 * @param integer $idCliente ID del cliente
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function dEntregaCliente($idCliente, $nameSelect = '', $idSelect = '') {
    $dEntrega = new ClientesDentrega();
    $rows = $dEntrega->fetchAll($idCliente);
    unset($dEntrega);

    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    $ch = "<div class='Etiqueta'>Dirección de Entrega</div>";
    $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select350'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag html <select> con todas las zonas comerciales de una sucursal.
 * @param integer $idSucursal ID de la sucursal
 * @return string Codigo html con el tag select
 */
function zonasSucursal($idSucursal = '') {
    $zona = new Zonas();
    $rows = $zona->fetchAll($idSucursal);
    unset($zona);

    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];
    if ($idSucursal == '')
        $idSucursal = $_SESSION['suc'];

    $ch = "<div class='Etiqueta'>Zona de Venta</div>";
    $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag <select> con todas las formas de pago y propone la habitual de la ficha del cliente dado
 * @param integer $idCliente ID del cliente
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function formasPagoCliente($idCliente, $nameSelect = '', $idSelect = '') {

    $fPago = new FormasPago();
    $rows = $fPago->fetchAll('Descripcion');
    unset($fPago);

    $cliente = new Clientes($idCliente);
    $fPagoCliente = $cliente->getIDFP()->getIDFP();
    unset($cliente);

    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    $ch = "<div class='Etiqueta'>Forma de Pago</div>";
    $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'";
        if ($fPagoCliente == $row['Id'])
            $ch .= " SELECTED ";
        $ch .= ">" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag <select> con todas las formas de pago y propone la habitual de la ficha del proveedor dado
 * @param integer $idProveedor ID del proveedor
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function formasPagoProveedor($idProveedor, $nameSelect = '', $idSelect = '') {

    $fPago = new FormasPago();
    $rows = $fPago->fetchAll('Descripcion');
    unset($fPago);

    $proveedor = new Proveedores($idProveedor);
    $fPagoProveedor = $proveedor->getIDFP()->getIDFP();
    unset($proveedor);

    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    $ch = "<div class='Etiqueta'>Forma de Pago</div>";
    $ch .= "<select name='" . $_GET['nameselect'] . "' id='" . $_GET['idselect'] . "' class='Select'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'";
        if ($fPagoProveedor == $row['Id'])
            $ch .= " SELECTED ";
        $ch .= ">" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag html <select> con todas las subfamilias de una familia dada
 * @param integer $idFamilia ID de familia
 * @return string Codigo html con el tag select 
 */
function subfamilias($idFamilia) {

    $subfamilia = new Subfamilias();
    $rows = $subfamilia->fetchAll($idFamilia, 'Subfamilia');
    unset($subfamilia);

    $ch = "<div class='Etiqueta'>Subfamilia</div>";
    $ch .= "<select name='" . $_GET['nameselect'] . "' id='" . $_GET['idselect'] . "' class='Select'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag html <select> con todos los clientes de un comercial dado
 * y de la sucursal en curso.
 * @param integer $idComercial ID de comercial
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function clientesComercial($idComercial, $nameSelect = '', $idSelect = '') {
    $cliente = new Clientes();
    $rows = $cliente->fetchAll('', $idComercial);
    unset($cliente);

    if ($nameSelect == '')
        $nameSelect = $_SESSION['nameselect'];
    if ($idSelect == '')
        $idSelect = $_SESSION['idselect'];

    $ch = "<div class='Etiqueta'>Cliente</div>";
    $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'";
    $ch .= " onchange=\"DesplegableAjax('div_AlbaranesCab_IDDirec','AlbaranesCab_IDDirec','AlbaranesCab[IDDirec]','dentrega',this.value);";
    $ch .= "DesplegableAjax('div_AlbaranesCab_IDFP','AlbaranesCab_IDFP','AlbaranesCab[IDFP]','formaspago',this.value);\"";
    $ch .= ">";
    $ch .= "<option value=''>:: Cliente</option>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag html <select> con todos los clientes de una sucursal y agente (comercial o no) dado
 * y de la sucursal en curso.
 * @param integer $idSucursal ID de la sucursal
 * @param integer $idAgente ID de agente
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function clientesSucursalAgente($idSucursal = '', $idAgente = '', $nameSelect = '', $idSelect = '') {
    $cliente = new Clientes();
    $rows = $cliente->fetchAll($idSucursal, $idAgente);
    unset($cliente);

    if ($idSucursal == '')
        $idSucursal = $_SESSION['suc'];
    if ($idAgente == '')
        $idAgente == $_SESSION['USER']['user']['id'];

    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    $ch = "<div class='Etiqueta'>Cliente</div>";
    $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'";
    $ch .= " onchange=\"DesplegableAjax('subbloque_ajax_cliente_albaran','','','clientealbaran',this.value); \">";
    $ch .= "<option value=''>:: Cliente</option>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

function getComercial($idCliente, $nameSelect = '', $idSelect = '') {
    $cliente = new Clientes($idCliente);

    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    $ch = '<input type="hidden" name=' . $nameSelect . ' id="' . $idSelect . '" value="' . $cliente->getIDComercial()->getIDAgente() . '" />';
    unset($cliente);

    return $ch;
}

/**
 * Construye un tag html <select> con todos las series de contadores de
 * la sucursal y tipo de contador indicado
 * @param integer $idSucursal ID de la sucursal
 * @param integer $tipo El tipo de contador (albaranes, pstos, etc).
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function getContadoresSucursal($idSucursal, $tipo, $nameSelect = '', $idSelect = '') {
    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    $contadores = new Contadores();
    $rows = $contadores->fetchAll($idSucursal, $tipo);
    unset($contadores);

    $ch = "<div class='Etiqueta'>Serie</div>";
    $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag html <select> con todos los comerciales de la sucursal indicada
 * @param integer $idSucursal ID de la sucursal
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function getComercialesSucursal($idSucursal, $nameSelect = '', $idSelect = '') {
    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    $comerciales = new Agentes();
    $rows = $comerciales->getComerciales($_SESSION['emp'], $idSucursal);
    unset($comerciales);

    $ch = "<div class='Etiqueta'>Comercial</div>";
    $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

/**
 * Construye un tag html <select> con todos los lotes que existen de un
 * articulo en un almacen
 * 
 * @param type $filtro El id de almacen y el id de articulo separados por un guion
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function lotesAlmacenArticulo($filtro, $nameSelect = '', $idSelect = '') {
    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    // En el filtro viene separado por un guión el id del almacen y el id del articulo
    $valores = explode("-", $filtro);
    $idAlmacen = $valores[0];
    $idArticulo = $valores[1];

    $articulo = new Articulos($idArticulo);
    $rows = $articulo->getLotesDisponibles($idAlmacen,true);
    $uma = $articulo->getUMA();
    unset($articulo);

    $ch .= "<div class='Etiqueta'>Lote</div>";
    if (count($rows)) {
        $ch .= "<select name='MvtosAlmacen[IDLote]' id='MvtosAlmacen_IDLote' class='Select' style='width:190px;'";
        $ch .= "onblur=\"DesplegableAjax('div_MvtosAlmacen_IDUbicacion','MvtosAlmacen_IDUbicacion','MvtosAlmacen[IDUbicacion]','mvtosAlmacenUbicacion',this.value+'-'+$('#MvtosAlmacen_IDAlmacen').val());\"";
        $ch .= ">";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . " -> " . sprintf("%9.2f",$row['Reales']) . " {$uma}</option>";
        }
    } else {
        $ch .= "No hay lotes";
    }
    $ch .= "</select></div>";

    return $ch;
}

/**
 * Construye un tag html <select> con todas las ubicaciones donde hay stock
 * para el lote y almacen indicado en el parametro
 * @param string $filtro El id de lote y el id de almacen separados por un guion
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function ubicacionesLoteStock($filtro, $nameSelect = '', $idSelect = '') {
    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    // En el filtro viene separado por un guión el id del lote y el id del almacen
    $valores = explode("-", $filtro);
    $idLote = $valores[0];
    $idAlmacen = $valores[1];

    $lote = new Lotes($idLote);
    $rows = $lote->getUbicacionesStock($idAlmacen);
    $uma = $lote->getIDArticulo()->getUMA();
    unset($lote);

    if (count($rows)) {
        $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select' style='width:190px;'>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . " -> " . sprintf("%9.2f",$row['Reales']) . " {$uma}</option>";
        }
        $ch .= "</select>";
    } else {
        $ch .= "No hay ubicaciones";
    }
    return $ch;
}

/**
 * Construye un tag html <select> con todas las ubicaciones donde hay stock
 * para el lote y almacen indicado en el parametro
 * @param string $filtro El id de lote y el id de almacen separados por un guion
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function ubicacionesLote($filtro, $nameSelect = '', $idSelect = '') {
    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    // En el filtro viene separado por un guión el id del lote y el id del almacen
    $valores = explode("-", $filtro);
    $idLote = $valores[0];
    $idAlmacen = $valores[1];

    $lote = new Lotes($idLote);
    $rows = $lote->getUbicaciones($idAlmacen);
    unset($lote);

    if (count($rows)) {
        $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select' style='width:110px;'>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
        }
        $ch .= "</select>";
    } else {
        $ch .= "No hay ubicaciones";
    }
    return $ch;
}

/**
 * Construye un tag html <select> con todas las ubicaciones del almacen indicado en el parametro
 * @param string $filtro El id de almacen
 * @param string $nameSelect El Name del select
 * @param string $idSelect El Id del select
 * @return string Codigo html con el tag select
 */
function ubicacionesAlmacen($filtro, $nameSelect = '', $idSelect = '') {
    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    // En el filtro viene el id del almacen
    $idAlmacen = $filtro;

    $almacen = new Almacenes($idAlmacen);
    $rows = $almacen->getUbicaciones();
    unset($almacen);

    $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select' style='width:110px;'>";
    foreach ($rows as $row) {
        $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
    }
    $ch .= "</select>";

    return $ch;
}

// Contruye un tag html <select> con todos los clientes de una sucursal que tienen
// albaranes pendientes de facturar entre un rango de fechas
function clientesFacturacion($filtro, $nameSelect = '', $idSelect = '') {
    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    // En el filtro viene separado por @ el id de la sucursal y el rango de fechas
    $valores = explode("@", $filtro);
    $idSucursal = $valores[0];
    $desdeFecha = $valores[1];
    $hastaFecha = $valores[2];

    $cliente = new Clientes();
    $rows = $cliente->fetchConPendienteDeFacturar($idSucursal, $desdeFecha, $hastaFecha);
    unset($cliente);

    if (count($rows) == 0) {
        $ch = "<div style='margin-top: 20px; font-weight: bold;'>No hay ningún cliente con albaranes pendientes en ese período</div>";
    } else {
        $ch .= "<div>Clientes con pendiente de facturar:</div>";
        $ch .= "<div><select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select' style='width:310px;' onchange='submit();'>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . " (" . $row['Total'] . ")</option>";
        }
        $ch .= "</select>";
        $ch .= "<input type='submit' value='Ver Albaranes' class='Comando'/></div>";
    }

    return $ch;
}

// Contruye un tag html <select> con todos los proveedores de una sucursal que tienen
// pedidos pendientes de facturar entre un rango de fechas
function proveedoresFacturacion($filtro, $nameSelect = '', $idSelect = '') {
    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    // En el filtro viene separado por @ el id de la sucursal y el rango de fechas
    $valores = explode("@", $filtro);
    $idSucursal = $valores[0];
    $desdeFecha = $valores[1];
    $hastaFecha = $valores[2];

    $proveedor = new Proveedores();
    $rows = $proveedor->fetchConPendienteDeFacturar($idSucursal, $desdeFecha, $hastaFecha);
    unset($proveedor);

    if (count($rows) == 0) {
        $ch = "<div style='margin-top: 20px; font-weight: bold;'>No hay ningún proveedor con pedidos pendientes en ese período</div>";
    } else {
        $ch .= "<div>Proveedores con pendiente de facturar:</div>";
        $ch .= "<div><select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select' style='width:310px;' onchange='submit();'>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . " (" . $row['Total'] . ")</option>";
        }
        $ch .= "</select>";
        $ch .= "<input type='submit' value='Ver Pedidos' class='Comando'/></div>";
    }

    return $ch;
}

// Contruye un tag html <select> con todos los tpvs de una sucursal
function tpvs($idSucursal, $nameSelect = '', $idSelect = '') {
    if ($nameSelect == '')
        $nameSelect = $_GET['nameselect'];
    if ($idSelect == '')
        $idSelect = $_GET['idselect'];

    $tpv = new Tpvs();
    $rows = $tpv->fetchAll($idSucursal);
    unset($tpv);

    $ch = "Tpv:";
    if (count($rows)) {
        $ch .= "<input name='{$nameSelect}' value='{$idSelect}' type='hidden' />";
        $ch .= "<select name='{$nameSelect}' id='{$idSelect}' style='width: 100px;'>";
        foreach ($rows as $row)
            $ch .= "<option value='{$row[Id]}'>{$row[Value]}</option>";

        $ch .= "</select>";
    } else {
        $ch .= "No hay Tpvs";
    }

    return $ch;
}

?>
