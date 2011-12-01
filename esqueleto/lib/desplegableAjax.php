<?php

session_start();

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
 */
include "../../lib/entityManager.class.php";

switch ($_GET['t']) {
    // Construye en cascada 3 tab html <select> vinculados según la sucursal que se elija:
    // Clientes, direcciones de entrega y formas de pago
    case 'clientealbaran':
        //$tag  = '<div class="Item" id="div_AlbaranesCab_IDCliente">' . clientesSucursalAgente($_GET['filtro'],'', $_GET['nameselect'], $_GET['idselect']) . '</div>';
        $tag .= '<div id="subbloque_ajax_cliente_albaran">';
        $tag .= '<div class="Item" id="div_AlbaranesCab_IDComercial">'.getComercial($_GET['filtro']).'</div>';
        $tag .= '<div class="Item" id="div_AlbaranesCab_IDDirec">'.dEntregaCliente($_GET['filtro'],'AlbaranesCab[IDDirec]','AlbaranesCab_IDDirec').'</div>';
        $tag .= '<div class="Item" id="div_AlbaranesCab_IDFP">'.formasPagoCliente($_GET['filtro'],'AlbaranesCab[IDFP]','AlbaranesCab_IDFP').'</div>';
        $tag .= '</div>';
        break;

    // Construye en cascada el tag de direcciones de entrega, las formas de pago y el comercial
    // asociado a cliente
    case 'comercialcliente':
        $tag  = getComercial($_GET['filtro']);
        $tag .= '<div class="Item" id="div_AlbaranesCab_IDDirec">'.dEntregaCliente($_GET['filtro'],'AlbaranesCab[IDDirec]','AlbaranesCab_IDDirec').'</div>';
        $tag .= '<div class="Item" id="div_AlbaranesCab_IDFP">'.formasPagoCliente($_GET['filtro'],'AlbaranesCab[IDDirec]','AlbaranesCab_IDDirec').'</div>';
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
}

/**
 * DEVUELVE EL SELECT CONSTRUIDO
 */
echo $tag;
//------------------------------------------------------------------------------

/**
 * Construye un tag html <select> con todos los almacenes de una empresa dada.
 * LE AÑADE UNA OPCION PARA '** TODOS **'
 * @param integer $idEmpresa ID de la empresa
 * @return string Codigo html con el tag select 
 */
function almacenesEmpresa($idEmpresa) {
    $em = new entityManager("empresas", "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $filtro = "WHERE (t1.IDEmpresa='" . $idEmpresa . "')  AND (t1.IDAlmacen=t2.IDAlmacen)";
        $query = "SELECT t1.IDAlmacen as Id, t2.Nombre as Value FROM empresas_almacenes as t1, almacenes as t2 $filtro ORDER BY t2.Nombre ASC;";

        $em->query($query);
        $rows = $em->fetchResult();
        $em->desConecta();
        unset($em);

        $ch = "<div class='Etiqueta'>Almacen</div>";
        $ch .= "<select name='" . $_GET['nameselect'] . "' id='" . $_GET['idselect'] . "' class='Select'>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
        }
        $ch .= "<option value='0'>** Todos **</option>";
        $ch .= "</select>";
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    return $ch;
}

/**
 * Construye un tag html <select> con todas las sucursales de una empresa dada.
 * LE AÑADE UNA OPCION PARA '** TODAS **'
 * @param integer $idEmpresa ID de la empresa
 * @return string Codigo html con el tag select 
 */
function sucursalesEmpresa($idEmpresa) {
    $em = new entityManager("empresas", "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $query = "SELECT IDSucursal as Id, Nombre as Value FROM sucursales WHERE IDEmpresa='" . $idEmpresa . "' ORDER BY Nombre ASC;";
        $em->query($query);
        $rows = $em->fetchResult();
        $em->desConecta();
        unset($em);

        $ch = "<div class='Etiqueta'>Sucursal</div>";
        $ch .= "<select name='" . $_GET['nameselect'] . "' id='" . $_GET['idselect'] . "' class='Select'>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
        }
        $ch .= "<option value='0'>** Todas **</option>";
        $ch .= "</select>";
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    return $ch;
}

/**
 * Construye un tag html <select> con todas las sucursales de un comercial dado.
 * @param integer $idComercial ID del comercial
 * @return string Codigo html con el tag select 
 */
