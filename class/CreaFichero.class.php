<?php

/**
 * Description of CreaFichero
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 08-jun-2011
 *
 */

class CreaFichero {

    public function __construct($filename, $content) {
        if (file_exists($filename))
            rename($filename, $filename . "_");
        $fp = @fopen($filename, "w");
        if ($fp) {
            fwrite($fp, $content);
            fclose($fp);
        } else
            echo "ERROR AL CREAR " . $filename . "</br>";
    }

}

class Esqueleto {

    /**
     * Crea la carpeta $pathDestino y copia en ella la estructura y contenido
     * de la carpeta $pathDestino
     * 
     * @param string $pathOrigen La carpeta origen
     * @param string $pathDestino La carpeta destino
     * @return boolean
     */
    public function copia($pathOrigen,$pathDestino) {
        
        if ($pathDestino)
            return $this->copy_r($pathOrigen, $pathDestino);
        else
            return false;
    }

    /**
     * Copia recursiva de origen a destino
     * 
     * @param string $path La carpeta origen
     * @param string $dest La carpeta destino
     * @return boolean
     */
    private function copy_r($path, $dest) {
        if (is_dir($path)) {
            @mkdir($dest);
            chmod($dest,'0777');
            $objects = scandir($path);
            if (sizeof($objects) > 0) {
                foreach ($objects as $file) {
                    if ($file == "." || $file == "..")
                        continue;
                    // go on
                    if (is_dir($path . DS . $file)) {
                        $this->copy_r($path . DS . $file, $dest . DS . $file);
                    } else {
                        copy($path . DS . $file, $dest . DS . $file);
                    }
                }
            }
            return true;
        } elseif (is_file($path)) {
            return copy($path, $dest);
        } else {
            return false;
        }
    }

}

?>
