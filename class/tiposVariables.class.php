<?php

/**
 * CORRESPONDENCIAS ENTRE TIPOS DE VARTIABLES
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @date 08-sep-2012 13:12:42
 */
class tiposVariables {

    /**
     * Tabla de correspondencia de tipos de variales
     * @var array
     */
    static $tipos = array(
        "int" => "integer",
        "longtext" => "string",
        "text" => "string",
        "bool" => "bool",
        "date" => "date",
        "blob" => "integer",
        "float" => "integer",
        "decimal" => "integer",
        "double" => "integer",
        "bigint" => "integer",
        "tinyint" => "tinyint",
        "longint" => "integer",
        "varchar" => "string",
        "char" => "string",
        "smallint" => "integer",
        "datetime" => "datetime",
        "timestamp" => "datetime",
    );

}

?>
