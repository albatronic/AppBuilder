<?php
$g=$_GET['g'];

if (isset($g)) { 
	$f=$_GET['f']; // INDICA EL M�DULO CON EL QUE VAMOS A TRABAJAR
	$f1=$_GET['f1']; 
	$s1=$_GET['s1']; 
	$f2=$_GET['f2']; 
	$s2=$_GET['s2']; 
	$num_objeto_md5=$_GET['num_objeto_md5']; 

	$pag=$_GET['pag'];
	//$desderegistro=$_GET['desderegistro'];
	$orden=$_GET['orden'];
	$criterio=$_GET['criterio'];
	$abc=$_GET['abc'];
	$criterio1=$_GET['criterio1'];
	$criterio2=$_GET['criterio2'];
	$criterio3=$_GET['criterio3'];

	$vengode=$_GET['vengode'];

	$f_Padre=$_GET['f_Padre']; // Valor de la Variable $f del formulario PADRE
	$f1_Padre=$_GET['f1_Padre']; // Valor de la Variable $f1 del formulario PADRE
	$md5_Padre=$_GET['md5_Padre']; // Valor MD5 del registro que tenemos abierto en el formulario PADRE
	$copio_Padre=$_GET['copio_Padre']; // Si esta variable toma el valor SI, entonces el objeto seleccionado en el POPUP, se copia en el formulario padre

	$f_Popup=$_GET['f_Popup']; // Valor de la Variable $f del POPUP que vamos a abrir
	$f1_Popup=$_GET['f1_Popup']; // Valor de la Variable $f1 del POPUP que vamos a abrir
	$s1_Popup=$_GET['s1_Popup']; // Valor de la Variable $s1 del POPUP que vamos a abrir
	$permiso_popup=$_GET['permiso_popup']; // Nombre del permiso que tiene que tener para abrir el popup

	$run_copy=$_GET['run_copy']; // Cuando toma el valor SI, entonces se ejecuta el copiado del valor en el del elemento POPUP en el formulario PADRE


	/*$action=$_GET['action']; 
	$ob=$_GET['ob'];
	$spp=$_GET['spp'];  
	$sp=$_GET['sp'];  
	$cp=$_GET['cp']; */ 
}else{
	$f=$_POST['f']; 
	$f1=$_POST['f1'];
	$s1=$_POST['s1'];
	$f2=$_POST['f2'];
	$s2=$_POST['s2'];
	$num_objeto_md5=$_POST['num_objeto_md5']; 


	$pag=$_POST['pag'];
	//$desderegistro=$_POST['desderegistro'];
	$orden=$_POST['orden'];
	$criterio=$_POST['criterio'];
	$abc=$_POST['abc'];
	$criterio1=$_POST['criterio1']; // CRITERIO1 Formulario de Búsqueda del Listado
	$criterio2=$_POST['criterio2']; // CRITERIO2 Formulario de Búsqueda del Listado
	$criterio3=$_POST['criterio3']; // CRITERIO3 Formulario de Búsqueda del Listado

	$vengode=$_POST['vengode'];


	$f_Padre=$_POST['f_Padre']; 
	$f1_Padre=$_POST['f1_Padre']; 
	$md5_Padre=$_POST['md5_Padre']; 
	$copio_Padre=$_POST['copio_Padre']; 
	
	$f1_Popup=$_POST['f1_Popup'];
	$s1_Popup=$_POST['s1_Popup']; 
	$permiso_popup=$_POST['permiso_popup']; // Nombre del permiso que tiene que tener para abrir el popup

	$run_copy=$_POST['run_copy'];
	/*$action=$_POST['action'];
	$ob=$_POST['ob'];
	$spp=$_POST['spp'];  
	$sp=$_POST['sp'];  
	$cp=$_POST['cp'];*/  
}

		trato_comillas($criterio1);
		$criterio1=$resultado;

		trato_comillas($criterio2);
		$criterio2=$resultado;

		trato_comillas($criterio3);
		$criterio3=$resultado;


if(!isset($f1)){$f1="1_menu_principal";} // Si no se nos indica ning�n subm�dulo, entonces se carga el Men� Principal del M�dulo
if(!isset($s1)){$s1="0_menu_principal";}

// Si no indicamos ning�n M�dulo se supone que eso s�lo ocurre cuando entramos en la aplicaci�n, es decir, que en ese caso debe mostrarse el formulario de LOGIN

//echo $f;
if(!isset($f)){$f=$variableadmin_prefijo_bd."gs_l"; $f1="login"; $s1="login";} 



	$ruta = $f.'/'.$f1.'/1_capturo_var_get_post.php';   if (file_exists($ruta)){include("$ruta"); }


/**/ 
?>