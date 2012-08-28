<?php
function conecta()
{
global $nombre_bd;
global $nombre_user; 
global $password; 
global $nombre_bd; 
global $localizacion; 

$db=mysql_connect($localizacion,$nombre_user,$password);
return $db;
}
?>