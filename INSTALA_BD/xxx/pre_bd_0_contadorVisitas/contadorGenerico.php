<?php


//if($_SESSION['sesion_control_bd_contadorvisitas_usuarios'] != 1){


//$erroresbd=0; // INICIALIZAMOS el Contador de Errores con la Base de Datos

//include ('dmntr/funciones/fechahoraahora.php'); 

$name_tabla=$variableadmin_prefijo_tablas."contadorvisitas";

//$query="lock tables $name_tabla write"; $result=mysql_query($query,$db); 

		$sql="select max(id_contadorvisitas) from $name_tabla";
		$res=mysql_query($sql,$db);
			while ($reg=mysql_fetch_array($res,MYSQL_NUM))
			{
			$maxid=$reg[0];
			}

//echo "maxid: ",$maxid,"<br>";

		$sql="select numerodevisitas,fecha from $name_tabla where id_contadorvisitas='$maxid'";
		$res=mysql_query($sql,$db);
			while ($reg=mysql_fetch_array($res))
			{
			$ultimasvisitas=$reg['numerodevisitas'];
			$ultimafecha=$reg['fecha'];
			$ultimodia=substr($ultimafecha,8,2);
			}
//echo "ultimasvisitas: ",$ultimasvisitas,"<br>";
//echo "ultimafecha: ",$ultimafecha,"<br>";
//echo "ultimodia: ",$ultimodia,"<br>";


		$sql="select numerodevisitas from $name_tabla where id_contadorvisitas='1'";
		$res=mysql_query($sql,$db);
			while ($reg=mysql_fetch_array($res))
			{
			$visitastotales=$reg['numerodevisitas'];
			}
		$nuevavisitatotal=$visitastotales+1;

//echo "visitastotales: ",$visitastotales,"<br>";
//echo "nuevavisitatotal: ",$nuevavisitatotal,"<br>";

// LA VARIABLE $d TOMA SU VALOR DEL SCRIPT funciones/fechahoraahora.php QUE SE HA CARGADO EN 0_comunes/funciones_comunes_todos_modulos.php
if ($ultimodia==$d){ 
$nuevavisitadiaria=$ultimasvisitas+1;

//echo "nuevavisitadiaria: ",$nuevavisitadiaria,"<br>";

		$sql="update $name_tabla set numerodevisitas='$nuevavisitadiaria' where id_contadorvisitas='$maxid'";
		$res=mysql_query($sql,$db);

		$sql="update $name_tabla set numerodevisitas='$nuevavisitatotal' where id_contadorvisitas='1'";
		$res=mysql_query($sql,$db);
		
		//$_SESSION['sesion_visita_usuarios']=1;
		}else{

		$sqlinsert="insert into $name_tabla (id_contadorvisitas,numerodevisitas,fecha) values(null, '1', '$fechahoybd')";
		$resinsert=mysql_query($sqlinsert,$db);


		/*$veoultimoidcontador=mysql_insert_id();
		$sqlupdate="update $name_tabla set num_contadorvisitas='$veoultimoidcontador' where id_contadorvisitas='$veoultimoidcontador';";
		$resupdate=mysql_query($sqlupdate,$db);*/

		$sql="update $name_tabla set numerodevisitas='$nuevavisitatotal' where id_contadorvisitas='1'";
		$res=mysql_query($sql,$db);

//echo "CREAMOS UNA NUEVA FILA *********************** <br>";
		
		//$_SESSION['sesion_visita_usuarios']=1;
//}

}

//$query="unlock tables"; $result=mysql_query($query,$db); 

/*
	if($erroresbd!="0"){
	echo "<center><font face='Arial' color='#ff0000' size='2'><b>Nº Errores: ".$erroresbd."</b>: Proceso CONTADOR GEN&Eacute;RICO <b>[".$name_tabla."]</b></font></center><br>";
	}else{
		$_SESSION['sesion_control_bd_contadorvisitas_usuarios']=1;
	}
*/

?>