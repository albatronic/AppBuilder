<?php

$nombre_tabla_permisos=$variableadmin_prefijo_tablas."permisos";

/* ASIGNAMOS PERMISOS AL SUPERADMINISTRADOR */
$sqlinsert="insert into $nombre_tabla_permisos (id_permiso,num_permiso,id_usuario,id_opcion,valor) values(null, null, '1', '$id_opcion', 'SI')";
$resinsert=mysql_query($sqlinsert,$db);
$veoultimoidpermiso=mysql_insert_id();
$sqlupdate="update $nombre_tabla_permisos set num_permiso='$veoultimoidpermiso' where id_permiso='$veoultimoidpermiso'";
$resupdate=mysql_query($sqlupdate,$db);

/* SE COMPRUEBA QUE TODO HA IDO BIEN AL ASIGNAR PERMISOS AL SUPERADMINISTRADOR */
if($resupdate){
echo 'PERMISO ASIGNADO AL SUPERADMINISTRADOR!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO ASIGNAR EL PERMISO AL SUPERADMINISTRADOR</font><br>';
}

/* ASIGNAMOS PERMISOS AL ADMINISTRADOR DEL CLIENTE */
$sqlinsert="insert into $nombre_tabla_permisos (id_permiso,num_permiso,id_usuario,id_opcion,valor) values(null, null, '2', '$id_opcion', 'SI')";
$resinsert=mysql_query($sqlinsert,$db);
$veoultimoidpermiso=mysql_insert_id();
$sqlupdate="update $nombre_tabla_permisos set num_permiso='$veoultimoidpermiso' where id_permiso='$veoultimoidpermiso'";
$resupdate=mysql_query($sqlupdate,$db);

/* SE COMPRUEBA QUE TODO HA IDO BIEN AL ASIGNAR PERMISOS AL ADMINISTRADOR DEL CLIENTE */
if($resupdate){
echo 'PERMISO ASIGNADO AL ADMINISTRADOR DEL CLIENTE!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO ASIGNAR EL PERMISO AL ADMINISTRADOR DEL CLIENTE</font><br>';
}


/*
// NEGAMOS EL PERMISO A TODOS LOS USUARIOS QUE NO SON LOS ADMINISTRADORES PRINCIPALES (A LOS CLIENTES NO SE LE ASIGNAN PERMISOS SOBRE LA APLICACIÓN DE GESTIÓN) 

		$sql="select * from usuarios where num_usuario<>'1' and num_usuario<>'2'";
		$res=mysql_query($sql,$db);
		while ($reg=mysql_fetch_array($res,MYSQL_NUM))
		{
		    $numusuario=$reg[1];
			$num_tipousuario=$reg[2];
			if($num_tipousuario=="2"){
			}else{
			$sqlinsert="insert into permisos (id_permiso,num_permiso,id_usuario,id_opcion,valor) values(null, null, '$numusuario', '$id_opcion', 'NO')";
			$resinsert=mysql_query($sqlinsert,$db);
			$veoultimoidpermiso=mysql_insert_id();
			$sqlupdate="update permisos set num_permiso='$veoultimoidpermiso' where id_permiso='$veoultimoidpermiso'";
			$resupdate=mysql_query($sqlupdate,$db);
			}

		}
// SE COMPRUEBA QUE TODO HA IDO BIEN AL DENEGAR PERMISOS A LOS ADMINISTRADORES SECUNDARIOS 
if($resupdate){
echo 'PERMISO DENEGADO A LOS ADMINISTRADORES SECUNDARIOS!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO DENEGAR EL PERMISO AL ADMINISTRADOR SECUNDARIO</font><br>';
} 
*/


?>