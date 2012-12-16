<?php

/**
 * Class for fechas
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @since 28.09.2010 20:14:08
 * @verison 1.0
 *
 * MANEJO DE FECHAS
 *
 * RECIBE UNA FECHA EN CUALQUIERA DE LOS SIGUIENTES FORMATOS:
 * ddmmaaa, dd-mm-aaaa, dd/mm/aaaa, dd.mm.aaaa, aaaa-mm-dd, aaaa/mm/dd, aaaa.mm.dd
 * ddmmaaa hh:mm:ss, dd/mm/aaaa hh:mm:ss, etc
 * y lo almacena en $fecha en formato aaaa-mm-dd.
 *
 * SI NO SE INDICA FECHA, SE PONE LA DEL DÍA EN CURSO.
 *
 * Si la fecha recibida no fuese correcta, almacena en $fecha FALSE.
 *
 */
class Fecha {

    private $fecha;
    private $dia;
    private $mes;
    private $anio;
    private $hora = '00';
    private $minutos = '00';
    private $segundos = '00';
    private $time = '00:00:00';
    private $esDateTime = FALSE;
    private $plantilla = array(
        "/^\d{1,2}\d{1,2}\d{4} \d{2}:\d{2}:\d{2}$/", // ddmmaaaa hh:mm:ss
        "/^\d{1,2}.\d{1,2}.\d{4} \d{2}:\d{2}:\d{2}$/", // dd.mm.aaaa hh:mm:ss
        "/^\d{1,2}-\d{1,2}-\d{4} \d{2}:\d{2}:\d{2}$/", // dd-mm-aaaa hh:mm:ss    
        "/^\d{1,2}\/\d{1,2}\/\d{4} \d{2}:\d{2}:\d{2}$/", // dd/mm/aaaa hh:mm:ss      

        "/^\d{4}\d{1,2}\d{1,2} \d{2}:\d{2}:\d{2}$/", // aaaammdd hh:mm:ss
        "/^\d{4}.\d{1,2}.\d{1,2} \d{2}:\d{2}:\d{2}$/", // aaaa.mm.dd hh:mm:ss
        "/^\d{4}-\d{1,2}-\d{1,2} \d{2}:\d{2}:\d{2}$/", // aaaa-mm-dd hh:mm:ss    
        "/^\d{4}\/\d{1,2}\/\d{1,2} \d{2}:\d{2}:\d{2}$/", // aaaa/mm/dd hh:mm:ss  

        "/^\d{1,2}\d{1,2}\d{4}$/", // ddmmaaaa        
        "/^\d{1,2}.\d{1,2}.\d{4}$/", // dd.mm.aaaa        
        "/^\d{1,2}-\d{1,2}-\d{4}$/", // dd-mm-aaaa
        "/^\d{1,2}\/\d{1,2}\/\d{4}$/", // dd/mm/aaaa

        "/^\d{4}\d{1,2}\d{1,2}$/", // aaaammdd        
        "/^\d{4}.\d{1,2}.\d{1,2}$/", // aaaa.mm.dd        
        "/^\d{4}-\d{1,2}-\d{1,2}$/", // aaaa-mm-dd
        "/^\d{4}\/\d{1,2}\/\d{1,2}$/", // aaaa/mm/dd        
    );

