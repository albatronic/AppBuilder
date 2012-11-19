<?php

/**
 * Class Log
 *
 * Registra evento en un fichero de texto
 *
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC, SL
 * @version 1.0 24.05.2011
 */
class Log {

    private $logFile;
    private $event;

    public function __construct($event, $logFile='tmp/log.txt') {
        $this->logFile = $logFile;
        $this->event = $event;
    }

    /**
     * Escribe el texto "$this->event"
     * en el fichero de texto "$this->logFile". Si no existe el fichero lo crea
     */
    public function write() {

        $ip = substr($_SERVER['REMOTE_ADDR'] . str_repeat(" ", 15), 0, 15);
        $this->event.="\n";

        if (!file_exists($this->logFile)) {
            $fp = fopen($this->logFile, 'w');
            fwrite($fp, "FICHERO DE LOGIN CREADO EL " . date('d-m-Y H:i:s') . " " . $ip . " " . $_SESSION['iu'] . " " . $_SESSION['login'] . "\n");
            fclose($fp);
        }
        $fp = fopen($this->logFile, 'a');
        fwrite($fp, $this->event);
        fclose($fp);
    }

}

?>
