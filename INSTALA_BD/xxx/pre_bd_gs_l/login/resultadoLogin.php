<?php
//echo "resultado";
if($errorLogin=="SI"){

if($usuario_en_blanco=="SI"){$textoCuadroDialogo='No puede dejar el Campo Usuario en blanco';}
if($password_en_blanco=="SI"){$textoCuadroDialogo='No puede dejar el Campo Contrase&ntilde;a en blanco';}
if($usuario_y_password_en_blanco=="SI"){$textoCuadroDialogo='No puede dejar los Campos Usuario y Contrase&ntilde;a en blanco';}
if($perfilDeshabilitado=="SI"){$textoCuadroDialogo='El Perfil asociado al Usuario se encuentra deshabilitado';}
if($usuario_incorrecto=="SI"){$textoCuadroDialogo='El Usuario es Incorrecto';}
if($password_incorrecto=="SI"){$textoCuadroDialogo='La Contrase&ntilde;a es incorrecta';}
if($cuenta_deshabilitada=="SI"){$textoCuadroDialogo='Esta cuenta de usuario está deshabilitada';}

$tituloCuadroDialogo='ERROR PROCESO LOGUEADO'; $textoCuadroDialogo=$textoCuadroDialogo; 
$imagenBoton1="btn_volver_rojo.jpg"; $titleBoton1="Volver Formulario Login"; $urlBoton1="index.php"; 
$ruta = $variableadmin_prefijo_bd.'0_api/cuadroDialogo250TextoError.php'; include("$ruta");

}else{


$tituloCuadroDialogo='LOGIN'; $textoCuadroDialogo="&iexcl;Usuario Autorizado!"; 
$imagenBoton1="btn_aceptar2.jpg"; $titleBoton1="Entrar a la Aplicaci&oacute;n"; $urlBoton1="index.php?g=1&amp;f=$variableadmin_nombre_modulo_home"; 
$ruta = $variableadmin_prefijo_bd.'0_api/cuadroDialogo250Texto.php'; include("$ruta");

}

//$tituloCuadroDialogo='LOGIN'; $includeCuadroDialogo='gs_l/login/xxxformularioLogin.php';
//include('0_api/cuadroDialogo250.php');
?>