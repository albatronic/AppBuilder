<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 02.10.2012 18:58:03
 */

/**
 * @orm:Entity(CpanDocs)
 */
class CpanDocs extends CpanDocsEntity {

    protected $_prePath;

    /**
     * Array con la estructura de $_FILES del documento a subir
     *
     * Esta variable no tiene correspondencia con ninguna
     * columna de la tabla.
     * @var array
     */
    protected $_ArrayDoc;

    public function __construct($primaryKeyValue = '') {

        $this->_prePath = $_SESSION['project']['ftp']['folder'];
        if ($this->_prePath != '') {
            if (substr($this->_prePath, -1) != '/')
                $this->_prePath .= "/";
        }

        parent::__construct($primaryKeyValue);

        $this->_ArrayDoc = array(
            'name' => $this->Name,
            'error' => '',
            'size' => $this->Size,
        );
    }

    public function __toString() {
        return $this->getId();
    }

    public function setArrayDoc($arrayDoc) {
        $this->_ArrayDoc = $arrayDoc;
    }

    public function getArrayDoc() {
        return $this->_ArrayDoc;
    }

    public function create() {

        $id = parent::create();

        if ($id) {
            $this->actualizaNombreAmigable();
            if ($this->subeDocumento())
                $this->save();
        }

        return $id;
    }

    /**
     * Marca como borrado un registro y borra el archivo asociado.
     *
     * @return bollean
     */
    public function delete() {

        $this->conecta();

        if (is_resource($this->_dbLink)) {
            // Auditoria
            $fecha = date('Y-m-d H:i:s');
            $query = "UPDATE `{$this->_dataBaseName}`.`{$this->_tableName}` SET `Deleted` = '1', `DeletedAt` = '{$fecha}', `DeletedBy` = '{$_SESSION['USER']['user']['Id']}' WHERE `{$this->_primaryKeyName}` = '{$this->getPrimaryKeyValue()}'";
            if (!$this->_em->query($query))
                $this->_errores = $this->_em->getError();
            else {
                // Borrar el archivo asociado al registro
                $this->borraArchivo();
            }
            $this->_em->desConecta();
        } else
            $this->_errores = $this->_em->getError();

        unset($this->_em);

        $ok = (count($this->_errores) == 0);

        return $ok;
    }

    /**
     * Borra físicamente un registro (delete) y su archivo asociado.
     *
     * @return boolean
     */
    public function erase() {

        $this->conecta();

        if (is_resource($this->_dbLink)) {
            $query = "DELETE FROM `{$this->_dataBaseName}`.`{$this->_tableName}` WHERE `{$this->_primaryKeyName}` = '{$this->getPrimaryKeyValue()}'";
            if (!$this->_em->query($query))
                $this->_errores = $this->_em->getError();
            else {
                // Borrar el archivo asociado al registro
                $this->borraArchivo();
            }
            $this->_em->desConecta();
        } else
            $this->_errores = $this->_em->getError();

        unset($this->_em);

        $ok = (count($this->_errores) == 0);

        return $ok;
    }

    /**
     * Borra físicamente el archivo del disco del servidor vía FTP
     *
     * @return boolean TRUE si se ha borrado con éxito
     */
    private function borraArchivo() {

        $pathInfo = pathinfo($this->PathName);

        $carpetaDestino = $this->_prePath . $pathInfo['dirname'];

        $ftp = new Ftp($_SESSION['project']['ftp']);
        $ok = $ftp->delete($carpetaDestino, $this->Name);
        $this->_errores = $ftp->getErrores();
        $ftp->close();
        unset($ftp);

        return $ok;
    }

    /**
     * Borrar los documentos de la entidad $entidad y $idEntidad
     * que son del tipo $tipo
     *
     * En el parámetro $tipo se puede usar el comodín '%' para
     * seleccionar varios tipos de documentos
     *
     * Borra las entradas en la tabla de documentos y
     * los archivos físicos del disco duro
     *
     *
     * @param string $entidad
     * @param integer $idEntidad
     * @param string $tipo El tipo de documento
     * @param string $criterio Expresión lógica a incluir en el criterio de borrado
     * @return boolean
     */
    public function borraDocs($entidad, $idEntidad, $tipo, $criterio = '1') {

        $ok = false;

        $filtro = "(Entity='{$entidad}') AND (IdEntity='{$idEntidad}') AND (Type LIKE '{$tipo}') AND ({$criterio})";

        $rows = $this->cargaCondicion('Id', $filtro);

        foreach ($rows as $row) {
            $doc = new CpanDocs($row['Id']);
            $doc->erase();
        }
        unset($doc);

        return $ok;
    }

