<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<style>
	fieldset { border:1px solid #009ec3 }
	
	legend {
	  padding: 0.2em 0.5em;
	  border:2px solid #009ec3;
	  font-size:100%;
	  text-align:right;
	  }
</style>
<?php
session_start();
include("conexion.php");	

	$en = $_POST["encuesta"];
	
	$con = mysqli_query($conexion,"SELECT * FROM Encuestas WHERE id_encuesta=".$en."; ");
						
		while($datos = mysqli_fetch_array($con)){	
			$no = $datos["nombre_encuesta"];
			$creador= $datos["activada_por"];
			$periodo = $datos["periodo"];
			$fe= $datos["fecha"];
		}
	
		echo '<div id="con" style="overflow:auto;height:100%">
			  <h1>Revisar Encuesta </h1>';
		echo '<div style="overflow:auto;height:100%">';
		echo '<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">

				<br><br>

				
				<b>Nombre de la Encuesta:</b> '.$no.'<br>
				<b>Fue creada por:</b> '.$creador.'<br>
				<b>El dia:</b> '.$fe.'<br>
				<b>Para el periodo:</b> '.$periodo.'<hr></hr>

			  
				
				<fieldset>
					<legend>Secciones de '.$no.' </legend>';
			  	
					
					$cont=1;
					$Secciones = mysqli_query($conexion,"SELECT * FROM Secciones WHERE id_encuesta=".$en.";");
					$Aviso = 0;
					
					while($datosSeccion = mysqli_fetch_array($Secciones)){

						echo '<div nombre="'.strtolower($datosSeccion["nombre_seccion"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Seccion '.$cont.': <font color="#191970" weight="bold"> '.$datosSeccion["nombre_seccion"].' </font></b>';

						
							$c=1;
							$p=1;
										
							echo'<img class="edit" src="imagenes/plus.png" style=" top:4px; position:absolute; right:3.5%; cursor:pointer;" onclick="$(\'#'.$datosSeccion["id_seccion"].'M\').toggle(\'drop\');">
								<img id="'.$datosSeccion["id_seccion"].'CS" class="edit" src="imagenes/checkmark.png" style=" top:4px; position:absolute; right:3.5%;display:none;cursor:pointer;" onclick="$(\'#'.$datosSeccion["id_seccion"].'M\').toggle(\'drop\');">
								<div id="'.$datosSeccion["id_seccion"].'M" style="display:none;" >
														
							<font color="#191970" weight="bold">Instrucciones:</font><br/> '.$datosSeccion["nota"]."<hr></hr>";

							$pregunta = mysqli_query($conexion,"SELECT * FROM Preguntas WHERE id_seccion = ".$datosSeccion["id_seccion"]." ;");
							while($dato = mysqli_fetch_array($pregunta)){

								echo "<br/>".$c.'.-  <font color="#191970" weight="bold"> ¿ '.$dato["pregunta"].' ?</font><input type="text" style="position:relative;left:10%;display:none;" value="'.$dato["id_pregunta"].'"  name="preId'.$c.'"/><br> ';
												 
								$respuesta = mysqli_query($conexion,"SELECT * FROM Respuestas WHERE id_pregunta=".$dato["id_pregunta"].";");
								$numRespuesta = mysqli_num_rows($pregunta);
								
								
											
								while($dat = mysqli_fetch_array($respuesta)){
												 	
									if ($dat["tipo_respuesta"]=="Abierta") {
										echo '<input type="text" style="position:relative;left:5%;"  name="Ab'.$c.'"/><input type="text" style="position:relative;left:10%;display:none;" value="'.$dat["id_respuesta"].'"  name="AbId'.$c.'"/><br/>';
									} 
									if ($dat["tipo_respuesta"]=="Poropciones") {
										echo '<input type="checkbox" style="position:relative;left:5%;" name="res'.$c.'" value="'.$dat["id_respuesta"].'" /><label style="position:relative;left:6%;">'.$dat["opciones"].'</label></br>';
									}
									if ($dat["tipo_respuesta"]=="Poropciones | otro"){
										echo '<input type="checkbox" style="position:relative;left:5%;" onclick="ot'.$p.'.disabled = false" value="'.$dat["id_respuesta"].'"  value="'.$dat["id_respuesta"].'" name="OtOp'.$p.'"  /><label style="position:relative;left:6%;">'.$dat["opciones"].' :</label> <input type="text" style="position:relative;left:6%;" placeholder="espesifique"  name="ot'.$p.'" disabled/><input type="text" style="position:relative;left:12%;display:none;" value="'.$dato["id_pregunta"].'"  name="pre'.$p.'"/><br/>';
										$p++;
									}		
								}
								$c++;
						
							}	

						echo '</div>
							</div>';
						$cont++;

					}
				
		echo'	</fieldset>
				 <br/>
				
				<fieldset>
					<legend>Apartados de '.$no.' </legend>';
			  	
					$con=1;
					$Apartados = mysqli_query($conexion,"SELECT * FROM Apartados WHERE id_encuesta=".$en.";");
					$Aviso2 = 0;
					
					while($datosApartado = mysqli_fetch_array($Apartados)){
						echo '  <div nombre="'.strtolower($datosApartado["nombre_apartado"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
									<b>Apartado '.$con.': <font color="#191970" weight="bold"> '.$datosApartado["nombre_apartado"].' </font></b>';
									
								
										$c=1;
										$i=1;

										echo'<img class="edit2" src="imagenes/plus.png" style=" top:4px; position:absolute; right:3.5%; cursor:pointer;" onclick="$(\'#'.$datosApartado["id_apartado"].'\').toggle(\'drop\');">		
										<img id="'.$datosApartado["id_apartado"].'CA" class="edit2" src="imagenes/checkmark.png" style=" top:4px; position:absolute; right:3.5%; cursor:pointer;display:none;" onclick="$(\'#'.$datosApartado["id_apartado"].'\').toggle(\'drop\');">
										<div id="'.$datosApartado["id_apartado"].'" style="display:none;" >
										';


										$pregunta = mysqli_query($conexion,"SELECT * FROM Preguntas_apartado WHERE id_apartado = ".$datosApartado["id_apartado"]." ;");
										while($dato = mysqli_fetch_array($pregunta)){
											 echo '<br/>'.$c.'.-  <font color="#191970" weight="bold">¿ '.$dato["pregunta"].' ?</font><input type="text" style="position:relative;left:10%;display:none;" value="'.$dato["id_pregunta_apartado"].'"  name="preId'.$c.'"/><br>';
											 $respuesta = mysqli_query($conexion,"SELECT * FROM Respuestas_apartado WHERE id_pregunta_apartado=".$dato["id_pregunta_apartado"].";");
											 $numRespuesta = mysqli_num_rows($pregunta);
											
											 while($dat = mysqli_fetch_array($respuesta)){
											 	if ($dat["tipo_respuesta"]=="Abierta") {
														echo '<input type="text" style="position:relative;left:5%;"  name="Ab'.$c.'"/><input type="text" style="position:relative;left:10%;display:none;" value="'.$dat["id_respuesta_apartado"].'"  name="AbId'.$c.'"/><br/>';
												} 
												if ($dat["tipo_respuesta"]=="Por opciones") {
														echo '<input type="checkbox" style="position:relative;left:5%;" name="res'.$c.'" value="'.$dat["id_respuesta_apartado"].'" /><label style="position:relative;left:6%;">'.$dat["opciones"]."</label></br>";
												}
												if ($dat["tipo_respuesta"]=="Por opciones | otro"){
													echo '<input type="checkbox" style="position:relative;left:5%;" onclick="ot'.$i.'.disabled = false" value="'.$dat["id_respuesta_apartado"].'" name="OtOp'.$i.'"  /><label style="position:relative;left:6%;">'.$dat["opciones"].' :</label> <input type="text" style="position:relative;left:6%;" placeholder="espesifique"  name="ot'.$i.'" disabled/><input type="text" style="position:relative;left:12%;display:none;" value="'.$dato["id_pregunta_apartado"].'"  name="pre'.$i.'"/><br/>';
													$i++;
												}
											}
											$c++;
										}
										
									
							echo'		</div>
								</div>';
						$con++;
					}
				
		echo'	</fieldset><br/>

		<fieldset>
					<legend>Competencias de '.$no.' </legend>';

					$con=1;
					$Apartados = mysqli_query($conexion,"SELECT * FROM Capasidades_encuesta WHERE id_encuesta=".$en.";");
					$Aviso3 = 0;
					
					while($datosApartado = mysqli_fetch_array($Apartados)){
						echo '  <div nombre="'.strtolower($datosApartado["capasidad"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
									<b>'.$con.': <font color="#191970" weight="bold">'.$datosApartado["capasidad"].'</font></b>';

									

						echo '		<img class="edit3" src="imagenes/plus.png" style=" top:4px; position:absolute; right:3.5%; cursor:pointer;" onclick="$(\'#'.$datosApartado["id_capasidad"].'P\').toggle(\'drop\');">
									<img id="'.$datosApartado["id_capasidad"].'CC" class="edit3" src="imagenes/checkmark.png" style=" top:4px; position:absolute; right:3.5%; cursor:pointer;display:none;" onclick="$(\'#'.$datosApartado["id_capasidad"].'P\').toggle(\'drop\');">
									<div id="'.$datosApartado["id_capasidad"].'P" style="display:none;" >
									';
									$o = 1;
									$pregunta = mysqli_query($conexion,"SELECT * FROM Preguntas_capasidades WHERE id_encuesta=".$en." ;");
										while($dato = mysqli_fetch_array($pregunta)){
											echo '<b>'.$o.' <font color="#191970" >¿'.$dato["pregunta"].'?</font> </b><br/>';
											echo' <input type="radio" style="position:relative;left:5%;" name="oc'.$o.'" value="'.$dato["opcion1"].'" /><label style="position:relative;left:6%;">'.$dato["opcion1"].'</label></br>
											      <input type="radio" style="position:relative;left:5%;" name="oc'.$o.'" value="'.$dato["opcion2"].'" /><label style="position:relative;left:6%;">'.$dato["opcion2"].'</label></br>
											      <input type="radio" style="position:relative;left:5%;" name="oc'.$o.'" value="'.$dato["opcion3"].'" /><label style="position:relative;left:6%;">'.$dato["opcion3"].'</label></br>
											      <input type="radio" style="position:relative;left:5%;" name="oc'.$o.'" value="'.$dato["opcion4"].'" /><label style="position:relative;left:6%;">'.$dato["opcion4"]."</label></br>";
											echo '<input type="text" name="idres'.$o.'" value="'.$dato["id_pregunta_capasidad"].'" style="display:none">';
											echo '<input type="text" name="idcap'.$o.'" value="'.$datosApartado["id_capasidad"].'" style="display:none">';
											$o++;
										}
									
								
						echo'			</div>';
						echo'	</div>';
							
						$con++;
						$Aviso3=0;
					}

		echo'	</fieldset>
				<br/>

				<center><form destino="1" action="system.php" method="post">
					<input type="hidden" name="option" value="salir">
					<button class="button" >Listo</button>
				</form></center><div id="1"></div>
		
		
		';

		
			
		
		echo '';
		
		echo '</div>';
			echo '  </div>
		      </div>';
?>