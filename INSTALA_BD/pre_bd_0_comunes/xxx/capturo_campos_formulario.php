<?php

$contadorCampos=0;
$arrayDeCampos = array();
$arrayDeValores = array();

foreach($_POST as $clave=>$valor){
	$contadorCampos=$contadorCampos+1;
	$arrayDeCampos[$contadorCampos]=$clave;
	if($variablesubmodulo_mayusculas=="SI"){$valor=strtoupper($valor);}
	$arrayDeValores[$contadorCampos]=$valor;
}




	$name_tabla=$variablesubmodulo_tabla_submodulo; 

	$sql="select * from $name_tabla where $variablesubmodulo_nombre_campo_md5='$num_objeto_md5'";
	$res=mysql_query($sql,$db);
	$num_campos=mysql_num_fields($res);

for ($i=0; $i<$num_campos; $i++){ // INICIO: bucle for
	$nombreCampo=mysql_field_name($res,$i);
	$tipo_campo=mysql_field_type($res,$i);
	$longitud_campo=mysql_field_len($res,$i);

if($tipo_campo=="datetime"){
		if(in_array($nombreCampo, $variableadmin_campos_fecha_no_formularios)){  // INICIO: if(in_array) // FIN: if(in_array)
		}else{
			$nombreCampoDia="dia_".$nombreCampo; $$nombreCampoDia=$_POST["$nombreCampoDia"]; 
			$nombreCampoMes="mes_".$nombreCampo; $$nombreCampoMes=$_POST["$nombreCampoMes"]; 
			$nombreCampoYear="year_".$nombreCampo; $$nombreCampoYear=$_POST["$nombreCampoYear"]; 
			if (strlen($$nombreCampoYear) > 1){
				$$nombreCampo=$$nombreCampoYear."-".$$nombreCampoMes."-".$$nombreCampoDia." 00:00:00"; 
				//echo $nombreCampo,": ",$$nombreCampo,"<br>";
			}
		}
}


	//echo $nombreCampo," | ",$tipo_campo," | ",$longitud_campo," | ",$$nombre_campo," | ",$arrayDeValores[$miIndiceProblema],"<br>";

	if(in_array($nombreCampo, $arrayDeCampos)){  // INICIO: if(in_array)
	
		$contadorIndices=0;
		foreach($arrayDeCampos as $veoValores){
			$contadorIndices=$contadorIndices+1;
			if($veoValores==$nombreCampo){$miIndiceProblema=$contadorIndices; break;}
		}

		if($variablesubmodulo_elimino_acento_primer_caracter=="SI"){
		$ruta = $variableadmin_prefijo_bd.'0_comunes/eliminoAcentoPrimerCaracter.php'; include("$ruta");
		}
		$ruta = $variableadmin_prefijo_bd.'0_comunes/tratamientoDeCadenas.php'; include("$ruta");
		$ruta = $variableadmin_prefijo_bd.'0_comunes/auditoriaDeCadaCampo.php'; include("$ruta");

		//echo $nombreCampo," | ",$arrayDeValores[$miIndiceProblema]," | ",$tipo_campo,"<br>";
	}// FIN: if(in_array)





} // FIN: buble for

		$ruta = $variableadmin_prefijo_bd.'0_comunes/capturoCampoCheckbox.php'; include("$ruta");

?>
