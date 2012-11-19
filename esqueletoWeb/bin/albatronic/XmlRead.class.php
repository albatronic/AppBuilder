<?php
/**
 * Description of XmlRead
 *
 * Lee un archivo XML y lo almacena en el array $this->xml
 * Con el método getXml() devuelve el contenido entero.
 * Con el método getNode() devuelve el contenido del nodo indicado
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @since 04-nov-2011
 *
 */

class XmlRead {

    /**
     * Archivo xml donde están las parámetros a leer
     * @var string
     */
    protected $file;
    /**
     * Array con el objeto XML
     * @var array
     */
    protected $xml = array();

    public function  __construct($file) {
        $this->file = $file;
        $this->load();
    }
    /**
     * Devuelve un array con el objeto XML completo
     * @return array
     */
    public function getXml() {
        return $this->xml;
    }

    /**
     * Devuelve un array con el contenido del nodo $nodeName
     * Si se indica $nodeNumber y existen varias ocurrencias del nodo
     * dentro del documento, se devuelve la ocurrencia $nodeNumber, teniendo
     * en cuenta que el orden empieza por 0
     * 
     * @param <type> $nodeName
     * @param <type> $nodeNumber 
     * @return array Contenido del nodo solicitado
     */
    public function getNode($nodeName,$nodeNumber=0) {
        $cont = 0;
        foreach ($this->xml->{$nodeName} as $key => $value) {
            if ($cont == $nodeNumber) {
                $nodeContent = $value;
                break;
            }
            $cont = $cont + 1;
        }
        return $nodeContent;
    }

    /**
     * Carga los parametros del formulario que están en el
     * archivo config.xml y los almacena en una variable
     * de tipo array
     */
    protected function load() {
        if (is_file($this->file)) {
            $str = file_get_contents($this->file);
            $str = preg_replace("/\<\!\[CDATA\[(.*?)\]\]\>/ies", "'[CDATA]'.base64_encode('$1').'[/CDATA]'", $str);
            $this->xml = new SimpleXMLElement($str);
        }
    }
}
?>
