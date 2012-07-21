<?php

/**
 * CONTROLADOR MULTIPROPOSITO PARA REDENRIZAR INFORMACION EN PANTALLAS EMERGENTES
 *
 * LA INFORMACION QUE SE MOSTRARA DEPENDE DEL METODO LLAMADO
 *
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL 
 * @since 27.07.2011 11:10:13

 */
class _EmergenteController {

    protected $request;
    protected $values;

    public function __construct($request) {
        // Cargar lo que viene en el request
        $this->request = $request;
        $this->values['request'] = $this->request;
    }

    /**
     * Muestra las líneas de albarán que están reservadas para el almacén y artículo indicado
     * @return array Con el template y values
     */
    public function reservasAction() {
        switch ($this->request["METHOD"]) {
            case 'GET':
                $idArticulo = $this->request['2'];
                $idAlmacen = $this->request['3'];
                $condicion = " JOIN albaranes_cab USING(IDAlbaran) where t1.IDAlmacen='{$idAlmacen}' and t1.IDArticulo='{$idArticulo}' and t1.IDEstado='1' ";
                $query = "select IDLinea from albaranes_lineas as t1 {$condicion} order by albaranes_cab.Fecha ASC";
                $em = new EntityManager("datos" . $_SESSION['emp']);
                $em->query($query);
                $rows = $em->fetchResult();
                $em->desConecta();
                unset($em);

                foreach ($rows as $key => $value) {
                    $data[] = new AlbaranesLineas($value['IDLinea']);
                }
                $this->values['data'] = $data;
                unset($data);
                break;

            case 'POST':
                break;
        }

        return array('template' => '_Emergente/reservasAlbaranes.html.twig', 'values' => $this->values);
    }

    /**
     * Muestra las líneas de pedido que están pendiente de recepción para el almacén y artículo indicado
     * @return array Con el template y values
     */
    public function entradasAction() {
        switch ($this->request["METHOD"]) {
            case 'GET':
                $idArticulo = $this->request['2'];
                $idAlmacen = $this->request['3'];
                $condicion = " JOIN pedidos_cab USING(IDPedido) where t1.IDAlmacen='{$idAlmacen}' and t1.IDArticulo='{$idArticulo}' and t1.IDEstado='1' ";
                $query = "select IDLinea from pedidos_lineas as t1 {$condicion} order by pedidos_cab.FechaEntrega ASC";
                $em = new EntityManager("datos" . $_SESSION['emp']);
                $em->query($query);
                $rows = $em->fetchResult();
                $em->desConecta();
                unset($em);

                foreach ($rows as $key => $value) {
                    $data[] = new PedidosLineas($value['IDLinea']);
                }
                $this->values['data'] = $data;
                unset($data);
                break;

            case 'POST':
                break;
        }

        return array('template' => '_Emergente/entradasPedidos.html.twig', 'values' => $this->values);
    }

    /**
     * Devuelve array con los posibles formatos de documentos para
     * el tipo de documento indicado como parámetro o en la posicion 2 del request
     *
     * El controlador que generará el documento viene en la posicion 3 del request
     * El id del objeto a imprimir viene en la posicion 4 del request
     *
     * Los formatos están definidos en  docs/docsXXX/tipoDocumento.yml
     * Se mostrarán solo aquellos que el perfil del usuario tenga acceso.
     *
     * En el nodo <idPerfil> se indican los IDs (separados por comas) de los perfiles que tendrán acceso
     * al documento. Si el nodo está vacio, se entiende que pueden acceder todos.
     *
     * @param string Tipo de Documento
     * @return array Con el template y values 
     */
    public function formatosDocumentosAction($tipoDocumento='') {

        switch ($this->request["METHOD"]) {
            case 'GET':
                if ($tipoDocumento == '')
                    $tipoDocumento = $this->request['2'];

                $controlador = $this->request['3'];
                $idDocumento = $this->request['4'];

                $documento = new DocumentoPdf();
                $formatos = $documento->getFormatos($tipoDocumento);
                unset($documento);

                $this->values = array(
                    'numeroDeFormatos' => count($formatos),
                    'tipoDocumento' => $tipoDocumento,
                    'formatos' => $formatos,
                    'controlador' => $controlador,
                    'idDocumento' => $idDocumento,
                );
                break;

            case 'POST':
                break;
        }
        return array('template' => '_Emergente/formatosDocumentos.html.twig', 'values' => $this->values);
    }

