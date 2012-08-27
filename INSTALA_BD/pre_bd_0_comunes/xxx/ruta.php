<?php
$nombre_tabla=$variableadmin_prefijo_tablas."opciones";

if($variablesubmodulo_opcion_raiz_submodulo==0){ echo 'Inicio';} // MENÚ INICIO DE LA PLATAFORMA



if($variablesubmodulo_opcion_raiz_submodulo>0){ // INICIO: if($variablesubmodulo_opcion_raiz_submodulo>0)

$sql="select * from $nombre_tabla where id_opcion='$variablesubmodulo_opcion_raiz_submodulo'";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
		$nivel_ruta=$reg['nivel'];
		$pertenece_a_ruta=$reg['pertenece_a'];
		$txtmostrar_ruta=$reg['txtmostrar'];
		$carpeta_ruta=$reg['carpeta'];
		$imagen_icono_ruta=$reg['imagen_icono'];
		$enlace_ruta=$reg['enlace'];
		$s1_ruta=$reg['s1'];
}

			if($nivel_ruta==1){ // INICIO: if($nivel_ruta==1)
				echo '<a href="index.php?g=1&amp;f='.$variableadmin_prefijo_bd.'gs_h">Inicio</a>';
				echo ' > ';
				echo $txtmostrar_ruta;
			} // FIN: if($nivel_ruta==1)




if($nivel_ruta==2){ // INICIO: if($nivel_ruta==2)
//echo " nivel_ruta: ",$nivel_ruta;
//echo " carpeta_ruta: ",$carpeta_ruta;
//echo " s1: ",$s1;

		$sql="select * from $nombre_tabla where id_opcion='$pertenece_a_ruta'";
		$res=mysql_query($sql,$db);
		while ($reg=mysql_fetch_array($res))
		{
				$nivel_ruta_nivel1=$reg['nivel'];
				$pertenece_a_ruta_nivel1=$reg['pertenece_a'];
				$txtmostrar_ruta_nivel1=$reg['txtmostrar'];
				$carpeta_ruta_nivel1=$reg['carpeta'];
				$imagen_icono_ruta_nivel1=$reg['imagen_icono'];
				$enlace_ruta_nivel1=$reg['enlace'];
				$s1_ruta_nivel1=$reg['s1'];
		}


echo '<a href="index.php?g=1&amp;f='.$variableadmin_prefijo_bd.'gs_h">Inicio</a>';

echo ' > ';
echo '<a href="index.php?g=1&amp;f='.$variableadmin_prefijo_bd.$carpeta_ruta_nivel1.'">'.$txtmostrar_ruta_nivel1.'</a>';


if($s1=="0_menu_principal"){
echo ' > ';
echo $txtmostrar_ruta;
}


if($s1=="0_nuevo"){
echo ' > ';
echo '<a href="index.php?g=1&amp;f='.$variableadmin_prefijo_bd.$carpeta_ruta_nivel1.'&amp;f1='.$carpeta_ruta.'">'.$txtmostrar_ruta.'</a>';
echo ' > Nuevo';
}


if($s1=="0_formulario"){
echo ' > ';
echo '<a href="index.php?g=1&amp;f='.$variableadmin_prefijo_bd.$carpeta_ruta_nivel1.'&amp;f1='.$carpeta_ruta.'">'.$txtmostrar_ruta.'</a>';
echo ' > Formulario';
}

if($s1=="0_listado"){
echo ' > ';
echo '<a href="index.php?g=1&amp;f='.$variableadmin_prefijo_bd.$carpeta_ruta_nivel1.'&amp;f1='.$carpeta_ruta.'">'.$txtmostrar_ruta.'</a>';
echo ' > Listado';
}


} // FIN: if($nivel_ruta==2)


} // FIN: if($variablesubmodulo_opcion_raiz_submodulo>0)

?>
