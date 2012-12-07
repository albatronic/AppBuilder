<?php

/**
 * RECORRE TODAS LAS TABLAS DE LA BASE DE DATOS $db
 * Y EJECUTA SOBRE ELLAS TODAS LAS QUERYS DEFININAS 
 * EN EL ARRAY $querys
 * 
 */
$db = $_GET['db'];

$querys[] = "ALTER TABLE  `TABLA` ADD  `IsSuper` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  'Abstract,ValoresSN,IDTipo' AFTER  `IsDefault` ,
ADD INDEX (  `IsSuper` );";
$querys[] = "ALTER TABLE  `TABLA` ADD  `DateTimeLastVisit` BIGINT( 11 ) NOT NULL DEFAULT  '0',
ADD INDEX (  `DateTimeLastVisit` );";

$dbLink = mysql_connect('localhost', 'root', 'albatronic');
if ($dbLink) {
    $connectId = mysql_select_db($db, $dbLink);
    if ($connectId) {
        $query = "SHOW TABLES";
        $result = mysql_query($query);
        while ($row = mysql_fetch_array($result)) {

            foreach ($querys as $query) {
                $query = str_replace("TABLA", $row[0], $query);
                $ok = mysql_query($query);
            }
            echo $row[0], " {$ok}<br/>";
        }

        mysql_close($dbLink);
    } else {
        echo "NO SE HA ESTABLECIDO CONEXION CON LA BASE DE DATOS '{$db}'";
    }
} else {
    echo "NO SE HA ESTABLECIDO CONEXION CON EL SERVIDOR";
}
?>
