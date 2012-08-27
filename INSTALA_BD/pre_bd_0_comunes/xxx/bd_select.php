<?php

//$erroresbd=0; // INICIALIZAMOS el Contador de Errores con la Base de Datos
		
		//if($func_decode_gestorcontenidos != "SI"){include ('funciones/decode_gestorcontenidos_acentos_v2.php');}

		//if($func_trato_comillas != "SI"){include ('funciones/trato_comillas_v2.php');}

		//if($func_decodeprocesadortextos != "SI"){include ('funciones/decodeprocesadortextos.php');}


$ruta = $variableadmin_prefijo_bd.'0_comunes/bd_select_sql.php'; include("$ruta");  


		//decode_gestorcontenidos($observaciones);
		//$observaciones=$resultado;

		//decodeprocesadortextos($observaciones);
		//$observaciones=$resultado;

/*
		trato_comillas($titulo);
		$titulo=$resultado;

		trato_comillas($url);
		$url=$resultado;

		trato_comillas($observaciones);
		$observaciones=$resultado;
*/



/*
if($cnfg_config_select_basicos != "SI"){
	$ruta_select_basicos = $modulo.'/007_config_select_basicos.php'; include("$ruta_select_basicos");
}

if($cnfg_config_decode_select != "SI"){
	$ruta_decode_select = $modulo.'/008_config_decode_select.php'; include("$ruta_decode_select");
}
*/



// ****************************************************************************************************
	//include("recursos_api/formulario_select_varios_1.php"); // FORMULARIO EN FORMATO SIMPLIFICADO fechapublicacion | fechaultimamodificacion | nick_usuarioquepublica | nick_usuarioultimamodificacion


	/* if($erroresbd!="0"){
	echo "<center><font face='Arial' color='#ff0000' size='2'><b>Nº Errores: ".$erroresbd."</b>: Proceso Select <b>[".$name_tabla."]</b></font></center><br>";
	} */



?>