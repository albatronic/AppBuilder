<?php


$name_tabla=$variablesubmodulo_tabla_submodulo; 

$numeroElementosArray=0;
foreach ($variablesubmodulo_control_datos_repetidos as $i => $value) {
	$numeroElementosArray=$numeroElementosArray+1;
}


//echo '<br><br><br><br><br><br><br><br><br><br><br>';
if($numeroElementosArray>0){ // INICIO: if($numeroElementosArray>0)
for ($i=0; $i<$numeroElementosArray; $i=$i+3){ // INICIO bucle for
    //echo $i,"<br>";
	$campoRepetido=$variablesubmodulo_control_datos_repetidos[$i];
	$indicecriterio=$i+1;
	$criterioDatoRepetido=$variablesubmodulo_control_datos_repetidos[$indicecriterio];
	$indicetextoError=$i+2;
	$textoErrorDatoRepetido=$variablesubmodulo_control_datos_repetidos[$indicetextoError];
		/*echo "campoEnBlanco: ",$campoEnBlanco,"<br>";
		echo "criterioEnBlanco: ",$criterioEnBlanco,"<br>";
		echo "textoErrorEnBlanco: ",$textoErrorEnBlanco,"<br>"; */ 


$ruta = $f.'/'.$f1.'/'.$variablesubmodulo_control_datos_repetidos_script_particular.'.php';

if(file_exists($ruta)){
	include("$ruta");
}else{
$sql="select $variablesubmodulo_nombre_campo_id from $name_tabla where $campoRepetido='".$$campoRepetido."' and $variablesubmodulo_nombre_campo_md5<>'$num_objeto_md5' and eliminado='NO'";
}

$res=mysql_query($sql,$db);
$totalDatosRepetidos=mysql_num_rows($res);

if($totalDatosRepetidos>0){ // INICIO: if($totalDatosRepetidos>0)
		//echo "sql: ",$sql,"<br>";
		//echo "totalDatosRepetidos: ",$totalDatosRepetidos,"<br>";
		$errorFormulario=$errorFormulario+1;
		$arrayDeErroresFormulario[$errorFormulario]=$textoErrorDatoRepetido;
		$$campoRepetido=$criterioDatoRepetido;
}// FIN: if($totalDatosRepetidos>0)


} // FIN bucle for
} // FIN: if($numeroElementosArray>0)
?>