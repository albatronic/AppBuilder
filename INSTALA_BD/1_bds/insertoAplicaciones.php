<?php
$nombre_tabla=$variableadmin_prefijo_tablas."core_aplicaciones";

$sqldelete="delete from $nombre_tabla";
$resdelete=mysql_query($sqldelete,$db);

$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/fechahoraahora.php'; include("$ruta");
if($function_trato_comillas!="SI"){$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/trato_comillas_v2.php'; include("$ruta");}
if($function_eliminoAcentoPrimerCaracter!="SI"){$ruta = '../'.$cnfg_prefijo_carpetas.'funciones/eliminoAcentoPrimerCaracter.php'; include("$ruta");}


$ruta = 'array_Aplicaciones.php'; include("$ruta");

$variablesubmodulo_nombre_campo_id="IDApp";
$variablesubmodulo_nombre_campo_md5="PrimaryKeyMD5";
$esdatopredeterminado_problema="1";
$publicar_problema="1";
$datosPredeterminados="insertoAplicaciones_datosPredeterminados"; //sin ".php"

foreach ($Campo1 as $value) { // INICIO: foreach #1
	$Campo1_explode = explode("|", $value);


	foreach ($Campo1_explode as $indice_explode => $value_explode) { // INICIO: foreach #2
		$value_explode=trim($value_explode);
		$ruta = 'insertoAplicaciones_ejecuto.php'; include("$ruta");
	}  // FIN: foreach #2


} // FIN: foreach #1


	unset($Campo1); 
	unset($value); 
	unset($Campo1_explode); 
	unset($value_explode); 

?>