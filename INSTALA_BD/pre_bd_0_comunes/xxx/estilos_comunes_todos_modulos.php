<?php

echo '<link href="'.$variableadmin_prefijo_bd.'estilos/reset.css" rel="stylesheet" type="text/css">';
echo '<link href="'.$variableadmin_prefijo_bd.'estilos/layout.css" rel="stylesheet" type="text/css">';
echo '<link href="'.$variableadmin_prefijo_bd.'estilos/formularios.css" rel="stylesheet" type="text/css">';
$ruta = $f.'/'.$f1.'/1_estilos_particulares_este_modulo.php';  if (file_exists($ruta)) {include("$ruta");}


/*echo '<style media="screen" type="text/css">';
		echo '@import url("'.$variableadmin_prefijo_bd.'estilos/reset.css");
		@import url("'.$variableadmin_prefijo_bd.'estilos/layout.css");
		@import url("'.$variableadmin_prefijo_bd.'estilos/formularios.css");';


echo '</style>';*/
?>