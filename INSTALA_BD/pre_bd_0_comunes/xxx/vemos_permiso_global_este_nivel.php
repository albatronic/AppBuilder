<?php

if($variablesubmodulo_permiso_global_este_nivel!="SI"){ // INICIO: if($variablesubmodulo_permiso_global_este_nivel!="SI")


$nombre_tabla=$variableadmin_prefijo_tablas."permisos";
$sqlpermisos="select valor from $nombre_tabla where id_opcion='$variablesubmodulo_opcion_raiz_submodulo' and id_usuario='$num_perfil'";
$respermisos=mysql_query($sqlpermisos,$db);
while ($regpermisos=mysql_fetch_array($respermisos))
{
	$valor=$regpermisos['valor'];
	if($valor=="SI"){$permiso_global_este_nivel="SI";} 		
}

if($variablesubmodulo_opcion_raiz_submodulo==0){$permiso_global_este_nivel="SI";} 		


} else { // FIN: if($variablesubmodulo_permiso_global_este_nivel!="SI")

	$permiso_global_este_nivel="SI";

}


		
?>