<?php

/**
 * RECORRE LAS TABLAS DE LA BASE DE DATOS $db
 * Y EJECUTA SOBRE ELLAS TODAS LAS QUERYS DEFININAS 
 * EN EL ARRAY $querys
 * 
 * SI SE RECIBE UN VALOR DISTINTO DE '*' EN $_GET['t'] LAS QUERYS SE
 * EJECUTARAN SOLO EN ESE TABLA, SI EL VALOR ES '*' SE EJECUTARAN
 * EN TODAS LAS TABLAS
 */
$db = $_GET['db'];
$tablas = $_GET['t'];
if (($db == '') or ($tablas == ''))
    die("USO: alterTables.php?db=NOMBRE_DE_LA_BASE_DE_DATOS&t=[ NOMBRE_DE_LA_TABLA | * ]");

$querys[] = "ALTER TABLE `TABLA` ADD  `IdSeccionVideos` BIGINT(11)  NULL DEFAULT  NULL AFTER `IdSeccionEnlaces`";
/**
$querys[] = "ALTER TABLE `TABLA` ADD  `SubetiquetaWeb1` VARCHAR(25)  NULL DEFAULT  NULL AFTER `EtiquetaWeb1`";
$querys[] = "ALTER TABLE `TABLA` ADD  `SubetiquetaWeb2` VARCHAR(25)  NULL DEFAULT  NULL AFTER `EtiquetaWeb2`";
$querys[] = "ALTER TABLE `TABLA` ADD  `SubetiquetaWeb3` VARCHAR(25)  NULL DEFAULT  NULL AFTER `EtiquetaWeb3`";
$querys[] = "ALTER TABLE `TABLA` ADD  `SubetiquetaWeb4` VARCHAR(25)  NULL DEFAULT  NULL AFTER `EtiquetaWeb4`";
$querys[] = "ALTER TABLE `TABLA` ADD  `SubetiquetaWeb5` VARCHAR(25)  NULL DEFAULT  NULL AFTER `EtiquetaWeb5`";

$querys[] = "ALTER TABLE  `TABLA` ADD  `IsSuper` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  'Abstract,ValoresSN,IDTipo' AFTER  `IsDefault` ,
ADD INDEX (  `IsSuper` );";
$querys[] = "ALTER TABLE  `TABLA` ADD  `DateTimeLastVisit` BIGINT( 11 ) NOT NULL DEFAULT  '0',
ADD INDEX (  `DateTimeLastVisit` );";
*/

echo "<pre>";
print_r($querys);
echo "</pre>";
$dbLink = mysql_connect('localhost', 'root', 'Peces2010');
if ($dbLink) {
    $connectId = mysql_select_db($db, $dbLink);
    if ($connectId) {
        
        if ($tablas == '*') {
            $query = "SHOW TABLES";
            $result = mysql_query($query);
            while ($row = mysql_fetch_array($result))
                $rows[] = $row;
        } else
            $rows[][0] = $tablas;

        foreach ($rows as $row) {
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
