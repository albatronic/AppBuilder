<?php
//echo "xxx: ",$variablesubmodulo_opcion_raiz_submodulo;

$nombre_tabla=$variableadmin_prefijo_tablas."opciones";
$sql="select * from $nombre_tabla where id_opcion='$variablesubmodulo_opcion_raiz_submodulo'";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
		$nivel_subir=$reg['nivel'];
		$pertenece_a_subir=$reg['pertenece_a'];
		$txtmostrar_subir=$reg['txtmostrar'];
		$carpeta_subir=$reg['carpeta'];
		$imagen_icono_subir=$reg['imagen_icono'];
		$enlace_subir=$reg['enlace'];
		$s1_subir=$reg['s1'];
}
//echo " nivel_ruta: ",$nivel_subir;
//echo " carpeta_ruta: ",$carpeta_subir;

if($nivel_subir==1){$destino_subir='index.php?g=1&amp;f='.$variableadmin_prefijo_bd.'gs_h';}

if($nivel_subir==2){ // INICIO: if($nivel_ruta==2)
		$sql="select * from $nombre_tabla where id_opcion='$pertenece_a_subir'";
		$res=mysql_query($sql,$db);
		while ($reg=mysql_fetch_array($res))
		{
				$nivel_subir_nivel1=$reg['nivel'];
				$pertenece_a_subir_nivel1=$reg['pertenece_a'];
				$txtmostrar_subir_nivel1=$reg['txtmostrar'];
				$carpeta_subir_nivel1=$reg['carpeta'];
				$imagen_icono_subir_nivel1=$reg['imagen_icono'];
				$enlace_subir_nivel1=$reg['enlace'];
				$s1_subir_nivel1=$reg['s1'];
		}
//echo " carpeta_subir_nivel1: ",$carpeta_subir_nivel1;


if($s1=="0_menu_principal"){
	$destino_subir="index.php?g=1&amp;f=".$variableadmin_prefijo_bd.$carpeta_subir_nivel1;
}else{
	$destino_subir="index.php?g=1&amp;f=".$variableadmin_prefijo_bd.$carpeta_subir_nivel1."&amp;f1=".$carpeta_subir;
}
}// FIN: if($nivel_ruta==2)

echo '<a href="'.$destino_subir.'"><img src="'.$variableadmin_prefijo_bd.'imagenes_barraherramientas/btn_herr_subir.jpg" alt="Subir un Nivel" title="Subir un Nivel" /></a>';

?>