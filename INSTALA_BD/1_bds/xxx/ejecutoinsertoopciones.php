<?php

$nombre_tabla_permisos=$variableadmin_prefijo_tablas."permisos";

/* ASIGNAMOS PERMISOS AL SUPERADMINISTRADOR */
$sqlinsert="insert into $nombre_tabla_permisos (id_permiso,id_usuario,id_opcion,valor) values(null, '1', '$id_opcion', 'SI')";
$resinsert=mysql_query($sqlinsert,$db);
/*$veoultimoidpermiso=mysql_insert_id();
$sqlupdate="update $nombre_tabla_permisos set num_permiso='$veoultimoidpermiso' where id_permiso='$veoultimoidpermiso'";
$resupdate=mysql_query($sqlupdate,$db);
*/

/* SE COMPRUEBA QUE TODO HA IDO BIEN AL ASIGNAR PERMISOS AL SUPERADMINISTRADOR */
if($resupdate){
echo 'PERMISO ASIGNADO AL SUPERADMINISTRADOR!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO ASIGNAR EL PERMISO AL SUPERADMINISTRADOR</font><br>';
}

/* ASIGNAMOS PERMISOS AL ADMINISTRADOR DEL CLIENTE */
$sqlinsert="insert into $nombre_tabla_permisos (id_permiso,id_usuario,id_opcion,valor) values(null, '2', '$id_opcion', 'SI')";
$resinsert=mysql_query($sqlinsert,$db);
/*$veoultimoidpermiso=mysql_insert_id();
$sqlupdate="update $nombre_tabla_permisos set num_permiso='$veoultimoidpermiso' where id_permiso='$veoultimoidpermiso'";
$resupdate=mysql_query($sqlupdate,$db);
*/

/* SE COMPRUEBA QUE TODO HA IDO BIEN AL ASIGNAR PERMISOS AL ADMINISTRADOR DEL CLIENTE */
if($resupdate){
echo 'PERMISO ASIGNADO AL ADMINISTRADOR DEL CLIENTE!<br>';
}else{
echo '<font color="#ff0000">NO SE HA PODIDO ASIGNAR EL PERMISO AL ADMINISTRADOR DEL CLIENTE</font><br>';
}




?>