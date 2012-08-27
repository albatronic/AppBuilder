<?php
if($_SESSION['controlinsert'] != 1){$ejecutoProcesoInsert="SI";}

// Si el objeto se crea al abrir un popup desde el formulario padre, entonces NO se hace el $_SESSION['controlinsert']
if($copio_Padre=="SI"){
if(strlen(trim($md5_Padre))>0){
$ejecutoProcesoInsert="SI";
}
}


if($ejecutoProcesoInsert=="SI"){


//$erroresbd=0; // INICIALIZAMOS el Contador de Errores con la Base de Datos
		
//include ('funciones/fechahoy.php'); // Cargamos la Fecha de Hoy en formato BD y PARA MOSTRAR

//include ('funciones/horaahora.php'); // Cargamos la Hora de Ahora en formato BD

//$datetime_ahora=$fechahoybd." ".$horaahorabd;

			$ruta = $variableadmin_prefijo_bd.'0_comunes/bd_insert_sql.php'; include("$ruta");

if(strlen(trim($variablesubmodulo_proceso_despues_insert))>0){
	$ruta = $f.'/'.$f1.'/'.$variablesubmodulo_proceso_despues_insert; include("$ruta");
}

/*
if(strlen(trim($conf_proceso_insert_despues))>0){
	$ruta_insert_despues = $modulo.'/'.$conf_proceso_insert_despues; include("$ruta_insert_despues");
}

		$num_objeto_md5=$num_objeto_md5; $num_usuario=$iu; $nombre_usuario=$nombredeusuarionick; 
		$fecha_modificacion=$datetime_ahora; $max_registros=$variableadmin_maxregistrosmodif;
		include ('modificaciones/gestion_registromodificaciones.php');  */
//$num_objeto_md5=$num_objeto_md5;
$tabla_registromodificaciones=$variablesubmodulo_tabla_submodulo;
$ruta = $variableadmin_prefijo_bd.'0_modificaciones/gestion_registromodificaciones.php'; include("$ruta");


}
?>