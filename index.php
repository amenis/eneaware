<!DOCTYPE html>
<?php
session_start();
	if(isset($_SESSION["Usuario_Eneaware"])){
        header('location: View/main.php');
	}
	else{
		echo '
			<html>
				<head>
					<meta charset="utf-8" />
					<title>EneaWare inicio</title>
					<link rel="icon" type="image/png" href="imagenes/icono.png" />
					<link href="css/servidor.css" rel="stylesheet">
					<script src="js/jquery-1.8.3.min.js"></script>
					<script src="js/jquery-ui.js"></script>
					<script src="js/servidor.js"></script>
					<script>
						$(document).ready(function(){
							$("*").tooltip({ position: { my: "left+15 center", at: "right center" }, tooltipClass: "tooltip", content: function () {
 								return $(this).prop("title");
 								}
 							});
							$("#login").draggable().show("drop",{direction:"down"},600).disableSelection().submit(function(){
								$("#resultadoInicio").show("clip");
								$.ajax({
									url: $(this).attr("action"),
									type:"POST",
									data:$(this).serialize(),
									success: function(data) {
										$("#resultadoInicio").hide("clip", function(){
											$(this).html(data).show("clip");
											if(data=="Inicio de sesion correcto"){
												$("#login").delay(800).fadeOut(800);
												setTimeout(function(){
													location.href="view/main.php";
												},1600);
											}
										});	
	  								}
								});
								return false;						
							});
						});
					</script>
				</head>
				<body>
					<center style="position:absolute;top:200px;width:98%;">
					<form id="login" method="post" action="controller/validar.php" >
						<div style="text-align:center;color:white;position:relative;top:-20px;left:-50px;padding:50px;padding-bottom:6px;padding-top:6px;width:100%;background-color:#464646;border-radius:2px 2px 0 0">
							Inicio de sesion
						</div>
						<img src="imagenes/inicio.jpg" style="width:60px;position:absolute;top:60px;left:10px">						
						<table style="width:100%;">
							<tr>
								<td style="width:100px;padding-left:30px">Usuario</td>
								<td><input type="text" placeholder="usuario" name="usuario"></td>
							</tr>
							<tr>
								<td style="width:100px;padding-left:30px">Contraseña</td>
								<td><input type="password" placeholder="pass" name="pass"></td>
							</tr>
						</table>
						<center><button class="boton">Iniciar sesion</button></center>
						<div id="resultadoInicio" style="position:absolute;bottom:0;left:0;display:none;background:lightgreen;padding-top:5px;padding-bottom:5px;width:100%">
							Iniciando sesion...
						</div>
					</form>
					</center>
				</body>
			</html>		
		';	
	}
?>