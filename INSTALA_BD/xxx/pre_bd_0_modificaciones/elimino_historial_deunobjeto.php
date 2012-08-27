<?php

$erroresbd=0; // INICIALIZAMOS el Contador de Errores con la Base de Datos




$name_tabla="registromodificaciones"; 

$query="lock tables $name_tabla write"; $result=mysql_query($query,$db); 


		$sql="delete from $name_tabla where num_objeto_md5='$num_objeto_md5'";
		$resdelete=mysql_query($sql,$db);
		if(!$resdelete){$erroresbd=$erroresbd+1;}


$query="unlock tables"; $result=mysql_query($query,$db); 
 


	if($erroresbd!="0"){
	echo "<center><font face='Arial' color='#ff0000' size='2'><b>Nº Errores: ".$erroresbd."</b>: Proceso Delete <b>[".$name_tabla."]</b></font></center><br>";
	}



?>