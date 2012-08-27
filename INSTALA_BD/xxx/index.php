<?php
session_start();
header('Content-Type: text/html; charset=iso-8859-1');

//header('Content-Type: text/html; charset=iso-8859-1');

include("cnfg.php"); 
$ruta = $cnfg_prefijo_carpetas.'1_comunes/variables_comunes_todos_modulos.php'; include("$ruta");
$ruta = $variableadmin_prefijo_bd.'0_comunes/funciones_comunes_todos_modulos.php'; include("$ruta");
$ruta = $variableadmin_prefijo_bd.'0_comunes/variables_sesion.php'; include("$ruta");
$ruta = $variableadmin_prefijo_bd.'0_comunes/capturo_var_get_post.php'; include("$ruta");
$ruta = $f.'/'.$f1.'/1_config_submodulo.php'; include("$ruta"); //if (file_exists($ruta)){}

$ruta = $variableadmin_prefijo_bd.'data/variables/'.$variablesubmodulo_carpeta_submodulo.'.php'; if(file_exists($ruta)){include("$ruta");}

$ruta = $variableadmin_prefijo_bd.'0_comunes/conecta.php'; include("$ruta"); $db=conecta();
$ruta = $variableadmin_prefijo_bd.'0_comunes/vemos_permiso_global_este_nivel.php'; include("$ruta");
$ruta = $variableadmin_prefijo_bd.'0_comunes/permisos_basicos_y_particulares.php'; include("$ruta");
$ruta = $variableadmin_prefijo_bd.'0_login/procesologin.php'; include("$ruta");



//$num_perfil=1; //OJOOOOOOOOOOOOOO  BORRAR ESTO DE AQUI
//$var_mostrar_barra_herramientas="NO"; //OJOOOOOOOOOOOOOO  BORRAR ESTO DE AQUI

$ruta = $variableadmin_prefijo_bd.$f.'/'.$f1.'/1_metatags.php'; if (file_exists($ruta)){include("$ruta"); }
//$ruta = $f.'/'.$f1.'/1_opciones.php'; if (file_exists($ruta)){include("$ruta");}
//$ruta = $f.'/'.$f1.'/1_variables_particulares_este_modulo.php'; if (file_exists($ruta)){include("$ruta");}


$ruta = $variableadmin_prefijo_bd.'0_comunes/html_metatags.php'; include("$ruta");
$ruta = $variableadmin_prefijo_bd.'0_comunes/estilos_comunes_todos_modulos.php'; include("$ruta");



$cargo_script_head=$f.'/'.$f1.'/'.$s1.'_head.php'; if (file_exists($cargo_script_head)){include("$cargo_script_head");}

if($run_copy==SI){$cargo_script_run_copy=$f_Padre.'/'.$f1_Padre.'/1_run_copy_'.$f1.'.php'; if (file_exists($cargo_script_run_copy)){include("$cargo_script_run_copy");}}
$ruta = $variableadmin_prefijo_bd.'0_comunes/javascript_comunes_todos_modulos.php'; include("$ruta");

?>



</head>

<?php

if(strlen(trim($accionBody))>0){
	echo '<body onLoad="'.$accionBody.'()">';
}else{
	echo '<body>';
}
if($permiso_global_este_nivel=="SI"){ // INICIO: if($permiso_global_este_nivel=="SI")

//$variablesubmodulo_mostrar_barra_herramientas="NO";
if($variablesubmodulo_mostrar_barra_herramientas=="SI"){ 
	echo '<div id="barra_menus">';
	echo '';
	echo '</div>';	
	
	echo '<div id="barra_herramientas">';
	$ruta = $f.'/'.$f1.'/1_barraHerramientas.php'; include("$ruta");//if (file_exists($ruta)){}
	echo '</div>';		

	echo '<div id="barra_ruta">'; // INICIO: <div id="barra_ruta">

	echo '<div id="desplegablesNavegacion">&nbsp;';
	//echo 'desplegables';
	echo '</div>';		

	echo '<div id="ruta">';
	$ruta = $variableadmin_prefijo_bd.'0_comunes/ruta.php'; include("$ruta");
	//$cargo_script = $f.'/'.$f1.'/1_ruta.php'; include("$cargo_script");//if (file_exists($cargo_script)){}
	echo '&nbsp;&nbsp;&nbsp;&nbsp;</div>';		

	echo '</div>'; // FIN: <div id="barra_ruta">
}

echo '<div id="contenidos">'; // INICIO <div id="contenidos">
		$cargo_script=$f.'/'.$f1.'/'.$s1.'.php'; include("$cargo_script");//if (file_exists($cargo_script)){}

echo '</div>'; // FIN <div id="contenidos">


} // FIN: if($permiso_global_este_nivel=="SI")
?>
</body>

</html>