<?php
session_start();
header('Content-Type: text/html; charset=iso-8859-1');

/**/ include("1_comunes/variables_comunes_todos_modulos.php"); 
	 include("0_comunes/funciones_comunes_todos_modulos.php"); 
	 include("0_comunes/conecta.php"); $db=conecta(); 
/**/ include("1_comunes/metatags_index.php"); 
	 include("0_comunes/html_metatags.php"); 
?>

<script language="JavaScript" type="text/JavaScript">
<!--
function f_open_window_max( aURL, aWinName )
{
   var wOpen;
   var sOptions;

   sOptions = 'status=no,menubar=no,scrollbars=no,resizable=yes,toolbar=no,location=no';
   sOptions = sOptions + ',width=' + (screen.availWidth - 13).toString();
   sOptions = sOptions + ',height=' + (screen.availHeight - 262).toString();
   sOptions = sOptions + ',screenX=0,screenY=0,left=0,top=0';

   wOpen = window.open( '', aWinName, sOptions );
   <?php echo "wOpen.location = '".$variableadmin_script_contenedor.".php?g=1&amp;f=".$variableadmin_nombre_modulo_home."';"; ?>
   wOpen.focus();
   wOpen.moveTo( 0, 0 );
   wOpen.resizeTo( screen.availWidth, screen.availHeight );
   return wOpen;
}
//-->
</script>

</head>

<body onload="f_open_window_max()">
</body>
</html>
