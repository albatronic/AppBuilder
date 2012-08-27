<?php

$contadorCampos=0;
$arrayDeCampos = array();
$arrayDeValores = array();

foreach($_POST as $clave=>$valor){
	$contadorCampos=$contadorCampos+1;
	$arrayDeCampos[$contadorCampos]=$clave;
	$arrayDeValores[$contadorCampos]=$valor;
}

/*
$contadorIndices=0;
$campoProblema="nombre";
foreach($arrayDeCampos as $veoValores){
			$contadorIndices=$contadorIndices+1;
			echo $veoValores," <br>";
			if($veoValores==$campoProblema){$miIndiceProblema=$contadorIndices; break;}
}



echo '<br /><br />';
echo "miIndiceProblema: ",$miIndiceProblema,"<br>";
echo "Valor Problema: ",$arrayDeValores[$miIndiceProblema],"<br>";

echo "contadorCampos: ",$contadorCampos,"<br>";

echo "array 7: ",$arrayDeCampos[7],"<br>";
echo "array 7: ",$arrayDeValores[7],"<br>";

$campoBuscado="action";
if(in_array($campoBuscado, $arrayDeCampos)){ 
  echo "Si contiene el campo ",$campoBuscado; 
}else{ 
  echo "NO contiene el campo ",$campoBuscado; 
}  */

$name_tabla=$variablesubmodulo_tabla_submodulo; 

$sql="select * from $name_tabla";
$res=mysql_query($sql,$db);
$num_campos=mysql_num_fields($res);




$camposSqlUpdate="";

$sqlupdate="update $name_tabla set ";

for ($i=0; $i<$num_campos; $i++){ // INICIO: bucle for
	$nombreCampo=mysql_field_name($res,$i);

	if(in_array($nombreCampo, $arrayDeCampos)){  // INICIO: if(in_array)
	
		$contadorIndices=0;
		foreach($arrayDeCampos as $veoValores){
			$contadorIndices=$contadorIndices+1;
			if($veoValores==$nombreCampo){$miIndiceProblema=$contadorIndices; break;}
		}
	
		$camposSqlUpdate.="$nombreCampo='$arrayDeValores[$miIndiceProblema]', "; 

	}// FIN: if(in_array)

}// FIN: bucle for

$camposSqlUpdate=substr($camposSqlUpdate,0,-2);

$sqlupdate.=$camposSqlUpdate;
$sqlupdate.=" where $variablesubmodulo_nombre_campo_md5='$num_objeto_md5'";
$resupdate=mysql_query($sqlupdate,$db);
//echo $sqlupdate;

?>