    /**
     * Devuelve un array de objetos documentos que cumplen
     * los criterios indicados en los parámetros recibidos por el método
     *
     * @param string $entidad
     * @param integer $idEntidad
     * @param string $tipo El tipo de documento
     * @param string $criterio Expresión lógica a incluir en el criterio de borrado
     * $param string $orderCriteria El criterio de ordenación
     * @return array El array con los objetos documentos
     */
    public function getDocs($entidad, $idEntidad, $tipo, $criterio = '1', $orderCriteria = 'SortOrder ASC') {

        $arrayDocs = array();

        $filtro = "(Entity='{$entidad}') AND (IdEntity='{$idEntidad}') AND (Type LIKE '{$tipo}') AND ({$criterio})";
        $rows = $this->cargaCondicion('Id', $filtro, $orderCriteria);

        foreach ($rows as $row)
            $arrayDocs[] = new CpanDocs($row['Id']);

        return $arrayDocs;
    }

    /**
     * Devuelve el número de documentos asociados a la entidad
     * indicada en los parámetros
     *
     * @param string $tipo El tipo de documento, se admite '%'
     * @param string $criterio Expresión lógica a incluir en el criterio de filtro
     * @return integer El número de documentos
     */
    public function getNumberOfDocs($entidad, $idEntidad, $tipo, $criterio = '1') {

        $rows = $this->cargaCondicion('Id', "(Entity='{$entidad}') AND (IdEntity='{$idEntidad}') AND (Type LIKE '{$tipo}') AND ({$criterio})");

        return count($rows);
    }

    /**
     * Calcula el nombre amigable y actualiza las
     * propiedades $this->Name, $this->PathName y $this->Extension
     *
     * En base al tipo de documento (imageN, galery, document, etc) se permiten
     * varios documentos para la misma entidad e idEntidad, o sólo uno.
     *
     * Esto viene determinado por el valor 'limit' del array TiposDocs.
     */
    private function actualizaNombreAmigable() {

        $archivo = pathinfo($this->_ArrayDoc['name']);
        $extension = strtolower($archivo['extension']);
        $this->setName(Textos::limpia($this->Name) . ".{$extension}");
        $this->setPathName("docs/{$this->Entity}/{$this->Name}");
        $this->setExtension($extension);

        $tipos = new TiposDocs($this->Type);
        $tipo = $tipos->getTipo();
        unset($tipos);
        switch ($tipo['limit']) {
            case '1':
                $doc = new CpanDocs();
                $rows = $doc->cargaCondicion("Id, Entity, IdEntity, Type, IsThumbnail", "(Name='{$this->Name}')");
                $row = $rows[0];
                if (($row['Id']) and ($row['Entity'] != "{$this->Entity}" or $row['IdEntity'] != "{$this->IdEntity}" or $row['Type'] != "{$this->Type}" or $row['IsThumbnail'] != "{$this->IsThumbnail}")) {
                    // Ya existe esa imagen amigable, le pongo al final el id
                    $aux = explode(".", $this->Name);
                    $this->Name = "{$aux[0]}-{$this->Id}.{$aux[1]}";
                }
                break;
            case '':
                // Puede haber n documentos para la misma entidad e idEntidad
                $doc = new CpanDocs();
                $rows = $doc->cargaCondicion("Id", "(Name='{$this->Name}')");
                $row = $rows[0];
                if (($row['Id']) and ($row['Id'] != $this->Id)) {
                    // Ya existe esa imagen amigable, le pongo al final el id
                    $aux = explode(".", $this->Name);
                    $this->Name = "{$aux[0]}-{$this->Id}.{$aux[1]}";
                }
                break;
        }

        unset($doc);

        $this->setPathName("docs/{$this->Entity}/{$this->Name}");
    }

