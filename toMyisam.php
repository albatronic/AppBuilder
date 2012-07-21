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
$link_identifier=mysql_connect('localhost','root','');
mysql_select_db('interpral_ppuerp001', $link_identifier);
$query="show tables;";
$result=mysql_query($query);
while($row =  mysql_fetch_array($result)){
    $query="ALTER TABLE `".$row[0]."` ENGINE = MYISAM";
    echo "<br>".$query;
    mysql_query($query);
}
?>
