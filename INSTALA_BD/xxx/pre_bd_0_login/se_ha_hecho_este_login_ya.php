<?php
// Consultamos si este usuario en esta sesi�n ha hecho ya el proceso de login en el tiempo absoluto que aqu� se refleja. Esto se hace como soluci�n a la NULA destrucci�n de sesiones, de forma que cuando volvemos hacia atr�s y recargamos la p�gina, se vuelve a la zona privada sin necesidad de loguearse, ya que se vuelve a enviar el formulario con los valores que se pusieron en el momento de loguearse. ESTO LO SOLUCIONA. Seguramente, dentro de un tiempo si leo esta anotaci�n, no la entender�, pero lo importante es que funcione.

$tabla=$variableadmin_prefijo_tablas."visitas";
$sql="select id_visita from $tabla where num_usuario='$iu' and sesion='$id_sesion' and tiempo_absoluto='$time_login'";
$res=mysql_query($sql,$db);
$total_logins_anteriores=mysql_num_rows($res);

//echo "total_logins_anteriores: ",$total_logins_anteriores,"<br>";
?>