<?php
// Consultamos si este usuario en esta sesión ha hecho ya el proceso de login en el tiempo absoluto que aquí se refleja. Esto se hace como solución a la NULA destrucción de sesiones, de forma que cuando volvemos hacia atrás y recargamos la página, se vuelve a la zona privada sin necesidad de loguearse, ya que se vuelve a enviar el formulario con los valores que se pusieron en el momento de loguearse. ESTO LO SOLUCIONA. Seguramente, dentro de un tiempo si leo esta anotación, no la entenderé, pero lo importante es que funcione.


		$sql="select id_visita from visitas_usuariosweb where num_usuario='$iu' and sesion='$id_sesion' and tiempo_absoluto='$time_login'";
		$res=mysql_query($sql,$db);
		$total_logins_anteriores=mysql_num_rows($res);

//echo "total_logins_anteriores: ",$total_logins_anteriores,"<br>";
?>