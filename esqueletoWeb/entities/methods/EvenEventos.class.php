<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 26.11.2012 17:52:26
 */

/**
 * @orm:Entity(EvenEventos)
 */
class EvenEventos extends EvenEventosEntity {

    public function __toString() {
        return $this->getId();
    }

    /*
     * Calcula el número de eventos que hay en el período de tiempo $periodo
     * para el valor $valor.
     * 
     * Los valores posibles para $periodo son:
     * 
     *      * 'a'  Año
     *      * 'sm' Semestre
     *      * 't'  Trimestre
     *      * 'm'  Mes
     *      * 's'  Semana
     *      * 'd'  Día
     * 
     * Ejemplos:
     *      getNumeroEventos('a','2012') Devuelte el nº de eventos del año 2012
     *      getNumeroEventos('d','1964-11-15') Devuelve el nº de eventos de ese día
     *      getNumeroEventos('t','2012-01') Devuelve el nº de eventos del primer TRIMESTRE del año 2012
     *      getNumeroEventos('m','2012-01') Devuelve el nº de eventos de ENERO del año 2012
     *      getNumeroEventos('sm','2012-01') Devuelve el nº de eventos del primer SEMESTRE del año 2012
     *      getNumeroEventos('s','2012-33') Devuelve el nº de eventos de la SEMANA 33 del año 2012
     */

    public function getNumeroEventos($periodo = 'd', $valor) {

        $nEventos = 0;

        $periodo = strtolower($periodo);

        if (in_array($periodo, array('a', 'sm', 't', 'm', 's', 'd'))) {
            switch ($periodo) {
                case 'a': // Año
                    $filtro = "YEAR(Fecha)='{$valor}'";
                    break;
                case 'sm': // Semestre
                    $anoSemestre = explode("-", $valor);
                    if ($anoSemestre[1] == 1)
                        $filtro = "MONTH(Fecha)>6";
                    else
                        $filtro = "MONTH(Fecha)<7";
                    $filtro = "YEAR(Fecha)='{$anoSemestre[0]}' AND " . $filtro;
                    break;
                case 't': // Trimestre
                    $anoTrimestre = explode("-", $valor);
                    $filtro = "YEAR(Fecha)='{$anoTrimestre[0]}' AND QUARTER(Fecha)='{$anoTrimestre[1]}'";
                    break;
                case 'm': //Mes
                    $anoMes = explode("-", $valor);
                    $filtro = "YEAR(Fecha)='{$anoMes[0]}' AND MONTH(Fecha)='{$anoMes[1]}'";
                    break;
                case 's': // Semana
                    $anoSemana = explode("-", $valor);
                    $filtro = "YEAR(Fecha)='{$anoSemana[0]}' AND WEEK(Fecha,1)='{$anoSemana[1]}'";
                    break;
                case 'd': // Día
                    $filtro = "Fecha='{$valor}'";
                    break;
                default:
                    break;
            }

            $rows = $this->cargaCondicion("COUNT(Id) nEventos", $filtro);
            $nEventos = $rows[0]['nEventos'];
        }

        return $nEventos;
    }

    /**
     * Devuelve un array con todos los eventos del $mes y $ano indicado
     * 
     * @param integer $mes El mes
     * @param integer $ano El año
     * @return array Array de eventos
     */
    public function getEnventosMes($mes, $ano) {

        $eventos = array();

        $rows = $this->cargaCondicion("Id,Fecha,HoraInicio,HoraFin,Entidad,IdEntidad", "MONTH(Fecha)='{$mes}' AND YEAR(Fecha)='{$ano}'", "Fecha DESC");
        foreach ($rows as $row) {
            $evento = new $row['Entidad']($rows['IdEntidad']);
            $eventos[] = array(
                'Id' => $row['Id'],
                'Fecha' => $row['Fecha'],
                'HoraInicio' => $row['HoraInicio'],
                'HoraFin' => $row['HoraFin'],
                'Titulo' => $evento->getTitulo(),
            );
        }
        unset($evento);

        return $eventos;
    }

    /**
     * Devuelve un array con los dias del mes en los que hay eventos
     * 
     * El índice del array es el ordinal del día del mes y el valor es
     * el número de eventos de ese día.
     * 
     * @param integer $mes El mes
     * @param integer $ano El año
     * @return array Array de pares dia=>nEventos
     */
    public function getDiasConEventos($mes, $ano) {

        $array = array();

        $this->conecta();
        if (is_resource($this->_dbLink)) {
            $query = "SELECT DAY(Fecha) dia, COUNT(Id) nEventos FROM `{$this->_dataBaseName}`.`{$this->_tableName}` WHERE MONTH(Fecha)='{$mes}' AND YEAR(Fecha)='{$ano}' GROUP BY dia";
            $this->_em->query($query);
            $this->setStatus($this->_em->numRows());
            $rows = $this->_em->fetchResult();
            $this->_em->desConecta();
        }
        unset($this->_em);

        foreach ($rows as $row)
            $array[$row['dia']] = $row['nEventos'];

        return $array;
    }

    /**
     * Devuelve el objeto del que es evento
     * 
     * @return \objeto
     */
    public function getObjetoEntidad() {
        return new $this->getEntidad($this->getIdEntidad());
    }

}

?>