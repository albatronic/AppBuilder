<?php
echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>'; // LLAMADA A JQUERY
	echo '<script type="text/javascript" src="js/pirobox_extended_def_08_2011.js"></script>';



echo '<script type="text/javascript">
		jQuery(document).ready(function($){

		$.pirobox_ext({
			piro_speed : 700,
			zoom_mode : true,
			move_mode : \'mousemove\',
			bg_alpha : 0.5,
			piro_scroll : true,
			share: false
		});
			
	$("a[rel=\'pop-up\']").click(function () {
	var caracteristicas = "height="+(screen.availHeight - 40)+",width="+(screen.availWidth - 13)+",screenX=0,screenY=0,left=0,top=0,status=no,menubar=yes,scrollbars=yes,resizable=yes,toolbar=yes,location=yes";
	nueva=window.open(this.href, \'Popup\', caracteristicas);
	return false;
	});

});
</script>';


?>