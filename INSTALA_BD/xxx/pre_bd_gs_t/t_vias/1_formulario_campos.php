<?php

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________

select_generico_submit("etiqueta_90","campotexto_205","Pa&iacute;s:","id_pais","id_pais","pais","t_paises","NO","select_205");

echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________

select_dependiente_submit_campo_vacio("etiqueta_90","campotexto_205","Provincia:","id_provincia","id_provincia","provincia","t_provincias","NO","select_205","id_pais","id_pais");

echo '</div>'; // FIN: FILA FORMULARIO _________________________________________

echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________

select_dependiente_dosvalores_submit_campo_vacio("etiqueta_90","campotexto_205","Localidad:","id_localidad","id_localidad","localidad","t_localidades","NO","select_205","id_provincia","id_provincia","id_pais","id_pais");

echo '</div>'; // FIN: FILA FORMULARIO _________________________________________


echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________

select_generico("etiqueta_90","campotexto_205","Tipo de V&iacute;a:","id_tiposdevias","id_tiposdevias","tiposdevia","t_tiposdevias","NO","select_205");

echo '</div>'; // FIN: FILA FORMULARIO _________________________________________


echo '<div class="filaformularioEspacioAbajo">'; // INICIO: FILA FORMULARIO _________________________________________

input_text_generico("etiqueta_90","campotexto_205","Nombre V&iacute;a:","nombrevia");

echo '</div>'; // FIN: FILA FORMULARIO _________________________________________




?>