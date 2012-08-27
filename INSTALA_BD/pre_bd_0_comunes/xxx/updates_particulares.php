<?php

$sqlupdate="update $name_tabla set ";
$sqlupdate.="$campoParticular='".$$campoParticular."'";
$sqlupdate.=" where $variablesubmodulo_nombre_campo_md5='$num_objeto_md5'";
$resupdate=mysql_query($sqlupdate,$db);
?>