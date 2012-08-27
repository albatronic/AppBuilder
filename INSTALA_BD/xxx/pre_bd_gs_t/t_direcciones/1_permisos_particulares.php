<?php


// **********************************************************
$id_opcion=17;

		$tabla=$variableadmin_prefijo_tablas."permisos";

		$sql="select * from $tabla where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_insert_t_paises="NO";
}else{ 
$permiso_insert_t_paises="SI";
}


// **********************************************************
$id_opcion=20;

		$tabla=$variableadmin_prefijo_tablas."permisos";

		$sql="select * from $tabla where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_list_t_paises="NO";
}else{ 
$permiso_list_t_paises="SI";
}


// **********************************************************
$id_opcion=45;

		$tabla=$variableadmin_prefijo_tablas."permisos";

		$sql="select * from $tabla where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_insert_t_provincias="NO";
}else{ 
$permiso_insert_t_provincias="SI";
}


// **********************************************************
$id_opcion=48;

		$tabla=$variableadmin_prefijo_tablas."permisos";

		$sql="select * from $tabla where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_list_t_provincias="NO";
}else{ 
$permiso_list_t_provincias="SI";
}


// **********************************************************
$id_opcion=40;

		$tabla=$variableadmin_prefijo_tablas."permisos";

		$sql="select * from $tabla where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_insert_t_localidades="NO";
}else{ 
$permiso_insert_t_localidades="SI";
}


// **********************************************************
$id_opcion=43;

		$tabla=$variableadmin_prefijo_tablas."permisos";

		$sql="select * from $tabla where id_opcion='$id_opcion' and id_usuario='$num_perfil' and valor='SI'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total==0){
$permiso_list_t_localidades="NO";
}else{ 
$permiso_list_t_localidades="SI";
}

?>