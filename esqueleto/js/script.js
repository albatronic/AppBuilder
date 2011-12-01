function CambiaEmpresa(){
    // document.empresa.s.value='';
    document.empresa.action.value='Empresa';
    document.empresa.submit();
}

function CambiaSucursal(){
    document.empresa.action.value='Sucursal';
    document.empresa.submit();
}

function CargaTapiz(){
    top.contenido.location='contenido.php?c=tapiz';
}

function Menu(url){
    top.submenu.location=url;
}

function CambiaIdioma(lang){
    location='servlet.php?lang=' + lang;
}

function Confirma(mensaje){
    if (confirm(mensaje)) return true;
    else return false;
}

function goPage(destiny){
    if (destiny != ("")) {
        document.location.href = destiny;
    }
}

function cambiacolor(idc,colora) {
    if (document.all) {
        document.all[idc].style.background = colora;
    } else if (document.getElementById) {
        document.getElementById(idc).style.background = colora;
    }
}

function MuestraArticulos(){
    var url;
    url='selecarti.php?idfab=' + document.forms[0].IDFabricante.value + '&idart=' + document.forms[0].IDArticulo.value;
    window.open(url,'SELECARTI','width=500,height=610,scrollbars=yes,resizable=yes')
}

function SacaArticulos(formulario,origen){
    var url;
    url='selecarticulos.php?idart=' + document[formulario].IDArticulo.value + '&form=' + formulario + '&origen=' + origen;
    window.open(url,'SELECARTICULOS','width=650,height=640,scrollbars=yes,resizable=yes')
}

function MuestraClientes(formulario,campoclave,campotexto){
    var url;
    url='seleccliente.php?texto=' + document[formulario][campotexto].value + '&form=' + formulario + '&campoclave=' + campoclave + '&campotexto=' + campotexto;
    window.open(url,'CLIENTES','width=550,height=610,scrollbars=yes,resizable=yes')
}

function MuestraProveedores(padre,formulario,campoclave,campotexto){
    var url;
    url='selecproveedor.php?padre=' + padre + '&texto=' + document[formulario][campotexto].value + '&form=' + formulario + '&campoclave=' + campoclave + '&campotexto=' + campotexto;
    window.open(url,'PROVEEDORES','width=500,height=610,scrollbars=yes,resizable=yes')
}
	
function loadNavigation(clave,accion) {
    var a;
	
    document.formulariopsto.IDArticulo.value='';

    document.formulariopsto.Incremento.value='0';
    document.formulariopsto.Descripcion.value='';
    document.formulariopsto.Unidades.value='1';
    document.formulariopsto.Precio.value='0';
    document.formulariopsto.Descuento.value='0';
    url=document.location + '&idfab=' + document.formulariopsto.IDFabricante.value;
    a='document.location.href=url';
}

function SymError() {
    return true;
}

window.onerror = SymError;

function veteA(combo) {
    donde= combo.options[combo.selectedIndex].value;
    if (donde!="#") window.location.href=donde;
}

function CerrarVentana() {
    window.close();
}

function Centrar() {
    ancho=document.body.clientWidth;
    alto=document.body.clientHeight;
    var X = (screen.width-ancho)/2;
    var Y = (screen.height-alto)/2;
    window.moveTo(X,Y)
}

function MuestraOficinas(formulario,campobanco,campooficina){
    var url;
    url='contenido.php?c=bancosoficinas&Banco=' + document[formulario][campobanco].value + '&form=' + formulario + '&campobanco=' + campobanco + '&campooficina=' + campooficina;
    window.open(url,'OFICINAS','width=500,height=655,scrollbars=yes,resizable=yes')
}	

function MuestraBancos(formulario,campobanco){
    var url;
    url='contenido.php?c=bancos&form=' + formulario + '&campobanco=' + campobanco;
    window.open(url,'BANCOS','width=500,height=590,scrollbars=yes,resizable=yes')
}

function LanzaPrograma(prog) {
    var Shell = new ActiveXObject("WScript.Shell");
    Shell.run(prog);
}

function Redondear(cantidad, decimales) {
    var vcantidad = parseFloat(cantidad);
    var vdecimales = parseFloat(decimales);
    vdecimales = (!vdecimales ? 2 : vdecimales);
    return Math.round(vcantidad * Math.pow(10, vdecimales)) / Math.pow(10, vdecimales);
}

function ValidaNif(documento,campo) {
    cadena = "TRWAGMYFPDXBNJZSQVHLCKET";
    mensaje='';
    caracteres=document.forms[documento].elements[campo].value.length;
    if ((caracteres < 7) || ( caracteres > 9)) {
        mensaje = 'Faltan caracteres';
    }
    else {
        nif=document.forms[documento].elements[campo].value;
        primero=nif.substring(0,1);
        if(!isNaN(primero)){
            numeros=nif.substring(0,8);
            letra=nif.substring(8,1);
            posicion=numeros % 23;
            letraok=cadena.substring(posicion,posicion+1);
            document.forms[documento].elements[campo].value = numeros + letraok;
        }
    }
    if(mensaje!='') alert(mensaje);
}

