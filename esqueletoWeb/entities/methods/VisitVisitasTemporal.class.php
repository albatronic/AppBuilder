<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 26.11.2012 17:23:42
 */

/**
 * @orm:Entity(VisitVisitasTemporal)
 */
class VisitVisitasTemporal extends VisitVisitasTemporalEntity {

    public function __toString() {
        return $this->getId();
    }

    /**
     * Borra registros antiguos en la tabla temporal de visitas
     * 
     * Borra todos los registros cuyo tiempo UNIX es anterior a $horas
     * 
     * Si no se indica $horas, se utilizará para el cálculo la variable
     * de sesión $_SESSION['frecuenciaHorasBorrado'] que está alimentada
     * con el parámetro 'frecuenciaHorasBorrado' del config/config.yml
     * 
     * @param integer $horas El nº de horas 
     * @return integer El número de registros borrados
     */
    public function borraTemporal($horas = '') {

        $nRegistrosBorrados = 0;

        if ($horas == '')
            $aPartirDe = time() - $_SESSION['frecuenciaHorasBorrado'] * 3600;
        else
            $aPartirDe = time() - $horas * 3600;

        $em = new EntityManager($this->getConectionName());
        if ($em->getDbLink()) {
            $query = "delete from {$this->getDataBaseName()}.CpanVisitasTemporal where TiempoUnix<={$aPartirDe}";
            $em->query($query);
            $nRegistrosBorrados = $em->getAffectedRows();
            $_SESSION['borradoTemporalVisitas'] = ( count($em->getError()) == 0 );
            $em->desConecta();
        }
        unset($em);

        return $nRegistrosBorrados;
    }

    /**
     * Incrementa el número de visitas UNICAS para la url amigable $idUrlAmigable
     * 
     * Para ello se apoya en la tabla temporal de visitas donde se van
     * registrando las visitas por sesion e id de url. Si en dicha tabla
     * ya existe una entrada para la misma sesion e id de url, no se incrementa
     * el número de visitas de la url, ya que en este caso significa que durante
     * la misma sesion se ha visitado varias veces la misma url.
     * 
     * @param integer $idUrlAmigable El id de la url amigable
     */
    public function anotaVisitaUrlUnica($idUrlAmigable) {

        $rows = $this->cargaCondicion('Id', "Sesion='{$_SESSION['IdSesion']}' AND IdUrlAmigable='{$idUrlAmigable}'");

        if (count($rows) == 0) {
            // Crear la entrada en la tabla temporal
            $this->setSesion($_SESSION['IdSesion']);
            $this->setIdUrlAmigable($idUrlAmigable);
            $this->setTiempoUnix(time());
            $this->create();

            // Incrementar las visitas de la url amigable
            $url = new CpanUrlAmigables($idUrlAmigable);
            $url->setNumberVisits($url->getNumberVisits() + 1);
            $url->save();
            unset($url);
        }
    }

}

?>