    /**
     * Comprueba que el archivo cumple las reglas de validación
     * respecto a tipo y tamaño
     *
     * Las propiedades del archivo a validar deben estar cargadas
     * en $this->_ArrayDoc
     *
     * @param array $rules Array con las reglas de validación
     * @return boolean TRUE si cumple las reglas de validación
     */
    public function validaArchivo(array $rules) {


        if ($this->_ArrayDoc['error'] == '0') {

            // Comprar que no excede el número máximo de documentos permitidos
            if ($rules['numMaxDocs'] > 0) {
                $doc = new CpanDocs();
                $nDocs = $doc->getNumberOfRecords("Type = '{$rules['type']}' and IsThumbNail='0'");
                unset($doc);
                $limiteExcedido = ($nDocs >= $rules['numMaxDocs']);
            }

            if (!$limiteExcedido) {
                // Comprobacion de tamaño
                $prohibidoTamano = ( ($rules['maxFileSize'] > 0) and ($this->_ArrayDoc['size'] > $rules['maxFileSize']) );

                // Comprobación de tipo
                $path_parts = pathinfo($this->_ArrayDoc['name']);
                $extension = strtolower($path_parts['extension']);
                $prohibidoTipo = !in_array($extension, $rules['allowTypes']);

                if ($prohibidoTipo)
                    $this->_errores[] = "El tipo de archivo '" . $this->_ArrayDoc['type'] . "' no está permitido.";
                if ($prohibidoTamano)
                    $this->_errores[] = "El tamaño del archivo (" . round($this->_ArrayDoc['size'] / 1000, 2) . " Kb) supera el limite autorizado (" . $rules['maxFileSize'] / 1000 . " Kb).";
            } else
                $this->_errores[] = "Se ha excedido el número máximo de archivos contratado. Por favor, contacte con el web master";
        } else {
            switch ($this->_ArrayDoc['error']) {
                case '':
                    // No hay error, el archivo ya está subido
                    break;
                case '1' :
                    $this->_errores[] = "El tamaño del archivo es superior al permitido por el hosting (Cod. Error: {$this->_ArrayDoc['error']}).";
                    break;
                case '2' :
                    $this->_errores[] = "El tamaño del archivo es superior al permitido (Cod. Error: {$this->_ArrayDoc['error']}).";
                    break;
                case '3' :
                    $this->_errores[] = "El archivo fue solo parcialmente subido (Cod. Error: {$this->_ArrayDoc['error']}).";
                    break;
                case '4' :
                    $this->_errores[] = "El archivo no se ha cargado (Cod. Error: {$this->_ArrayDoc['error']}).";
                    break;
                case '6' :
                    $this->_errores[] = "No se ha localizado la carpeta temporal de subidas (Cod. Error: {$this->_ArrayDoc['error']}).";
                    break;
                case '7' :
                    $this->_errores[] = "Hubo un fallo al escribir en el disco (Cod. Error: {$this->_ArrayDoc['error']}).";
                    break;
                case '8' :
                    $this->_errores[] = "La carga del archivo ha sido interrumpida (Cod. Error: {$this->_ArrayDoc['error']}).";
                    break;
            }
        }


        return (count($this->_errores) == 0);
    }

    /**
     * Valida el objeto
     *
     * También compruebo que el titulo y el nombre no están vacios, si fuera el caso
     * los lleno con el valor de la columna indicado en la variable de entorno 'fieldGeneratorUrlFriendly'
     *
     * @param array $rules
     * @return boolean TRUE si el objeto completo pasa la validación
     */
    public function valida(array $rules) {

        if ($this->validaArchivo($rules)) {

            // Validar que se haya indicado título y nombre, en su defecto
            // se toma el indicado por la variable de entorno
            if (($this->Title == '') or ($this->Name == '')) {
                $variables = new CpanVariables('Mod', 'Env', $this->getEntity());
                $varEnv = $variables->getValores();
                unset($variables);
                $datos = new $this->Entity($this->IdEntity);
                $columnaSlug = $varEnv['fieldGeneratorUrlFriendly'];
                $slug = $datos->{"get$columnaSlug"}();
                unset($datos);

                if ($this->Title == '')
                    $this->Title = $slug;
                if ($this->Name == '')
                    $this->Name = $slug;
            } $slug = $this->Name;

            if ($slug == '')
                $this->_errores[] = "No se ha indicado el título";
        }

        return (count($this->_errores) == 0);
    }

