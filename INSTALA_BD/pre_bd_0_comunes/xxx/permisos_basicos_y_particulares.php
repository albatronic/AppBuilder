<?php

/*
$id_opcion_permiso_insert=722;
$id_opcion_permiso_update=723;
$id_opcion_permiso_delete=724;
$id_opcion_permiso_list=725;
$id_opcion_permiso_modificar_orden=726;
*/

// **********************************************************
$id_opcion=$variablesubmodulo_id_opcion_permiso_insert;

		$tabla=$variableadmin_prefijo_tablas."permisos";

		$sql="select * from $tabla where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_insert="NO";
}else{ 
$permiso_insert="SI";
}


// **********************************************************
$id_opcion=$variablesubmodulo_id_opcion_permiso_update;

		$sql="select * from $tabla where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_update="NO";
}else{ 
$permiso_update="SI";
}


// **********************************************************
$id_opcion=$variablesubmodulo_id_opcion_permiso_delete;

		$sql="select * from $tabla where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_delete="NO";
}else{ 
$permiso_delete="SI";
}


// **********************************************************
$id_opcion=$variablesubmodulo_id_opcion_permiso_list;

		$sql="select * from $tabla where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_list="NO";
}else{ 
$permiso_list="SI";
}


// **********************************************************
$id_opcion=$variablesubmodulo_id_opcion_permiso_auditoriacampo;

		$sql="select * from $tabla where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_auditoriacampo="NO";
}else{ 
$permiso_auditoriacampo="SI";
}


// **********************************************************
/*$id_opcion=$id_opcion_permiso_modificar_orden;

		$sql="select * from permisos where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_modificar_orden="NO";
}else{ 
$permiso_modificar_orden="SI";
}*/



if(strlen(trim($variablesubmodulo_script_permisos_particulares))>1){
$ruta = $f.'/'.$f1.'/'.$variablesubmodulo_script_permisos_particulares.'.php'; if(file_exists($ruta)){ include("$ruta"); }
}

?>