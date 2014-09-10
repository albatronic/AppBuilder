<?php

/**
 * GENERAR EL CODIGO PHP CON EL CONTROL DE ACCIONES DE UNA TABLA
 *
 * NECESITA APOYARSE EN LA CLASE 'TableDescriptor'
 *
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright Informatica ALBATRONIC, SL 15.03.2011
 * @version 1.0
 */
class ControllerBuilder
{
    private $buffer;
    private $filename;
    private $td;

    public function __construct($table='')
    {
        $this->td = new TableDescriptor(DB_BASE, $table);

        //$this->filename = str_replace("_", " ", $this->td->getTable());
        //$this->filename = str_replace(" ", "", ucwords($this->filename));
        $this->filename = $this->td->getTable();
        $this->Load();
    }

    private function Load()
    {
        $sinPrefijo = str_replace(PREFIJO, "", $this->filename);

        $buf = "<?php\n";
        $buf .= "/**\n";
        $buf .= "* CONTROLLER FOR " . $sinPrefijo . "\n";
        $buf .= "* @author: Sergio Perez <sergio.perez@albatronic.com>\n";
        $buf .= "* @copyright: INFORMATICA ALBATRONIC SL \n* @date " . date('d.m.Y H:i:s') . "\n\n";
        $buf .= "* Extiende a la clase controller\n";
        $buf .= "*/\n\n";

        /**
         * Includes: NO SE USAN, EL AUTOLOADER SE ENCARGA DE CARGAR TODAS
         * LAS CLASES NECESARIAS
         *
        $buf .= "include \"entities/" . $this->filename . ".php\";\n\n";

        $ParentEntities = $this->td->getParentEntities();
        foreach ($ParentEntities as $value) {
            $buf .= "include \"entities/" . $value . ".php\";\n";
        }
        $buf .= "\ninclude \"modules/controller.php\";\n\n";
         */

        $buf .= "class " . $sinPrefijo . "Controller extends Controller {\n\n";
        $buf .= "\tprotected \$entity = \"" . $sinPrefijo . "\";\n";
        $buf .= "\tprotected \$parentEntity = \"\";\n\n";
        $buf .= "\tpublic function IndexAction() {\n";
        $buf .= "\t\treturn \$this->listAction();\n";
        $buf .= "\t}\n";
        $buf .= "}\n?>";

        $this->buffer = $buf;
    }

    /**
     * Devuelve el código php con el control de las acciones del formulario de mantenimiento
     * @return text
     */
    public function Get()
    {
        return $this->buffer;
    }

}

?>
