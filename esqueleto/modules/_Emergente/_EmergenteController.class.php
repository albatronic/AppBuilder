<?php

/**
 * CONTROLADOR MULTIPROPOSITO PARA REDENRIZAR INFORMACION EN PANTALLAS EMERGENTES
 *
 * LA INFORMACION QUE SE MOSTRARA DEPENDE DEL METODO LLAMADO
 *
 * @author: Sergio Perez <sergio.perez@albatronic.com>
 * @copyright: INFORMATICA ALBATRONIC SL 
 * @date 27.07.2011 11:10:13

 * Extiende a la clase controller
 */
class _EmergenteController extends controller {

    protected $entity = "";

    public function __construct($request) {

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
                $idArticulo = $this->request['3'];
                $idAlmacen = $this->request['4'];
                $condicion = " JOIN albaranes_cab USING(IDAlbaran) where t1.IDAlmacen='{$idAlmacen}' and t1.IDArticulo='{$idArticulo}' and t1.IDEstado='1' ";
                $query = "select IDLinea from albaranes_lineas as t1 {$condicion} order by albaranes_cab.Fecha ASC";
                $em = new entityManager("datos" . $_SESSION['emp']);
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
                $idArticulo = $this->request['3'];
                $idAlmacen = $this->request['4'];
                $condicion = " JOIN pedidos_cab USING(IDPedido) where t1.IDAlmacen='{$idAlmacen}' and t1.IDArticulo='{$idArticulo}' and t1.IDEstado='1' ";
                $query = "select IDLinea from pedidos_lineas as t1 {$condicion} order by pedidos_cab.FechaEntrega ASC";
                $em = new entityManager("datos" . $_SESSION['emp']);
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
     * el tipo de documento indicado como parámetro o en la posicion 3 del request
     *
     * El controlador que generará el documento viene en la posicion 4 del request
     * El id del objeto a imprimir viene en la posicion 5 del request
     *
     * Los formatos están definidos en  docs/docsXXX/tipoDocumento.xml
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
                    $tipoDocumento = $this->request['3'];

                $controlador = $this->request['4'];
                $idDocumento = $this->request['5'];
                $formatos = array();

                $file = "docs/docs" . $_SESSION['emp'] . "/formats/" . $tipoDocumento . ".xml";
                $xml = new xmlRead($file);

                $perfilUsuario = $_SESSION['USER']['user']['IDPerfil'];
                $i = 0;
                foreach ($xml->getXml() as $formato) {
                    $perfiles = (string) $formato->idPerfil;
                    $arrayPerfiles = explode(',', $perfiles);
                    if (($perfiles == '') or (in_array($perfilUsuario, $arrayPerfiles)))
                        $formatos[] = array(
                            'Id' => $i++,
                            'Value' => (string) $formato->title
                        );
                }
                unset($xml);

                $this->values = array(
                    'numeroDeFormatos' => count($formatos),
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

}

?>