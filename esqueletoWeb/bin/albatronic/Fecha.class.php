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
        "([0-9]{1,2})([0-9]{1,2})([0-9]{4}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", //ddmmaaaa hh:mm:ss
        "([0-9]{1,2})/([0-9]{1,2})/([0-9]{4}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", //dd/mm/aaaa hh:mm:ss
        "([0-9]{1,2})-([0-9]{1,2})-([0-9]{4}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", //dd-mm-aaaa hh:mm:ss
        "([0-9]{1,2}).([0-9]{1,2}).([0-9]{4}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", //dd.mm.aaaa hh:mm:ss

        "([0-9]{4})([0-9]{1,2})([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", //aaaammdd hh:mm:ss
        "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", //aaaa/mm/dd hh:mm:ss
        "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", //aaaa-mm-dd hh:mm:ss
        "([0-9]{4}).([0-9]{1,2}).([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", //aaaa.mm.dd hh:mm:ss

        "([0-9]{1,2})([0-9]{1,2})([0-9]{4})", //ddmmaaaa
        "([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", //dd-mm-aaaa
        "([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", //dd/mm/aaaa
        "([0-9]{1,2}).([0-9]{1,2}).([0-9]{4})", //dd.mm.aaaa

        "([0-9]{4})([0-9]{1,2})([0-9]{1,2})", //aaaammdd
        "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", //aaaa-mm-dd
        "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})", //aaaa/mm/dd
        "([0-9]{4}).([0-9]{1,2}).([0-9]{1,2})", //aaaa.mm.dd
    );

    public function __construct($fecha = '') {
        $formatoCorrecto = 0;

        if ($fecha == '')
            $fecha = date('d-m-Y H:i:s');

        //Buscar en que formato viene la fecha. Lo indicará el valor del índice $i
        for ($i = 0; $i < count($this->plantilla); $i++) {
            if (ereg($this->plantilla[$i], $fecha, $registro)) {
                $formatoCorrecto = 1;
                break;
            }
        }

        if ($formatoCorrecto) {
            switch ($i) {
                case '0': // Formato datetime ddmmaaaa
                case '1':
                case '2':
                case '3':
                    $this->dia = $registro[1];
                    $this->mes = $registro[2];
                    $this->anio = $registro[3];
                    $this->hora = $registro[4];
                    $this->minutos = $registro[5];
                    $this->segundos = $registro[6];
                    $this->time = $this->hora . ":" . $this->minutos . ":" . $this->segundos;
                    $this->esDateTime = TRUE;
                    break;
                case '4': // Formato datetime aaaammdd
                case '5':
                case '6':
                case '7':
                    $this->dia = $registro[3];
                    $this->mes = $registro[2];
                    $this->anio = $registro[1];
                    $this->hora = $registro[4];
                    $this->minutos = $registro[5];
                    $this->segundos = $registro[6];
                    $this->time = $this->hora . ":" . $this->minutos . ":" . $this->segundos;
                    $this->esDateTime = TRUE;
                    break;
                case '8': // Formato date ddmmaaaa
                case '9':
                case '10':
                case '11':
                    $this->dia = $registro[1];
                    $this->mes = $registro[2];
                    $this->anio = $registro[3];
                    break;
                case '12': // Formato date aaammdd
                case '13':
                case '14':
                case '15':
                    $this->dia = $registro[3];
                    $this->mes = $registro[2];
                    $this->anio = $registro[1];
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