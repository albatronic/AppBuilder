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


$modifico0=str_replace($signo_ampersand, "&amp;", $variable); 

$modifico01=str_replace($signo_cerrar_interrogacion, "&#63;", $modifico0); 
$modifico02=str_replace($dolar, "&#36;", $modifico01); 
$modifico03=str_replace($igual, "&#61;", $modifico02); 

$modifico1=str_replace($comillasdobles, "&quot;", $modifico03); 
$modifico2=str_replace($comillassimples, "&#39;", $modifico1); 

$modifico3=str_replace($menor, "&lt;", $modifico2); 
$modifico4=str_replace($mayor, "&gt;", $modifico3); 
$modifico5=str_replace($enter, "<br />", $modifico4); 

$modifico51=str_replace("&amp;#63;", "&#63;", $modifico5); 
$modifico52=str_replace("&amp;#36;", "&#36;", $modifico51); 
$modifico53=str_replace("&amp;#61;", "&#61;", $modifico52); 
$modifico54=str_replace("&lt;p&gt;", "<p>", $modifico53); 
$modifico541=str_replace("&lt;/p&gt;", "</p>", $modifico54); 

$modifico55=str_replace("&lt;p ", "<p ", $modifico541); 

$modifico60=str_replace("&lt;div", "<div", $modifico55); 
$modifico61=str_replace("style&#61;", "style=", $modifico60); 
$modifico62=str_replace("&lt;img", "<img", $modifico61); 
$modifico63=str_replace("src&#61;", "src=", $modifico62); 
$modifico64=str_replace("width&#61;", "width=", $modifico63); 
$modifico65=str_replace("height&#61;", "height=", $modifico64); 
$modifico66=str_replace("&lt;/div&gt;", "</div>", $modifico65); 
$modifico67=str_replace("/&gt;", "/>", $modifico66); 
$modifico68=str_replace("border&#61;", "border=", $modifico67); 
$modifico69=str_replace("&gt;<", "><", $modifico68); 

$modifico90=str_replace("align=&quot;", "align='", $modifico69); 
$modifico901=str_replace("align&#61;&quot;", "align='", $modifico90); 

$modifico91=str_replace("&quot;>", "'>", $modifico901); 
$modifico911=str_replace("&quot;&gt;", "'>", $modifico91); 

$modifico92=str_replace("style=&quot;", "style='", $modifico911); 
$modifico922=str_replace("style#61;&quot;", "style='", $modifico92); 

$modifico93=str_replace("&quot;>", "'>", $modifico922); 
$modifico94=str_replace("src=&quot;", "src='", $modifico93); 
$modifico944=str_replace("src#61;&quot;", "src='", $modifico94); 

$modifico95=str_replace("&quot; border", "' border", $modifico944); 
$modifico96=str_replace("border=&quot;", "border='", $modifico95); 
$modifico966=str_replace("border#61;&quot;", "border='", $modifico96); 

$modifico97=str_replace("&quot; width", "' width", $modifico966); 
$modifico98=str_replace("width=&quot;", "width='", $modifico97); 
$modifico988=str_replace("width#61;&quot;", "width='", $modifico98); 


$modifico99=str_replace("&quot; height", "' height", $modifico988); 
$modifico100=str_replace("height=&quot;", "height='", $modifico99); 
$modifico1001=str_replace("height#61;&quot;", "height='", $modifico100); 

$modifico101=str_replace("&quot; />", "' />", $modifico1001); 

$modifico102=str_replace("&lt;strong&gt;", "<strong>", $modifico101); 
$modifico103=str_replace("&lt;/strong&gt;", "</strong>", $modifico102); 

$modifico104=str_replace("&lt;em&gt;", "<em>", $modifico103); 
$modifico105=str_replace("&lt;/em&gt;", "</em>", $modifico104); 

$modifico1051=str_replace("&lt;u&gt;", "<u>", $modifico105); 
$modifico1052=str_replace("&lt;/u&gt;", "</u>", $modifico1051); 


$modifico106=str_replace("&lt;a href&#61;&quot;", "<a href='", $modifico1052); 

$modifico107=str_replace("&quot; target", "' target", $modifico106); 
$modifico108=str_replace("target&#61;&quot;", "target='", $modifico107); 
$modifico109=str_replace("target=&quot;", "target='", $modifico108); 
$modifico110=str_replace("&lt;/a&gt;", "</a>", $modifico109); 

$modifico111=str_replace("&amp;quot;;", "&quot;&#59;", $modifico110); 


$modifico70=str_replace($sustitucion_align, "align='", $modifico111); 
$modifico71=str_replace($sustitucion_comillas_cierre, "'>", $modifico70); 
$modifico72=str_replace($sustitucion_inicio_style, "style='", $modifico71); 
$modifico73=str_replace($sustitucion_comillas_cierre2, "'>", $modifico72); 
$modifico74=str_replace($sustitucion_src, "src='", $modifico73); 
$modifico75=str_replace($sustitucion_comillas_border, "' border", $modifico74); 
$modifico76=str_replace($sustitucion_border, "border='", $modifico75); 
$modifico77=str_replace($sustitucion_comillas_width, "' width", $modifico76); 
$modifico78=str_replace($sustitucion_width, "width='", $modifico77); 
$modifico79=str_replace($sustitucion_comillas_height, "' height", $modifico78); 
$modifico80=str_replace($sustitucion_height, "height='", $modifico79); 
$modifico81=str_replace($sustitucion_comillas_cierre3, "' />", $modifico80); 


$modifico82=str_replace($sustitucion_comienzo_a, "<a href='", $modifico81); 
$modifico83=str_replace($sustitucion_comienzo_target, "' target", $modifico82); 
$modifico84=str_replace($sustitucion_target, "target='", $modifico83); 




/*
$modifico70=str_replace("style=&quot;", "style='", $modifico69); 
$modifico71=str_replace("&quot;>", "'>", $modifico70); 
$modifico72=str_replace("src=&quot;", "src='", $modifico71); 
$modifico73=str_replace("border=&quot;", "border='", $modifico72); 
$modifico74=str_replace("&quot; border", "' border", $modifico73); 
$modifico75=str_replace("width=&quot;", "width='", $modifico74); 
$modifico76=str_replace("height=&quot;", "height='", $modifico75); 

$modifico77=str_replace("&quot; width", "' width", $modifico76); 
$modifico78=str_replace("&quot; height", "' height", $modifico77); 
$modifico79=str_replace("&quot; />", "' />", $modifico78); 

$modifico81=str_replace("&quot; align", "' align", $modifico80); 
*/

$resultado=str_replace("  ", "&nbsp;&nbsp;", $modifico84); 
	return $resultado;
	}

$function_procesadortextos="SI";
?>