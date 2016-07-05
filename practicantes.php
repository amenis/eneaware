<script src="js/jquery.tablePagination.js"></script>
<?php
session_start();
	include 'conexion.php';
	echo'<div style="overflow:auto;height:100%">
			<h1>Lugares Practicantes</h1>
			<button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="AlumnoLugar">Asignar Alumno a Lugar</button>
			<button class="tab"  style="border-bottom:none;" permiso="A" mostrar="RegistrarLugar">Registrar Lugar</button>
			<button class="tab" style="border-bottom:none;" mostrar="modificarL">Ver / Modificar Informacion del Lugar</button>	
			<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
				<div id="AlumnoLugar" class="tabCont" permiso="A">

					<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
						<input type="search" autofocus class="name" padre="alumno"  placeholder="Buscar por nombre">
						<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
					</div>

					<h2>Asignar Alumno a Lugar</h2><hr></hr>
					<form action="guardarLugar.php" destino="resultadoRegistro" method="POST">
						<input type="hidden" name="accion" value="guardarAlumno">
						 <table>
						 	<tr><td>Alumno: ';
						 	$pro= mysqli_query($conexion,"SELECT * FROM Alumnos WHERE status=1;");
							$numpro = mysqli_num_rows($pro);
								echo"<select name='alumno' ><option value='na'>Eliga la Alumna (o) a asignar...</option>";
								if($numpro>0){
									for($x=0;$x<$numpro;$x++){
										$datos = mysqli_fetch_array($pro);
										echo"<option value='".$datos["id_alumno"]."'>". $datos["apellidoP"].' '.$datos["apellidoM"].' '.$datos["nombre"]."</option>";
									}
								}
								echo"</select>  &nbsp; Lugar: ";
							$pro= mysqli_query($conexion,"SELECT * FROM Lugares_practicantes");
							$numpro = mysqli_num_rows($pro);
								echo"<select name='lugar' ><option value='na'>Eliga el Lugar a asignar...</option>";
								if($numpro>0){
									for($x=0;$x<$numpro;$x++){
										$datos = mysqli_fetch_array($pro);
										echo"<option value='".$datos["id_lugar"]."'>". $datos["institucion"]."</option>";
									}
								}
								echo"</select>  &nbsp; <button>Asignar</button>";
						 	echo'	</td></tr>  
						 	</table><br/>
					</form>		

					<h2>Alumnos Asignados</h2><hr></hr>

					<table id="alumno" style="width:100%;">';
				
						$alumnos = mysqli_query($conexion, "SELECT * FROM Practicantes WHERE status = 1 ;");
						while($dato = mysqli_fetch_array($alumnos)){

							$alumno = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno = ".$dato["id_alumno"]." ;");
							$lugares = mysqli_query($conexion,"SELECT * FROM Lugares_practicantes WHERE id_lugar=".$dato["id_lugar"].";");
							while($datos = mysqli_fetch_array($alumno)){

								echo'

									<tr class="alumno">

										<td>
										<span class="alumno_nombre" style="display:none;">'.$datos["apellidoP"].' '.$datos["apellidoM"].' '.$datos["nombre"].'</span>
											<div nombre="'.strtolower($datos["nombre"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
												<b>'.$datos["apellidoP"].' '.$datos["apellidoM"].' '.$datos["nombre"].'</b>							
												<div id="resPer'.$datos["id_alumno"].'" style="display:none">';
												$dat = mysqli_fetch_array($lugares);
												echo'	 <table>
													 	<tr><td>Institucion</td><td><label><font color="#191970" weight="bold">'.$dat['institucion'].'</font></label></td></tr>
													 	<tr><td>Telefono</td><td><label><font color="#191970" weight="bold">'.$dat['telefono'].'</font></label></td></tr>
													 	<tr><td>Domicilio</td><td><label><font color="#191970" weight="bold">'.$dat['domicilio'].'</font></label></td></tr>
													 	<tr><td>Encargado</td><td><label><font color="#191970" weight="bold">'.$dat['encargado'].'</font></label></td></tr>
													 	<tr><td>Estado</td><td><label><font color="#191970" weight="bold">'.$dat['estado_pais'].'</font></label></td></tr>
													 	<tr><td>Municipio</td><td><label><font color="#191970" weight="bold">'.$dat['municipio'].'</font></label></td></tr>
													 	<tr><td>Notas</td><td><label><font color="#191970" weight="bold">'.$dat['notas'].'</font></label></td></tr>
													 </table>
												</div>
												<img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#resPer'.$datos["id_alumno"].'\').toggle(\'drop\')">
											</div>

										</td>

									</tr>';
							}		

						}

					echo '</table>

						<script>
							$("#alumno").tablePagination({});
							$.expr[":"].Contains = function(x, y, z){
							return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
							};
						</script>


				</div>
				<div id="RegistrarLugar" class="tabCont" style="display:none;" permiso="A">
					<h2>Registro de Lugares</h2>
					<form action="guardarLugar.php" destino="resultadoRegistro" method="POST">
						<input type="hidden" name="accion" value="guardar">
						 <table>
						 	<tr><td>Institucion</td><td><input type="text" name="institucion"></td></tr>
						 	<tr><td>Telefono</td><td><input type="text"  name="telefono"></td></tr>
						 	<tr><td>Domicilio</td><td><input type="text" name="domicilio"></td></tr>
						 	<tr><td>Encargado</td><td><input type="text" name="encargado"></td></tr>
						 	<tr><td>Estado</td><td><input type="text" name="estado"></td></tr>
						 	<tr><td>Municipio</td><td><input type="text" name="municipio"></td></tr>
						 	<tr><td>Notas</td><td><textArea row="10" cols="40" name="notas"></textArea></td></tr>
						 </table>
						 <img src="imagenes/geolocalizacion.jpg" style="cursor:pointer;position:absolute;top:50px;right:5%;border-radius:4px;border:2px solid grey;width:25%" onclick="$(this).next().next().trigger(\'click\')"/><br/>
						 <input type="file" nombre="archivo" accept=".jpg, .gif, .png" style="display:none;"/>
						 <center><button>Guardar</button></center>
					</form>				
				</div>
				<div id="modificarL" style="display:none;" permiso="M" class="tabCont" destino="resultadoRegistro" method="POST">
					<h2>Modificar Lugares</h2>

					<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
						<input type="search" autofocus class="name" padre="Mod"  placeholder="Buscar por nombre">
						<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
					</div>

					<table id="Mod" style="width:100%;">';
						
						$cons = mysqli_query($conexion,"SELECT * FROM Lugares_practicantes;");
						$cant = mysqli_num_rows($cons);
						$cont=0;
						while($cont < $cant){
							$datos = mysqli_fetch_array($cons);

							if(file_exists("imagenes/lugares/".$datos["id_lugar"].".png")){
								$imagenTmp1=$datos["id_lugar"].'.png';
							}
							else{
								if(file_exists("imagenes/lugares/".$datos["id_lugar"].".jpg")){
									$imagenTmp1=$datos["id_lugar"].'.jpg';
								}
								else{
									if(file_exists("imagenes/lugares/".$datos["id_lugar"].".gif")){
										$imagenTmp1=$datos["id_lugar"].'.gif';
									}
									else {
										if(file_exists("imagenes/lugares/".$datos["id_lugar"].".svg")){
											$imagenTmp1=$datos["id_lugar"].'.svg';
										}
										else {
											$imagenTmp1="../geolocalizacion.jpg";
										}
									}
								}
							}

							echo'<tr class="Mod">

										<td>

										<div nombre="'.strtolower($datos["institucion"]).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
											<b>'.$datos["institucion"].'</b>
											<img class="edit" src="imagenes/edit.png" style="padding:4px; top:5px; position:absolute; right:3%;" onclick="$(\'#\'+\''.$datos["id_lugar"].'\').toggle(\'drop\');">
											<img src="imagenes/bin.png"  permiso="D" style="padding:4px; top:5px; position:absolute;right:0;" onclick="$(this).next().toggle(\'drop\');">
											
											<div style="display:none;" permiso="D">
												<form class="borrar" destino="resultadoRegistro" action="GuardarLugar.php"style="display:inline-block" >
													<input type="hidden" value="borrar" name="option">
													<input type="hidden" value="'.$datos["institucion"].'" name="insitucion" >									
														<label>Estas Seguro que deseas deshabilitar a este alumno@ '.$datos["institucion"].'"</label>
														<button>Si,estoy seguro</button>																		
												</form>
												<button style="display:inline-block" onclick="return false,$(this).parent().toggle(\'drop\')">No</button>	
											</div>
											
											<form  id="'.$datos['id_lugar'].'" action="guardarLugar.php" style="display:none;" destino="resultadoRegistro">
												<input type="hidden" name="accion"  value="modificiar">
												<input type="hidden" name="id_lugar" value="'.$datos['id_lugar'].'">
												 <table>
												 	<tr><td>Institucion</td><td><input type="text" value="'.$datos['institucion'].'" name="institucion"></td></tr>
												 	<tr><td>Telefono</td><td><input type="text"  value="'.$datos['telefono'].'" name="telefono"></td></tr>
												 	<tr><td>Domicilio</td><td><input type="text" value="'.$datos['domicilio'].'" name="domicilio"></td></tr>
												 	<tr><td>Encargado</td><td><input type="text" value="'.$datos['encargado'].'" name="encargado"></td></tr>
												 	<tr><td>Estado</td><td><input type="text" value="'.$datos['estado_pais'].'" name="estado"></td></tr>
												 	<tr><td>Municipio</td><td><input type="text" value="'.$datos['municipio'].'" name="municipio"></td></tr>
												 	<tr><td>Notas</td><td><textArea row="10" cols="40" name="notas">'.$datos['notas'].'</textArea></td></tr>
												 </table>
												  <img src="imagenes/lugares/'.$imagenTmp1.'" style="cursor:pointer;position:absolute;top:50px;right:5%;border-radius:4px;border:2px solid grey;width:25%" onclick="$(this).next().next().trigger(\'click\')"/><br/>
												  <input type="file" nombre="archivo" accept=".jpg, .gif, .png" style="display:none;"/>
												 <center><button onclick="$(".subBoton").trigger("click")" permiso="M">Modificar</button></center>
											</form>	
										</div>';
									$cont++;
								
										

									echo'	</td>

									</tr>';
						}

					echo '</table>

						<script>
							$("#Mod").tablePagination({});
							$.expr[":"].Contains = function(x, y, z){
							return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
							};
						</script>

				</div><br>
			</div>
		 </div>';
		if(substr($_SESSION["Permisos_Eneaware"][13],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
		}
		if(substr($_SESSION["Permisos_Eneaware"][13],1,1)=="0"){
			echo "<script>$('#principalInner [permiso=D]').remove()</script>";
		}
		if(substr($_SESSION["Permisos_Eneaware"][13],2,1)=="0"){
			echo "
				<script>
					$('#principalInner form[permiso=M] input').prop('disabled', true);
					$('#principalInner form[permiso=M] select').prop('disabled', true);
					$('#principalInner form[permiso=M] button').remove();
				</script>";
		}
	mysqli_close($conexion);
?>