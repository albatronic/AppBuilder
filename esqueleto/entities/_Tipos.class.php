<?php

/*
 * Class Tipos
 *
 * Definición de todos los valores estáticos de
 * diferentes entidades. Son los valores de tipo 'ENUM'
 * que pueden contener las propiedades de las entidades.
 *
 * El método fetchAll() devuelve los valores para que
 * los formulario rendericen los desplegables de valores
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC, SL
 * @date 08.06.2011
 */

class Tipos {

    private $IDTipo;
    private $Descripcion;

    public function __construct($IDTipo=null) {
        if (isset($IDTipo)) {
            foreach ($this->tipos as $key => $value) {
                if ($value['Id'] == $IDTipo) {
                    $this->IDTipo = $this->tipos[$key]['Id'];
                    $this->Descripcion = $this->tipos[$key]['Value'];
                    return;
                } else {
                    $this->IDTipo = null;
                    $this->Descripcion = "** NO DEFINIDO **";
                }
            }
        }
    }

    public function fetchAll() {
        return $this->tipos;
    }

    public function getIDTipo() {
        return $this->IDTipo;
    }

    public function getDescripcion() {
        return $this->Descripcion;
    }

    public function __toString() {
        return $this->getDescripcion();
    }

}

/**
 * VALORES SI o NO
 */
class ValoresSN extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'No'),
        array('Id' => '1', 'Value' => 'Si'),
    );

}

/**
 * Rolles de usuarios
 */
class Roles extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'Admon'),
        array('Id' => '1', 'Value' => 'Comercial'),
        array('Id' => '2', 'Value' => 'Repartidor'),
        array('Id' => '3', 'Value' => 'Almacenero'),
    );

}

/**
 * DIAS DE LA SEMANA
 */
class DiasSemana extends Tipos {

    protected $tipos = array(
        array('Id' => '1', 'Value' => 'Lunes'),
        array('Id' => '2', 'Value' => 'Martes'),
        array('Id' => '3', 'Value' => 'Miércoles'),
        array('Id' => '4', 'Value' => 'Jueves'),
        array('Id' => '5', 'Value' => 'Viernes'),
        array('Id' => '6', 'Value' => 'Sábado'),
        array('Id' => '7', 'Value' => 'Domingo'),
    );

}

/**
 * ESTADOS RECIBOS CLIENTES
 */
class EstadosRecibosClientes extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'En cartera'),
        array('Id' => '1', 'Value' => 'Descontado'),
        array('Id' => '2', 'Value' => 'Al Vcto'),
        array('Id' => '3', 'Value' => 'Endosado'),
        array('Id' => '4', 'Value' => 'Cobrado'),
    );

}

/**
 * ESTADOS RECIBOS PROVEEDORES
 */
class EstadosRecibosProveedores extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'Pendiente'),
        array('Id' => '1', 'Value' => 'Endosado'),
        array('Id' => '2', 'Value' => 'Pagado'),
    );

}

/**
 * ESTADOS DE PRESUPUESTOS
 */
class EstadosPresupuestos extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'Pte. Confirmar'),
        array('Id' => '1', 'Value' => 'Confirmado')
    );

}

/**
 * ESTADOS DE ALBARANES
 */
class EstadosAlbaranes extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'Pte. Confirmar'),
        array('Id' => '1', 'Value' => 'Confirmado'),
        array('Id' => '2', 'Value' => 'Expedido')
    );

}

/**
 * ESTADOS DE LINEAS DE ALBARANES
 */
class EstadosLineasAlbaranes extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'Pte. Confirmar'),
        array('Id' => '1', 'Value' => 'Reservado'),
        array('Id' => '2', 'Value' => 'Expedido')
    );

}

/**
 * ESTADOS DE PEDIDOS
 */
class EstadosPedidos extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'Pte. Confirmar'),
        array('Id' => '1', 'Value' => 'Confirmado'),
        array('Id' => '2', 'Value' => 'Recepcionado'),
        array('Id' => '3', 'Value' => 'Facturado'),
    );

}

/**
 * ESTADOS DE LINEAS DE PEDIDOS
 */
class EstadosLineasPedidos extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'Pte. Confirmar'),
        array('Id' => '1', 'Value' => 'Entrando'),
        array('Id' => '2', 'Value' => 'Recepcionado'),
        array('Id' => '3', 'Value' => 'Facturado'),
    );

}

/**
 * ESTADOS DE TRASPASOS
 */
class EstadosTraspasos extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'Elaboracion'),
        array('Id' => '1', 'Value' => 'Enviado'),
        array('Id' => '2', 'Value' => 'Recibido')
    );

}

/**
 * TIPOS DE ALMACENES
 */
class AlmacenesTipos extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => 'Propio'),
        array('Id' => '1', 'Value' => 'Logístico'),
    );

}

/**
 * SIGNOS DE MOVIMITOS DE ALMACEN
 */
class SignosMvtosAlmacen extends Tipos {

    protected $tipos = array(
        array('Id' => 'E', 'Value' => 'Entrada'),
        array('Id' => 'S', 'Value' => 'Salida'),
    );

}

/**
 * TIPOS DE DOCUMENTOS PARA LOS TIPOS DE MOVIMIENTOS DE ALMACEN
 */
class DocumentosMvtosAlmacen extends Tipos {

    protected $tipos = array(
        array('Id' => 'AL', 'Value' => 'Albaran'),
        array('Id' => 'PE', 'Value' => 'Pedido'),
        array('Id' => 'TR', 'Value' => 'Traspaso'),
    );

}

/**
 * TIPOS DE TARIFAS
 */
class TarifasTipos extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => '% Dcto'),
        array('Id' => '1', 'Value' => '% Margen'),
    );

}

/**
 * TIPOS DE PROMOCIONES
 */
class PromocionesTipos extends Tipos {

    protected $tipos = array(
        array('Id' => '0', 'Value' => '% Dcto'),
        array('Id' => '1', 'Value' => '% Margen'),
        array('Id' => '2', 'Value' => 'Precio Neto'),
    );

}

/**
 * TIPOS DE DOCUMENTOS
 */
class DocumentosTipos extends Tipos {

    protected $tipos = array(
        array('Id' => 'AL', 'Value' => 'Albarán'),
        array('Id' => 'FE', 'Value' => 'Factura Emitida'),
        array('Id' => 'FR', 'Value' => 'Factura Recibida'),
        array('Id' => 'PR', 'Value' => 'Presupuesto'),
        array('Id' => 'TR', 'Value' => 'Traspaso'),
        array('Id' => 'ET', 'Value' => 'Etiqueta'),
        array('Id' => 'TI', 'Value' => 'Ticket'),
        array('Id' => 'PE', 'Value' => 'Pedido'),
    );

}

class DocumentosOrientacion extends Tipos {

    protected $tipos = array(
        array('Id' => '1', 'Value' => 'Vertical'),
        array('Id' => '2', 'Value' => 'Apaisado'),
    );

}

/**
 * Formatos de Papel
 */
class PapelFormato extends Tipos {

    protected $tipos = array(
        array('Id' => '1', 'Value' => 'Hojas Sueltas'),
        array('Id' => '2', 'Value' => 'Papel Continuo'),
    );

}

?>
