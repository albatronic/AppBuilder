<?php


//CodigoApp bigint(11) | NombreModulo varchar(255) | PerteneceA varchar(255) | Nivel int(4) | Titulo varchar(100) | Descripcion varchar(100) | Funcionalidades varchar(255) | Publicar tinyint(1)


$Campo1 = array(
"Core | Core | 0 | 0 | Master | Contenedor de módulos master | AC | 0",
"Core | CoreVariables/Web/Pro | Core | 1 | Variables Web del Proyecto | Permite Gestionar las variables web del proyecto | AC | 1",
"Core | CoreVariables/Env/Pro | Core | 1 | Variables de Entorno del Proyecto | Permite Gestionar las variables de entorno del proyecto | AC | 1",

"Enl | Enl | 0 | 0 | Enlaces de Interés | Gestión de los Enlaces de Interés de la Web | AC,VW | 1",
"Enl | EnlSecciones | Enl | 1 | Secciones | Permite Gestionar las Secciones en que se clasificarén los Enlaces | | 1",
"Enl | EnlEnlaces | Enl | 1 | Enlaces de Interés | Permite Gestionar los Enlaces de Interés asociados a cada Seccién | | 1",
);

?>