function sucursalesComercial($idComercial, $nameSelect='', $idSelect='') {
    if ($nameSelect == '')
        $nameSelect = $_SESSION['nameselect'];
    if ($idSelect == '')
        $idSelect = $_SESSION['idselect'];

    $em = new entityManager("empresas", "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $query = "SELECT IDSucursal FROM agentes WHERE IDAgente='" . $idComercial . "'";
        $em->query($query);
        $rows = $em->fetchResult();
        $sucursal = $rows[0]['IDSucursal'];
        if ($sucursal < 1) {
            //Puede acceder a todas las sucursales de la empresa
            $query = "select IDSucursal as Id, Nombre as Value from sucursales where IDEmpresa='" . $_SESSION['emp'] . "'";
            $em->query($query);
            $rows = $em->fetchResult();
        } else {
            //Puede acceder solo a una
            $query = "select IDSucursal as Id, Nombre as Value from sucursales where IDEmpresa='" . $_SESSION['emp'] . "' and IDSucursal='" . $sucursal . "'";
            $em->query($query);
            $rows = $em->fetchResult();
        }
        $em->desConecta();
        unset($em);

        $ch = "<div class='Etiqueta'>Sucursal</div>";
        $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
        }
        $ch .= "</select>";
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    return $ch;
}

/**
 * Construye un tag html <select> con todos los almacenes de un comercial dado.
 * @param integer $idComercial ID del comercial
 * @return string Codigo html con el tag select
 */
function almacenesComercial($idComercial, $nameSelect='', $idSelect='') {
    if ($nameSelect == '')
        $nameSelect = $_SESSION['nameselect'];
    if ($idSelect == '')
        $idSelect = $_SESSION['idselect'];

    $em = new entityManager("empresas", "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $query = "SELECT IDAlmacen FROM agentes WHERE IDAgente='" . $idComercial . "'";
        $em->query($query);
        $rows = $em->fetchResult();
        $almacen = $rows[0]['IDAlmacen'];
        if ($almacen < 1) {
            //Puede acceder a todos los almacenes de la empresa
            $query = "select t1.IDAlmacen as Id, t2.Nombre as Value from empresas_almacenes as t1, almacenes as t2
                            where t1.IDAlmacen=t2.IDAlmacen
                            and t1.IDEmpresa='" . $_SESSION['emp'] . "'";
            $em->query($query);
            $rows = $em->fetchResult();
        } else {
            //Puede acceder solo a uno
            $query = "select IDAlmacen as Id, Nombre as Value from almacenes where IDAlmacen='" . $almacen . "'";
            $em->query($query);
            $rows = $em->fetchResult();
        }
        $em->desConecta();
        unset($em);

        $ch = "<div class='Etiqueta'>Almacen</div>";
        $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
        }
        $ch .= "</select>";
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    return $ch;
}

/**
 * Construye un tag html <select> con todas las direcciones de entrega de un cliente dado.
 * @param integer $idCliente ID del cliente
 * @return string Codigo html con el tag select
 */
function dEntregaCliente($idCliente, $nameSelect='', $idSelect='') {
    if ($nameSelect == '') $nameSelect = $_GET['nameselect'];
    if ($idSelect == '') $idSelect = $_GET['idselect'];

    $em = new entityManager("datos" . $_SESSION['emp'], "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $query = "SELECT IDDirec as Id, Direccion as Value FROM clientes_dentrega WHERE IDCliente='" . $idCliente . "' ORDER BY Direccion ASC;";
        $em->query($query);
        $rows = $em->fetchResult();
        $em->desConecta();
        unset($em);

        $ch = "<div class='Etiqueta'>Dirección de Entrega</div>";
        $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
        }
        $ch .= "</select>";
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }
    
    return $ch;
}

/**
 * Construye un tag html <select> con todas las zonas comerciales de una sucursal.
 * @param integer $idSucursal ID de la sucursal
 * @return string Codigo html con el tag select
 */
