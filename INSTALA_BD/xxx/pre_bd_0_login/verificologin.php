<?php
//echo "verificologin";

$ruta = $variableadmin_prefijo_bd.'0_login/consulto_bd.php'; include("$ruta");
$ruta = $variableadmin_prefijo_bd.'0_login/se_ha_hecho_este_login_ya.php'; include("$ruta");

//echo "passwordmd5: ",$passwordmd5,"<br>";
//echo "passwordbd: ",$passwordbd,"<br>";

if($total_logins_anteriores<1){ // INICIO: if($total_logins_anteriores<1) ___________________________
if($_SESSION['grabar_bd']<1){ // INICIO: if($grabar_bd<1) ___________________________

/*if($publicar_perfildeusuario=="NO"){
// El Perfil de Usuario asociado está Deshabilitado

		$perfilDeshabilitado="SI"; $errorLogin="SI";

}else{
// El Perfil de Usuario asociado está HABILITADO */

if($usuario=="" or $password==""){ 	
	// Ha dejado en blanco alguno de los campos USUARIO o PASSWORD (o los dos)

		if($usuario==""){$usuario_en_blanco="SI"; $errorLogin="SI"; /*$slide_login_error="SI";*/}else{$usuario_en_blanco="NO";}
		if($password==""){$password_en_blanco="SI"; $errorLogin="SI"; /*$slide_login_error="SI";*/}else{$password_en_blanco="NO";}
		if($usuario=="" and $password==""){$usuario_y_password_en_blanco="SI"; $errorLogin="SI"; /*$slide_login_error="SI";*/}
		
	} else { 
	// Ha completado los Campos USUARIO y PASSWORD

		if($usuario_correcto=="NO"){ 	
		// El Nombre de USUARIO No es Correcto

			$usuario_incorrecto="SI"; $errorLogin="SI"; /*$slide_login_error="SI";*/ $usuario="";

	
		} else {
		// El Nombre de USUARIO S� es Correcto

			$el_usuario_es_correcto = "SI";
		
					if($passwordmd5!=$passwordbd){
					// El Password es Incorrecto

						$password_incorrecto="SI"; $errorLogin="SI"; /*$slide_login_error="SI";*/ $password="";

					} else {
					// Password Correcto, el proceso de Logueado a finalizado.
								if($cuentahabilitada=="NO"){ 	
								// La cuenta est� deshabilitada

										$cuenta_deshabilitada="SI"; $errorLogin="SI"; /*$usuario_y_password_en_blanco="SI";*/ /*$slide_login_error="SI";*/
							
								} else { 
								// La cuenta del Usuario est� habilitada (est� operativa) Y LOS DATOS DE LOGUEADO SON CORRECTOS

										if($publicar_perfildeusuario=="NO"){
										// El Perfil de Usuario asociado está Deshabilitado
										
												$perfilDeshabilitado="SI"; $errorLogin="SI";
										
										}else{

											$_SESSION['nombrepersona']=$nombre;
											$_SESSION['nombredeusuarionick']=$usuariobd;					
											$_SESSION['iu']=$iu;
											$_SESSION['quiensoy']=$quiensoy;
											$_SESSION['num_perfil']=$num_perfildeusuario;
											$_SESSION['grabar_bd']=1;
											
	
											$nombrepersona=$nombre;
											$nombredeusuarionick=$usuariobd;
											$iu=$iu;
											$quiensoy=$quiensoy;
											$num_perfil=$num_perfildeusuario;
	
											/*echo "nombrepersona: ",$nombrepersona,"<br>";
											echo "nombredeusuarionick: ",$nombredeusuarionick,"<br>";
											echo "iu: ",$iu,"<br>";
											echo "quiensoy: ",$quiensoy,"<br>";
											echo "num_perfil: ",$num_perfil,"<br>";*/
	
										$ruta = $variableadmin_prefijo_bd.'0_contadorVisitas/contadorDespuesLogin.php'; include("$ruta");

											$proceso_login_correcto="SI";
										
										}
								}

					}		
		
		}

	}

//}

} // FIN: if($total_logins_anteriores<1) ___________________________
} // FIN: if($grabar_bd<1) ___________________________

//echo "errorLogin: ",$errorLogin,"<br>";
?>