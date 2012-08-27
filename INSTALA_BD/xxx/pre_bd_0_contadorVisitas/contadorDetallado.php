<?php

//if($_SESSION['sesion_control_bd_detallevisitas_usuarios'] != 1){

//$erroresbd=0; // INICIALIZAMOS el Contador de Errores con la Base de Datos

//include ('dmntr/funciones/fechahoraahora.php'); 


//$query="lock tables $name_tabla write, usuarios write, logs_visitas_usuariosweb write"; $result=mysql_query($query,$db); 

$name_tabla=$variableadmin_prefijo_tablas."visitas";
$sqlinsert="insert into $name_tabla (id_visita,fecha,hora,num_usuario,num_usuario_md5,sesion,tiempo_absoluto) values(null, '$fechahoybd', '$horaahorabd', '$iu', '$quiensoy', '$id_sesion', '$time_login')";
$resinsert=mysql_query($sqlinsert,$db);

/*
$veoultimoidcontador=mysql_insert_id();
$sqlupdate="update $name_tabla set num_numvisita='$veoultimoidcontador' where id_visita='$veoultimoidcontador';";
$resupdate=mysql_query($sqlupdate,$db);
*/

$name_tabla=$variableadmin_prefijo_tablas."usuarios";
$sql="select numerodevisitas from $name_tabla where id_usuario='$iu'";
$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))
{
	$usuario_numerodevisitas_anterior=$reg['numerodevisitas'];
}
	$usuario_numerodevisitas_nuevo=$usuario_numerodevisitas_anterior+1;


$name_tabla=$variableadmin_prefijo_tablas."usuarios";
$sqlupdate="update $name_tabla set numerodevisitas='$usuario_numerodevisitas_nuevo' where id_usuario='$iu';";
$resupdate=mysql_query($sqlupdate,$db);



$ruta = $variableadmin_prefijo_bd.'0_contadorVisitas/logVisitas.php'; include("$ruta");

		//$_SESSION['sesion_detallevisita_usuarios']=$veoultimoidcontador;
		//$_SESSION['sesion_control_bd_detallevisitas_usuarios']=1;


//$query="unlock tables"; $result=mysql_query($query,$db); 

	/*if($erroresbd!="0"){
	echo "<center><font face='Arial' color='#ff0000' size='2'><b>Nº Errores: ".$erroresbd."</b>: Proceso CONTADOR DETALLADO <b>[".$name_tabla."]</b></font></center><br>";
	}*/
	
	
//}

?>