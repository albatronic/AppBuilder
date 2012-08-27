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

$modifico0=trim($variable); 
$modifico01=str_replace($signo_cerrar_interrogacion, "&#63;", $modifico0); 
$modifico02=str_replace($dolar, "&#36;", $modifico01); 
$modifico03=str_replace($igual, "&#61;", $modifico02); 

$modifico1=str_replace($signo_ampersand, "&amp;", $modifico03); 


$modifico001=str_replace($exclamacion_abrir, "&iexcl;", $modifico1); 
$modifico002=str_replace($exclamacion_cerrar, "&#33;", $modifico001); 
$modifico003=str_replace($interrogacion_abrir, "&iquest;", $modifico002); 
$modifico004=str_replace($interrogacion_cerrar, "&#63;", $modifico003); 


$modifico01=str_replace($a_acento, "&aacute;", $modifico004); 
$modifico02=str_replace($e_acento, "&eacute;", $modifico01); 
$modifico03=str_replace($i_acento, "&iacute;", $modifico02); 
$modifico04=str_replace($o_acento, "&oacute;", $modifico03); 
$modifico05=str_replace($u_acento, "&uacute;", $modifico04); 
$modifico06=str_replace($a_may_acento, "&Aacute;", $modifico05); 
$modifico07=str_replace($e_may_acento, "&Eacute;", $modifico06); 
$modifico08=str_replace($i_may_acento, "&Iacute;", $modifico07); 
$modifico09=str_replace($o_may_acento, "&Oacute;", $modifico08); 
$modifico010=str_replace($u_may_acento, "&Uacute;", $modifico09); 
$modifico011=str_replace($enie_acento, "&ntilde;", $modifico010); 
$modifico012=str_replace($enie_may_acento, "&Ntilde;", $modifico011); 


$modifico2=str_replace($comillassimples, "&#39;", $modifico012); 
$modifico3=str_replace($menor, "&lt;", $modifico2); 
$modifico4=str_replace($comillasdobles, "&quot;", $modifico3); 
$modifico41=str_replace("&amp;#63;", "&#63;", $modifico4); 
$modifico42=str_replace("&amp;#36;", "&#36;", $modifico41); 
$modifico43=str_replace("&amp;#61;", "&#61;", $modifico42); 

$resultado=str_replace($mayor, "&gt;", $modifico43); 

	return $resultado;
	}
	
	$func_trato_comillas="SI";
?>