<?php

/**
 * CLASS password
 *
 * GENERA CONTRASEÑAS ALEATORIAS DE LONGITUD $longitud
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC, SL
 * @version 1.0 30.08.2011
 */

class Password {

    private $longitud;
    /**
     * Asignamos el juego de caracteres al array $caracteres para generar la contraseña.
     * Podemos añadir mas caracteres para hacer mas segura la contraseña.
     * @var string
     */
    private $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    /**
     * Se valida la longitud proporcionada. Debe ser numero y mayor de cero. 
     * Si es menor o igual a cero le asignamos una longitud 8.
     * Si es mayor de 32 le asignamos 32.  
     */
    public function __construct($longitud=8) {

        $this->longitud = $longitud;

        if (!is_numeric($this->longitud) || $this->longitud <= 0) {
            $this->longitud = 8;
        }
        if ($this->longitud > 32) {
            $this->longitud = 32;
        }
    }

    /**
     * Devuelve la contraseña generada con un tamaño de $longitud caracteres
     * @param integer $longitud
     * @return string La contraseña
     */
    function genera() {

        /* Introduce la semilla del generador de numeros aleatorios mejorado */
        mt_srand(microtime() * 1000000);
        for ($i = 0; $i < $this->longitud; $i++) {
            /* Genera un valor aleatorio mejorado con mt_rand, entre 0 y el tamaño del array
              $caracteres menos 1. Posteriormente vamos concatenando en la cadena $password
              los caracteres que se van eligiendo aleatoriamente.
             */
            $key = mt_rand(0, strlen($this->caracteres) - 1);
            $password = $password . $this->caracteres{$key};
        }
        return $password;
    }

}

?>