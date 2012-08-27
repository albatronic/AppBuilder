<?php
// INCLUIDO EN:			usuariosweb_logicanickcorrecto.php


//$erroresbd=0; // INICIALIZAMOS el Contador de Errores con la Base de Datos
		
//$name_tabla="registromodificaciones"; 

//$query="lock tables $name_tabla read"; $result=mysql_query($query,$db); 

/*	$sql="select * from $name_tabla where tabla='$var_conf_nombretabla' and num_objeto_md5='$num_objeto_md5' and sesion='$id_sesion'";
	$res=mysql_query($sql,$db);
	$totalmodificacionesanteriores=mysql_num_rows($res); */
	//if(!$res){$erroresbd=$erroresbd+1;}

//$query="unlock tables"; $result=mysql_query($query,$db); 

//echo $sql;
//echo "totalmodificacionesanteriores: ",$totalmodificacionesanteriores,"<br>";

/*if($totalmodificacionesanteriores > 0){
	$grabo_modificacion="NO"; 
}else{
	$grabo_modificacion="SI"; 
} */

	/*if($erroresbd!="0"){
	echo "<center><font face='Arial' color='#ff0000' size='2'><b>Nº Errores: ".$erroresbd."</b>: Proceso Select <b>[".$name_tabla."]</b></font></center><br>";
	} */


	$grabo_modificacion="SI"; 

?>