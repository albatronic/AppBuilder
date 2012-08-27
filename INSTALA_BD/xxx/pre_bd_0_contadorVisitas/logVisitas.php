<?php
//echo "LOG DE VISITAS";

/*
		include("dmntr/contadorvisitas_usuarios/configuracion.php");
		include("data/variables/contadorvisitas_usuarios.php");
//echo "variable_num_registros_logs_user: ",$variable_num_registros_logs_user,"<br>";

$name_tabla="visitas_usuariosweb"; 

//$query="lock tables $name_tabla read, logs_visitas_usuariosweb write"; $result=mysql_query($query,$db); 

		$sql="select id_visita from $name_tabla where num_usuario='$iu'";
		$res=mysql_query($sql,$db);
		$totalvisitas=mysql_num_rows($res);
		if(!$res){$erroresbd=$erroresbd+1;}

//echo "totalvisitas: ",$totalvisitas,"<br>";


if($totalvisitas > $variable_num_registros_logs_user){

		$sql="select max(num_numvisita) from $name_tabla where num_usuario='$iu'";
		$res=mysql_query($sql,$db);
		if(!$res){$erroresbd=$erroresbd+1;}
			while ($reg=mysql_fetch_array($res,MYSQL_NUM))
			{
			$maxid_visitausuario=$reg[0];
			}


		$sql="select fecha from $name_tabla where num_numvisita='$maxid_visitausuario'";
		$res=mysql_query($sql,$db);
		if(!$res){$erroresbd=$erroresbd+1;}
			while ($reg=mysql_fetch_array($res))
			{
			$fecha_fin=$reg['fecha'];
			}

		$sql="select min(num_numvisita) from $name_tabla where num_usuario='$iu'";
		$res=mysql_query($sql,$db);
		if(!$res){$erroresbd=$erroresbd+1;}
			while ($reg=mysql_fetch_array($res,MYSQL_NUM))
			{
			$minid_visitausuario=$reg[0];
			}


		$sql="select fecha from $name_tabla where num_numvisita='$minid_visitausuario'";
		$res=mysql_query($sql,$db);
		if(!$res){$erroresbd=$erroresbd+1;}
			while ($reg=mysql_fetch_array($res))
			{
			$fecha_inicio=$reg['fecha'];
			}

//echo "maxid_visitausuario: ",$maxid_visitausuario,"<br>";
//echo "minid_visitausuario: ",$minid_visitausuario,"<br>";
//echo "num_usuario: ",$iu,"<br>";
//echo "num_usuario_md5: ",$quiensoy,"<br>";
//echo "numerodevisitas: ",$totalvisitas,"<br>";
//echo "fecha_inicio: ",$fecha_inicio,"<br>";
//echo "fecha_fin: ",$fecha_fin,"<br>"; 


$sqlinsert="insert into logs_visitas_usuariosweb (id_log,num_log,fecha_inicio,fecha_fin,num_usuario,num_usuario_md5,numerodevisitas,nombrefichero,ruta_almacenamiento) values(null, null, '$fecha_inicio', '$fecha_fin', '$iu', '$quiensoy', '$totalvisitas', null, '$var_conf_rutaalmacenamiento')";
$resinsert=mysql_query($sqlinsert,$db);
if(!$resinsert){$erroresbd=$erroresbd+1;}


$veoultimoid=mysql_insert_id();
$nombrefichero=$veoultimoid."_web.php";

$sqlupdate="update logs_visitas_usuariosweb set num_log='$veoultimoid' where id_log='$veoultimoid'";
$resupdate=mysql_query($sqlupdate,$db);
if(!$resupdate){$erroresbd=$erroresbd+1;}

$sqlupdate="update logs_visitas_usuariosweb set nombrefichero='$nombrefichero' where id_log='$veoultimoid'";
$resupdate=mysql_query($sqlupdate,$db);
if(!$resupdate){$erroresbd=$erroresbd+1;}



$dolar=chr(36);

$variables='data/contadorvisitas_usuarios/'.$veoultimoid.'_web.php';
if (!$descriptor=fopen($variables, "w+")){
echo "ERROR AL CARGAR LAS VARIABLES DE ENTORNO";
$erroresbd=$erroresbd+1;
}

$asignovariables="<?php
".$dolar."historial=\"";

$sql="select fecha,hora,num_usuario from $name_tabla where num_numvisita>='$minid_visitausuario' and num_numvisita<='$maxid_visitausuario' and num_usuario='$iu' order by id_visita asc";
$res=mysql_query($sql,$db);
if(!$res){$erroresbd=$erroresbd+1;}
	while ($reg=mysql_fetch_array($res))
	{
	$fecha=$reg['fecha'];
	$hora=$reg['hora'];
	$num_usuario=$reg['num_usuario'];

			$fechahora_problema=$fecha;
			include ('dmntr/funciones/decodificofechahora.php');
			$fecha=$fecha_decode;

			$txt_historial=$fecha." ".$hora;
			$asignovariables.=$txt_historial."<br />\n";

	}

$asignovariables.="\"";
$asignovariables.="?>"; 

fwrite($descriptor, $asignovariables);

if(!$cerrar=fclose($descriptor)){
echo "ERROR AL CERRAR LAS VARIABLES DE ENTORNO";
$erroresbd=$erroresbd+1;
}


$sql="delete from $name_tabla where num_numvisita>='$minid_visitausuario' and num_numvisita<='$maxid_visitausuario' and num_usuario='$iu'";
$res=mysql_query($sql,$db);
if(!$res){$erroresbd=$erroresbd+1;}


}


*/
?>