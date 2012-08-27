<?php

if($grabo_modificacion == "SI"){


//$erroresbd=0; // INICIALIZAMOS el Contador de Errores con la Base de Datos

$name_tabla=$variableadmin_prefijo_tablas."registromodificaciones"; 

//$query="lock tables $name_tabla write"; $result=mysql_query($query,$db); 

$sqlinsert="insert into $name_tabla (id_registromodificaciones,tabla,num_objeto_md5,num_usuario,fecha_modificacion,sesion) values(null, '$tabla_registromodificaciones', '$num_objeto_md5', '$iu', '$datetime_ahora', '$id_sesion')";
$resinsert=mysql_query($sqlinsert,$db);
//if(!$resinsert){$erroresbd=$erroresbd+1;}

//echo $sqlinsert;
$veoultimoid=mysql_insert_id();

//$sqlupdate="update $name_tabla set num_registromodificaciones='$veoultimoid' where id_registromodificaciones='$veoultimoid'";
//$resupdate=mysql_query($sqlupdate,$db);
//if(!$resupdate){$erroresbd=$erroresbd+1;}

/*$query="unlock tables"; $result=mysql_query($query,$db); 

	if($erroresbd!="0"){
	echo "<center><font face='Arial' color='#ff0000' size='2'><b>Nº Errores: ".$erroresbd."</b>: Proceso Insert <b>[".$name_tabla."]</b></font></center><br>";
	} */


}
?>