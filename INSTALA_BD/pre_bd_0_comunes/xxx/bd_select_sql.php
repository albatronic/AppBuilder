<?php

//echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
$name_tabla=$variablesubmodulo_tabla_submodulo; 

//$query="lock tables $name_tabla read"; $result=mysql_query($query,$db); 



		$sql="select * from $name_tabla where $variablesubmodulo_nombre_campo_md5='$num_objeto_md5'";
		$res=mysql_query($sql,$db);
		$num_campos=mysql_num_fields($res);

		//while ($reg=mysql_fetch_array($res,MYSQL_NUM))
		$reg=mysql_fetch_array($res,MYSQL_NUM);

		//{
			for ($i=0; $i<$num_campos; $i++){
			$nombre_campo=mysql_field_name($res,$i);
			$tipo_campo=mysql_field_type($res,$i);
			$longitud_campo=mysql_field_len($res,$i);

			$$nombre_campo=$reg[$i];
			//echo $nombre_campo,": ",$$nombre_campo,"<br>";
// DECODIFICO LOS CAMPOS TIPO FECHA __________________________________________
$ruta = $variableadmin_prefijo_bd.'0_comunes/bd_select_campo_fecha.php'; include("$ruta");
// PROCESAMOS LOS CAMPOS TIPO BLOB __________________________________________
$ruta = $variableadmin_prefijo_bd.'0_comunes/bd_select_campo_blob.php'; include("$ruta");

			}
		//}



//echo $sql;
//echo "1 pertenece_a: ",$pertenece_a,"<br>";


//$query="unlock tables"; $result=mysql_query($query,$db); 


?>