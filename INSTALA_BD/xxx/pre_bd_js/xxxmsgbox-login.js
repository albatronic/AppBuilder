$(document).ready(
	function(ev) {
	
	  $.msgbox("", {
		type    : "prompt",
		name    : "lock",
		inputs  : [
		  {type: "text",     name: "usuario", value: "", label: "Usuario:", required: true},
		  {type: "password", name: "password", value: "", label: "Contraseña:", required: true}
		],
		buttons : [
		  {type: "submit", name: "submit", value: "Aceptar"},
		],
		form : {
		  active: true,
		  method: "post",
		  action: "plataforma.php?g=1&f=gs_l&f1=0_menu_principal&s1=0_menu_principal"
		}
	  });
	  
	  ev.preventDefault();
	
	}
)
