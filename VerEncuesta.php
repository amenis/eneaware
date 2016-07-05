<script src="js/encuesta.js"></script>
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script>
	 $(document).ready(function(){
	 	
		$("#").on("click",function(){
			$( '#seccionI' ).toggle( 'slide' );
			$( '#' ).toggle( 'slide' );
        });
	 });
</script>
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

	$folio=$_POST["alumno"];
	$consultaFolio = mysqli_query($conexion, "SELECT * FROM Folio_encuesta ;");
				
	while($datos = mysqli_fetch_array($consultaFolio)){	
		$egresado = $datos["id_alumno"];
		$en = $datos["id_encuesta"];
		$id_folio = $datos["folio"];
	}

	if ($folio == $id_folio) {

		$con = mysqli_query($conexion,"SELECT * FROM Encuestas WHERE id_encuesta=".$en."; ");
						
		while($datos = mysqli_fetch_array($con)){	
			$no = $datos["nombre_encuesta"];
		}

		

		$consultaAl = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno=".$egresado." ;");
				
		while($datosCurp = mysqli_fetch_array($consultaAl)){			
			$nombre = $datosCurp["apellidoP"]." ".$datosCurp["apellidoM"]." ".$datosCurp["nombre"];
			$domicilio = $datosCurp["calle_local"]."   ".$datosCurp["num_ext_local"];
			$ce = $datosCurp["municipio_local"]." - ".$datosCurp["estado_local"];
			$telefono = $datosCurp["tel_casa"];
			$email = $datosCurp["email"];
			$fn = $datosCurp["fecha_nacimiento"];
			$se = $datosCurp["sexo"];
			$id_alumno = $datosCurp["id_alumno"];
			$edad = date("Y")-$fn;
			$cu = $datosCurp["curp"];
			$matricula = $datosCurp["matricula"];
			$generacion = $datosCurp["generacion"];
		}

		$conEn = mysqli_query($conexion,"SELECT * FROM Encuestas_activadas WHERE periodo=".$en." AND id_alumno= ".$id_alumno."; ");
						
		while($datos = mysqli_fetch_array($conEn)){	
			$aplicador = $datos["aplicador"];
			$fecha_inicio = $datos["fecha_inicio"];
			$hora_inicio = $datos["hora_inicio"];
			$fecha_fin = $datos["fecha_fin"];
			$hora_fin = $datos["hora_fin"];
		}
		
		if ($se=="M") {
			$sexo="Mujer";
		} else {
			$sexo="Hombre";
		}
		
			echo '<div id="con" style="overflow:auto;height:100%">
				  <h1><font color="#191970" weight="bold"> Ver Encuesta Contestada </font> </h1>';
			echo '<div style="overflow:auto;height:100%">';
			echo '<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
				  
				  
				  <br/><font color="#191970" weight="bold">Encuesta: </font><b>'.$no.'</b><br/>
				  <font color="#191970" weight="bold">Aplicada por: </font><b>'.$aplicador.'</b><br/>
				  <font color="#191970" weight="bold">Fecha y hora de inicio: </font><b>'.$fecha_inicio.' | '.$hora_inicio.'</b><br/>
				  <font color="#191970" weight="bold">Fecha y hora de termino: </font><b>'.$fecha_fin.' | '.$hora_fin.'</b><br/>
				  <font color="#191970" weight="bold">No. de folio: </font><b>'.$id_folio.'</b><br/>
				  <hr></hr>
								
				 <fieldset>
					<legend>Datos del Alumno Ecuestado</legend>
					
					<table>
						<tr>
							<td colspan:3><b>Fecha:</b> <font color="#191970" weight="bold">'.date("d-m-Y").'</font><br/><br/></td>
						</tr>
						<tr>
							<td><b>Matricula:</b> <font color="#191970" weight="bold">'.$matricula.'</font></td>
							<td><b>Nombre de la Encuestada (o):</b> <font color="#191970" weight="bold">'.$nombre.'</font></td>
							<td><b>Curp:</b> <font color="#191970" weight="bold">'.$cu.'</font></td>
						</tr>
						<tr>
							<td><b>Domicilio:</b> <font color="#191970" weight="bold">'.$domicilio.'</font></td>
							<td><b>Ciudad y Estado:</b> <font color="#191970" weight="bold">'.$ce.'</font> </td>
							<td><b>Telefono:</b> <font color="#191970" weight="bold">'.$telefono.'</font></td>
						</tr>
						<tr>
							<td><b>Fecha de nacimiento:</b> <font color="#191970" weight="bold">'.$fn.'</font></td>
							<td><b>Edad:</b> <font color="#191970" weight="bold">'.$edad.'</font></td>
							<td><b>Sexo:</b> <font color="#191970" weight="bold">'.$sexo.'</font> &nbsp;&nbsp;&nbsp;
							<b>E-mail:</b> <font color="#191970" weight="bold">'.$email.'</font></td>
						</tr>
						<tr>
							<td><b>Generacion:</b> <font color="#191970" weight="bold">'.$generacion.'</font></td>
						</tr>
					</table>
					
				 </fieldset>
				  
				  <br/>
				  
					<fieldset>
						<legend>Secciones de '.$no.' </legend>';

						echo "<font color='red' weight='bold'>Nota:</font> Las preguntas que aparescan en blanco la alumna no las contesto por indicacion de la encuesta.<hr></hr>";
				  	
						$cont=1;
						$Secciones = mysqli_query($conexion,"SELECT * FROM Secciones WHERE id_encuesta=".$en.";");
						
						while($datosSeccion = mysqli_fetch_array($Secciones)){
							echo '  <div nombre="'.strtolower($datosSeccion["nombre_seccion"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
										<b>Seccion '.$cont.': <font color="#191970" weight="bold"> '.$datosSeccion["nombre_seccion"].' </font></b>
										<img class="edit" src="imagenes/ver.png" style=" top:4px; position:absolute; right:3.5%; cursor:pointer;" onclick="$(\'#'.$datosSeccion["id_seccion"].'M\').toggle(\'drop\');">';
							echo '		<div id="'.$datosSeccion["id_seccion"].'M" style="display:none;" >';
											$c=1;
											$i=1;
										
											$pregunta = mysqli_query($conexion,"SELECT * FROM Preguntas WHERE id_seccion = ".$datosSeccion["id_seccion"]." ;");
											
											while($dato = mysqli_fetch_array($pregunta)){

												 echo "<br/>".$c.'.-  <font color="#191970" weight="bold"> ¿ '.$dato["pregunta"].' ?</font><input type="text" style="position:relative;left:10%;display:none;" value="'.$dato["id_pregunta"].'"  name="preId'.$c.'"/><br/>';
												 $Respuestas = mysqli_query($conexion, "SELECT * FROM Encuestas_contestadas WHERE id_pregunta='".$dato["id_pregunta"]."' AND id_alumno='".$id_alumno."' AND seccion=".$datosSeccion["id_seccion"]." ;");
												 $Num = mysqli_num_rows($Respuestas);

												
												 	
													 while($datosRespuesta = mysqli_fetch_array($Respuestas)){

													 	$consulResp = mysqli_query($conexion, "SELECT * FROM Respuestas WHERE id_respuesta='".$datosRespuesta["id_respuesta"]."';");
													 	$NumRespuestas =mysqli_num_rows($consulResp);

													 	while($datoRespuesta = mysqli_fetch_array($consulResp)){


																if ($datoRespuesta["tipo_respuesta"]=="Abierta") {

																	if ($datosRespuesta["respuesta_contestada"]=="") {
																		echo ' ';
													 
																	} else {
																		echo '<label style="position:relative;left:5%;"> R= '.$datosRespuesta["respuesta_contestada"].'</label>';
																
																	}
																	

																}
																if ($datoRespuesta["tipo_respuesta"]=="Poropciones") {
																	echo '<label style="position:relative;left:5%;"> R= '.$datoRespuesta["opciones"].'</label>';
																
																}

																	
																if ($datoRespuesta["tipo_respuesta"]=="Poropciones | otro") {
																	echo '<label style="position:relative;left:5%;"> R= '.$datoRespuesta["opciones"]." : ".$datosRespuesta["respuesta_contestada"].'</label>';
																}
															
														}

													 }
												 
												$c++;
											}
											
						
										
										
										
							echo '		</div>
									</div>';
							$cont++;
						}
						
				
					
			echo'	</fieldset>
					 <br/>
					
					<fieldset>
						<legend>Apartados de '.$no.' </legend>';
				  	
						$con=1;
						$Apartados = mysqli_query($conexion,"SELECT * FROM Apartados WHERE id_encuesta=".$en.";");
						
						while($datosApartado = mysqli_fetch_array($Apartados)){
							echo '  <div nombre="'.strtolower($datosApartado["nombre_apartado"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
										<b>Apartado '.$con.': <font color="#191970" weight="bold"> '.$datosApartado["nombre_apartado"].' </font></b>
										<img class="edit2" src="imagenes/ver.png" style=" top:4px; position:absolute; right:3.5%; cursor:pointer;" onclick="$(\'#'.$datosApartado["id_apartado"].'\').toggle(\'drop\');">';
							echo '		<div id="'.$datosApartado["id_apartado"].'" style="display:none;" >';
										
											$c=1;
											$i=1;

											$pregunta = mysqli_query($conexion,"SELECT * FROM Preguntas_apartado WHERE id_apartado = ".$datosApartado["id_apartado"]." ;");
											while($dato = mysqli_fetch_array($pregunta)){
												 echo '<br/>'.$c.'.-  <font color="#191970" weight="bold">¿ '.$dato["pregunta"].' ?</font><input type="text" style="position:relative;left:10%;display:none;" value="'.$dato["id_pregunta_apartado"].'"  name="preId'.$c.'"/><br/>';
												 $Respuestas = mysqli_query($conexion, "SELECT * FROM Encuestas_contestadas WHERE apartado='".$datosApartado["id_apartado"]."' AND id_pregunta='".$dato["id_pregunta_apartado"]."' AND id_alumno='".$id_alumno."' ;");
												 $Num = mysqli_num_rows($Respuestas);

												 if ($Num == 0) {
												 	echo '<label style="position:relative;left:5%;"> La alumna (o) No requirio contestar esta pregunta </label>';
												 } else {
							
													 while($datosRespuesta = mysqli_fetch_array($Respuestas)){

													 	$consulResp = mysqli_query($conexion, "SELECT * FROM Respuestas_apartado WHERE id_respuesta_apartado='".$datosRespuesta["id_respuesta"]."';");

													 	while($datoRespuesta = mysqli_fetch_array($consulResp)){
															if ($datoRespuesta["tipo_respuesta"]=="Abierta") {
																echo '<label style="position:relative;left:5%;"> R= '.$datosRespuesta["respuesta_contestada"].'</label>';
															}
															if ($datoRespuesta["tipo_respuesta"]=="Por opciones") {
																echo '<label style="position:relative;left:5%;"> R= '.$datoRespuesta["opciones"].'</label>';
															}
															if ($datoRespuesta["tipo_respuesta"]=="Por opciones | otro") {
																echo '<label style="position:relative;left:5%;"> R= '.$datoRespuesta["opciones"]." : ".$datosRespuesta["respuesta_contestada"].'</label>';
															}
														}

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
						<legend>Competencias del egresado de '.$no.' </legend>

						<font color="red" weight="bold">Nota:</font><b> A continuacion presentamos las peguntas que se hicieron en 
						cada copetencia</b><hr></hr>';
						
						$k = 1;
						$pregunta = mysqli_query($conexion,"SELECT * FROM Preguntas_capasidades WHERE id_encuesta=".$en."  ;");
											
						while($dato = mysqli_fetch_array($pregunta)){

							echo '  <div nombre="'.strtolower($dato["pregunta"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
									<b>Pregunta '.$k.' <font color="#191970" weight="bold"> ¿ '.$dato["pregunta"].' ? </font></b>
									<img class="edit2" src="imagenes/ver.png" style=" top:4px; position:absolute; right:3.5%; cursor:pointer;" onclick="$(\'#'.$dato["id_pregunta_capasidad"].'P\').toggle(\'drop\');">';
							echo '	<div id="'.$dato["id_pregunta_capasidad"].'P" style="display:none;" ><br/>';

										$Respuestas = mysqli_query($conexion,"SELECT * FROM Respuesta_capasidad WHERE id_pregunta_capasidad=".$dato["id_pregunta_capasidad"]." AND id_alumno= ".$id_alumno." ;");
											
										$n = 1;
										while($datoRespuesta = mysqli_fetch_array($Respuestas)){


											$Competencias = mysqli_query($conexion,"SELECT * FROM Capasidades_encuesta WHERE id_capasidad=".$datoRespuesta["id_capasidad"]." ;");
											

											while($datos = mysqli_fetch_array($Competencias)){

												if ($datoRespuesta["respuesta"] == $dato["opcion1"]) {
													echo '<label style="position:relative;left:5%;">'.$n.'.- <font color="#191970" weight="bold">'.$datos["capasidad"].'</font> R= <b>'.$dato["opcion1"].'</b> </label><br/>';
												}
												if ($datoRespuesta["respuesta"] == $dato["opcion2"]) {
													echo '<label style="position:relative;left:5%;">'.$n.'.- <font color="#191970" weight="bold">'.$datos["capasidad"].'</font> R= <b>'.$dato["opcion2"].'</b> </label><br/>';
												}
												if ($datoRespuesta["respuesta"] == $dato["opcion3"]) {
													echo '<label style="position:relative;left:5%;">'.$n.'.- <font color="#191970" weight="bold">'.$datos["capasidad"].'</font> R= <b>'.$dato["opcion3"].'</b> </label><br/>';
												}
												if ($datoRespuesta["respuesta"] == $dato["opcion4"]) {
													echo '<label style="position:relative;left:5%;">'.$n.'.- <font color="#191970" weight="bold">'.$datos["capasidad"].'</font> R= <b>'.$dato["opcion4"].'</b> </label><br/>';
												}

												$n++;

											}

										}
									
							echo'	</div>';
							echo'	</div>';

							$k++;
								
						}

			echo'	</fieldset>
					<br/>
			
			
			';

			
			
			echo '</div>
				  </div>
			      </div>';
		
	} else {
		echo '<div id="con" style="overflow:auto;height:100%">
				<h1><font color="red" weight="bold">Error ...</font> </h1>';
		echo '<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);height: auto;padding-left:20px;">
				<font color="#191970" weight="bold">No. de Folio invalido</font>

				<form destino="con" action="administrarEncuesta.php" method="post" >
					<input type="hidden" name="option" value="salir">
					<br/><hr></hr>
					<center><button>Intentar de nuevo</button></center><br/>
			 	</form>

				</div>
				</div>';  	
	}
	

	
		
?>