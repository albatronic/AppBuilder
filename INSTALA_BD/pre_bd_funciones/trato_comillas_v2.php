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

$a_acento=chr(225);
$e_acento=chr(233);
$i_acento=chr(237);
$o_acento=chr(243);
$u_acento=chr(250);
$a_may_acento=chr(193);
$e_may_acento=chr(201);
$i_may_acento=chr(205);
$o_may_acento=chr(211);
$u_may_acento=chr(218);

$enie_acento=chr(241);
$enie_may_acento=chr(209);

$exclamacion_abrir=chr(161);
$exclamacion_cerrar=chr(33);
$interrogacion_abrir=chr(191);
$interrogacion_cerrar=chr(63);

$resultado=trim($variable); 
$resultado=str_replace($signo_cerrar_interrogacion, "&#63;", $resultado); 
$resultado=str_replace($dolar, "&#36;", $resultado); 
$resultado=str_replace($igual, "&#61;", $resultado); 

$resultado=str_replace($signo_ampersand, "&amp;", $resultado); 


$resultado=str_replace($exclamacion_abrir, "&iexcl;", $resultado); 
$resultado=str_replace($exclamacion_cerrar, "&#33;", $resultado); 
$resultado=str_replace($interrogacion_abrir, "&iquest;", $resultado); 
$resultado=str_replace($interrogacion_cerrar, "&#63;", $resultado); 


$resultado=str_replace($a_acento, "&aacute;", $resultado); 
$resultado=str_replace($e_acento, "&eacute;", $resultado); 
$resultado=str_replace($i_acento, "&iacute;", $resultado); 
$resultado=str_replace($o_acento, "&oacute;", $resultado); 
$resultado=str_replace($u_acento, "&uacute;", $resultado); 
$resultado=str_replace($a_may_acento, "&Aacute;", $resultado); 
$resultado=str_replace($e_may_acento, "&Eacute;", $resultado); 
$resultado=str_replace($i_may_acento, "&Iacute;", $resultado); 
$resultado=str_replace($o_may_acento, "&Oacute;", $resultado); 
$resultado=str_replace($u_may_acento, "&Uacute;", $resultado); 
$resultado=str_replace($enie_acento, "&ntilde;", $resultado); 
$resultado=str_replace($enie_may_acento, "&Ntilde;", $resultado); 


$resultado=str_replace($comillassimples, "&#39;", $resultado); 
$resultado=str_replace($menor, "&lt;", $resultado); 
$resultado=str_replace($comillasdobles, "&quot;", $resultado); 
$resultado=str_replace("&amp;#63;", "&#63;", $resultado); 
$resultado=str_replace("&amp;#36;", "&#36;", $resultado); 
$resultado=str_replace("&amp;#61;", "&#61;", $resultado); 

$resultado=str_replace($mayor, "&gt;", $resultado); 

	return $resultado;
	}
	
	$function_trato_comillas="SI";
?>