function zonasSucursal($idSucursal='') {
    if ($nameSelect == '') $nameSelect = $_GET['nameselect'];
    if ($idSelect == '') $idSelect = $_GET['idselect'];
    if ($idSucursal == '') $idSucursal = $_SESSION['suc'];

    $em = new entityManager("datos" . $_SESSION['emp'], "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $query = "SELECT IDZona as Id, Zona as Value FROM zonas WHERE IDSucursal='" . $idSucursal . "' ORDER BY Zona ASC;";
        $em->query($query);
        $rows = $em->fetchResult();
        $em->desConecta();
        unset($em);

        $ch = "<div class='Etiqueta'>Zona de Venta</div>";
        $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
        }
        $ch .= "</select>";
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    return $ch;
}

/**
 * Construye un tag <select> con todas las formas de pago y propone la habitual de la ficha del cliente dado
 * @param integer $idCliente ID del cliente
 * @return string Codigo html con el tag select
 */
function formasPagoCliente($idCliente, $nameSelect='', $idSelect='') {
    if ($nameSelect == '') $nameSelect = $_GET['nameselect'];
    if ($idSelect == '') $idSelect = $_GET['idselect'];

    $em = new entityManager("datos" . $_SESSION['emp'], "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $query = "SELECT IDFP as Id, Descripcion as Value FROM formas_pago ORDER BY Descripcion ASC;";
        $em->query($query);
        $formasPago = $em->fetchResult();

        $query = "SELECT IDFP from clientes where IDCliente='{$idCliente}'";
        $em->query($query);
        $formaPagoCliente = $em->fetchResult();

        $em->desConecta();
        unset($em);

        $ch = "<div class='Etiqueta'>Forma de Pago</div>";
        $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'>";
        foreach ($formasPago as $row) {
            $ch .= "<option value='" . $row['Id'] . "'";
            if ($formaPagoCliente[0]['IDFP'] == $row['Id'])
                $ch .= " SELECTED ";
            $ch .= ">" . $row['Value'] . "</option>";
        }
        $ch .= "</select>";
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    return $ch;
}

/**
 * Construye un tag <select> con todas las formas de pago y propone la habitual de la ficha del proveedor dado
 * @param integer $idProveedor ID del proveedor
 * @return string Codigo html con el tag select
 */
function formasPagoProveedor($idProveedor) {
    $em = new entityManager("datos" . $_SESSION['emp'], "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $query = "SELECT IDFP as Id, Descripcion as Value FROM formas_pago ORDER BY Descripcion ASC;";
        $em->query($query);
        $formasPago = $em->fetchResult();

        $query = "SELECT IDFP from proveedores where IDProveedor='{$idProveedor}'";
        $em->query($query);
        $formaPagoCliente = $em->fetchResult();

        $em->desConecta();
        unset($em);

        $ch = "<div class='Etiqueta'>Forma de Pago</div>";
        $ch .= "<select name='" . $_GET['nameselect'] . "' id='" . $_GET['idselect'] . "' class='Select'>";
        foreach ($formasPago as $row) {
            $ch .= "<option value='" . $row['Id'] . "'";
            if ($formaPagoCliente[0]['IDFP'] == $row['Id'])
                $ch .= " SELECTED ";
            $ch .= ">" . $row['Value'] . "</option>";
        }
        $ch .= "</select>";
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    return $ch;
}

/**
 * Construye un tag html <select> con todas las subfamilias de una familia dada
 * @param integer $idFamilia ID de familia
 * @return string Codigo html con el tag select 
 */
function subfamilias($idFamilia) {
    $em = new entityManager("datos" . $_SESSION['emp'], "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $query = "SELECT IDSubfamilia as Id, Subfamilia as Value FROM subfamilias WHERE IDFamilia='" . $idFamilia . "' ORDER BY Subfamilia ASC;";
        $em->query($query);
        $rows = $em->fetchResult();
        $em->desConecta();
        unset($em);

        $ch = "<div class='Etiqueta'>Subfamilia</div>";
        $ch .= "<select name='" . $_GET['nameselect'] . "' id='" . $_GET['idselect'] . "' class='Select'>";
        $ch .= "<option value=''>:: Subfamilia</option>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
        }
        $ch .= "</select>";
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    return $ch;
}

/**
 * Construye un tag html <select> con todos los clientes de un comercial dado
 * y de la sucursal en curso.
 * @param integer $idComercial ID de comercial
 * @return string Codigo html con el tag select
 */
function clientesComercial($idComercial, $nameSelect='', $idSelect='') {
    if ($nameSelect == '')
        $nameSelect = $_SESSION['nameselect'];
    if ($idSelect == '')
        $idSelect = $_SESSION['idselect'];

    $em = new entityManager("datos" . $_SESSION['emp'], "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $query = "SELECT IDCliente as Id, RazonSocial as Value FROM clientes WHERE IDComercial='" . $idComercial . "' AND IDSucursal='" . $_SESSION['suc'] . "' ORDER BY RazonSocial ASC;";
        $em->query($query);
        $rows = $em->fetchResult();
        $em->desConecta();
        unset($em);

        $ch  = "<div class='Etiqueta'>Cliente</div>";
        $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'";
        $ch .= " onchange=\"DesplegableAjax('div_AlbaranesCab_IDDirec','AlbaranesCab_IDDirec','AlbaranesCab[IDDirec]','dentrega',this.value);";
        $ch .= "DesplegableAjax('div_AlbaranesCab_IDFP','AlbaranesCab_IDFP','AlbaranesCab[IDFP]','formaspago',this.value);\"";
        $ch .= ">";
        $ch .= "<option value=''>:: Cliente</option>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
        }
        $ch .= "</select>";
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    return $ch;
}

/**
 * Construye un tag html <select> con todos los clientes de una sucursal y agente (comercial o no) dado
 * y de la sucursal en curso.
 * @param integer $idSucursal ID de la sucursal
 * @param integer $idAgente ID de agente
 * @return string Codigo html con el tag select
 */
function clientesSucursalAgente($idSucursal='', $idAgente='', $nameSelect='', $idSelect='') {
    if ($idSucursal == '')
        $idSucursal = $_SESSION['suc'];
    if ($idAgente == '')
        $idAgente == $_SESSION['USER']['user']['id'];
    /*
    if ($nameSelect == '')
        $nameSelect = $_SESSION['nameselect'];
    if ($idSelect == '')
        $idSelect = $_SESSION['idselect'];*/

    //Ver si el agente es comercial
    $esComercial = false;

    $em = new entityManager("empresas", "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $query = "select Rol from agentes where IDAgente='{$idAgente}'";
        $em->query($query);
        $rows = $em->fetchResult();
        $em->desConecta();
        unset($em);

        $esComercial = ($rows[0]['Rol'] == '1');
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    $em = new entityManager("datos" . $_SESSION['emp'], "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        if ($esComercial)
            $query = "SELECT IDCliente as Id, RazonSocial as Value FROM clientes WHERE IDComercial='" . $idComercial . "' AND IDSucursal='" . $idSucursal . "' ORDER BY RazonSocial ASC;";
        else
            $query = "SELECT IDCliente as Id, RazonSocial as Value FROM clientes WHERE IDSucursal='" . $idSucursal . "' ORDER BY RazonSocial ASC;";

        $em->query($query);
        $rows = $em->fetchResult();
        $em->desConecta();
        unset($em);

        $ch  = "<div class='Etiqueta'>Cliente</div>";
        $ch .= "<select name='" . $nameSelect . "' id='" . $idSelect . "' class='Select'";
        $ch .= " onchange=\"DesplegableAjax('subbloque_ajax_cliente_albaran','','','clientealbaran',this.value); \">";
        $ch .= "<option value=''>:: Cliente</option>";
        foreach ($rows as $row) {
            $ch .= "<option value='" . $row['Id'] . "'>" . $row['Value'] . "</option>";
        }
        $ch .= "</select>";
    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    return $ch;
}

function getComercial($idCliente) {
    $em = new entityManager("datos" . $_SESSION['emp'], "../config/config.xml");
    if (is_resource($em->getDbLink())) {
        $query = "SELECT IDComercial from clientes where IDCliente='{$idCliente}'";
        $em->query($query);
        $rows = $em->fetchResult();
        $em->desConecta();
        unset($em);
        $idComercial = $rows[0]['IDComercial'];

        $ch  = '<input type="hidden" name="AlbaranesCab[IDComercial]" id="AlbaranesCab_IDComercial" value="'.$idComercial.'" />';

    } else {
        foreach ($em->getError() as $error) {
            $ch .= $error . "\n";
        }
    }

    return $ch;
}
?>
