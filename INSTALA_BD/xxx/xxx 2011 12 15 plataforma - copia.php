<?php
session_start();
header('Content-Type: text/html; charset=iso-8859-1');

include("1_comunes/variables_comunes_todos_modulos.php"); 
include("0_comunes/funciones_comunes_todos_modulos.php"); 
include("0_comunes/variables_sesion.php"); 
include("0_comunes/capturo_var_get_post.php"); 
include("0_comunes/conecta.php"); $db=conecta(); 
include("0_login/procesologin.php");   


//$num_perfil=1; //OJOOOOOOOOOOOOOO  BORRAR ESTO DE AQUI

	$ruta = $f.'/'.$f1.'/1_metatags.php'; include("$ruta");
	$ruta = $f.'/'.$f1.'/1_opciones.php'; include("$ruta");
	$ruta = $f.'/'.$f1.'/1_variables_particulares_este_modulo.php'; include("$ruta");



include("0_comunes/html_metatags.php"); 
include("0_comunes/estilos_comunes_todos_modulos.php"); 
	//$ruta = $f.'/'.$f1.'/1_estilos_particulares_este_modulo.php'; include("$ruta");

include("0_comunes/javascript_comunes_todos_modulos.php"); 
	//$ruta = $f.'/'.$f1.'/1_javascript_particulares_este_modulo.php'; include("$ruta");


?>



</head>

<body>
<?php
if($permiso_global_este_nivel=="SI"){ // INICIO: if($permiso_global_este_nivel=="SI")

	if($var_mostrar_barra_herramientas=="SI"){
		echo '<div id="barra_herramientas">';
		echo '<img src="imagenes_barraherramientas/btn_herr_salir.jpg" alt="" title="" />';
		echo '<img src="imagenes_barraherramientas/btn_herr_cerrarsesion.jpg" alt="" title="" />';
		echo '</div>';
	}


	$cargo_script=$f.'/'.$f1.'/'.$s1.'.php'; include("$cargo_script");

} // FIN: if($permiso_global_este_nivel=="SI")
?>
</body>

</html>