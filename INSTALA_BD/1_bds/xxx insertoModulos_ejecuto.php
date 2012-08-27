<?php

if($indice_explode==0){
		echo "VALOR EXPLODE: ".$indice_explode." ".$value_explode."<br>";

	$sql="select IDModulo from $nombre_tabla where CodigoApp='$value_explode'";
	$res=mysql_query($sql,$db);
	$totalobjetos=mysql_num_rows($res);

	if($totalobjetos==0){
		$rutaInsert = 'insertamosPrecargaDeVariosDatos.php'; include("$rutaInsert");
	}


if($totalobjetos>0){
	$sqlupdate="update $nombre_tabla set NombreApp='$Campo1_explode[1]',Descripcion='$Campo1_explode[2]' where CodigoApp='$Campo1_explode[0]'";
	$resupdate=mysql_query($sqlupdate,$db);
}

}
?>