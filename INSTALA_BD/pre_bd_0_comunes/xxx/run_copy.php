<?php

if($decode_md5=="SI"){
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
$resupdate=mysql_query($sqlupdate,$db);

//echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
//echo $sqlupdate;
?>
