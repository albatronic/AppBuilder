<?php


$nombre_tabla_opciones=$variableadmin_prefijo_tablas."opciones";
//echo $f,"<br>";
$sql="select id_opcion,txtmostrar,descripcion,es_opcion_super,carpeta,imagen_icono,enlace,s1 from $nombre_tabla_opciones where pertenece_a='$variablesubmodulo_opcion_raiz_submodulo' and mostrar='SI' order by orden asc";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
		$id_opcion=$reg['id_opcion'];
		$txtmostrar=$reg['txtmostrar'];
		$descripcion=$reg['descripcion'];
		$es_opcion_super=$reg['es_opcion_super'];
		$carpeta_opciones=$reg['carpeta'];
		$imagen_icono_opciones=$reg['imagen_icono'];
		$enlace_opciones=$reg['enlace'];
		$s1_opciones=$reg['s1'];

		$valor = "NO";

		$nombre_tabla_permisos=$variableadmin_prefijo_tablas."permisos";	
		$sqlpermisos="select valor from $nombre_tabla_permisos where id_opcion='$id_opcion' and id_usuario='$num_perfil'";
		//echo $sqlpermisos,"<br>";
		$respermisos=mysql_query($sqlpermisos,$db);
		while ($regpermisos=mysql_fetch_array($respermisos))
		{
		$valor=$regpermisos['valor'];
		}


if($valor == "SI"){
//echo $f,"<br>";
//$ruta = $f.'/'.$f1.'/1_configOpcionesMenuPrincipal.php';  include("$ruta"); //if (file_exists($ruta)){}
echo '<a href="'.$enlace_opciones.'"><img src="'.$variableadmin_prefijo_bd.'imagenes_iconos/'.$imagen_icono_opciones.'" alt="'.$txtmostrar.'" title="'.$txtmostrar.'" /></a>';
}

}

?>