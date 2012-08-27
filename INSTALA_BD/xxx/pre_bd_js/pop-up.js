jQuery(document).ready(function($){

			
	$("a[rel='pop-up']").click(function () {
	var caracteristicas = "height="+(screen.availHeight - 40)+",width="+(screen.availWidth - 13)+",screenX=0,screenY=0,left=0,top=0,status=no,menubar=yes,scrollbars=yes,resizable=yes,toolbar=yes,location=yes";
	nueva=window.open(this.href, 'Popup', caracteristicas);
	return false;
	});

});