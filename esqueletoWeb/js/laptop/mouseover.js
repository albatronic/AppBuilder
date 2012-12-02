$(document).ready(function(){
    
$("#activar1").css("background", "url(images/enviar.png) right 50% no-repeat")
$("#proyectos2").css("display", "none")
/* --------------- INSTALACIONES --------------- */
$("#activar1").click(function(){
  //alert("Handler for .click() called.");
          $("#proyectos1").css("display", "block");
          $("#proyectos2").css("display", "none");
          $("#activar1").css("background", "url(images/enviar.png) right 50% no-repeat")
          $("#activar2").css("background", "none")
});

$("#activar2").click(function(){
  //alert("Handler for .click() called.");
          $("#proyectos1").css("display", "none");
          $("#proyectos2").css("display", "block");
          $("#activar1").css("background", "none")
          $("#activar2").css("background", "url(images/enviar.png) right 50% no-repeat")

});

/* ------------------------------------------------------*/

});
