<?php

$numeroElementosArray=0;
foreach ($variablesubmodulo_control_campos_blanco as $i => $value) {
	$numeroElementosArray=$numeroElementosArray+1;
}


//echo '<br><br><br><br><br><br><br><br><br><br><br>';
if($numeroElementosArray>0){ // INICIO: if($numeroElementosArray>0)
for ($i=0; $i<$numeroElementosArray; $i=$i+3){ // INICIO bucle for
    //echo $i,"<br>";
	$campoEnBlanco=$variablesubmodulo_control_campos_blanco[$i];
	$indicecriterio=$i+1;
	$criterioEnBlanco=$variablesubmodulo_control_campos_blanco[$indicecriterio];
	$indicetextoError=$i+2;
	$textoErrorEnBlanco=$variablesubmodulo_control_campos_blanco[$indicetextoError];
		/*echo "campoEnBlanco: ",$campoEnBlanco,"<br>";
		echo "criterioEnBlanco: ",$criterioEnBlanco,"<br>";
		echo "textoErrorEnBlanco: ",$textoErrorEnBlanco,"<br>"; */ 

$sql="select $campoEnBlanco from $name_tabla where $variablesubmodulo_nombre_campo_md5='$num_objeto_md5'";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
		$$campoEnBlanco=$reg["$campoEnBlanco"];
}

if($criterioEnBlanco=="longitud"){
	if(strlen(trim($$campoEnBlanco))<1){
		$errorFormulario=$errorFormulario+1; //echo $campoEnBlanco;
		$arrayDeErroresFormulario[$errorFormulario]=$textoErrorEnBlanco;
	}
}

if($criterioEnBlanco=="valorcero"){
	if($$campoEnBlanco<1){
		$errorFormulario=$errorFormulario+1;
		$arrayDeErroresFormulario[$errorFormulario]=$textoErrorEnBlanco;
	}
}


} // FIN bucle for
} // FIN: if($numeroElementosArray>0)
?>