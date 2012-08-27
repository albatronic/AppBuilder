<?php

$erroresbd=0; // INICIALIZAMOS el Contador de Errores con la Base de Datos

$name_tabla="registromodificaciones"; 
$query="lock tables $name_tabla read"; $result=mysql_query($query,$db); 

echo $fechaultimamodificacion." [".$nick_usuarioultimamodificacion."]<br>";

$sql="select * from $name_tabla where tabla='$var_conf_nombretabla' and num_objeto_md5='$num_objeto_md5' order by fecha_modificacion desc";

$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res,MYSQL_NUM))
{
$nombre_usuario=$reg[5];
$fecha_modificacion=$reg[6];

			// Decodificamos la Fecha de la &Uacute;ltima Modificaci&oacute;n
			$fechahora_problema=$fecha_modificacion;
			include ('funciones/decodificofechahora.php');
			$fecha_modificacion=$fecha_hora_decode;

echo $fecha_modificacion." [".$nombre_usuario."]<br>";
}


$query="unlock tables"; $result=mysql_query($query,$db); 

	if($erroresbd!="0"){
	echo "<center><font face='Arial' color='#ff0000' size='2'><b>Nº Errores: ".$erroresbd."</b>: Proceso Select <b>[".$name_tabla."]</b></font></center><br>";
	}

?>