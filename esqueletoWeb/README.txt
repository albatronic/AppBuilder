ARTICO ESTUDIO

PROCESOS A SEGUIR PARA LA PUESTA EN MARCHA DEL PROYECTO


* Crear la carpeta del proyecto en el servidor.
* Ejecutar http://localhost/appBuilder para crear el esqueleto del proyecto dentro de la carpeta.
* Creacion de las urls básicas en la entidad 'CpanUrlAmigables'

	- /
	- /error404
	- /oldBrowser
	- /contacto

* Cada vista de cada controlador puede (opcionalmente) tener un archivo para los includes de 'css' y otro para los de 'js', 
  con la siguiente nomenclatura: si la vista se llama vista.html.twig, vista.css.twig y vista.js.twig;

  Pero si no existen se utilizarán los que haya en la carpeta '_global': css.twig y js.twig respectivamente

* Personalizar config/config.yml según se indica en su interior.

* Comprobar que exista la carpeta 'tmp' para la caché de templates y class_path

* Comprobar que existan los archivos .htaccess en la carpeta raiz del proyecto,
  y las carpetas 'config', 'bin', 'entities' y 'log'

* Poner el archivo 'favicon.ico' correcto en la carpeta raiz del proyecto

* Las carpetas 'css' y 'js' deben contener dos subcarpetas llamadas 'laptop' y 'mobile'

* Poner en las carpetas 'js/laptop' y 'js/mobile' la última librería de jquery

* Poner en las carpetas 'css/laptop' y 'css/mobile' el archivo 'reset.css'

