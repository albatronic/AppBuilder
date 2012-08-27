<?php

if($tipo_campo=="string"){
		trato_comillas($arrayDeValores[$miIndiceProblema]);
		$arrayDeValores[$miIndiceProblema]=$resultado;
		$$nombreCampo=$resultado;
		//echo $resultado,"<br>";
}

if($tipo_campo=="blob"){
		procesadortextos($arrayDeValores[$miIndiceProblema]);
		$arrayDeValores[$miIndiceProblema]=$resultado;
		$$nombreCampo=$resultado;

}

?>
