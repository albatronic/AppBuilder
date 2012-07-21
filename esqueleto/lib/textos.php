<?php
function DecodificaTexto($variable){
	$enter=chr(13);
	$resultado=str_replace("<br>", $enter, $variable);
	$resultado=str_replace("<br />", $enter, $resultado);
        $resultado=str_replace("&nbsp;", " ", $resultado);
	$resultado=str_replace("&quot;", "\"", $resultado);
	$resultado=str_replace("&gt;",">",$resultado);
	return $resultado;
}
	
function CodificaTexto($variable){

	$enter=chr(13);
	$espacio=chr(32);
	$comillasdobles="\"";//chr(92).chr(34);
	$comillassimples="'";//chr(92).chr(39);
	$menor="<";//chr(60);
	$mayor=">";//chr(62);
	$modifico1=str_replace($comillasdobles, "&quot;", $variable); 
	$modifico2=str_replace($comillassimples, "&#39;", $modifico1); 
	$modifico3=str_replace($menor, "&lt;", $modifico2); 
	$modifico4=str_replace($mayor, "&gt;", $modifico3); 
	$modifico5=str_replace($enter, "<br>", $modifico4); 
	$resultado=str_replace("  ", "&nbsp;&nbsp;", $modifico5); 
	return $resultado;
}

function trato_comillas($variable){

	$comillasdobles=chr(92).chr(34);
	$comillassimples=chr(92).chr(39);
	$menor=chr(60);
	$mayor=chr(62);
	$modifico1=str_replace($comillasdobles, "&quot;", $variable); 
	$modifico2=str_replace($comillassimples, "&#39;", $modifico1); 
	$modifico3=str_replace($menor, "&lt;", $modifico2); 
	$resultado=str_replace($mayor, "&gt;", $modifico3); 
	return $resultado;
}
?>
