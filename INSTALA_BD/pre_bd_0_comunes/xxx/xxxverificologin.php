<?php
include("dmntr/login/consulto_bd.php");
include("0_comunes/se_ha_hecho_este_login_ya.php");

if($total_logins_anteriores<1){ // INICIO: if($total_logins_anteriores<1) ___________________________

	if($usuario=="" or $password==""){ 	
	// Ha dejado en blanco alguno de los campos USUARIO o PASSWORD (o los dos)

		if($usuario==""){$usuario_en_blanco="SI"; $slide_login_error="SI";}else{$usuario_en_blanco="NO";}
		if($password==""){$password_en_blanco="SI"; $slide_login_error="SI";}else{$password_en_blanco="NO";}
		if($usuario=="" and $password==""){$usuario_y_password_en_blanco="SI"; $slide_login_error="SI";}
		
	} else { 
	// Ha completado los Campos USUARIO y PASSWORD

		if($usuario_correcto=="NO"){ 	
		// El Nombre de USUARIO No es Correcto

			$usuario_incorrecto="SI"; $slide_login_error="SI"; $usuario="";

	
		} else {
		// El Nombre de USUARIO Sí es Correcto

			$el_usuario_es_correcto = "SI";
		
					if($passwordmd5!=$passwordbd){
					// El Password es Incorrecto

						$password_incorrecto="SI"; $slide_login_error="SI"; $password="";

					} else {
					// Password Correcto, el proceso de Logueado a finalizado.
								if($cuentahabilitada=="NO"){ 	
								// La cuenta está deshabilitada

										$cuenta_deshabilitada="SI"; $usuario_y_password_en_blanco="SI"; $slide_login_error="SI";
							
								} else { 
								// La cuenta del Usuario está habilitada (está operativa) Y LOS DATOS DE LOGUEADO SON CORRECTOS

										$_SESSION['nombrepersonaweb']=$nombre;					
										$_SESSION['nombredeusuarionick']=$usuariobd;					
										$_SESSION['iuweb']=$iu;
										$_SESSION['quiensoyweb']=$quiensoy;
										//$_SESSION['tipoprecio_usuario']=$num_descuento;
										$_SESSION['controlinsert']=1;
										

										$nombrepersonaweb=$nombre;
										$nombredeusuarionick=$usuariobd;
										$iuweb=$iu;
										$quiensoyweb=$quiensoy;

										include("dmntr/contadorvisitas_usuarios/contadorvisitas_web.php");
										
										$proceso_login_correcto="SI";
										

								}

					}		
		
		}

	}


} // FIN: if($total_logins_anteriores<1) ___________________________
?>