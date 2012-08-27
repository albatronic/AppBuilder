<?php
$id_opcion_este_nivel=0; 

$permiso_global_este_nivel="NO";
if($id_opcion_este_nivel==0){$permiso_global_este_nivel="SI";} 		

		$sqlpermisos="select valor from permisos where id_opcion='$id_opcion_este_nivel' and id_usuario='$num_perfil'";
		$respermisos=mysql_query($sqlpermisos,$db);
		while ($regpermisos=mysql_fetch_array($respermisos))
		{
			$valor=$regpermisos['valor'];
			if($valor=="SI"){$permiso_global_este_nivel="SI";} 		
		}




function opciones($opcion_problema)
{
global $imagen_icono;
global $enlace_opcion;

		if($opcion_problema == 1){
			$imagen_icono="ico_ayudadomicilio.jpg";
			$enlace_opcion="plataforma.php?g=1&f=gs_ad";
		}

		if($opcion_problema == 3){
			$imagen_icono="ico_vivienda.jpg";
			$enlace_opcion="plataforma.php?g=1&f=gs_vi";

		}

return $imagen_icono;
return $enlace_opcion;

}
		
?>