<?php
function eliminoAcentoPrimerCaracter($variable)
	{
	global $resultado;

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


$variable=trim($variable); 
$numeroCaracteres=strlen($variable);
$numeroCaracteresMenosUno=$numeroCaracteres-1;

$primerCaracter=substr($variable,0,1);
$restoCaracteres=substr($variable,1,$numeroCaracteresMenosUno);



$resultado=str_replace($a_acento, "a", $primerCaracter); 
$resultado=str_replace($e_acento, "e", $resultado); 
$resultado=str_replace($i_acento, "i", $resultado); 
$resultado=str_replace($o_acento, "o", $resultado); 
$resultado=str_replace($u_acento, "u", $resultado); 
$resultado=str_replace($a_may_acento, "A", $resultado); 
$resultado=str_replace($e_may_acento, "E", $resultado); 
$resultado=str_replace($i_may_acento, "I", $resultado); 
$resultado=str_replace($o_may_acento, "O", $resultado); 
$resultado=str_replace($u_may_acento, "U", $resultado); 

	$resultado=$resultado.$restoCaracteres;

	return $resultado;
	}
	
	$function_eliminoAcentoPrimerCaracter="SI";
?>