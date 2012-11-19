<?php

/**
 * Genera un archivo xml con el contenido de la instruccion sql
 * @author Sergio Perez
 * @copyright INFORMATICA ALBATRONIC SL
 * @since 28.09.2010 20:14:08
 * @version 1.0
 */
class XmlBuilder {
    /**
     * Cabecera del documento xml
     * @var string
     */
    protected $xmlStringHeader = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
    /**
     * Nombre de la conexion
     * @var string
     */
    protected $conexion;
    /**
     * Sentencia sql
     * @var string
     */
    protected $sql;
    /**
     * Nombre del archivo a generar
     * @var string
     */
    protected $file;
    /**
     * Nombre del elemento root del archivo xml
     * @var string
     */
    protected $root;
    /**
     * Nombre del elemento node del archivo xml
     * @var string
     */
    protected $node;
    /**
     * String donse se construye el documento xml
     * @var string
     */
    protected $xmlString;
    /**
     * Objeto de conexion de la base de datos
     * @var database
     */
    protected $_em;
    /**
     * Link a la base de datos
     * @var dbLink
     */
    protected $_dbLink;
    /**
     * Array con los eventuales errores
     * @var array
     */
    protected $_errores;
    /**
     * Indica el estado del objeto instanciado
     * despues de llamar al métido load
     * @var integer
     */
    protected $_status;

    /**
     * CONSTRUCTOR
     * Inicializa las variables y crea el documento xml
     */
    public function __construct($conexion, $sql, $file, $root, $node) {
        $this->conexion = $conexion;
        $this->sql = $sql;
        $this->file = $file;
        $this->root = $root;
        $this->node = $node;
        $this->createXml();
    }

    /**
     * Conexion a la base de datos
     */
    private function conecta() {
        $this->_em = new EntityManager($this->conexion);
        $this->_dbLink = $this->_em->getDbLink();
    }

    /**
     * Crea el documento xml en base a la sentencia sql
     */
    private function createXml() {
        $this->conecta();

        if (is_resource($this->_dbLink)) {
            if ($this->_em->query($this->sql)) {
                $rows = $this->_em->fetchResult();

                $this->xmlString = $this->xmlStringHeader . "<{$this->root}>\n";

                foreach ($rows as $row) {
                    $this->xmlString .= "  <{$this->node}>\n";
                    foreach ($row as $key => $value)
                        $this->xmlString .= "    <{$key}>{$value}</{$key}>\n";

                    $this->xmlString .= "  </{$this->node}>\n";
                }

                $this->xmlString .= "</{$this->root}>\n";
            } else {
                $this->_errores = $this->_em->getError();
            }

            $this->_em->desConecta();
        }
    }

    /**
     * GENERA UN FICHERO CON EL CONTENIDO EN FORMATO XML
     * EL NOMBRE DEL FICHERO GENERADO ESTA EN $this->file
     * DEVUELVE TRUE O FALSE SEGUN EL EXITO DEL METODO
     * @return boolean
     */
    public function writeXml() {
        $exito = false;
        if ($this->file != '') {
            $fp = @fopen($this->file, "w");
            if ($fp) {
                fwrite($fp, $this->getXmlString());
                fclose($fp);
                $exito = true;
            }
        }
        return $exito;
    }

    /**
     * Devuelve el documento xml en un string
     * @return string
     */
    public function getXmlString() {
        return $this->xmlString;
    }

}

// Fin de la clase xmlBuilder
?>