<?php
$usuario_correcto="NO"; // Inicializamos esta variable, suponiendo de entrada que el nombre de usuario es incorrecto. Mediante una consulta a la base de datos se comprobar&aacute; si es v&aacute;lido.

//$query="lock tables usuarios read, usuarios_extra1 read, semillas read, perfilesdeusuarios read"; $result=mysql_query($query,$db); //BLOQUEAMOS LAS TABLAS

		// Comprobamos que el Nombre de Usuario existe en la Base de Datos
$tabla=$variableadmin_prefijo_tablas."usuarios";
$sql="select * from $tabla where nick='$usuario' and eliminado='NO'";
$res=mysql_query($sql,$db);
$total=mysql_num_rows($res);
if($total!=0){
        while ($reg=mysql_fetch_array($res))
        {
            $iu=$reg['id_usuario'];
            $num_tipousuario=$reg['num_tipousuario'];
            $usuariobd=$reg['nick'];
            $passwordbd=$reg['password'];
            $quiensoy=$reg['quiensoy'];
            $nombre=$reg['nombre'];
            $num_perfildeusuario=$reg['num_perfildeusuario'];
            $cuentahabilitada=$reg['cuentahabilitada'];
        }
        $usuario_correcto="SI";
}

		// Consultamos el tipo de precio que tiene asignado este usuarios
		/*$sql="select * from usuarios_extra1 where quiensoy='$quiensoy'";
		$res=mysql_query($sql,$db);
			while ($reg=mysql_fetch_array($res,MYSQL_NUM))
			{ 
			$num_descuento=$reg[12];
			}*/



/*$sqlsemilla="select semilla from ".$variableadmin_prefijo_tablas."semillas where num_semilla='1'";
$ressemilla=mysql_query($sqlsemilla,$db);
while ($regsemilla=mysql_fetch_array($ressemilla))
{ 
    $semillabd=$regsemilla['semilla'];
}*/

$passwordmd5=md5($password.$variableadmin_semillamd5);


// Consultamos si el Perfil de Usuario asignado est&aacute; publicado
$tabla=$variableadmin_prefijo_tablas."perfilesdeusuarios";
$sql="select publicar from $tabla where id_perfildeusuario='$num_perfildeusuario'";
$res=mysql_query($sql,$db);
        while ($reg=mysql_fetch_array($res))
        {
        $publicar_perfildeusuario=$reg['publicar'];
        }


//$query="unlock tables"; $result=mysql_query($query,$db); //DESBLOQUEAMOS LAS TABLAS

?>