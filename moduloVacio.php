<?php
session_start();
	include("conexion.php");
	echo '
	<div style="overflow:auto;height:100%">

		<h1>Configuracion del Sistema</h1>
		<div style="height:95%;background:url(imagenes/a.png) no-repeat center center">
						
		</div>
	</div>
	';
	
	mysqli_close($conexion);
?>