<?php

session_start();

include "../../lib/entityManager.class.php";

$conexion = '';

switch ($_POST['entidad']) {

    // BUSCA CLIENTES DE LA SUCURSAL EN CURSO POR %RAZONSOCIAL% y $NOMBRECOMERCIAL%
    case 'clientes':
        $conexion = 'datos' . $_SESSION['emp'];
        if ($_POST['idSucursal'] == '')
            $_POST['idSucursal'] = $_SESSION['suc'];
        $filtro = "(IDSucursal='{$_POST['idSucursal']}') and (Vigente='1') and ( (RazonSocial LIKE '%{$_POST['valor']}%') or (NombreComercial LIKE '%{$_POST['valor']}%') )";
        if ($_SESSION['USER']['user']['EsComercial'])
            $filtro .= " and (IDComercial='" . $_SESSION['USER']['user']['id'] . "')";

        $query = "SELECT IDCliente as Id, CONCAT(RazonSocial,' - ',NombreComercial) as Value FROM clientes where ( {$filtro} ) ORDER BY RazonSocial";
        break;

    // BUSCA PROVEEDORES POR %RAZONSOCIAL%
    case 'proveedores':
        $conexion = 'datos' . $_SESSION['emp'];
        $filtro = "RazonSocial LIKE '%{$_POST['valor']}%'";
        $query = "SELECT IDProveedor as Id, RazonSocial as Value FROM proveedores where ({$filtro}) ORDER BY RazonSocial";
        break;

    // BUSCA ARTICULOS DE LA SUCURSAL EN CURSO POR IDARTICULO% Y $DESCRIPCION%
    case 'articulos':
        $conexion = 'datos' . $_SESSION['emp'];
        $filtro = "IDSucursal='{$_POST['idSucursal']}') and (Vigente='1') and ((Codigo LIKE '%{$_POST['valor']}%') or (Descripcion LIKE '%{$_POST['valor']}%') or (CodigoEAN LIKE '%{$_POST['valor']}%')";
        $query = "SELECT IDArticulo as Id, Codigo, Descripcion as Value FROM articulos where ({$filtro}) ORDER BY Descripcion";
        break;

    // BUSCA ARTICULOS DE LA FAMILIA INDICADA POR IDARTICULO% Y $DESCRIPCION%
    // EN ESTE CASA UTILIZA LA VARIABLE 'idSucursal' COMO LA FAMILIA
    case 'articulosFamilia':
        $conexion = 'datos' . $_SESSION['emp'];
        if ($_POST['idSucursal'] == '')
            $filtro = '1';
        else
            $filtro = "IDFamilia='{$_POST['idSucursal']}'";

        $filtro .= " and (Vigente='1') and ((IDArticulo LIKE '{$_POST['valor']}%') or (Descripcion LIKE '%{$_POST['valor']}%'))";
        $query = "SELECT IDArticulo as Id, Descripcion as Value FROM articulos where ({$filtro}) ORDER BY Descripcion";
        break;
}


if (($conexion != '') and (strlen($_POST['valor']) > 0)) {
    $em = new entityManager($conexion, '../config/config.xml');
    if ($em->getDbLink()) {

        if ($em->query($query)) {
            $datos = $em->fetchResult();

            $response = "";
            foreach ($datos as $value) {
                if ($_POST['entidad'] == 'articulos')
                    $valorMostrar = "<div style='float:left;width:60px;overflow:hidden;margin-right:3px;'>" . $value['Codigo'] . "</div><div style='float:left;'>" . $value['Value'] . "</div><div style='clear:both;'></div>";
                else
                    $valorMostrar = "<div style='float:left;width:60px;overflow:hidden;margin-right:3px;'>" . $value['Id'] . "</div><div style='float:left;'>" . $value['Value'] . "</div><div style='clear:both;'></div>";
                $response .= sprintf('<li onclick="fill(\'%s\',\'%s\',\'%s\',\'%s\',\'%s\',\'%s\');">%s</li>', $_POST['key'], $_POST['idInput'], $value['Id'], $_POST['idTexto'], $value['Value'], $_POST['desplegableAjax'], $valorMostrar);
            }
        }

        $em->desConecta();
    } else {
        $response = $em->getError();
        $response = $response[0];
    }
}

echo $response;
?>
