<?php
$usuario_correcto="NO"; // Inicializamos esta variable, suponiendo de entrada que el nombre de usuario es incorrecto. Mediante una consulta a la base de datos se comprobar&aacute; si es v&aacute;lido.

$query="lock tables usuarios read, usuarios_extra1 read, semillas read, perfilesdeusuarios read"; $result=mysql_query($query,$db); //BLOQUEAMOS LAS TABLAS

		// Comprobamos que el Nombre de Usuario existe en la Base de Datos
		$sql="select * from usuarios where nick='$usuario' and eliminado='NO'";
		$res=mysql_query($sql,$db);
		$total=mysql_num_rows($res);
		if($total!=0){
			while ($reg=mysql_fetch_array($res,MYSQL_NUM))
			{ 
			$iu=$reg[1];
			$num_tipousuario=$reg[2];
			$usuariobd=$reg[3];
			$passwordbd=$reg[4];
			$quiensoy=$reg[5];
			$nombre=$reg[10];

			$num_perfildeusuario=$reg[20];
			$cuentahabilitada=$reg[22];
			}
			$usuario_correcto="SI";
		}

		// Consultamos el tipo de precio que tiene asignado este usuarios
		$sql="select * from usuarios_extra1 where quiensoy='$quiensoy'";
		$res=mysql_query($sql,$db);
			while ($reg=mysql_fetch_array($res,MYSQL_NUM))
			{ 
			$num_descuento=$reg[12];
			}



				$sqlsemilla="select * from semillas where num_semilla='1'"; 
				$ressemilla=mysql_query($sqlsemilla,$db);
				while ($regsemilla=mysql_fetch_array($ressemilla,MYSQL_NUM))
				{ 
				$semillabd=$regsemilla[2];
				} 
				
				$passwordmd5=md5($password.$semillabd);


		// Consultamos si el Perfil de Usuario asignado est&aacute; publicado
		$sql="select * from perfilesdeusuarios where num_perfildeusuario='$num_perfildeusuario'";
		$res=mysql_query($sql,$db);
			while ($reg=mysql_fetch_array($res,MYSQL_NUM))
			{ 
			$publicar_perfildeusuario=$reg[5];
			}


$query="unlock tables"; $result=mysql_query($query,$db); //DESBLOQUEAMOS LAS TABLAS

?>