function IsNumeric(valor){
    var log=valor.length;
    var sw="S";
    for (x=0; x<log; x++){
        v1=valor.substr(x,1);
        v2 = parseInt(v1);
        //Compruebo si es un valor numerico
        if (isNaN(v2)) {
            sw= "N";
        }
    }
    if (sw=="S") {
        return true;
    } else {
        return false;
    }
}

var primerslap=false;
var segundoslap=false;

function formateafecha(fecha){
    var longitud = fecha.length;
    var dia;
    var mes;
    var ano;
    if ((longitud>=2) && (primerslap==false)) {
        dia=fecha.substr(0,2);
        if ((IsNumeric(dia)==true) && (dia<=31) && (dia!="00")) {
            fecha=fecha.substr(0,2)+"/"+fecha.substr(3,7);
            primerslap=true;
        }
        else {
            fecha="";
            primerslap=false;
        }
    }
    else
    {
        dia=fecha.substr(0,1);
        if (IsNumeric(dia)==false)
        {
            fecha="";
        }
        if ((longitud<=2) && (primerslap=true)) {
            fecha=fecha.substr(0,1);
            primerslap=false;
        }
    }
    if ((longitud>=5) && (segundoslap==false))
    {
        mes=fecha.substr(3,2);
        if ((IsNumeric(mes)==true) &&(mes<=12) && (mes!="00")) {
            fecha=fecha.substr(0,5)+"/"+fecha.substr(6,4);
            segundoslap=true;
        }
        else {
            fecha=fecha.substr(0,3);
            segundoslap=false;
        }
    }
    else {
        if ((longitud<=5) && (segundoslap=true)) {
            fecha=fecha.substr(0,4);
            segundoslap=false;
        }
    }
    if (longitud>=7)
    {
        ano=fecha.substr(6,4);
        if (IsNumeric(ano)==false) {
            fecha=fecha.substr(0,6);
        }
        else {
            if (longitud==10){
                if ((ano==0) || (ano<1900) || (ano>2100)) {
                    fecha=fecha.substr(0,6);
                }
            }
        }
    }
    if (longitud>=10){
        fecha=fecha.substr(0,10);
        dia=fecha.substr(0,2);
        mes=fecha.substr(3,2);
        ano=fecha.substr(6,4);
        // A�o no viciesto y es febrero y el dia es mayor a 28
        if ( (ano%4 != 0) && (mes ==02) && (dia > 28) ) {
            fecha=fecha.substr(0,2)+"/";
        }
    }
    return (fecha);
}

function MuestraHora()
{
    var timerN=null;
    var ahora=new Date();
    var ahorah=ahora.getHours();
    var ahoram=ahora.getMinutes();
    var ahoras=ahora.getSeconds()
	
    // Calculo las horas
    var hora = ((ahorah<10) ? "0" : "") + ahorah + ((ahoram<10) ? ":0" : ":") + ahoram + ((ahoras<10) ? ":0" : ":") + ahoras
    reloj.value = hora;
		
    // Muestro la hora actual cada segundo
    timerN=setTimeout("MuestraHora()",1000);
}

function Saludar(nombre) {
    var oneDate = new Date();
    var elDia = oneDate.getDate();
    var elMes = oneDate.getMonth();
    var elAnio = oneDate.getYear();
    var laHora = oneDate.getHours();
    var saludo;
    if ((laHora > 5) && (laHora < 15)) {
        saludo=" Buenos dias";
    } else {
        if ((laHora > 14) && (laHora < 21)) {
            saludo="Buenas tardes";
        } else {
            if ((laHora > 20) || (laHora < 6)) {
                saludo="Buenas noches";
            }
        }
    }
    saludo = saludo + " " + nombre;
    saludojornada.value = saludo;
}


/*
 * ----------------------------------------------------------------
 * FUNCIONES AJAX
 * ----------------------------------------------------------------
 * GENERA UN DESPLEGLABE CON TECNOLOGIA AJAX. LOS PARAMETROS SON
 *
 * iddiv        -> ID identificador del contenedor que será rellenado con la respuesta (¡¡no vale el atributo name!!)
 * idselect     -> ID identificador del select que se creará  (¡¡no vale el atributo name!!)
 * nameselect   -> NAME name del select que se creará (se utiliza para capturar del datos del formulario)
 * tipo         -> indica el tipo de select. O sea la tabla que se empleará. Ver script 'desplegable_ajax.php'
 * filtro       -> elemento html que contiene el valor por el que filtrar los datos.
 */
function DesplegableAjax(iddiv,idselect,nameselect,tipo,filtro) {
    var url        = '/erp/lib/desplegableAjax.php';
    var parametros = 't='+tipo+'&filtro='+eval(filtro)+'&idselect='+idselect+'&nameselect='+nameselect;

    // Coloco un gif "Cargando..." en la capa
    $('#'+iddiv).html("<img src='/erp/images/loading.gif'>");

    jQuery('#'+iddiv).load(url, parametros);
}