    /**
     * Renderiza el template _Emergente/historicoCompras.html.twig
     * mostrando las compras realizadas a un proveedor de un articulo dado.
     * La información se obtiene en base a los pedidos confimardos o facturados.
     * No se tienen en cuenta los pedidos no confirmados.
     *
     * Puede entrar por POST o por GET. Los parámetros vienen en
     * idArticulo y idProveedor si es por POST, o
     * posicion 2 (idArticulo) y 3 (idProveedor) si es por GET
     *
     * @return array El template y los datos
     */
    public function HistoricoComprasAction() {

        switch ($this->request["METHOD"]) {
            case 'GET':
                $idArticulo = $this->request['2'];
                $idProveedor = $this->request['3'];
                break;
            case 'POST':
                $idArticulo = $this->request['idArticulo'];
                $idProveedor = $this->request['idProveedor'];
                break;
        }

        $articulo = new Articulos($idArticulo);
        $proveedor = new Proveedores($idProveedor);


        // Calcular el total de unidades compradas y el precio medio de venta
        // Solo calcula los pedidos que están confirmados o facturados
        $em = new EntityManager("datos" . $_SESSION['emp']);
        if ($em->getDbLink()) {
            $query = "SELECT SUM(t1.Unidades) as Unidades, SUM(t1.Importe) as Importe
                FROM pedidos_lineas as t1, pedidos_cab as t2
                WHERE t1.IDPedido=t2.IDPedido
                AND t2.IDProveedor='{$idProveedor}'
                AND t1.IDArticulo='{$idArticulo}'
                AND t2.IDEstado<>'0'";
            $em->query($query);
            $rows = $em->fetchResult();
            $em->desConecta();
        }

        ($rows[0]['Unidades'] != 0) ? $precioMedio = $rows[0]['Importe'] / $rows[0]['Unidades'] : $precioMedio = 0;
        ($rows[0]['Unidades'] == '') ? $unidades = 0 : $unidades = $rows['0']['Unidades'];

        $this->values['datos'] = array(
            'idsucursal' => $_SESSION['suc'],
            'articulo' => $articulo,
            'proveedor' => $proveedor,
            'unidades' => $unidades,
            'precioMedio' => number_format($precioMedio, 3),
        );

        // Obtener el litado historico de compras para el articulo y proveedor
        // Solo muestra los pedidos que están confirmador o facturados
        $em = new EntityManager("datos" . $_SESSION['emp']);
        if ($em->getDbLink()) {
            $query = "SELECT t2.IDLinea,t1.IDPedido,DATE_FORMAT(t1.Fecha,'%d-%m-%Y') as Fecha,t2.Unidades,t2.Precio,t2.Descuento,t2.Importe
                FROM pedidos_cab as t1, pedidos_lineas as t2, proveedores as t3
                WHERE t1.IDPedido=t2.IDPedido
                AND t1.IDProveedor=t3.IDProveedor
                AND t1.IDProveedor='{$idProveedor}'
                AND t2.IDArticulo='{$idArticulo}'
                AND t1.IDEstado<>'0'
                ORDER BY t1.Fecha DESC";
            $em->query($query);
            $rows = $em->fetchResult();
            $em->desConecta();
        }

        $this->values['listado'] = $rows;

        unset($em);
        unset($articulo);
        unset($cliente);

        return array('template' => '_Emergente/historicoCompras.html.twig', 'values' => $this->values);
    }

