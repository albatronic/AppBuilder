/*
 * Debe estar definida la variable appPath que indica el path a la app
 * Se le asigna valor en 'modules/_global/layoutStd.html.twig' y 'modules/_global/popupStd.html.twig'
 *
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright Informatica Albatronic, sl
 * @since 22/01/2012
 */


/**
 * Para las solapas
 */
$(function() {
    $( "#tabs" ).tabs();
});

/**
 * Para el efecto acordeon
 */
$(function() {
    $( "#accordion" ).accordion({
        autoHeight: false,
        navigation: true,
        collapsible: true
    });
});

function Confirma(mensaje) {
    var dialogo = $('<div title="Confirmación"><p>' + mensaje + '</p></div>');
    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $( "#dialog:ui-dialog" ).dialog( "destroy" );

    dialogo.dialog({
        autoOpen: true,
        dialogClass: "alert",
        resizable: false,
        height: 150,
        modal: true,
        show: "fold",
        hide: "scale",
        buttons: {
            Aceptar: function() {
                $( this ).dialog( "close" );
                return true;
            },
            Cancelar: function() {
                $( this ).dialog( "close" );
                return false;
            }
        }
    });
}

function Confirma1(mensaje){
    if (confirm(mensaje)) return true;
    else return false;
}

function CerrarVentana() {
    window.close();
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

function esNumero(numero){
    
 return (/^([0-9])*.([0-9])*$/.test(numero));
 
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

function loading(iddiv) {
    // Coloco un gif "Cargando..." en la capa
    $('#'+iddiv).html("<img src='"+appPath+"/images/loading.gif'>");
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
 * tipo         -> indica el tipo de select. O sea la tabla que se empleará. Ver script 'desplegableAjax.php'
 * filtro       -> elemento html que contiene el valor por el que filtrar los datos.
 */
function DesplegableAjax(iddiv,idselect,nameselect,tipo,filtro) {
    var url        = appPath + '/lib/desplegableAjax.php';
    var parametros = 't='+tipo+'&filtro='+filtro+'&idselect='+idselect+'&nameselect='+nameselect;

    // Coloco un gif "Cargando..." en la capa
    $('#'+iddiv).html("<img src='"+appPath+"/images/loading.gif'>");

    jQuery('#'+iddiv).load(url, parametros);
}

/*
 * GENERA UN LISTA DE AUTOCOMPLETADO CON JQUERY. REQUIRE DE LA FUNCION 'devuelve'
 *
 * campoAutoCompletar   -> es el id del campo donde se genera el autocompletado
 * campoId              -> es el id del campo donde se devuelve el id obtenido
 * campoTexto           -> es el id del campo donde se devuelve el texto obtenido
 * entidad              -> indica en base a qué entidad de datos se genera el autocompletado
 * idSucursal           -> valor de la sucursal, es opcional
 * desplegableAjax      -> array con parametros adicionales para disparar desplegables en cascada
 */
function autoCompletar(campoAutoCompletar,campoId,campoTexto,entidad,idSucursal,desplegableAjax) {
    $( "#"+campoAutoCompletar).autocomplete({
        source: appPath + "/lib/autoCompletar.php?idSucursal=" + idSucursal + "&entidad=" + entidad,
        minLength: 2,
        select: function( event, ui ) {
            devuelve( campoId, ui.item.id, campoTexto, ui.item.value, desplegableAjax );
        }
    });
}

function devuelve( campoId, id, campoTexto, value, desplegableAjax) {
    $( "#"+campoId ).val(id);
    $( "#"+campoTexto ).val(value);
    if (desplegableAjax.length > 0) {
        var params = desplegableAjax;
        DesplegableAjax(params[0],params[1],params[2],params[3],id);
    }
    $( "#"+campoTexto ).focus();
}

////////////////////////////////////////////////////////////////////////////////

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
 * SI NO SE INDICA iddiv, SE CREA EL LOTE PERO NO SE RECARGA EL DIV
 * EL PARAMETRO puntero SE UTILIZA PARA EL ID DEL TAG <SELECT>
 */
function CrearLote(puntero,iddiv,idSelect,nameSelect,idArticulo,lote,fFabricacion,fCaducidad,width) {
    var url        = appPath + '/lib/crearlote.php';
    var parametros = 'puntero='+puntero+'&idArticulo='+idArticulo+'&lote='+lote+'&fFabricacion='+fFabricacion+'&fCaducidad='+fCaducidad+'&idSelect='+idSelect+'&nameSelect='+nameSelect+'&width='+width;

    // Coloco un gif "Cargando..." en la capa
    $('#'+iddiv).html("<img src='"+appPath+"/images/loading.gif' />");

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
 * NECESITA LA HOJA DE ESTILOS jquery.autocompletar.css
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
            appPath + "/lib/autoCompletar.php",
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

function documentos(entidad, id, idDiv) {
    var url        = appPath + '/lib/documentos.php';
    var parametros = 'id='+id+'&entidad='+entidad;

    // Coloco un gif "Cargando..." en la capa
    $('#'+idDiv).html("<img src='"+appPath+"/images/loading.gif'>");

    jQuery('#'+idDiv).load(url, parametros); 
}