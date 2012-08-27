<?php

$nombre_completo=$nombre." ".$apellido1." ".$apellido2;
$nombre_completo=trim($nombre_completo);

// UPDATE__________________________________________
$sqlupdate="update $name_tabla set ";
$sqlupdate.="nombre_completo='$nombre_completo'";
$sqlupdate.=" where $variablesubmodulo_nombre_campo_md5='$num_objeto_md5'";
$resupdate=mysql_query($sqlupdate,$db);


?>