    public function __construct($fecha = '') {
        $formatoCorrecto = 0;

        if ($fecha == '')
            $fecha = date('d-m-Y H:i:s');

        //Buscar en que formato viene la fecha. Lo indicará el valor del índice $i
        for ($i = 0; $i < count($this->plantilla); $i++) {
            if (preg_match($this->plantilla[$i], $fecha, $registro)) {
                $formatoCorrecto = 1;
                break;
            }
        }

        if ($formatoCorrecto) {
            switch ($i) {
                case '0': // Formato datetime ddmmaaaa hh:mm:ss
                    $this->dia = substr($registro[0], 0, 2);
                    $this->mes = substr($registro[0], 2, 2);
                    $this->anio = susbtr($registro[0], 4, 4);
                    $hora = explode(":", substr($registsro[0], -8));
                    $this->hora = $hora[0];
                    $this->minutos = $hora[1];
                    $this->segundos = $hora[2];
                    $this->time = $this->hora . ":" . $this->minutos . ":" . $this->segundos;
                    $this->esDateTime = TRUE;
                    break;
                case '1': // Formato datetime dd.mm.aaaa hh:mm:ss
                    $fecha = explode(".", substr($registro[0], 0, 10));
                    $this->dia = $fecha[0];
                    $this->mes = $fecha[1];
                    $this->anio = $fecha[2];
                    $hora = explode(":", substr($registsro[0], -8));
                    $this->hora = $hora[0];
                    $this->minutos = $hora[1];
                    $this->segundos = $hora[2];
                    $this->time = $this->hora . ":" . $this->minutos . ":" . $this->segundos;
                    $this->esDateTime = TRUE;
                case '2': // Formato datetime dd-mm/aaaa hh:mm:ss
                    $fecha = explode("-", substr($registro[0], 0, 10));
                    $this->dia = $fecha[0];
                    $this->mes = $fecha[1];
                    $this->anio = $fecha[2];
                    $hora = explode(":", substr($registsro[0], -8));
                    $this->hora = $hora[0];
                    $this->minutos = $hora[1];
                    $this->segundos = $hora[2];
                    $this->time = $this->hora . ":" . $this->minutos . ":" . $this->segundos;
                    $this->esDateTime = TRUE;
                case '3': // Formato datetime dd/mm/aaaa hh:mm:ss
                    $fecha = explode("/", substr($registro[0], 0, 10));
                    $this->dia = $fecha[0];
                    $this->mes = $fecha[1];
                    $this->anio = $fecha[2];
                    $hora = explode(":", substr($registsro[0], -8));
                    $this->hora = $hora[0];
                    $this->minutos = $hora[1];
                    $this->segundos = $hora[2];
                    $this->time = $this->hora . ":" . $this->minutos . ":" . $this->segundos;
                    $this->esDateTime = TRUE;
                    break;
                case '4': // Formato datetime aaaammdd hh:mm:ss
                    $this->dia = substr($registro[0], 6, 2);
                    $this->mes = substr($registro[0], 4, 2);
                    $this->anio = susbtr($registro[0], 0, 4);
                    $hora = explode(":", substr($registsro[0], -8));
                    $this->hora = $hora[0];
                    $this->minutos = $hora[1];
                    $this->segundos = $hora[2];
                    $this->time = $this->hora . ":" . $this->minutos . ":" . $this->segundos;
                    $this->esDateTime = TRUE;
                    break;
                case '5': // Formato datetime aaaa.mm.dd hh:mm:ss
                    $fecha = explode(".", substr($registro[0], 0, 10));
                    $this->dia = $fecha[2];
                    $this->mes = $fecha[1];
                    $this->anio = $fecha[0];
                    $hora = explode(":", substr($registsro[0], -8));
                    $this->hora = $hora[0];
                    $this->minutos = $hora[1];
                    $this->segundos = $hora[2];
                    $this->time = $this->hora . ":" . $this->minutos . ":" . $this->segundos;
                    $this->esDateTime = TRUE;
                    break;
                case '6': // Formato datetime aaaa-mm-dd hh:mm:ss
                    $fecha = explode("-", substr($registro[0], 0, 10));
                    $this->dia = $fecha[2];
                    $this->mes = $fecha[1];
                    $this->anio = $fecha[0];
                    $hora = explode(":", substr($registsro[0], -8));
                    $this->hora = $hora[0];
                    $this->minutos = $hora[1];
                    $this->segundos = $hora[2];
                    $this->time = $this->hora . ":" . $this->minutos . ":" . $this->segundos;
                    $this->esDateTime = TRUE;
                    break;
                case '7': // Formato datetime aaaa/mm/dd hh:mm:ss
                    $fecha = explode("/", substr($registro[0], 0, 10));
                    $this->dia = $fecha[2];
                    $this->mes = $fecha[1];
                    $this->anio = $fecha[0];
                    $hora = explode(":", substr($registsro[0], -8));
                    $this->hora = $hora[0];
                    $this->minutos = $hora[1];
                    $this->segundos = $hora[2];
                    $this->time = $this->hora . ":" . $this->minutos . ":" . $this->segundos;
                    $this->esDateTime = TRUE;
                    break;
                case '8': // Formato date ddmmaaaa
                    $this->dia = substr($registro[0], 0, 2);
                    $this->mes = substr($registro[0], 2, 2);
                    $this->anio = susbtr($registro[0], 4, 4);
                    $this->esDateTime = FALSE;
                    break;
                case '9': // Formato date dd.mm.aaaa
                case '10': // Formato date dd-mm-aaaa
                case '11': // Formato date dd/mm/aaaa
                    $fecha = explode("/", substr($registro[0], 0, 10));
                    $this->dia = substr($registro[0], 0, 2);
                    $this->mes = substr($registro[0], 3, 2);
                    $this->anio = substr($registro[0], 6, 4);
                    $this->esDateTime = FALSE;
                    break;
                case '12': // Formato date aaaammdd
                    $this->dia = substr($registro[0], -2);
                    $this->mes = substr($registro[0], 4, 2);
                    $this->anio = susbtr($registro[0], 0, 4);
                    $this->esDateTime = FALSE;
                    break;
                case '13': // Formato date aaaa.mm.dd
                case '14': // Formato date aaaa-mm-dd
                case '15': // Formato date aaaa/mm/dd
                    $this->dia = substr($registro[0], -2);
                    $this->mes = substr($registro[0], 5, 2);
                    $this->anio = substr($registro[0], 0, 4);
                    $this->esDateTime = FALSE;
                    break;
            }
            $this->fecha = $this->anio . "-" . $this->mes . "-" . $this->dia;
        } else
            $this->fecha = false;
    }

