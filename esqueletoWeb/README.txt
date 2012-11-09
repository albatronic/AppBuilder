ARTICO ESTUDIO

PROCESOS A SEGUIR PARA LA PUESTA EN MARCHA DEL PROYECTO


* Crear la carpeta del proyecto en el servidor.
* Ejecutar http://localhost/appBuilder para crear el esqueleto del proyecto dentro de la carpeta.
* Creacion de las urls básicas en la entidad 'CpanUrlAmigables'

	- /
	- /error404
	- /oldBrowser
	- /contacto

* Poner en la carpeta 'js' la última librería de jquery
* Poner en la carpeta 'css' el archivo 'reset.css'
* Cada controlador debe tener un archivo para los includes de 'css' y otro para los de 'js', pero si no existen
  se utilizarán los que haya en la carpeta '_global': css.twig y js.twig respectivamente

* En el config/config.yml definir la conexión a la base de datos.

