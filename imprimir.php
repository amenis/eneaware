<script src="js/printThis.js"></script>
<?php
session_start();
if(isset($_SESSION["Usuario_Eneaware"])){
	if($_SESSION["Permisos_Eneaware"][12]!="000"){

		include("conexion.php");


		if($_POST['accion']=="imprimir"){

			echo'<h2>Imprimir Reporte</h2>';
			
			echo '
			<button onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();"><img src="imagenes/print.png"/></button>

			<div media="print" style="font-family:Arial;margin:auto;padding:1cm;background:white;width:17.5cm;border:1px solid grey; height:24cm">				
				<img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:0%;"/>	
				<span style="position:relative;left:70%;top:0;">'.$_SESSION["Nombre_Usuario_Eneaware"].'</span>
						
				skdijfkdsnfkldslfjnioadsknkfkl
				
		
			</div>';
		}
		

	}
}
else {
	header("Location: index.php");	
}
?>