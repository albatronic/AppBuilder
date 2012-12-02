<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 26.11.2012 17:23:06
 */

/**
 * @orm:Entity(VisitVisitasItinerarios)
 */
class VisitVisitasItinerarios extends VisitVisitasItinerariosEntity {

    public function __toString() {
        return $this->getId();
    }

    /**
     * Crea un detalle de la visita en el registro de itinerario
     * Anotando el tiempo empleado en el itinerario anterior y
     * acumulando el tiempo en el registro cabecera de visita
     * 
     * @param integer $idVisita El id del registro padre de la visita
     * @param array $request Array con los valores del request
     * @return integer El id del detalle de la visitia creado
     */
    public function anotaDetalle($idVisita, $request) {

        $diferencia = 0;

        // Buscar el eventual registro de itinerario justamente anterior
        // Si existe, actualizo los segundos que ha estado en esa visita
        // en base a la diferencia de tiempo entre el tiempo actual y el tiempo
        // en el que entró.

        $detalleVisita = new VisitVisitasItinerarios();
        $rows = $detalleVisita->cargaCondicion("Id", "IdVisita='{$idVisita}'", "Id DESC limit 1");
        if (count($rows)) {
            $detalleVisita = new VisitVisitasItinerarios($rows[0]['Id']);
            $diferencia = time() - $detalleVisita->getTiempoUnix();
            $detalleVisita->setSegundosVisita($diferencia);
            $detalleVisita->save();
        }
        unset($detalleVisita);

        // Crear el registro de itinerario actual
        $this->setIdVisita($idVisita);
        $this->setIdUsuario($_SESSION['USER']['user']['Id']);
        $this->setEntidad($request['Entity']);
        $this->setIdEntidad($request['IdEntity']);
        $this->setTiempoUnix(time());
        $idItinerario = $this->create();

        if ($idItinerario) {
            // Incrementar el registro de visita cabacera
            $visita = $this->getIdVisita();
            $visita->setSegundosVisita($visita->getSegundosVisita() + $diferencia);
            $visita->save();
            unset($visita);
        }

        return $idItinerario;
    }

}

?>