<?php

$campo_md5_Padre="num_direccion_md5"; // Este es el nombre del campo ID_MD5 del formulario Padre
$campo_copy_Padre="id_pais"; // Nombre del campo del formulario Padre donde se copiará el dato seleccionado en el Pop-Up
$decode_md5="SI"; // Si toma el valor SI, entonces tendremos que decodificar el valor MD5 que se ha seleccionado en el Pop-UP
$campo_ID_popup="id_pais";// Este es el nombre del campo ID del formulario Popup. Sólo es necesario si  $decode_md5="SI"
$campo_MD5_popup="num_pais_md5";// Este es el nombre del campo ID_MD5 del formulario Popup.  Sólo es necesario si  $decode_md5="SI"
$accionBody="submit_hijo_y_submit_padre"; // La acción Javascript que hara el body OnLoad 

$ruta = $variableadmin_prefijo_bd.'0_comunes/run_copy.php'; include("$ruta");

/* if($decode_md5=="SI"){
$name_tabla_popup=$variableadmin_prefijo_tablas.$f1;
$sql="select $campo_ID_popup from $name_tabla_popup where $campo_MD5_popup='$num_objeto_md5'";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{ 
	$num_objeto_Popup=$reg[$campo_ID_popup];
}
}else{
$num_objeto_Popup=$num_objeto_md5;
}

echo '<form name="form_oculto" method="post" action="index.php">';
echo '<input type="hidden" name="id_problema_popup" value="'.$num_objeto_Popup.'">';
echo '</form>'; 


$name_tabla_padre=$variableadmin_prefijo_tablas.$f1_Padre;
$sqlupdate="update $name_tabla_padre set ";
$sqlupdate.="$campo_copy_Padre='$num_objeto_Popup'";
$sqlupdate.=" where $campo_md5_Padre='$md5_Padre'";
$resupdate=mysql_query($sqlupdate,$db); */

//echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
//echo $sqlupdate;
?>
