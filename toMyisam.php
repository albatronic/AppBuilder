<?php

/*
 * CONVIERTE TODAS LAS TABLAS DE UNA BASE DE DATOS
 * A FORMATO MyIsam
 *
 * @author: Sergio Perez <sergio.perez@albatronic.com>
 * @copyright: Informatica ALBATRONIC, SL
 * @date: 10-06-2011
 *
 */

if ($_GET['h'] == '' or $_GET['u'] == '' or $_GET['db'] == '')
    die("USO: toMyisam.php?h=HOST&u=USER&p=PASSWORD&db=DATABASE");

$dbLink = mysql_connect($_GET['h'], $_GET['u'], $_GET['p']);
if ($dbLink) {
    $idConection = mysql_select_db($_GET['db'], $dbLink);
    if ($idConection) {
        echo "CAMBIANDO TABLAS....<br/>";
        $query = "show tables;";
        $result = mysql_query($query);

        while ($row = mysql_fetch_array($result)) {
            $query = "ALTER TABLE `" . $row[0] . "` ENGINE = MYISAM";
            echo $query . "<br/>";
            mysql_query($query);
        }
    } else
        die("La base de datos indicada ({$_GET['db']}) no existe o no está disponible");
} else
    die("Error de conexión al servidor de datos");
