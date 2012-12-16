<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 26.11.2012 17:22:25
 */

/**
 * @orm:Entity(VisitVisitas)
 */
class VisitVisitas extends VisitVisitasEntity {

    public function __toString() {
        return $this->getId();
    }

    /**
     * Anota la visita actual en el registro de visitas
     * 
     * El registro de visitas se gestiona con dos tablas, una de cabecera
     * con la información general de la visita (fecha y hora de inicio, duración total,
     * origen de la visita, navegador, etc) y otra tabla para el detalle (itinerario)
     * de toda la visita (urls visitadas y tiempo empleado)
     * 
     * Este método se encarga de toda la gestión:
     * 
     * - Crea la cabecera de la visita
     * - Crea el registro de detalle
     * - Actualiza el tiempo empleado en el registro de detalle anterior
     * - Actualiza el tiempo total de la visita en el registro de cabecera
     * 
     * @param array $request La información del request
     */
    public function anotaVisita($request) {

        $visita = $this->find('Sesion', $_SESSION['IdSesion']);

        $idVisita = $visita->getId();

        if (!$idVisita) {
            // Es la primera visita para esta sesión. Creo el registro de cabecera
            $visita->setSesion($_SESSION['IdSesion']);
            $visita->setTiempoUnix(time());
            $visita->setHost($_SESSION['origen']['Host']);
            $visita->setIpAddress($_SESSION['origen']['IpAddress']);
            $visita->setCodigoPais($_SESSION['origen']['CodigoPais']);
            $visita->setNombrePais($_SESSION['origen']['NombrePais']);
            $visita->setCodigoRegion($_SESSION['origen']['CodigoRegion']);
            $visita->setNombreRegion($_SESSION['origen']['NombreRegion']);
            $visita->setCiudad($_SESSION['origen']['Ciudad']);
            $visita->setCodigoPostal($_SESSION['origen']['CodigoPostal']);
            $visita->setLatitud($_SESSION['origen']['Latitud']);
            $visita->setLongitud($_SESSION['origen']['Longitud']);
            $visita->setISP($_SESSION['origen']['ISP']);
            $visita->setOrganizacion($_SESSION['origen']['Organizacion']);
            $visita->setUrlOrigen($_SERVER['HTTP_REFERER']);
            
            $browser = new Browser();

            $visita->setBrowser($browser->getBrowser());
            $visita->setBrowserVersion($browser->getVersion());
            $visita->setPlatform($browser->getPlatform());
            $visita->setUserAgent($browser->getUserAgent());
            $visita->setIsMobile($browser->isMobile());
            $visita->setIsRobot($browser->isRobot());
            $visita->setIsAol($browser->isAol());
            $visita->setAolVersion($browser->getAolVersion());
            $visita->setIsChromeFrame($browser->isChromeFrame());

            unset($browser);

            $idVisita = $visita->create();
        }

        // Crear el registro de detalle de la visita
        $itinerario = new VisitVisitasItinerarios();
        $itinerario->anotaDetalle($idVisita, $request);
        unset($itinerario);
    }

}

?>