    /**
     * Renderiza el template _Emergente/historicoVentas.html.twig
     * mostrando las ventas realizadas a un cliente de un articulo dado.
     * La información se obtiene en base a los albaranes confimardos o facturados.
     * No se tienen en cuenta los albaranes no confirmados.
     *
     * Puede entrar por POST o por GET. Los parámetros vienen en
     * idArticulo y idCliente si es por POST, o
     * posicion 2 (idArticulo) y 3 (idCliente) si es por GET
     *
     * @return array El template y los datos
     */
    public function HistoricoVentasAction() {

        switch ($this->request["METHOD"]) {
            case 'GET':
                $idArticulo = $this->request['2'];
                $idCliente = $this->request['3'];
                break;
            case 'POST':
                $idArticulo = $this->request['idArticulo'];
                $idCliente = $this->request['idCliente'];
                break;
        }

        $articulo = new Articulos($idArticulo);
        $cliente = new Clientes($idCliente);


        // Calcular el total de unidades vendidas y el precio medio de venta
        // Solo calcula los albaranes que están confirmados o facturados
        $em = new EntityManager("datos" . $_SESSION['emp']);
        if ($em->getDbLink()) {
            $query = "SELECT SUM(t1.Unidades) as Unidades, SUM(t1.Importe) as Importe
                FROM albaranes_lineas as t1, albaranes_cab as t2
                WHERE t1.IDAlbaran=t2.IDAlbaran
                AND t2.IDCliente='{$idCliente}'
                AND t1.IDArticulo='{$idArticulo}'
                AND t2.IDEstado<>'0'";
            $em->query($query);
            $rows = $em->fetchResult();
            $em->desConecta();
        }

        ($rows[0]['Unidades'] != 0) ? $precioMedio = $rows[0]['Importe'] / $rows[0]['Unidades'] : $precioMedio = 0;
        ($rows[0]['Unidades'] == '') ? $unidades = 0 : $unidades = $rows['0']['Unidades'];

        $this->values['datos'] = array(
            'idsucursal' => $_SESSION['suc'],
            'articulo' => $articulo,
            'cliente' => $cliente,
            'unidades' => $unidades,
            'precioMedio' => number_format($precioMedio, 3),
        );

        // Obtener el litado historico de ventas para el articulo y cliente
        // Solo muestra los albaranes que están confirmador o facturados
        $em = new EntityManager("datos" . $_SESSION['emp']);
        if ($em->getDbLink()) {
            $query = "SELECT t2.IDLinea,t1.IDAlbaran,t1.NumeroAlbaran,DATE_FORMAT(t1.Fecha,'%d-%m-%Y') as Fecha,t2.Unidades,t2.Precio,t2.Descuento,t2.Importe,t2.IDPromocion
                FROM albaranes_cab as t1, albaranes_lineas as t2, clientes as t3
                WHERE t1.IDAlbaran=t2.IDAlbaran
                AND t1.IDCliente=t3.IDCliente
                AND t1.IDCliente='{$idCliente}'
                AND t2.IDArticulo='{$idArticulo}'
                AND t1.IDEstado<>'0'
                ORDER BY t1.Fecha DESC";
            $em->query($query);
            $rows = $em->fetchResult();
            $em->desConecta();
        }
        // Recorro el array de resultados y convierto (si procede) la columna IDPromocion
        // en un objeto promocion para tener todos los datos de la promocion en el template.
        foreach ($rows as $key => $value) {
            if ($value['IDPromocion'])
                $rows[$key]['IDPromocion'] = new Promociones($value['IDPromocion']);
        }

        $this->values['listado'] = $rows;

        unset($em);
        unset($articulo);
        unset($cliente);

        return array('template' => '_Emergente/historicoVentas.html.twig', 'values' => $this->values);
    }

}

?>