/*
 * ----------------------------------------------------------------
 * FUNCION PARA LOS MENSAJES DE NOTIFICACION
 * NECESITA:
 *       notificaciones.css
 *       habilitar un tag <div id="notificacion"></div> en cualquier
 *       parte de la pagina, preferiblemente en el layout principal
 *
 * $mensaje: es el mensaje de notificacion a mostrar
 * $tipo:    determina el estilo del mensaje. Los valores posibles son:
 *           exito,alerta,info,error (que coinciden con los estilos
 *           definidos en notificaciones.css)
 *
 * ----------------------------------------------------------------
 */
function notificacion(mensaje,tipo) {
    var v=0;
    var errores="";
    for (var i=0; i<=mensaje.length;i++)
    {
        if(mensaje[i]=='#')
        {
            errores += '<p>' + mensaje.substring(i, v) + '</p>';
            v=i+1;
        }
    }

    document.getElementById('notificacion').innerHTML = errores;
    document.getElementById('notificacion').className = tipo+" notificacion";

    setTimeout(function(){
        $(".notificacion").fadeIn(2000).fadeOut(6000);
    }, 0000);
}

/**
 * CREA UN LOTE Y RECARGA EL DIV iddiv CON EL SELECT DE TODOS
 * LOS LOTE DEL PRODUCTO idArticulo
 */
function CrearLote(iddiv,idArticulo,lote,fFabricacion,fCaducidad) {
    var url        = '/erp/lib/crearlote.php';
    var parametros = 'idArticulo='+idArticulo+'&lote='+lote+'&fFabricacion='+fFabricacion+'&fCaducidad='+fCaducidad;

    // Coloco un gif "Cargando..." en la capa
    $('#'+iddiv).html("<img src='/erp/images/loading.gif'>");

    jQuery('#'+iddiv).load(url, parametros);
}

/**
 * FUNCTION PARA AUTOCOMPLETAR
 *
 * PARAMETROS:
 *      key:        Para identificar los divs que hay que rellenar u ocultar
 *      idSucursal: EL ID de la sucursal para filtrar clientes y articulos
 *      idInput:    EL ID del campo donde hay que devolver el id del resultado
 *      idTexto:    El ID del campo donde hay que devolver el texto del resultado
 *      entidad:    Para saber que tipo de consulta debe hacer el script php (autoCompletar.php)
 *      valor:      El valor introducido por el usuario
 *
 * SE APOYA EN LA FUNCION fill, DESCRITA MÁS ABAJO
 * 
 * POR RAZONES DE OPTIMIZACION, NO SE LANZA LA BUSQUEDA HASTA QUE NO SE HAN
 * INTRODUCIDO AL MENOS TRES CARACTERES.
 *
 * NECESITA LA HOJA DE ESTILOS jquery-autocompletar.css
 *
 * LLAMA AL SCRIP autoCompletar.php QUE ES EL QUE HACE LA CONSULTA
 * A LA BASE DE DATOS Y DEVUELVE EL RESULTADO
 */
function lookup(key,idSucursal,idInput,idTexto,entidad,valor,desplegableAjax) {

    if(valor.length < 3) {
        // Hide the suggestion box.
        $('#suggestions'+key).hide();
    } else {
        $.post(
            "/erp/lib/autoCompletar.php",
            {
                key: ""+key+"",
                idSucursal: ""+idSucursal+"",
                idInput: ""+idInput+"",
                idTexto: ""+idTexto+"",
                entidad: ""+entidad+"",
                valor: ""+valor+"",
                desplegableAjax: ""+desplegableAjax+""
            },
            function(data){
                if(data.length >0) {
                    $('#suggestions'+key).show();
                    $('#autoSuggestionsList'+key).html(data);
                }
            }
            );
    }
}

/**
 * PONE EL VALOR value EN EL CAMPO idInput
 * PONE EL VALOR texto EN EL CAMPO idTexto
 * Y OCULTA EL DIV suggestions+key
 *
 * ESTA FUNCION ES UTILIZADA POR LA FUNCION lookup
 *
 * SI desplegableAjax TIENE VALOR, SE ENTIENDE QUE ES UN ARRAY
 * DE VALORES SEPARADOR POR COMAS Y SERAN UTILIZADOS COMO
 * PARAMETROS PARA LA FUNCION DesplegableAjax
 */
function fill(key,idInput,value,idTexto,texto, desplegableAjax) {

    $('#'+idInput).val(value);
    $('#'+idTexto).val(texto);
    setTimeout("$('#suggestions"+key+"').hide();", 200);

    if (desplegableAjax.length > 0){
        var params = desplegableAjax.split(',');
        DesplegableAjax(params[0],params[1],params[2],params[3],value);
    }
}

/**
 * OCULTA EL DIV suggestions+key
 */
function hideSuggestions(key) {
    setTimeout("$('#suggestions"+key+"').hide();", 200);
}