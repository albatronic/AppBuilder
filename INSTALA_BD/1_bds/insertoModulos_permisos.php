<?php
$NombreModulo=trim($Campo1_explode[1]);
$Funcionalidades=trim($Campo1_explode[6]);

$sqlpermisos="insert into $nombre_tabla_permisos (IDPermiso,IDPerfil,NombreModulo,Funcionalidades) values(null, '1', '$NombreModulo', '$Funcionalidades')";
$respermisos=mysql_query($sqlpermisos,$db);
//echo "<br>",$sqlpermisos,"<br>";
?>