<?php
//echo "capturo";
/*
if($_POST['cambiarpassword']=="1"){$cambiarpassword=1;}
if($_GET['cambiarpassword']=="1"){$cambiarpassword=1;}

if($_POST['olvidopassword']=="1"){$olvidopassword=1;}
if($_GET['olvidopassword']=="1"){$olvidopassword=1;}
*/

$login=$_POST['login'];
$usuario=$_POST['usuario'];
$password=$_POST['password'];

trato_comillas($usuario);
$usuario=$resultado;

trato_comillas($password);
$password=$resultado;

//echo $usuario,"<br>";
//echo $password,"<br>";

//if(strlen(trim($usuario))>0 and strlen(trim($password))>0){$login=1;}
?>