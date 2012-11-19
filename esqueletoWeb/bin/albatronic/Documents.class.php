<?php

/**
 * Description of Documents
 *
 * Devuelve un array con objetos "Archivo" asociados
 * a la entidad indicada en el constructor
 *
 * Los archivos pueden ser documentos o imágenes dependientedo
 * del parámetro $tipo, cuyos valores pueden ser:
 *
 *   documents
 *   images
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @since 26-agosto-2012 20:41
 *
 */
class Documents {

    protected $entidad;
    protected $path;
    protected $arrayDocuments = array();

    /**
     * Tipos de documentos permitidos
     * @var array
     */
    protected $tipos = array(
        'documents',
        'images',
    );

    public function __construct($entidad, $id, $tipo = 'documents') {

        if (in_array($tipo, $this->tipos)) {
            $this->entidad = $entidad;
            $this->path = $_SERVER['DOCUMENT_ROOT'] . $_SESSION['appPath'] . "/docs/docs" . $_SESSION['emp'] . "/" . $tipo . "/" . $this->entidad . "/" . $id . "_*.*";

            foreach (glob($this->path) as $fileName) {
                $pathDocument = $_SERVER['DOCUMENT_ROOT'] . $_SESSION['appPath'] . "/docs/docs{$_SESSION['emp']}/" . $tipo . "/{$this->entidad}/" . basename($fileName);
                $this->arrayDocuments[] = new Archivo($pathDocument);
            }
        }
    }

    /**
     * Devuelve un array con el path a los documentos asociados
     * a la entidad e id indicado en el constructor.
     *
     * El path es relativo al path de la app (no es absoluto)
     *
     * @return array Array con el path a los documentos
     */
    public function getDocuments() {
        return $this->arrayDocuments;
    }

    /**
     * Devuelve el numero de documentos asociados a la entidad
     * e id indicado en el constructor
     *
     * @return integer El numero de documentos
     */
    public function getNumberOfDocuments() {
        return count($this->arrayDocuments);
    }

}

?>
