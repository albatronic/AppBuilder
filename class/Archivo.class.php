<?php

/**
 * Description of Archivo
 *
 * Clase multipropósito para la gestión de archivos:
 *
 * El constructor recibe el fullPath name de un archivo
 * y sus métodos devuelven las caracteristicas del mismo:
 * tipo, si es imagen: anchura, altura, tamaño, etc.
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @since 14-abr-2012
 *
 */
class Archivo
{
    /**
     * Path completo del archivo incluido el nombre y la extension
     * @var string
     */
    private $fullPath = null;

    /**
     * Path relativo a la ubicacion de la app
     * incluido el nombre y la extension
     * @var string
     */
    private $relativePath = null;

    /**
     * El nombre del archivo (sin el path) incluida la extension
     * @var string
     */
    private $baseName = null;

    /**
     * El directorio del archivo (sin terminar en /)
     * @var string
     */
    private $dirName = null;

    /**
     * La extensión del archivo
     * @var string
     */
    private $extension = null;

    /**
     * El nombre del archivo sin el path ni la extensión
     * @var string
     */
    private $fileName = null;

    /**
     * El tipo de archivo
     * @var string
     */
    private $type = null;

    /**
     * Si es una imagen, su anchura
     * @var integer
     */
    private $imageWidth = null;

    /**
     * Si es una imagen, su altura
     * @var integer
     */
    private $imageHeight = null;

    /**
     * Tamaño del archivo en bytes
     * @var dobule
     */
    private $size = null;

    /**
     * Indica si es o no una imagen
     * @var boolean
     */
    private $isImage = false;

    /**
     * Nombre del archivo subido
     * @var string
     */
    private $upLoadedFileName = null;

    /**
     * Manejador del archivo
     * @var integer;
     */
    private $fp = false;
    private $columnsDelimiter = "\t";
    private $columnsEnclosure = "";
    private $escape = "\\";

    /**
     * Array de errores ocurridos durante la carga del archivo
     * al servidor
     * @var array
     */
    private $errores = array();

    public function __construct($fullPath)
    {
        if ($fullPath) {
            $this->getPathInfo($fullPath);
            $this->fullPath = $fullPath;

            if (file_exists($fullPath)) {
                $this->relativePath = str_replace($_SERVER['DOCUMENT_ROOT'] . $_SESSION['appPath'] . "/", "", $this->fullPath);
                $this->size = filesize($this->fullPath);
                $this->isImage = exif_imagetype($this->fullPath);

                if ($this->isImage) {
                    $this->type = $this->isImage;
                    list($this->imageWidth, $this->imageHeight) = getimagesize($this->fullPath);
                }
            }
        }
    }

    public function getFullPath()
    {
        return $this->fullPath;
    }

    public function getRelativePath()
    {
        return $this->relativePath;
    }

    /**
     * Devuelve la ruta del archivo:
     * '/www/htdocs/inc/lib.inc.php' => /www/htdocs/inc
     * @return string
     */
    public function getDirName()
    {
        return $this->dirName;
    }

    /**
     * Devuelve el nombre del archivo y la extension:
     * '/www/htdocs/inc/lib.inc.php' => lib.inc.php
     * @return string
     */
    public function getBaseName()
    {
        return $this->baseName;
    }

    /**
     * Devuelve la extension:
     * '/www/htdocs/inc/lib.inc.php' => php
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Devuelve el nombre del archivo sin la extensión:
     * '/www/htdocs/inc/lib.inc.php' => lib.inc
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    public function getNumericType()
    {
        return $this->type;
    }

    public function getMimeType()
    {
        return image_type_to_mime_type($this->type);
    }

    public function getImageWidth()
    {
        return $this->imageWidth;
    }

    public function getImageHeight()
    {
        return $this->imageHeight;
    }

    public function getIsImage()
    {
        return $this->isImage;
    }

    /**
     * Devuelve el tamañano del archivo
     *
     * @return double EL tamaño del archivo en bytes
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Genera un nombre de archivo aleatorio (md5) para crearlo en la
     * carpeta docs/docsPPP/pdfs/XX/nombreDeArchivo.pdf
     *
     * Donde:
     *
     *  * PPP es el nombre del proyecto en curso
     *
     *  * XX es el nombre de subcarpeta que se creará si no existe y se
     *    obtiene con los dos primeros caracteres del nombre de archivo
     *
     *  * nombreDeArchivo se obtiene en base a la función MD5
     *
     * Si el método ha sido capaz de generar (si no existía) la carpeta XX, devuelve
     * un string con el nombre de archivo completo, en caso contrario devuelve vacío
     *
     * Uso:
     *
     *   $fichero = Archivo::getTemporalFileName();
     *   echo $fichero; -> docs/docs001/pdfs/a0/a0asdasdfasd.pdf
     *
     * @return string El nombre de archivo con el path completo
     */
    public static function getTemporalFileName()
    {
        $fileName = md5($_SESSION['USER']['user']['iu'] . date('d-m-Y H:i:s'));
        $prefijoCarpeta = substr($fileName, 0, 2);
        $path = "docs/docs" . $_SESSION['project']['folder'] . "/pdfs/" . $prefijoCarpeta;
        $archivo = $path . "/" . $fileName . ".pdf";
        if (!is_dir($path))
            $ok = mkdir($path);
        if (!is_dir($path))
            $archivo = '';

        return $archivo;
    }

