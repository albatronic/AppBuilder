<?php
function trato_comillas($variable)
	{
	global $resultado;

$comillasdobles=chr(92).chr(34);
$comillassimples=chr(92).chr(39);
$menor=chr(60);
$mayor=chr(62);
$signo_ampersand=chr(38);
$signo_cerrar_interrogacion=chr(63);
$dolar=chr(36);
$igual=chr(61);

$modifico0=trim($variable); 
$modifico01=str_replace($signo_cerrar_interrogacion, "&#63;", $modifico0); 
$modifico02=str_replace($dolar, "&#36;", $modifico01); 
$modifico03=str_replace($igual, "&#61;", $modifico02); 

$modifico1=str_replace($signo_ampersand, "&amp;", $modifico03); 
$modifico2=str_replace($comillassimples, "&#39;", $modifico1); 
$modifico3=str_replace($menor, "&lt;", $modifico2); 
$modifico4=str_replace($comillasdobles, "&quot;", $modifico3); 
$modifico41=str_replace("&amp;#63;", "&#63;", $modifico4); 
$modifico42=str_replace("&amp;#36;", "&#36;", $modifico41); 
$modifico43=str_replace("&amp;#61;", "&#61;", $modifico42); 

$resultado=str_replace($mayor, "&gt;", $modifico43); 

	return $resultado;
	}
	

$function_trato_comillas="SI";	
?>