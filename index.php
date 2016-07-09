<!DOCTYPE html>
<?php
session_start();
	if(isset($_SESSION["Usuario_Eneaware"])){
        header('location: View/main.php');
	}
	else{
?>
			<html>
				<head>
					<meta charset="utf-8" />
					<title>EneaWare inicio</title>
					<link rel="icon" type="image/png" href="imagenes/icono.png" />
					<link href="css/servidor.css" rel="stylesheet">
                    <link href="css/bootstrap.css" rel="stylesheet">
					<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
					<script type="text/javascript" src="js/jquery-ui.js"></script>
                    <script type="text/javascript" src="js/bootstrap.min.js"></script>
					<script type="text/javascript" src="js/servidor.js"></script>
					<script>
						$(document).ready(function(){
							$("*").tooltip({ position: { my: "left+15 center", at: "right center" }, tooltipClass: "tooltip", content: function () {
 								return $(this).prop("title");
 							    }
                            });
                           // 
							$("#login").draggable().show("drop",{direction:"down"},600);
								//$("#resultadoInicio").show("clip");
							
                            $('#form-login').on('submit',function(){
                                $.ajax({
									url:"controller/validar.php",
									type:"POST",
									data:$(this).serialize(),
									success: function(data) {
										$("#resultadoInicio").hide("clip", function(){
											$(this).html(data).show("clip");
                                            if(data=="Inicio de sesion correcto"){
												$("#login").delay(800).fadeOut(800);
												setTimeout(function(){
													location.reload();
                                                    //location.href="view/main.php";
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
					<center style="width:98%;">
                    <div  id="login">
                        <div style="text-align:center;color:white;position:relative;top:-20px;padding:50px;padding-bottom:6px;padding-top:6px;width:100%;background-color:#464646;border-radius:2px 2px 0 0">
                                Inicio de sesion
                        </div>
                         <img src="imagenes/inicio.jpg" style="width:60px;position:absolute;top:60px;left:10px">
                        <form id="form-login" role="form" class="form-horizontal">
                                               	
                            <div class="form-group">
                                <label  class="control-label col-xs-2">Usuario</label>
                                <div class='col-xs-8'>
                                    <input type="text" class="form-control" name="usuario">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-2">Contrase&ntilde;a</label>
                                <div class='col-xs-8'>
                                    <input type="text" class="form-control"  name="pass">
                                </div>
                            </div>

                           <button type="submit" class="btn-submit btn btn-success">Entrar</button>
                            
                        </form>
                        <div id="resultadoInicio" style="position:absolute;bottom:0;left:0;display:none;background:lightgreen;padding-top:5px;width:100%">
                                Iniciando sesion...
                            </div>
                    </div>
					</center>
				</body>
			</html>		
<?php	
	}
?>