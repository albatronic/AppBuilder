<?php
function decodeprocesadortextos($variable)
	{
	global $resultado;
$resultado=str_replace("&nbsp;", " ", $variable); 

$resultado=str_replace("<br />", "", $resultado); 
	return $resultado;
	}
	
	$func_decodeprocesadortextos = "SI";
?>