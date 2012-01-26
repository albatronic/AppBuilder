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

    private $raiz;
    private $status = true;
    private $esqueleto = array(
        'bin',
        'config',
        'css',
        'docs',
        'docs/formats',
        'docs/docs001',
        'docs/docs001/catalog',
        'docs/docs001/export',
        'docs/docs001/export/xmls',
        'docs/docs001/formats',
        'docs/docs001/images',
        'docs/docs001/pdfs',
        'entities',
        'entities/abstract',
        'entities/models',
        'entities/methods',
        'images',
        'images/calendario',
        'images/notificaciones',
        'js',
        'lang',
        'lib',
        'log',
        'modules',
        'modules/_Emergente',
        'modules/_global',
        'modules/_help',
        'modules/_help/images',
        'tmp',
    );

    public function __construct($raiz) {
        $this->raiz = $raiz;
    }

    public function crea() {

        // SI NO EXISTE, CREA EL DIRECTORIO RAIZ
        if (!file_exists($this->raiz))
            $this->status = @mkdir($this->raiz, 0, true);

        // CREO LOS SUBDIRECTORIOS
        if ($this->status) {
            foreach ($this->esqueleto as $folder) {
                @mkdir($this->raiz . "/" . $folder, 0, true);
            }
        }
        return $this->status;
    }

}

?>
