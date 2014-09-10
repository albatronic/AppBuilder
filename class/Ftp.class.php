<?php
/**
 *
 * Clase para gestionar archivos vía FTP
 *
 * Uso:
 *
 * $ftp = new Ftp('servidorFtp','usuario','password');
 *
 * Subir archivo: $ok = $ftp->upload('carpetaDestino','archivoOrigen','archivoDestino');
 *
 * Descargar archivo: $ok = $ftp->downLoad('archivoDelServidor','archivoLocal');
 *
 * Obtener eventuales errores: $array = $ftp->getErrores();
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 18-oct-2012 19:55:37
 */
class Ftp
{
    public $server;
    public $user;
    public $password;
    public $errores = array();

    public function __construct($server, $user, $password)
    {
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Sube un archivo al servidor vía ftp
     *
     * @param  string  $targetFolder Carpeta destino
     * @param  string  $sourceFile   Fichero origen
     * @param  string  $targetFile   Fichero destino
     * @param  integer $transferMode Tipo de transferencia (FTP_ASCII, FTP_BINARY), por defecto FTP_BINARY
     * @return boolean TRUE si el archivo se subió con éxito
     */
    public function upLoad($targetFolder, $sourceFile, $targetFile, $transferMode = FTP_BINARY)
    {
        $this->errores = array();

        $connId = $this->connect();

        if ($connId) {
            ftp_chdir($connId, $targetFolder);
            $ok = @ftp_put($connId, $targetFile, $sourceFile, $transferMode);
            ftp_close($connId);

            if (!$ok)
                $this->errores[] = "FTP: La carga ha fallado!";
        }

        return (count($this->errores) == 0);
    }

    /**
     * Descarga un archivo desde el servidor FTP y lo copia en
     * un archivo local
     *
     * @param  string  $serverFile   El archivo a descargar desde el servidor
     * @param  string  $localFile    El nombre del archivo local que se generará
     * @param  integer $transferMode Tipo de transferencia (FTP_ASCII, FTP_BINARY), por defecto FTP_BINARY
     * @return boolean TRUE si la descarga se hizo con éxito
     */
    public function downLoad($serverFile, $localFile, $transferMode = FTP_BINARY)
    {
        $this->errores = array();

        $connId = $this->connect();

        if ($connId) {
            $ok = @ftp_get($connId, $localFile, $serverFile, $transferMode);
            ftp_close($connId);

            if (!$ok)
                $this->errores[] = "FTP: No se ha podido descargar el archivo '{$serverFile} a '{$localFile}'";
        }

        return (count($this->errores) == 0);
    }

    /**
     * Borrar un archivo del servidor vía FTP
     *
     * @param  string  $folder Carpeta donde está el fichero a borrar
     * @param  string  $file   Fichero a borrar
     * @return boolean TRUE si el archivo se subió con éxito
     */
    public function delete($folder, $file)
    {
        $this->errores = array();

        $connId = $this->connect();

        if ($connId) {
            ftp_chdir($connId, $folder);
            $ok = @ftp_delete($connId, $file);
            ftp_close($connId);
            if (!$ok)
                $this->errores[] = "FTP: El borrado ha fallado!";
        }

        return (count($this->errores) == 0);
    }

    /**
     * Cambia de nombre a un archivo vía FTP
     *
     * @param  string  $folder  Carpeta donde está el archivo a cambiar
     * @param  string  $oldName El nombre actual del archivo
     * @param  string  $newName El nombre nuevo
     * @return boolean TRUE si el cambio de nombre se hizo con éxito
     */
    public function rename($folder, $oldName, $newName)
    {
        $this->errores = array();

        $connId = $this->connect();

        if ($connId) {
            ftp_chdir($connId, $folder);
            $ok = @ftp_rename($connId, $oldName, $newName);
            ftp_close($connId);

            if (!$ok)
                $this->errores[] = "FTP: El cambio de nombre ha fallado!";
        }

        return (count($this->errores) == 0);
    }

    /**
     * Crear un directorio en el servidor vía FTP.
     *
     * @param  string  $directory Directorio a crear
     * @return boolean TRUE si se creó el directorio
     */
    public function mkdir($directory)
    {
        $this->errores = array();

        $connId = $this->connect();

        if ($connId) {
            $ok = @ftp_mkdir($connId, $directory);
            ftp_close($connId);

            if (!$ok)
                $this->errores[] = "FTP: No se ha podido crear la carpeta '{$directory}'";
        }

        return (count($this->errores) == 0);
    }

    /**
     * Borra un directorio en el servidor vía FTP.
     *
     * El directorio debe estar vacio.
     *
     * @param  string  $directory Directorio a borrar
     * @return boolean TRUE si se borró el directorio
     */
    public function rmdir($directory)
    {
        $this->errores = array();

        $connId = $this->connect();

        if ($connId) {
            $ok = @ftp_rmdir($connId, $directory);
            ftp_close($connId);

            if (!$ok)
                $this->errores[] = "FTP: No se ha podido borrar la carpeta '{$directory}'";
        }

        return (count($this->errores) == 0);
    }

    /**
     * Ejecuta el comando FTP LIST, y devuelve el resultado como una matriz.
     *
     * @param  string  $directory El directorio a listar
     * @param  boolean $recursive TRUE para
     * @return array   Array con el listado del directorio
     */
    public function listDir($directory, $recursive = FALSE)
    {
        $this->errores = array();

        $connId = $this->connect();

        if ($connId) {
            $array = @ftp_rawlist($connId, $directory, $recursive);
            ftp_close($connId);

            if (!is_array($array))
                $this->errores[] = "FTP: Ha fallado el listado de la carpeta '{$directory}'";
        }

        return $array;
    }

    /**
     * Lee el contenido de un archivo vía curl
     *
     * Devuelve un array con dos elementos:
     *
     * 'result' => El contenido del archivo
     * 'info' => array con la información de la operación realizada
     *
     * @param  string $urlFile Url del archivo a leer
     * @return array  Array con el resultado
     */
    public function getFileContent($urlFile)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER => FALSE,
        );

        $ch = curl_init($urlFile);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return array(
            'result' => $result,
            'info' => $info,
        );
    }

    /**
     * Se conecta al servidor por FTP
     *
     * @return boolean TRUE si la conexión fue exitosa
     */
    private function connect()
    {
        $connId = ftp_connect($this->server);
        $ok = @ftp_login($connId, $this->user, $this->password);

        if ($ok)
            return $connId;
        else {
            $this->errores[] = "FTP: La conexión ha fallado!";

            return FALSE;
        }
    }

    /**
     * Devuelve un array con los eventuales errores producidos
     *
     * @return array Array de errores
     */
    public function getErrores()
    {
        return $this->errores;
    }

}