    /**
     * Sube el documento indicado en $this->_ArrayDoc al servidor via FTP
     *
     * Si es una imagen, la redimensiona se han establecido dimensiones
     * fijas en $this->_ArrayDoc['width'] y $this->_ArrayDoc['heigth']
     *
     * @return boolean TRUE si se subió con éxito
     */
    private function subeDocumento() {

        $pathInfo = pathinfo($this->PathName);

        $carpetaDestino = $this->_prePath . $pathInfo['dirname'];

        $ok = is_uploaded_file($this->_ArrayDoc['tmp_name']);

        if ($ok) {
            if (exif_imagetype($this->_ArrayDoc['tmp_name'])) {
                // Tratamiento de la imagen antes de subirla
                list($ancho, $alto) = getimagesize($this->_ArrayDoc['tmp_name']);

                if (($this->_ArrayDoc['maxWidth']) and ($ancho > $this->_ArrayDoc['maxWidth']))
                    $ancho = $this->_ArrayDoc['maxWidth'];
                if (($this->_ArrayDoc['maxHeight']) and ($alto > $this->_ArrayDoc['maxHeight']))
                    $alto = $this->_ArrayDoc['maxHeight'];

                $img = new Gd();
                $img->loadImage($this->_ArrayDoc['tmp_name']);
                $img->crop($ancho, $alto);
                $imagenRecortada = "tmp/" . md5($this->_ArrayDoc['tmp_name']);
                $ok = $img->save($imagenRecortada);
                unset($img);
                $archivo = new Archivo($imagenRecortada);
                $this->setSize($archivo->getSize());
                $this->setWidth($archivo->getImageWidth());
                $this->setHeight($archivo->getImageHeight());
                $this->setMimeType($archivo->getMimeType());
                unset($archivo);
                $archivoSubir = $imagenRecortada;
            } else $archivoSubir = $this->_ArrayDoc['tmp_name'];

            $ftp = new Ftp($_SESSION['project']['ftp']);
            if ($ftp) {
                $ok = $ftp->upLoad($carpetaDestino, $archivoSubir, $this->Name);
                $this->_errores = $ftp->getErrores();
                $ftp->close();
            } else
                $this->_errores[] = "Fallo al conectar vía FTP";

            unset($ftp);
            $ok = ( count($this->_errores) == 0);
            
            if (file_exists($imagenRecortada))
                @unlink ($imagenRecortada);
        }

        return $ok;
    }

    /**
     * Cambia el nombre de una imagen existente
     *
     * Actualiza el nombre nuevo en la tabla de imagenes y cambia
     * el nombre al archivo físico
     *
     * @param string $titulo El titulo de la imagen
     * @param string $slug El nombre de la imagen sin limpiar
     * @param booelan $mostrarPieFoto TRUE si se quiere mostrar el titulo en el pie de la imagen
     * @param array $documento Array con los parametros del documento
     * @param booelan $idThumbnail
     * @param integer $orden
     * @return boolean TRUE si se cambió con Exito
     */
    public function actualiza() {

        $ok = TRUE;

        // Cargo los datos del objeto antes de cambiarlos
        $doc = new CpanDocs($this->getId());
        $pathName = $doc->getPathName();
        $nombreAnterior = $doc->getName();
        unset($doc);

        // Si el nombre propuesto es distinto al que ya tiene y no es Thumbnail
        // recalculo el nombre amigable, cambio el path y renombro el archivo
        $this->actualizaNombreAmigable();
        $nombreNuevo = $this->getName();

        $pathInfo = pathinfo($pathName);

        $carpetaDestino = $this->_prePath . $pathInfo['dirname'];

        $ftp = new Ftp($_SESSION['project']['ftp']);
        $ok = $ftp->rename($carpetaDestino, $nombreAnterior, $nombreNuevo);
        $this->_errores = $ftp->getErrores();
        $ftp->close();
        unset($ftp);

        if ($this->_ArrayDoc['tmp_name'] != '') {
            $ok = $this->subeDocumento();
        }

        // Si todo ha ido bien, actualizo el objeto
        if ($ok)
            $this->save();

        unset($this);

        return $ok;
    }

    /**
     * Devuelve el objeto que es ThumbNail perteneciente
     * al objeto actual
     */
    public function getThumbNail() {

        $obj = new CpanDocs();
        $rows = $obj->cargaCondicion('Id', "BelongsTo='{$this->Id}'");
        unset($obj);

        return new CpanDocs($rows[0]['Id']);
    }

}

?>