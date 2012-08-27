<?php
// INCLUIDO EN:			usuariosweb_logicanickcorrecto.php


$erroresbd=0; // INICIALIZAMOS el Contador de Errores con la Base de Datos
		
$name_tabla="registromodificaciones"; 

$query="lock tables $name_tabla write"; $result=mysql_query($query,$db); 

		$sql="select * from $name_tabla where tabla='$var_conf_nombretabla' and num_objeto_md5='$num_objeto_md5' order by fecha_modificacion desc";
		$res=mysql_query($sql,$db);
		$totalregistromodificaciones=mysql_num_rows($res);
		if(!$res){$erroresbd=$erroresbd+1;}

			while ($reg=mysql_fetch_array($res,MYSQL_NUM))
			{
			$num_registromodificaciones=$reg[1];
			}

if($totalregistromodificaciones > $max_registros){
		$sql="delete from $name_tabla where num_registromodificaciones='$num_registromodificaciones'";
		$resdelete=mysql_query($sql,$db);
		if(!$resdelete){$erroresbd=$erroresbd+1;}
		//echo "@@@@@@@@@ BORRAMOS ";
}


$query="unlock tables"; $result=mysql_query($query,$db); 


	if($erroresbd!="0"){
	echo "<center><font face='Arial' color='#ff0000' size='2'><b>Nº Errores: ".$erroresbd."</b>: Proceso Select <b>[".$name_tabla."]</b></font></center><br>";
	}

?>