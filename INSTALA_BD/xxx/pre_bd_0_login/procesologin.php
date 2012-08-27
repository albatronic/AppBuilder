<?php
//echo "proceso";
/*
		$nombredeusuarionick=$_SESSION['nombredeusuarionick'];
		$iuweb=$_SESSION['iuweb'];
		$quiensoyweb=$_SESSION['quiensoyweb'];
		$nombrepersonaweb=$_SESSION['nombrepersonaweb'];
		$control_sesion=$_SESSION['control_sesion'];
*/

//echo "iuweb: ",$iuweb,"<br>";


/*if($_POST['cambiarpassword']=="1"){$cambiarpassword=1;}
if($_GET['cambiarpassword']=="1"){$cambiarpassword=1;}

if($_POST['olvidopassword']=="1"){$olvidopassword=1;}
if($_GET['olvidopassword']=="1"){$olvidopassword=1;}


		$usuario=$_POST['usuario'];
		$password=$_POST['password']; */

//if(strlen(trim($usuario))>0 and strlen(trim($password))>0){$login=1;}


/*
		$time_login=time();
		$usuario=$_POST['usuario'];
		$password=$_POST['password']; 

echo "time_login: ",$time_login,"<br>";
echo "usuario: ",$usuario,"<br>";
echo "password: ",$password,"<br>";
*/
if($login=="1"){
//echo "jejeje";
		//$time_login=$_POST['time_login'];
		$time_login=time();
/*
echo "time_login: ",$time_login,"<br>";
echo "usuario: ",$usuario,"<br>";
echo "password: ",$password,"<br>";
*/
		/*trato_comillas($usuario);
		$usuario=$resultado;

		trato_comillas($password);
		$password=$resultado; */

$ruta = $variableadmin_prefijo_bd.'0_login/verificologin.php'; include("$ruta");


}


if($cambiarpassword=="1"){
		if($_POST['envio_form_cambiarpassword']=="SI"){

				$passwordanterior=$_POST['passwordanterior'];
				$passwordnuevo1=$_POST['passwordnuevo1']; 
				$passwordnuevo2=$_POST['passwordnuevo2']; 
		
				trato_comillas($passwordanterior);
				$passwordanterior=$resultado;
		
				trato_comillas($passwordnuevo1);
				$passwordnuevo1=$resultado;
		
				trato_comillas($passwordnuevo2);
				$passwordnuevo2=$resultado;
		
				include("dmntr/modificarpassword/bd_select_web.php"); // Consultamos los datos existentes en la Base de Datos
		
				include("login/verificocambiopassword.php");

		}
}



if($olvidopassword=="1"){
		if($_POST['envio_form_olvidarpassword']=="SI"){

				$nick=$_POST['nick'];
				$email=$_POST['email'];

				trato_comillas($nick);
				$nick=$resultado;

				trato_comillas($email);
				$email=$resultado;
		
				include("login/verificoolvidarpassword.php");
		}
}




if($_GET['cerrarsesion']=="1"){
		$nombredeusuarionick="";
		$iuweb=0;
		$quiensoyweb="";
		$nombrepersonaweb="";

		$_SESSION['nombredeusuarionick']="";
		$_SESSION['iuweb']="";
		$_SESSION['quiensoyweb']="";
		$_SESSION['nombrepersonaweb']="";

		/*session_unset();
		session_destroy();
		
		$parametros_cookies=session_get_cookie_params();
		setcookie(session_name(),0,1,$parametros_cookies["path"]); */

		/*unset($nombredeusuarionick);
		unset($iuweb);
		unset($quiensoyweb);
		unset($nombrepersonaweb);


		unset($_SESSION['nombredeusuarionick']);
		unset($_SESSION['iuweb']);
		unset($_SESSION['quiensoyweb']);
		unset($_SESSION['nombrepersonaweb']);

		session_destroy();*/


}

/*
echo "nombredeusuarionick: ",$_SESSION['nombredeusuarionick'],"<br>";
echo "iuweb: ",$_SESSION['iuweb'],"<br>";
echo "quiensoyweb: ",$_SESSION['quiensoyweb'],"<br>";
echo "nombrepersonaweb: ",$_SESSION['nombrepersonaweb'],"<br>";
*/
?>