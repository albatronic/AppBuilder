<?php
		

$tabla=$variablesubmodulo_tabla_submodulo;

$sql="select $variablesubmodulo_nombre_campo_id from $tabla where eliminado='NO'";
//echo $sql,"<br>";
$res=mysql_query($sql,$db);
$totalobjetos=mysql_num_rows($res);

//echo "totalobjetos: ",$totalobjetos,"<br>";

if($totalobjetos < $maximopermitido){
	$hago_insert="SI"; 
}else{
	$hago_insert="NO";
	$muestro_formulario="NO";
	$alerta="SI";
	$texto_alerta="Ha excedido el M&aacute;ximo N&uacute;mero de Registros permitidos";

		decode_acentos($texto_alerta);
		$texto_alerta=$resultado; 
	
}



?>