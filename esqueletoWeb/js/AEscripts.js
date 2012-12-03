/* 
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Ártico Estudio, sl
 * @version 1.0 27-nov-2012
 */


/*
 * CALENDARIO AE
 *
 */

var meses = new Array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

$(document).ready(function(){
    
    $('#calendarioBotonAnterior').click(
        function(){
            var mes = parseInt( $('#calendarioMesActual').val() );
            var ano = parseInt( $('#calendarioAnoActual').val() );
            
            mes = mes - 1;
            if (mes <= 0) {
                mes = 12;
                ano = ano - 1;
            }
            
            calendario('calendarioTablaDias',mes,ano);
            
            $('#calendarioMesActual').val(mes);
            $('#calendarioAnoActual').val(ano);    
        }
        );

    $('#calendarioBotonSiguiente').click(
        function(){
            var mes = parseInt( $('#calendarioMesActual').val() );
            var ano = parseInt( $('#calendarioAnoActual').val() );
            
            mes = mes + 1;
            if (mes >= 13) {
                mes = 1;
                ano = ano + 1;
            }            

            calendario('calendarioTablaDias',mes,ano);
            
            $('#calendarioMesActual').val(mes);
            $('#calendarioAnoActual').val(ano);    
        }
        );   

});

   
/**
 * Genera el html con el calendario del 'mes' y 'ano'
 * y lo pone dentro del div 'idDiv'
 */
function calendario(idDiv,mes,ano) {
    var url        = appPath + '/lib/calendario.php';
    var parametros = 'mes='+mes+'&ano='+ano;

    // Coloco un gif "Cargando..." en la capa
    $('#'+idDiv).html("<img src='"+appPath+"/images/loading.gif'>");

    // Pintar el literal del mes y año
    jQuery('#calendarioTextoMes').html(meses[mes-1] + " " + ano);
    // Pintar el calendario
    jQuery('#'+idDiv).load(url, parametros);
    
}