    /**
     * Sube un archivo al servidor
     *
     * El archivo destino será el indicado en el constructor y tendrá
     * la misma extensión que el archivo origen en minúsculas.
     *
     * Previa a la carga, se hacen validaciones de tipo y tamaño permitido
     * en base a los parámetros ULTYP y ULSIZ respectivamente.
     *
     * Si hubiera errores de validación o de carga, se pueden recoger con
     * el método getErrores()
     *
     * @param  string  $origen EL archivo origen
     * @return boolean
     */
    public function upLoad($origen)
    {
        $this->errores = array();

        $subido = false;
        $prohibido = false;
        $pathDestino = $this->getDirName();

        if (!is_dir($pathDestino))
            $creado = mkdir($pathDestino);

        if (is_dir($pathDestino)) {
            $pathOrigen = pathinfo($origen['name']);
            $extension = "";
            $extension = strtolower($pathOrigen['extension']);
            if ($extension)
                $extension = "." . $extension;
            $destino = $pathDestino . "/" . $this->getFileName() . $extension;
            $origen = $origen['tmp_name'];
            $tipoArchivo = $origen['type'];
            //Paso el tamaño a KBytes
            $tamanoArchivo = round($origen['size'] / 1024);

            //Comprobaciones de tamaño y tipo de archivo
            $param = new Parametros();
            $tamanoMaximo = trim($param->find("Codigo", "ULSIZ")->getValor());
            if (!$tamanoMaximo)
                $tamanoMaximo = 500;
            $tiposProhibidos = trim($param->find("Codigo", "ULTYP")->getValor());
            if ($tiposProhibidos)
                $tiposProhibidos = explode(",", $tiposProhibidos);
            else
                $tiposProhibidos[0] = "application/octet-stream";
            unset($param);

            $prohibidoTipo = in_array($tipoArchivo, $tiposProhibidos);
            $prohibidoTamano = ($tamanoArchivo > $tamanoMaximo);

            if ($prohibidoTipo)
                $this->errores[] = "Ese tipo de archivo (" . $tipoArchivo . ") no esta permitido. Consulte el parametro ULTYP.";
            if ($prohibidoTamano)
                $this->errores[] = "El tamaño del archivo (" . $tamanoArchivo . " Kb) supera el limite autorizado (" . $tamanoMaximo . " Kb). Revise el parámetro ULSIZ";

            if ((!$prohibidoTipo) and (!$prohibidoTamano)) {
                //Sube el archivo al servidor local
                if (is_uploaded_file($origen)) {
                    if (copy($origen, $destino))
                        $this->upLoadedFileName = $destino;
                    else
                        $this->errores[] = "Falló la carga del archivo";
                }
            }
        } else
            $this->errores[] = "No se ha podido crear la carpeta para almacenar los documentos";

        return (count($this->errores) == 0);
    }

    /**
     * Devuelve el nombre del archivo subido
     * @return string
     */
    public function getUpLoadedFileName()
    {
        return $this->upLoadedFileName;
    }

    /**
     * Devuelve un array con los errores producidos
     * durante la carga del archivo
     *
     * @return array Array con los errores
     */
    public function getErrores()
    {
        return $this->errores;
    }

    /**
     * Obtiene las partes que componen el nombre del archivo $path
     * @param string $path
     */
    private function getPathInfo($path)
    {
        $path_parts = pathinfo($path);
        $this->dirName = $path_parts['dirname'];
        $this->baseName = $path_parts['basename'];
        $this->extension = $path_parts['extension'];
        $this->fileName = $path_parts['filename'];
    }

    /**
     * Abre el archivo indicado en el constructor en modo $mode
     * y pone en $this->fp el manejador
     *
     * @param  string  $mode
     * @return boolean TRUE si se abrió con éxito
     */
    public function open($mode = "r")
    {
        $this->fp = fopen($this->fullPath, $mode);

        return ($this->fp != false);
    }

    /**
     * Lee el archivo indicado en el constructor
     * y devuelve su contenido. Si no se pudo abrir, devuelve FALSE
     *
     * @return string La cadena de texto leida o FALSE
     */
    public function read()
    {
        $cadena = '';

        if ($this->open('r')) {
            $cadena = fread($this->fp, $this->getSize());
            $this->close();
        }

        return $cadena;
    }

    /**
     * Escribe en el archivo indicado en el constructor
     * la cadena de texto $datos
     *
     * @param  string  $datos La cadena de texto a escribir
     * @return boolean TRUE si la escritura se hizo con éxito
     */
    public function write($datos)
    {
        $ok = FALSE;

        if ($this->open('w')) {
            $ok = fwrite($this->fp, $datos);
            $this->close();
        }

        return $ok;
    }

    /**
     * Cierra el fichero
     */
    public function close()
    {
        fclose($this->fp);
    }

    /**
     * Lee una linea del fichero y devuelve un array
     * asociativo. El valor de la primera columna estará en el elemento 0
     *
     * @return variant Array o false si es final de fichero
     */
    public function readLine()
    {
        if (!feof($this->fp)) {
            if ($this->columnsEnclosure)
                return fgetcsv($this->fp, 1000, $this->columnsDelimiter, $this->columnsEnclosure, $this->escape);
            else
                return fgetcsv($this->fp, 1000, $this->columnsDelimiter);
        } else

            return false;
    }

    /**
     * Escribe una línea en el fichero
     * @param string $string
     */
    public function writeLine($string)
    {
        fwrite($this->fp, $string . PHP_EOL);
    }

    /**
     * Establece el carácter de separación entre columnas
     * Por defecto el tabulador
     *
     * @param char(1) $char
     */
    public function setColumnsDelimiter($char)
    {
        $this->columnsDelimiter = $char;
    }

    /**
     * Establece el carácter que envuelve cada columna
     * Por defecto vacio
     *
     * @param char(1) $char
     */
    public function setColumnsEnclosure($char)
    {
        $this->columnsEnclosure = $char;
    }

    /**
     * Establece el carácter de escape (un sólo carácter). Por defecto es una barra invertida.
     * @param char(1) $char
     */
    public function setEscape($char)
    {
        $this->escape = $char;
    }

}
