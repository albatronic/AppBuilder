<?php
function procesadortextos($variable)
	{
	global $resultado;
$enter=chr(13);
$espacio=chr(32);
$comillasdobles=chr(92).chr(34);
$comillassimples=chr(92).chr(39);
$menor=chr(60);
$mayor=chr(62);
$signo_ampersand=chr(38);
$signo_cerrar_interrogacion=chr(63);
$dolar=chr(36);
$igual=chr(61);

$exclamacion_abrir=chr(161);
$exclamacion_cerrar=chr(33);
$interrogacion_abrir=chr(191);
//$interrogacion_cerrar=chr(63);


$a_acento=chr(225);
$e_acento=chr(233);
$i_acento=chr(237);
$o_acento=chr(243);
$u_acento=chr(250);
$a_may_acento=chr(193);
$e_may_acento=chr(201);
$i_may_acento=chr(205);
$o_may_acento=chr(211);
$u_may_acento=chr(218);

$enie_acento=chr(241);
$enie_may_acento=chr(209);


$sustitucion_align='align&#61;"';
$sustitucion_comillas_cierre='"&gt;';
$sustitucion_comillas_cierre2='">';
$sustitucion_inicio_style='style="';
$sustitucion_src='src="';
$sustitucion_comillas_border='" border';
$sustitucion_border='border="';
$sustitucion_comillas_width='" width';
$sustitucion_width='width="';
$sustitucion_comillas_height='" height';
$sustitucion_height='height="';
$sustitucion_comillas_cierre3='" />';
$sustitucion_comienzo_a='&lt;a href&#61;"';
$sustitucion_comienzo_target='" target';
$sustitucion_target='target&#61;"';

$resultado=str_replace($signo_ampersand, "&amp;", $variable); 

$resultado=str_replace($a_acento, "&aacute;", $resultado); 
$resultado=str_replace($e_acento, "&eacute;", $resultado); 
$resultado=str_replace($i_acento, "&iacute;", $resultado); 
$resultado=str_replace($o_acento, "&oacute;", $resultado); 
$resultado=str_replace($u_acento, "&uacute;", $resultado); 
$resultado=str_replace($a_may_acento, "&Aacute;", $resultado); 
$resultado=str_replace($e_may_acento, "&Eacute;", $resultado); 
$resultado=str_replace($i_may_acento, "&Iacute;", $resultado); 
$resultado=str_replace($o_may_acento, "&Oacute;", $resultado); 
$resultado=str_replace($u_may_acento, "&Uacute;", $resultado); 
$resultado=str_replace($enie_acento, "&ntilde;", $resultado); 
$resultado=str_replace($enie_may_acento, "&Ntilde;", $resultado); 



$resultado=str_replace($signo_cerrar_interrogacion, "&#63;", $resultado); 

$resultado=str_replace($exclamacion_abrir, "&iexcl;", $resultado); 
$resultado=str_replace($exclamacion_cerrar, "&#33;", $resultado); 
$resultado=str_replace($interrogacion_abrir, "&iquest;", $resultado); 


$resultado=str_replace($dolar, "&#36;", $resultado); 
$resultado=str_replace($igual, "&#61;", $resultado); 

$resultado=str_replace($comillasdobles, "&quot;", $resultado); 
$resultado=str_replace($comillassimples, "&#39;", $resultado); 

$resultado=str_replace($menor, "&lt;", $resultado); 
$resultado=str_replace($mayor, "&gt;", $resultado); 
$resultado=str_replace($enter, "<br />", $resultado); 

$resultado=str_replace("&amp;#63;", "&#63;", $resultado); 
$resultado=str_replace("&amp;#36;", "&#36;", $resultado); 
$resultado=str_replace("&amp;#61;", "&#61;", $resultado); 
$resultado=str_replace("&lt;p&gt;", "<p>", $resultado); 
$resultado=str_replace("&lt;/p&gt;", "</p>", $resultado); 

$resultado=str_replace("&lt;p ", "<p ", $resultado); 

$resultado=str_replace("&lt;div", "<div", $resultado); 
$resultado=str_replace("style&#61;", "style=", $resultado); 
$resultado=str_replace("&lt;img", "<img", $resultado); 
$resultado=str_replace("src&#61;", "src=", $resultado); 
$resultado=str_replace("width&#61;", "width=", $resultado); 
$resultado=str_replace("height&#61;", "height=", $resultado); 
$resultado=str_replace("&lt;/div&gt;", "</div>", $resultado); 
$resultado=str_replace("/&gt;", "/>", $resultado); 
$resultado=str_replace("border&#61;", "border=", $resultado); 
$resultado=str_replace("&gt;<", "><", $resultado); 

$resultado=str_replace("align=&quot;", "align='", $resultado); 
$resultado=str_replace("align&#61;&quot;", "align='", $resultado); 

$resultado=str_replace("&quot;>", "'>", $resultado); 
$resultado=str_replace("&quot;&gt;", "'>", $resultado); 

$resultado=str_replace("style=&quot;", "style='", $resultado); 
$resultado=str_replace("style#61;&quot;", "style='", $resultado); 

$resultado=str_replace("&quot;>", "'>", $resultado); 
$resultado=str_replace("src=&quot;", "src='", $resultado); 
$resultado=str_replace("src#61;&quot;", "src='", $resultado); 

$resultado=str_replace("&quot; border", "' border", $resultado); 
$resultado=str_replace("border=&quot;", "border='", $resultado); 
$resultado=str_replace("border#61;&quot;", "border='", $resultado); 

$resultado=str_replace("&quot; width", "' width", $resultado); 
$resultado=str_replace("width=&quot;", "width='", $resultado); 
$resultado=str_replace("width#61;&quot;", "width='", $resultado); 


$resultado=str_replace("&quot; height", "' height", $resultado); 
$resultado=str_replace("height=&quot;", "height='", $resultado); 
$resultado=str_replace("height#61;&quot;", "height='", $resultado); 

$resultado=str_replace("&quot; />", "' />", $resultado); 

$resultado=str_replace("&lt;strong&gt;", "<strong>", $resultado); 
$resultado=str_replace("&lt;/strong&gt;", "</strong>", $resultado); 

$resultado=str_replace("&lt;em&gt;", "<em>", $resultado); 
$resultado=str_replace("&lt;/em&gt;", "</em>", $resultado); 

$resultado=str_replace("&lt;u&gt;", "<u>", $resultado); 
$resultado=str_replace("&lt;/u&gt;", "</u>", $resultado); 


$resultado=str_replace("&lt;a href&#61;&quot;", "<a href='", $resultado); 

$resultado=str_replace("&quot; target", "' target", $resultado); 
$resultado=str_replace("target&#61;&quot;", "target='", $resultado); 
$resultado=str_replace("target=&quot;", "target='", $resultado); 
$resultado=str_replace("&lt;/a&gt;", "</a>", $resultado); 

$resultado=str_replace("&amp;quot;;", "&quot;&#59;", $resultado); 


$resultado=str_replace($sustitucion_align, "align='", $resultado); 
$resultado=str_replace($sustitucion_comillas_cierre, "'>", $resultado); 
$resultado=str_replace($sustitucion_inicio_style, "style='", $resultado); 
$resultado=str_replace($sustitucion_comillas_cierre2, "'>", $resultado); 
$resultado=str_replace($sustitucion_src, "src='", $resultado); 
$resultado=str_replace($sustitucion_comillas_border, "' border", $resultado); 
$resultado=str_replace($sustitucion_border, "border='", $resultado); 
$resultado=str_replace($sustitucion_comillas_width, "' width", $resultado); 
$resultado=str_replace($sustitucion_width, "width='", $resultado); 
$resultado=str_replace($sustitucion_comillas_height, "' height", $resultado); 
$resultado=str_replace($sustitucion_height, "height='", $resultado); 
$resultado=str_replace($sustitucion_comillas_cierre3, "' />", $resultado); 


$resultado=str_replace($sustitucion_comienzo_a, "<a href='", $resultado); 
$resultado=str_replace($sustitucion_comienzo_target, "' target", $resultado); 
$resultado=str_replace($sustitucion_target, "target='", $resultado); 





$resultado=str_replace("  ", "&nbsp;&nbsp;", $resultado); 
	return $resultado;
	}
	
		$function_procesadortextos="SI";

?>