    /**
     * Devuelve la fecha en formato dd/mm/aaaa
     * @return string
     */
    public function getddmmaaaa() {
        if ($this->fecha)
            return $this->dia . "/" . $this->mes . "/" . $this->anio;
        else
            return "00/00/0000";
    }

    /**
     * Devuelve la fecha en formato aaaa/mm/dd
     * @return string
     */
    public function getaaaammdd() {
        if ($this->fecha)
            return $this->anio . "/" . $this->mes . "/" . $this->dia;
        else
            return "0000/00/00";
    }

    /**
     * Devuelve el año de la fecha en formato aaaa
     * @return string
     */
    public function getaaaa() {
        if ($this->fecha)
            return $this->anio;
        else
            return "0000";
    }

    /**
     * Devuelve el mes de la fecha en formato mm
     * @return string El mes
     */
    public function getmm() {
        if ($this->fecha)
            return $this->mes;
        else
            return "00";
    }

    /**
     * Devuelve el mes de la fecha en formato literal
     * @return string El mes
     */
    public function getMes() {
        if ($this->fecha)
            return date('M', $this->mes);
    }

    /**
     * Devuelve el dia de la fecha en formato dd
     * @return string
     */
    public function getdd() {
        if ($this->fecha)
            return $this->dia;
        else
            return "00";
    }

    /**
     * Le suma o resta días a la fecha actual y devuelve la fecha resultante
     * @param integer $dias Numero de días a sumar o restar
     * @return date  La nueva fecha calculada
     */
    public function sumaDias($dias) {
        return date('Y-m-d', mktime(0, 0, 0, $this->getmm(), $this->getdd() + $dias, $this->getaaaa()));
    }

    /**
     * Devuelve la fecha en formato aaaa-mm-dd
     * @return string
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Devuelve la hora en formato hh:mm:ss
     * @return string
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * Devuelve la fecha y la hora en formato aaaa-mm-dd hh:mm:ss
     * @return string
     */
    public function getFechaTime() {
        return $this->fecha . " " . $this->time;
    }

    /**
     * Devuelve la hora en formato hh
     * @return string
     */
    public function getHora() {
        return $this->hora;
    }

    /**
     * Devuelve los minutos en formato mm
     * @return string
     */
    public function getMinutos() {
        return $this->minutos;
    }

    /**
     * Devuelve los segundos en formato ss
     * @return string
     */
    public function getSegundos() {
        return $this->segundos;
    }

    /**
     * Devuelve la fecha en formato dd/mm/aaaa hh:mm:ss
     * @return string
     */
    public function getddmmaaaahhmmss() {
        if ($this->fecha)
            return $this->dia . "/" . $this->mes . "/" . $this->anio . " " . $this->hora . ":" . $this->minutos . ":" . $this->segundos;
        else
            return "00/00/0000 00:00:00";
    }

    /**
     * Devuelve la representación numérica ISO-8601 del día
     * de la semana (1 para Lunes ... 7 para Domingo)
     */
    public function getDiaSemana() {
        return date("N", mktime(0, 0, 0, $this->getmm(), $this->getdd(), $this->getaaaa()));
    }

    /**
     * Devuelve TRUE si la fecha está en formato datetime
     * @return boolean
     */
    public function getEsDateTime() {
        return $this->esDateTime;
    }

}

?>