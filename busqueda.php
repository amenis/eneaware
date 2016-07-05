<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.tablePagination.js"></script>
<?php
session_start();
	if(isset($_SESSION["Usuario_Eneaware"])){
		if($_SESSION["Permisos_Eneaware"][10]!="000"){
			include('conexion.php');
			$accion = $_POST["option"];	

			if($accion=="porAlumno"){

				echo '<table id="activasA" style="width:100%;">';
				
			$alumnos = mysqli_query($conexion, "SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre, matricula,carrera,status,id_alumno FROM Alumnos WHERE nombre LIKE '%".$_POST["mati"]."%' OR apellidoP LIKE '%".$_POST["mati"]."%' OR apellidoM LIKE '%".$_POST["mati"]."%'  OR matricula='".$_POST["mati"]."' ;");
				while($datos = mysqli_fetch_array($alumnos)){

				echo'<tr class="activasA">
						<td>

					<div nombre="'.strtolower($datos["nombre"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
					<b><font color="#191970" weight="bold">'.$datos["matricula"].'</font>, '.$datos["nombre"].'</b>							
					<div id="resPer'.$datos["id_alumno"].'" style="display:none">
						<form destino="resultadoRegistro" action="guardarEncuesta.php" style="display:inline-block">
							<input type="hidden" name="option" value="activar">';

								$apli = $_SESSION["Usuario_Eneaware"];
								$aplicador = "";
								$consulta= mysqli_query($conexion,"SELECT * FROM Usuarios WHERE usuario='".$apli."';");
								$numapli = mysqli_num_rows($consulta);
								if($numapli>0){
									for($x=0;$x<$numapli;$x++){
										$datosapli = mysqli_fetch_array($consulta);			
										$aplicador = $datosapli["nombre"];
									}	
								}
								$nombre_al = $datos["nombre"];
																				
								$pro= mysqli_query($conexion,"SELECT * FROM Encuestas WHERE status=1;");
								$numpro = mysqli_num_rows($pro);
								echo"<select name='periodo' required ><option value='na'>Eliga la Encuesta a aplicar</option>";
								if($numpro>0){
									for($x=0;$x<$numpro;$x++){
										$datospro = mysqli_fetch_array($pro);
										echo"<option value='".$datospro["id_encuesta"]."'>". $datospro["nombre_encuesta"]."</option>";
									}
								}
								echo"</select><hr></hr>";
																				
								echo'<input type="text" name="aplicador" value="'.$aplicador.'" style="display:none"/>
								<input type="text" name="nombre" value="'.$datos["nombre"].'" style="display:none"/>
								<input type="hidden" name="egresado" value="'.$datos["id_alumno"].'"/>
								<input type="hidden" name="carrera" value="'.$datos["carrera"].'"/>
								¿Estas seguro que deseas Habilitar la Encuesta a: <font color="#191970" weight="bold">'.$datos["nombre"].'</font>?
								<button >Si, estoy seguro</button>									
						</form>
						
						<button style="display:inline-block" onclick="$(this).parent().toggle(\'drop\')">No</button>
					
					</div>';
																
					if ($datos["status"]==1) {
						echo'<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#resPer'.$datos["id_alumno"].'\').toggle(\'drop\')">';
					} 
				echo'</div>
				</td>
					</tr>';

				}
				echo '</table>

					<script>
						$("#activasA").tablePagination({});
						$.expr[":"].Contains = function(x, y, z){
						return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
						};
					</script>';

			}

			if($accion=="porGrupo"){

				echo '<table id="activas" style="width:100%;">';
				
				$c=1;
				$alumnos = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE semestre='".$_POST["semestre"]."' AND carrera='".$_POST["carrera"]."' ORDER BY apellidoP,apellidoM ASC ;");
				$numal = mysqli_num_rows($alumnos);
				while($datos = mysqli_fetch_array($alumnos)){

				echo'<tr class="activas">
						<td>
							<div nombre="'.strtolower($datos["nombre"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b><font color="#191970" weight="bold">'.$datos["matricula"].'</font>, '.$datos["apellidoP"].' '.$datos["apellidoM"].' '.$datos["nombre"].'</b>							
							</div>
						</td>
					</tr>';

				$id[$c] = $datos["id_alumno"];	
				$nombre_al[$c] = $datos["nombre"];	
				$c++;

				}

				echo '</table>

					<script>
						$("#activas").tablePagination({});
						$.expr[":"].Contains = function(x, y, z){
						return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
						};
					</script>';

				echo '<br><hr></hr>
				<form destino="resultadoRegistro" action="guardarEncuesta.php" style="display:inline-block">';

				$pro= mysqli_query($conexion,"SELECT * FROM Encuestas WHERE status=1;");
				$numpro = mysqli_num_rows($pro);
				echo"<select name='periodo' required ><option value='na'>Eliga la Encuesta a aplicar</option>";
				if($numpro>0){
					for($x=0;$x<$numpro;$x++){
						$datospro = mysqli_fetch_array($pro);
						echo"<option value='".$datospro["id_encuesta"]."'>". $datospro["nombre_encuesta"]."</option>";
					}
				}
				echo"</select>";

				$apli = $_SESSION["Usuario_Eneaware"];
				$aplicador = "";
				$consulta= mysqli_query($conexion,"SELECT * FROM Usuarios WHERE usuario='".$apli."';");
				$numapli = mysqli_num_rows($consulta);
				if($numapli>0){
					for($x=0;$x<$numapli;$x++){
						$datosapli = mysqli_fetch_array($consulta);			
						$aplicador = $datosapli["nombre"];
					}	
				}

				echo'
						<input type="hidden" name="option" value="activar2">
						<input type="text" name="aplicador" value="'.$aplicador.'" style="display:none"/>
						<input type="text" name="res" value="'.$numal.'" style="display:none"/>';

						for($x=1;$x<=$numal;$x++){
							echo'<input type="text" name="egresado'.$x.'" value="'.$id[$x].'" style="display:none;"/>
								<input type="hidden" name="nombre'.$x.'" value="'.$nombre_al[$x].'"/>';
						}
						if ($_POST["carrera"]=="Lincenciatura en Educacion Preescolar") {
							echo'<input type="hidden" name="carrera" value="Lincenciatura en Educacion Preescolar"/>';
						}else{
							echo'<input type="hidden" name="carrera" value="Lincenciatura en Educacion Primaria"/>';
						}

						echo'&nbsp;&nbsp;¿Estas seguro que deseas Habilitar la Encuesta a este semestre?';
						if ($numal==0) {
							echo'<button disabled >Si, estoy seguro</button>';
						}else{
							echo'<button >Si, estoy seguro</button>';
						}
					echo'</form>&nbsp;<button style="display:inline-block" onclick="$(this).parent().toggle(\'drop\')">No</button>';
					
			}
			if($accion=="bporAlumno"){

				echo '<table id="modAl1" style="width:100%;">';

			$alumnos = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE nombre LIKE '%".$_POST["mati"]."%' OR apellidoP LIKE '%".$_POST["mati"]."%' OR apellidoM LIKE '%".$_POST["mati"]."%'  OR matricula='".$_POST["mati"]."' ;");
				while($datosAl = mysqli_fetch_array($alumnos)){

					if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".png")){
											$imagenTmp1=$datosAl["id_alumno"].'.png';
										}
										else{
											if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".jpg")){
												$imagenTmp1=$datosAl["id_alumno"].'.jpg';
											}
											else{
												if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".gif")){
													$imagenTmp1=$datosAl["id_alumno"].'.gif';
												}
												else {
													if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".svg")){
														$imagenTmp1=$datosAl["id_alumno"].'.svg';
													}
													else {
														$imagenTmp1="disable.gif";
													}
												}
											}
										}
										$fecha= $datosAl["fecha_nacimiento"];
										$edad=CalculaEdad($fecha);

										echo'
										<tr class="modAl1">
											<td>
												<div nombre="'.strtolower($datosAl["nombre"]).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
													<b><font color="#191970" weight="bold">'.$datosAl["matricula"].'</font>, '.$datosAl['apellidoP']." ".$datosAl['apellidoM']." ".$datosAl["nombre"].' </b>
													<img class="edit" src="imagenes/edit.png" permiso="M" style="padding:4px; top:5px; position:absolute;right:3%;" onclick="$(\'#\'+\''.$datosAl["id_alumno"].'\').toggle(\'drop\');">
													<img src="imagenes/bin.png" permiso="D" style="padding:4px; top:5px; position:absolute;right:0;" onclick="$(this).next().toggle(\'drop\');" permiso="D">
													<div style="display:none;">
														<form permiso="D" class="borrar" destino="resultadoRegistro" action="accionesAlumno.php"style="display:inline-block" >
															<input type="hidden" value="borrar" name="accion">
															<input type="hidden" value="'.$datosAl["id_alumno"].'" name="alumno" >									
																<label>Estas Seguro que deseas deshabilitar a este alumno@ '.$datosAl["nombre"].'"</label>
																<button>Si,estoy seguro</button>																		
														</form>
														<button style="display:inline-block" onclick="return false,$(this).parent().toggle(\'drop\')">No</button>	
													</div>
													<form permiso="M"  id="'.$datosAl["id_alumno"].'" destino="resultadoRegistro" action="accionesAlumno.php" method="post" style="display:none" >
														<input type="hidden" name="accion" value="modificar">
														<input type="hidden" name="id" value="'.$datosAl["id_alumno"].'">
														<div>
														<table>

															<tr><td>Apellido Paterno</td><td><input type="text" name="apP" value="'.$datosAl["apellidoP"].'" size="25" required title="Este campo no puede quedar vacio" autofocus></td><td></td></tr>
															<tr><td>Apellido Materno</td><td><input type="text" name="apM" value="'.$datosAl["apellidoM"].'" size="25" required title="Este campo no puede quedar vacio" autofocus></td><td></td></tr></td><td></td></tr>
															<tr><td>Nombre</td><td><input type="text" name="nombre" name="nombre" value="'.$datosAl["nombre"].'" size="25" required title="Este campo no puede quedar vacio" autofocus></td><td></td></tr>
															<tr><td> Matricula</td><td><input type="text" value="'.$datosAl["matricula"].'" size="25" name="matricula" disabled></td><td><td></tr>
															<tr><td> Generacion</td><td><input type="text" value="'.$datosAl["generacion"].'" size="25" name="generacion"></td><td><td></tr>
															<tr><td> Turno</td><td><input type="text" value="'.$datosAl["turno"].'" size="25" name="turno"></td><td><td></tr>';
															if($datosAl["sexo"]=="H"){
																echo'<tr><td>Sexo</td><td> <input type="radio" id="sexRPH" value="H" name="sexo" checked><label for="sexRPH">Hombre</label><br><input type="radio" id="sexRPM" name="sexo" value="M"><label for="sexRPM">Mujer</label></td><td></td></tr>';
															}
															else{
																echo'<tr><td>Sexo</td><td> <input type="radio" id="sexRPH" value="H" name="sexo" ><label for="sexRPH">Hombre</label><br><input type="radio" id="sexRPM" name="sexo" value="M" checked><label for="sexRPM">Mujer</label></td><td></td></tr>';
															}

															echo'<tr><td>Curp</td><td><input type="text" value="'.$datosAl["curp"].'" name="curp" size="25" pattern="[A-Z0-9]{18}" title="Debe de tener una longitud de 18 digitos"></td></td></td></tr>
															<tr><td>Fecha de Nacimiento</td><td><input type="date" name="fechaN" value="'.$datosAl["fecha_nacimiento"].'"></td></tr><tr><td>Edad:</td><td><input type="text" value="'.$edad.'" size="1" readonly/></td></tr>
															<tr><td>Lugar de Nacimiento</td><td><input type="text" name="lg" value="'.$datosAl["lugar_nacimiento"].'"></td><td></td></tr>
															<tr><td>Telefono de Casa</td><td><input type="text" name="telCasa" value="'.$datosAl["tel_casa"].'"></td><td></td></tr>
															<tr><td>Telefono Celular</td><td><input type="text" name="telCel" value="'.$datosAl["tel_celular"].'"></td><td></td></tr>
															<tr><td>Email </td><td><input type="email" value="'.$datosAl["email"].'" name="email" size="30" title="Debe ser un email real"></td><td></td></tr>
															<tr><td>Email ENEA </td><td><input type="email" value="'.$datosAl["email_enea"].'" name="email_enea" size="30"></td><td></td></tr>
															<tr><td>Domicilio</td><td><input type="text" name="dom" value="'.$datosAl["calle_local"].'"></td><td></td></tr>
															<tr><td>Numero Exterior</td><td><input type="text" name="NumExt" value="'.$datosAl["num_ext_local"].'"></td><td></td></tr>
															<tr><td>Numero Interior</td><td><input type="text" name="NumInt" value="'.$datosAl["num_int_local"].'"></td><td></td></tr>
															<tr><td>Colonia</td><td><input type="text" name="colonia" value="'.$datosAl["colonia_local"].'" ></td><td></td></tr>
															<tr><td>Municipio</td><td><input type="text" name="municipio" value="'.$datosAl["municipio_local"].'"></td><td></td></tr>
															<tr><td>Codigo Postal</td><td><input type="text" name="cp" value="'.$datosAl["cp_local"].'"></td><td></td></tr>
															<tr><td>Estado</td>
																<td>
																	<select name="state" id="state'.$datosAl['id_alumno'].'">
																		<option value="Aguascalientes">Aguascalientes</option>
																		<option value="Baja California">Baja California</option>
																		<option value="Baja California Sur">Baja California Sur</option>
																		<option value="Campeche">Campeche</option>
																		<option value="Chiapas">Chiapas</option>
																		<option value="Chihuahua">Chihuahua</option>
																		<option value="Coahuila">Coahuila</option>
																		<option value="Colima">Colima</option>
																		<option value="Distrito Federal">Distrito Federal</option>
																		<option value="Durango">Durango</option>
																		<option value="Estado de México">Estado de México</option>
																		<option value="Guanajuato">Guanajuato</option>
																		<option value="Guerrero">Guerrero</option>
																		<option value="Hidalgo">Hidalgo</option>
																		<option value="Jalisco">Jalisco</option>
																		<option value="Michoacán">Michoacán</option>
																		<option value="Morelos">Morelos</option>
																		<option value="Nayarit">Nayarit</option>
																		<option value="Nuevo León">Nuevo León</option>
																		<option value="Oaxaca">Oaxaca</option>
																		<option value="Puebla">Puebla</option>
																		<option value="Querétaro">Querétaro</option>
																		<option value="Quintana Roo">Quintana Roo</option>
																		<option value="San Luis Potosí">San Luis Potosí</option>
																		<option value="Sinaloa">Sinaloa</option>
																		<option value="Sonora">Sonora</option>
																		<option value="Tabasco">Tabasco</option>
																		<option value="Tamaulipas">Tamaulipas</option>
																		<option value="Tlaxcala">Tlaxcala</option>
																		<option value="Veracruz">Veracruz</option>
																		<option value="Yucatán">Yucatán</option>
																		<option value="Zacatecas">Zacatecas</option>
																	</select>
																	<script>
																		var opciones = $("#state'.$datosAl['id_alumno'].'").find("option");
																		opciones.each(function(){
																			if($(this).val()=="'.$datosAl['estado_local'].'"){
																				$(this).prop("selected",true);
																				return false;
																			}
																		});
																	</script>
																</td><td></td>
															</tr>
															<tr><td>¿Vive Fuera?</td><td>';
															if($datosAl["calle_foranea"]==""){
																echo'<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').hide()" type="radio" id="rFoN" value="N" name="foraneo" checked><label for="rFoN">No</label><br>
																<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').show()" type="radio" id="rFoS" value="S" name="foraneo"><label for="rFoS">Si</label>';											
															}
															else{
																echo'
																<script> 
																	$(\'.\'+\''.$datosAl["id_alumno"].'\').show();
																</script>';
															}
															echo'</td><td></td></tr>	
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td >Domicilio</td><td><input type="text" name="calleF" value="'.$datosAl["calle_foranea"].'" size="30"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Numero Exterior</td><td><input type="text" name="NumExtF" value="'.$datosAl["num_ext_foranea"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td  >Numero Interior</td><td ><input type="text" name="NumIntF"value="'.$datosAl["num_int_foranea"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td >Colonia</td><td ><input type="text" name="coloniaF"value="'.$datosAl["colonia_foranea"].'" ></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Municipio</td><td ><input type="text" name="municipioF" value="'.$datosAl["municipio_foranea"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;" ><td>Codigo Postal</td><td><input type="text" name="cpF" value="'.$datosAl["cp_foranea"].'" ></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"> <td>Estado</td><td><input type="text" name="estadoF" value="'.$datosAl["estado_foranea"].'"></td><td></td></tr>';
															if($datosAl["tutor"]==""){
																echo'<tr><td>¿Tiene tutor?</td><td >
																<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').hide() " type="radio" id="TN" value="N" name="tutor" checked><label for="TN">No</label><br>
																<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').show()" type="radio" name="tutor" id="TS" value="S"><label for="TS">Si</label>';
															}
															else{
																echo'
																<script> 
																	$(\'.\'+\''.$datosAl["id_alumno"].'\').show();
																</script>
																';
															}
															echo'</td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Nombre del Tutor</td><td><input type="text" name="tutor" value="'.$datosAl["tutor"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Domicilio del Tutor</td><td><input type="text" name="domTu" value="'.$datosAl["domicilio_tutor"].'"></td><td></td></tr>
															<tr><td>Nombre del Padre</td><td><input type="text" name="padre" value="'.$datosAl["padre"].'"></td><td></td></tr>
															<tr><td>Domicilio del Padre</td><td><input type="text" name="DomPa" value="'.$datosAl["dom_padre"].'"></td><td></td></tr>
															<tr><td>Nombre del Madre</td><td><input type="text" name="madre" value="'.$datosAl["madre"].'"></td><td></td></tr>
															<tr><td>Domicilio del Madre</td><td><input type="text" name="DomMa" value="'.$datosAl["dom_madre"].'"></td><td></td></tr>
															<tr><td>En caso de emergencia llamar a </td><td><input type="text" name="emerg" value="'.$datosAl["nombre_emergecia"].'"></td><td></td></tr>
															<tr><td>Domicilio de Emergencia</td><td><input type="text" name="domEme" value="'.$datosAl["domicilio_emergencia"].'"></td><td></td></tr>
															<tr><td>Telefono de Emergencia</td><td><input type="text" name="telEme" value="'.$datosAl["tel_emergencia"].'"></td><td></td></tr>
															<tr><td>Tipo de Sangre</td><td><input type="text" name="tipSan" value="'.$datosAl["tipo_sangre"].'"></td><td></td></tr>
															<tr><td>No de Seguro</td><td><input type="text" name="imss" value="'.$datosAl["imss"].'"></td><td></td></tr>
															<tr><td>Bachillerato </td><td><input type="text" name="bachi" value="'.$datosAl["bachillerato"].'"></td><td></td></tr>
															<tr><td>Fecha de Ingreso</td><td><input type="date" name="inside" value="'.$datosAl["fecha_ingreso"].'"></td><td></td></tr>
															<tr>
																<td>Carrera </td>
																<td>
																	<select id="carrera'.$datosAl['id_alumno'].'" name="carrera">
																		<option value="Lincenciatura en Educacion Preescolar">Lincenciatura en Educacion Presscolar</option>
																		<option value="Lincenciatura en Educacion Primaria">Lincenciatura en Educacion Primaria</option>
																	</select>
																	<script>
																		var opciones = $("#carrera'.$datosAl['id_alumno'].'").find("option");
																		opciones.each(function(){
																			if($(this).val()=="'.$datosAl['carrera'].'"){
																				$(this).prop("selected",true);
																				return false;
																			}
																		});
																	</script>
																	
																</td>
																<td></td>
															</tr>
															<tr><td>Semestre Actual</td><td>
															<select id="semestre'.$datosAl['id_alumno'].'" name="semestre">
																<option value="1">1ro</option>
																<option value="2">2do</option>
																<option value="3">3ro</option>
																<option value="4">4to</option>
																<option value="5">5to</option>
																<option value="6">6to</option>
																<option value="7">7mo</option>
																<option value="8">8vo</option>
																<option value="9">Egrasado</option>
																<option value="10">Tutulado</option>
															</select>
															<script>
																		var opciones = $("#semestre'.$datosAl['id_alumno'].'").find("option");
																		opciones.each(function(){
																			if($(this).val()=="'.$datosAl["semestre"].'"){
																				$(this).prop("selected",true);
																				return false;
																			}
																		});
																	</script></td><td></td></tr>';		
															if($datosAl["beca"]=="0"){
																echo '<tr><td>¿Tiene Beca?</td><td><input type="radio" id="rN"  onclick="$(\'#nB'.$datosAl['id_alumno'].'\').hide()" value="0" checked name="beca" ><label for="rN">No</label><br><input type="radio" onclick="$(\'#nB'.$datosAl['id_alumno'].'\').show()" name="beca" id="rS" value="1"><label for="rS">Si</lable></td><td></td></tr>';
															}
															else{
																echo '<tr style="display:none"><td>¿Tiene Beca?</td><td><input type="radio" id="rN"  onclick="$(\'#nB'.$datosAl['id_alumno'].'\').hide()" value="0" checked name="beca" ><label for="rN">No</label><br><input type="radio" onclick="$(\'#nB'.$datosAl['id_alumno'].'\').show()" name="beca" id="rS" value="1"><label for="rS">Si</lable></td><td></td></tr>';
																echo'
																<script>
																	$("#nB'.$datosAl['id_alumno'].'").show();
																</script>
																';
															}
															echo'
															<tr id="nB'.$datosAl['id_alumno'].'" style="display:none"><td>Nombre de la beca</td><td><input type="text" name="nombreBeca" value="'.$datosAl['nombreBeca'].'" /></td><td></td></tr>
															<tr><td>Fecha de Termino</td><td><input type="date" name="term" value="'.$datosAl["fecha_termino"].'"></td><td></td></tr>
															<tr><td>Dictamen de Titulacion</td><td><input type="text" name="dict" value="'.$datosAl["dictamen_titulacion"].'" size="50 "></td><td></td></tr>';
															
															echo'<tr><td>Notas</td><td><textarea rows="4" cols="40" name="notas">'.$datosAl["notas"].'</textarea></td><td></td></tr>
															
														
														</table>
														</div>
														<img src="imagenes/alumnos/'.$imagenTmp1.'" style="position:absolute;top:50px;right:85px;width:25%;border:2px solid grey;border-radius:5px" onclick="$(this).next().next().trigger(\'click\')"/><br/>
														<input type="file" nombre="archivo" accept=".jpg, .gif, .png" style="display:none;"/>
														
														<center><button onclick="$(".subBoton").trigger("click")" permiso="M">EDITAR</button></center>									
													</form>
												</div>
												</td>
					</tr>';

				}
				echo '</table>

					<script>
						$("#modAl1").tablePagination({});
						$.expr[":"].Contains = function(x, y, z){
						return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
						};
					</script>';

			}
			if($accion=="bporGrupo"){

				echo '<table id="modAl1" style="width:100%;">';

				$alumnos = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE semestre='".$_POST["semestre"]."' AND carrera='".$_POST["carrera"]."' ORDER BY apellidoP,apellidoM ASC ;");
				$numal = mysqli_num_rows($alumnos);
				while($datosAl = mysqli_fetch_array($alumnos)){

										if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".png")){
											$imagenTmp1=$datosAl["id_alumno"].'.png';
										}
										else{
											if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".jpg")){
												$imagenTmp1=$datosAl["id_alumno"].'.jpg';
											}
											else{
												if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".gif")){
													$imagenTmp1=$datosAl["id_alumno"].'.gif';
												}
												else {
													if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".svg")){
														$imagenTmp1=$datosAl["id_alumno"].'.svg';
													}
													else {
														$imagenTmp1="disable.gif";
													}
												}
											}
										}
										$fecha= $datosAl["fecha_nacimiento"];
										$edad=CalculaEdad($fecha);

										echo'
										<tr class="modAl1">
											<td>
												<div nombre="'.strtolower($datosAl["nombre"]).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
													<b><font color="#191970" weight="bold">'.$datosAl["matricula"].'</font>, '.$datosAl['apellidoP']." ".$datosAl['apellidoM']." ".$datosAl["nombre"].' </b>
													<img class="edit" src="imagenes/edit.png" permiso="M" style="padding:4px; top:5px; position:absolute;right:3%;" onclick="$(\'#\'+\''.$datosAl["id_alumno"].'B\').toggle(\'drop\');">
													<img src="imagenes/bin.png" permiso="D" style="padding:4px; top:5px; position:absolute;right:0;" onclick="$(this).next().toggle(\'drop\');" permiso="D">
													<div style="display:none;">
														<form permiso="D" class="borrar" destino="resultadoRegistro" action="accionesAlumno.php"style="display:inline-block" >
															<input type="hidden" value="borrar" name="accion">
															<input type="hidden" value="'.$datosAl["id_alumno"].'" name="alumno" >									
																<label>Estas Seguro que deseas deshabilitar a este alumno@ '.$datosAl["nombre"].'"</label>
																<button>Si,estoy seguro</button>																		
														</form>
														<button style="display:inline-block" onclick="return false,$(this).parent().toggle(\'drop\')">No</button>	
													</div>
													<form permiso="M"  id="'.$datosAl["id_alumno"].'B" destino="resultadoRegistro" action="accionesAlumno.php" method="post" style="display:none" >
														<input type="hidden" name="accion" value="modificar">
														<input type="hidden" name="id" value="'.$datosAl["id_alumno"].'">
														<div>
														<table>

															<tr><td>Apellido Paterno</td><td><input type="text" name="apP" value="'.$datosAl["apellidoP"].'" size="25" required title="Este campo no puede quedar vacio" autofocus></td><td></td></tr>
															<tr><td>Apellido Materno</td><td><input type="text" name="apM" value="'.$datosAl["apellidoM"].'" size="25" required title="Este campo no puede quedar vacio" autofocus></td><td></td></tr></td><td></td></tr>
															<tr><td>Nombre</td><td><input type="text" name="nombre" name="nombre" value="'.$datosAl["nombre"].'" size="25" required title="Este campo no puede quedar vacio" autofocus></td><td></td></tr>
															<tr><td> Matricula</td><td><input type="text" value="'.$datosAl["matricula"].'" size="25" name="matricula" disabled></td><td><td></tr>
															<tr><td> Generacion</td><td><input type="text" value="'.$datosAl["generacion"].'" size="25" name="generacion"></td><td><td></tr>
															<tr><td> Turno</td><td><input type="text" value="'.$datosAl["turno"].'" size="25" name="turno"></td><td><td></tr>';
															if($datosAl["sexo"]=="H"){
																echo'<tr><td>Sexo</td><td> <input type="radio" id="sexRPH" value="H" name="sexo" checked><label for="sexRPH">Hombre</label><br><input type="radio" id="sexRPM" name="sexo" value="M"><label for="sexRPM">Mujer</label></td><td></td></tr>';
															}
															else{
																echo'<tr><td>Sexo</td><td> <input type="radio" id="sexRPH" value="H" name="sexo" ><label for="sexRPH">Hombre</label><br><input type="radio" id="sexRPM" name="sexo" value="M" checked><label for="sexRPM">Mujer</label></td><td></td></tr>';
															}

															echo'<tr><td>Curp</td><td><input type="text" value="'.$datosAl["curp"].'" name="curp" size="25" pattern="[A-Z0-9]{18}" title="Debe de tener una longitud de 18 digitos"></td></td></td></tr>
															<tr><td>Fecha de Nacimiento</td><td><input type="date" name="fechaN" value="'.$datosAl["fecha_nacimiento"].'"></td></tr><tr><td>Edad:</td><td><input type="text" value="'.$edad.'" size="1" readonly/></td></tr>
															<tr><td>Lugar de Nacimiento</td><td><input type="text" name="lg" value="'.$datosAl["lugar_nacimiento"].'"></td><td></td></tr>
															<tr><td>Telefono de Casa</td><td><input type="text" name="telCasa" value="'.$datosAl["tel_casa"].'"></td><td></td></tr>
															<tr><td>Telefono Celular</td><td><input type="text" name="telCel" value="'.$datosAl["tel_celular"].'"></td><td></td></tr>
															<tr><td>Email </td><td><input type="email" value="'.$datosAl["email"].'" name="email" size="30" title="Debe ser un email real"></td><td></td></tr>
															<tr><td>Email ENEA </td><td><input type="email" value="'.$datosAl["email_enea"].'" name="email_enea" size="30"></td><td></td></tr>
															<tr><td>Domicilio</td><td><input type="text" name="dom" value="'.$datosAl["calle_local"].'"></td><td></td></tr>
															<tr><td>Numero Exterior</td><td><input type="text" name="NumExt" value="'.$datosAl["num_ext_local"].'"></td><td></td></tr>
															<tr><td>Numero Interior</td><td><input type="text" name="NumInt" value="'.$datosAl["num_int_local"].'"></td><td></td></tr>
															<tr><td>Colonia</td><td><input type="text" name="colonia" value="'.$datosAl["colonia_local"].'" ></td><td></td></tr>
															<tr><td>Municipio</td><td><input type="text" name="municipio" value="'.$datosAl["municipio_local"].'"></td><td></td></tr>
															<tr><td>Codigo Postal</td><td><input type="text" name="cp" value="'.$datosAl["cp_local"].'"></td><td></td></tr>
															<tr><td>Estado</td>
																<td>
																	<select name="state" id="state'.$datosAl['id_alumno'].'">
																		<option value="Aguascalientes">Aguascalientes</option>
																		<option value="Baja California">Baja California</option>
																		<option value="Baja California Sur">Baja California Sur</option>
																		<option value="Campeche">Campeche</option>
																		<option value="Chiapas">Chiapas</option>
																		<option value="Chihuahua">Chihuahua</option>
																		<option value="Coahuila">Coahuila</option>
																		<option value="Colima">Colima</option>
																		<option value="Distrito Federal">Distrito Federal</option>
																		<option value="Durango">Durango</option>
																		<option value="Estado de México">Estado de México</option>
																		<option value="Guanajuato">Guanajuato</option>
																		<option value="Guerrero">Guerrero</option>
																		<option value="Hidalgo">Hidalgo</option>
																		<option value="Jalisco">Jalisco</option>
																		<option value="Michoacán">Michoacán</option>
																		<option value="Morelos">Morelos</option>
																		<option value="Nayarit">Nayarit</option>
																		<option value="Nuevo León">Nuevo León</option>
																		<option value="Oaxaca">Oaxaca</option>
																		<option value="Puebla">Puebla</option>
																		<option value="Querétaro">Querétaro</option>
																		<option value="Quintana Roo">Quintana Roo</option>
																		<option value="San Luis Potosí">San Luis Potosí</option>
																		<option value="Sinaloa">Sinaloa</option>
																		<option value="Sonora">Sonora</option>
																		<option value="Tabasco">Tabasco</option>
																		<option value="Tamaulipas">Tamaulipas</option>
																		<option value="Tlaxcala">Tlaxcala</option>
																		<option value="Veracruz">Veracruz</option>
																		<option value="Yucatán">Yucatán</option>
																		<option value="Zacatecas">Zacatecas</option>
																	</select>
																	<script>
																		var opciones = $("#state'.$datosAl['id_alumno'].'").find("option");
																		opciones.each(function(){
																			if($(this).val()=="'.$datosAl['estado_local'].'"){
																				$(this).prop("selected",true);
																				return false;
																			}
																		});
																	</script>
																</td><td></td>
															</tr>
															<tr><td>¿Vive Fuera?</td><td>';
															if($datosAl["calle_foranea"]==""){
																echo'<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').hide()" type="radio" id="rFoN" value="N" name="foraneo" checked><label for="rFoN">No</label><br>
																<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').show()" type="radio" id="rFoS" value="S" name="foraneo"><label for="rFoS">Si</label>';											
															}
															else{
																echo'
																<script> 
																	$(\'.\'+\''.$datosAl["id_alumno"].'\').show();
																</script>';
															}
															echo'</td><td></td></tr>	
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td >Domicilio</td><td><input type="text" name="calleF" value="'.$datosAl["calle_foranea"].'" size="30"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Numero Exterior</td><td><input type="text" name="NumExtF" value="'.$datosAl["num_ext_foranea"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td  >Numero Interior</td><td ><input type="text" name="NumIntF"value="'.$datosAl["num_int_foranea"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td >Colonia</td><td ><input type="text" name="coloniaF"value="'.$datosAl["colonia_foranea"].'" ></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Municipio</td><td ><input type="text" name="municipioF" value="'.$datosAl["municipio_foranea"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;" ><td>Codigo Postal</td><td><input type="text" name="cpF" value="'.$datosAl["cp_foranea"].'" ></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"> <td>Estado</td><td><input type="text" name="estadoF" value="'.$datosAl["estado_foranea"].'"></td><td></td></tr>';
															if($datosAl["tutor"]==""){
																echo'<tr><td>¿Tiene tutor?</td><td >
																<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').hide() " type="radio" id="TN" value="N" name="tutor" checked><label for="TN">No</label><br>
																<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').show()" type="radio" name="tutor" id="TS" value="S"><label for="TS">Si</label>';
															}
															else{
																echo'
																<script> 
																	$(\'.\'+\''.$datosAl["id_alumno"].'\').show();
																</script>
																';
															}
															echo'</td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Nombre del Tutor</td><td><input type="text" name="tutor" value="'.$datosAl["tutor"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Domicilio del Tutor</td><td><input type="text" name="domTu" value="'.$datosAl["domicilio_tutor"].'"></td><td></td></tr>
															<tr><td>Nombre del Padre</td><td><input type="text" name="padre" value="'.$datosAl["padre"].'"></td><td></td></tr>
															<tr><td>Domicilio del Padre</td><td><input type="text" name="DomPa" value="'.$datosAl["dom_padre"].'"></td><td></td></tr>
															<tr><td>Nombre del Madre</td><td><input type="text" name="madre" value="'.$datosAl["madre"].'"></td><td></td></tr>
															<tr><td>Domicilio del Madre</td><td><input type="text" name="DomMa" value="'.$datosAl["dom_madre"].'"></td><td></td></tr>
															<tr><td>En caso de emergencia llamar a </td><td><input type="text" name="emerg" value="'.$datosAl["nombre_emergecia"].'"></td><td></td></tr>
															<tr><td>Domicilio de Emergencia</td><td><input type="text" name="domEme" value="'.$datosAl["domicilio_emergencia"].'"></td><td></td></tr>
															<tr><td>Telefono de Emergencia</td><td><input type="text" name="telEme" value="'.$datosAl["tel_emergencia"].'"></td><td></td></tr>
															<tr><td>Tipo de Sangre</td><td><input type="text" name="tipSan" value="'.$datosAl["tipo_sangre"].'"></td><td></td></tr>
															<tr><td>No de Seguro</td><td><input type="text" name="imss" value="'.$datosAl["imss"].'"></td><td></td></tr>
															<tr><td>Bachillerato </td><td><input type="text" name="bachi" value="'.$datosAl["bachillerato"].'"></td><td></td></tr>
															<tr><td>Fecha de Ingreso</td><td><input type="date" name="inside" value="'.$datosAl["fecha_ingreso"].'"></td><td></td></tr>
															<tr>
																<td>Carrera </td>
																<td>
																	<select id="carrera'.$datosAl['id_alumno'].'" name="carrera">
																		<option value="Lincenciatura en Educacion Preescolar">Lincenciatura en Educacion Presscolar</option>
																		<option value="Lincenciatura en Educacion Primaria">Lincenciatura en Educacion Primaria</option>
																	</select>
																	<script>
																		var opciones = $("#carrera'.$datosAl['id_alumno'].'").find("option");
																		opciones.each(function(){
																			if($(this).val()=="'.$datosAl['carrera'].'"){
																				$(this).prop("selected",true);
																				return false;
																			}
																		});
																	</script>
																	
																</td>
																<td></td>
															</tr>
															<tr><td>Semestre Actual</td><td>
															<select id="semestre'.$datosAl['id_alumno'].'" name="semestre">
																<option value="1">1ro</option>
																<option value="2">2do</option>
																<option value="3">3ro</option>
																<option value="4">4to</option>
																<option value="5">5to</option>
																<option value="6">6to</option>
																<option value="7">7mo</option>
																<option value="8">8vo</option>
																<option value="9">Egrasado</option>
																<option value="10">Tutulado</option>
															</select>
															<script>
																		var opciones = $("#semestre'.$datosAl['id_alumno'].'").find("option");
																		opciones.each(function(){
																			if($(this).val()=="'.$datosAl["semestre"].'"){
																				$(this).prop("selected",true);
																				return false;
																			}
																		});
																	</script></td><td></td></tr>';		
															if($datosAl["beca"]=="0"){
																echo '<tr><td>¿Tiene Beca?</td><td><input type="radio" id="rN"  onclick="$(\'#nB'.$datosAl['id_alumno'].'\').hide()" value="0" checked name="beca" ><label for="rN">No</label><br><input type="radio" onclick="$(\'#nB'.$datosAl['id_alumno'].'\').show()" name="beca" id="rS" value="1"><label for="rS">Si</lable></td><td></td></tr>';
															}
															else{
																echo '<tr style="display:none"><td>¿Tiene Beca?</td><td><input type="radio" id="rN"  onclick="$(\'#nB'.$datosAl['id_alumno'].'\').hide()" value="0" checked name="beca" ><label for="rN">No</label><br><input type="radio" onclick="$(\'#nB'.$datosAl['id_alumno'].'\').show()" name="beca" id="rS" value="1"><label for="rS">Si</lable></td><td></td></tr>';
																echo'
																<script>
																	$("#nB'.$datosAl['id_alumno'].'").show();
																</script>
																';
															}
															echo'
															<tr id="nB'.$datosAl['id_alumno'].'" style="display:none"><td>Nombre de la beca</td><td><input type="text" name="nombreBeca" value="'.$datosAl['nombreBeca'].'" /></td><td></td></tr>
															<tr><td>Fecha de Termino</td><td><input type="date" name="term" value="'.$datosAl["fecha_termino"].'"></td><td></td></tr>
															<tr><td>Dictamen de Titulacion</td><td><input type="text" name="dict" value="'.$datosAl["dictamen_titulacion"].'" size="50 "></td><td></td></tr>';
															
															echo'<tr><td>Notas</td><td><textarea rows="4" cols="40" name="notas">'.$datosAl["notas"].'</textarea></td><td></td></tr>
															
														</table>
														</div>
														<img src="imagenes/alumnos/'.$imagenTmp1.'" style="position:absolute;top:50px;right:85px;width:25%;border:2px solid grey;border-radius:5px" onclick="$(this).next().next().trigger(\'click\')"/><br/>
														<input type="file" nombre="archivo" accept=".jpg, .gif, .png" style="display:none;"/>
														<center><button onclick="$(".subBoton").trigger("click")" permiso="M">EDITAR</button></center>									
													</form>
												</div>
													</td>
										</tr>';
			
				}

				echo '</table>

					<script>
						$("#modAl1").tablePagination({});
						$.expr[":"].Contains = function(x, y, z){
						return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
						};
					</script>';

			}
			if($accion=="ver"){

				echo'<div id="dialog-message" title="Actualizar datos a '.$_POST["nombre"].' " >';

					$alumnos = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno=".$_POST["id"]." ;");
				$numal = mysqli_num_rows($alumnos);
				while($datosAl = mysqli_fetch_array($alumnos)){

										if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".png")){
											$imagenTmp1=$datosAl["id_alumno"].'.png';
										}
										else{
											if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".jpg")){
												$imagenTmp1=$datosAl["id_alumno"].'.jpg';
											}
											else{
												if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".gif")){
													$imagenTmp1=$datosAl["id_alumno"].'.gif';
												}
												else {
													if(file_exists("imagenes/alumnos/".$datosAl["id_alumno"].".svg")){
														$imagenTmp1=$datosAl["id_alumno"].'.svg';
													}
													else {
														$imagenTmp1="disable.gif";
													}
												}
											}
										}
										$fecha= $datosAl["fecha_nacimiento"];
										$edad=CalculaEdad($fecha);
										$id=$datosAl["id_alumno"]."B";

										echo'
										<form permiso="M"  id="'.$datosAl["id_alumno"].'B" destino="reinscripciones" action="accionesAlumno.php" method="post"  >
														<input type="hidden" name="accion" value="modificarAluRein">
														<input type="hidden" name="id" value="'.$datosAl["id_alumno"].'">
														<input type="hidden" name="matricula" value="'.$datosAl["matricula"].'">
														
														<div>
														<table>
															<tr><td>Ciclo de Reinscripcion:</td>
															<td><select  name="tipo_reins">
																<option value="1">Ciclo A: Agosto-Enero</option>
																<option value="2">Ciclo B: Febrero-Julio</option>
															</select></td></tr>
															<tr><td colspan="2"><hr></hr></td></tr>
															<tr><td>Apellido Paterno</td><td><input type="text" name="apP" value="'.$datosAl["apellidoP"].'" size="25" required  ></td><td></td></tr>
															<tr><td>Apellido Materno</td><td><input type="text" name="apM" value="'.$datosAl["apellidoM"].'" size="25" required title="Este campo no puede quedar vacio" ></td><td></td></tr></td><td></td></tr>
															<tr><td>Nombre</td><td><input type="text" name="nombre" name="nombre" value="'.$datosAl["nombre"].'" size="25" required title="Este campo no puede quedar vacio" ></td><td></td></tr>
															<tr><td> Matricula</td><td><input type="text" value="'.$datosAl["matricula"].'" size="25" name="matricula" disabled></td><td><td></tr>
															<tr><td> Generacion</td><td><input type="text" value="'.$datosAl["generacion"].'" size="25" name="generacion"></td><td><td></tr>
															<tr><td> Turno</td><td><input type="text" value="'.$datosAl["turno"].'" size="25" name="turno"></td><td><td></tr>';
															if($datosAl["sexo"]=="H"){
																echo'<tr><td>Sexo</td><td> <input type="radio" id="sexRPH" value="H" name="sexo" checked><label for="sexRPH">Hombre</label><br><input type="radio" id="sexRPM" name="sexo" value="M"><label for="sexRPM">Mujer</label></td><td></td></tr>';
															}
															else{
																echo'<tr><td>Sexo</td><td> <input type="radio" id="sexRPH" value="H" name="sexo" ><label for="sexRPH">Hombre</label><br><input type="radio" id="sexRPM" name="sexo" value="M" checked><label for="sexRPM">Mujer</label></td><td></td></tr>';
															}

															echo'<tr><td>Curp</td><td><input type="text" value="'.$datosAl["curp"].'" name="curp" size="25" pattern="[A-Z0-9]{18}" title="Debe de tener una longitud de 18 digitos"></td></td></td></tr>
															<tr><td>Fecha de Nacimiento</td><td><input type="date" name="fechaN" value="'.$datosAl["fecha_nacimiento"].'"></td></tr><tr><td>Edad:</td><td><input type="text" value="'.$edad.'" size="1" readonly/></td></tr>
															<tr><td>Lugar de Nacimiento</td><td><input type="text" name="lg" value="'.$datosAl["lugar_nacimiento"].'"></td><td></td></tr>
															<tr><td>Telefono de Casa</td><td><input type="text" name="telCasa" value="'.$datosAl["tel_casa"].'"></td><td></td></tr>
															<tr><td>Telefono Celular</td><td><input type="text" name="telCel" value="'.$datosAl["tel_celular"].'"></td><td></td></tr>
															<tr><td>Email </td><td><input type="email" value="'.$datosAl["email"].'" name="email" size="30" title="Debe ser un email real"></td><td></td></tr>
															<tr><td>Email ENEA </td><td><input type="email" value="'.$datosAl["email_enea"].'" name="email_enea" size="30"></td><td></td></tr>
															<tr><td>Domicilio</td><td><input type="text" name="dom" value="'.$datosAl["calle_local"].'"></td><td></td></tr>
															<tr><td>Numero Exterior</td><td><input type="text" name="NumExt" value="'.$datosAl["num_ext_local"].'"></td><td></td></tr>
															<tr><td>Numero Interior</td><td><input type="text" name="NumInt" value="'.$datosAl["num_int_local"].'"></td><td></td></tr>
															<tr><td>Colonia</td><td><input type="text" name="colonia" value="'.$datosAl["colonia_local"].'" ></td><td></td></tr>
															<tr><td>Municipio</td><td><input type="text" name="municipio" value="'.$datosAl["municipio_local"].'"></td><td></td></tr>
															<tr><td>Codigo Postal</td><td><input type="text" name="cp" value="'.$datosAl["cp_local"].'"></td><td></td></tr>
															<tr><td>Estado</td>
																<td>
																	<select name="state" id="state'.$datosAl['id_alumno'].'">
																		<option value="Aguascalientes">Aguascalientes</option>
																		<option value="Baja California">Baja California</option>
																		<option value="Baja California Sur">Baja California Sur</option>
																		<option value="Campeche">Campeche</option>
																		<option value="Chiapas">Chiapas</option>
																		<option value="Chihuahua">Chihuahua</option>
																		<option value="Coahuila">Coahuila</option>
																		<option value="Colima">Colima</option>
																		<option value="Distrito Federal">Distrito Federal</option>
																		<option value="Durango">Durango</option>
																		<option value="Estado de México">Estado de México</option>
																		<option value="Guanajuato">Guanajuato</option>
																		<option value="Guerrero">Guerrero</option>
																		<option value="Hidalgo">Hidalgo</option>
																		<option value="Jalisco">Jalisco</option>
																		<option value="Michoacán">Michoacán</option>
																		<option value="Morelos">Morelos</option>
																		<option value="Nayarit">Nayarit</option>
																		<option value="Nuevo León">Nuevo León</option>
																		<option value="Oaxaca">Oaxaca</option>
																		<option value="Puebla">Puebla</option>
																		<option value="Querétaro">Querétaro</option>
																		<option value="Quintana Roo">Quintana Roo</option>
																		<option value="San Luis Potosí">San Luis Potosí</option>
																		<option value="Sinaloa">Sinaloa</option>
																		<option value="Sonora">Sonora</option>
																		<option value="Tabasco">Tabasco</option>
																		<option value="Tamaulipas">Tamaulipas</option>
																		<option value="Tlaxcala">Tlaxcala</option>
																		<option value="Veracruz">Veracruz</option>
																		<option value="Yucatán">Yucatán</option>
																		<option value="Zacatecas">Zacatecas</option>
																	</select>
																	<script>
																		var opciones = $("#state'.$datosAl['id_alumno'].'").find("option");
																		opciones.each(function(){
																			if($(this).val()=="'.$datosAl['estado_local'].'"){
																				$(this).prop("selected",true);
																				return false;
																			}
																		});
																	</script>
																</td><td></td>
															</tr>
															<tr><td>¿Vive Fuera?</td><td>';
															if($datosAl["calle_foranea"]==""){
																echo'<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').hide()" type="radio" id="rFoN" value="N" name="foraneo" checked><label for="rFoN">No</label><br>
																<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').show()" type="radio" id="rFoS" value="S" name="foraneo"><label for="rFoS">Si</label>';											
															}
															else{
																echo'
																<script> 
																	$(\'.\'+\''.$datosAl["id_alumno"].'\').show();
																</script>';
															}
															echo'</td><td></td></tr>	
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td >Domicilio</td><td><input type="text" name="calleF" value="'.$datosAl["calle_foranea"].'" size="30"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Numero Exterior</td><td><input type="text" name="NumExtF" value="'.$datosAl["num_ext_foranea"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td  >Numero Interior</td><td ><input type="text" name="NumIntF"value="'.$datosAl["num_int_foranea"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td >Colonia</td><td ><input type="text" name="coloniaF"value="'.$datosAl["colonia_foranea"].'" ></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Municipio</td><td ><input type="text" name="municipioF" value="'.$datosAl["municipio_foranea"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;" ><td>Codigo Postal</td><td><input type="text" name="cpF" value="'.$datosAl["cp_foranea"].'" ></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"> <td>Estado</td><td><input type="text" name="estadoF" value="'.$datosAl["estado_foranea"].'"></td><td></td></tr>';
															if($datosAl["tutor"]==""){
																echo'<tr><td>¿Tiene tutor?</td><td >
																<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').hide() " type="radio" id="TN" value="N" name="tutor" checked><label for="TN">No</label><br>
																<input onclick="$(\'.\'+\''.$datosAl["id_alumno"].'\').show()" type="radio" name="tutor" id="TS" value="S"><label for="TS">Si</label>';
															}
															else{
																echo'
																<script> 
																	$(\'.\'+\''.$datosAl["id_alumno"].'\').show();
																</script>
																';
															}
															echo'</td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Nombre del Tutor</td><td><input type="text" name="tutor" value="'.$datosAl["tutor"].'"></td><td></td></tr>
															<tr class="'.$datosAl["id_alumno"].'" style="display:none;"><td>Domicilio del Tutor</td><td><input type="text" name="domTu" value="'.$datosAl["domicilio_tutor"].'"></td><td></td></tr>
															<tr><td>Nombre del Padre</td><td><input type="text" name="padre" value="'.$datosAl["padre"].'"></td><td></td></tr>
															<tr><td>Domicilio del Padre</td><td><input type="text" name="DomPa" value="'.$datosAl["dom_padre"].'"></td><td></td></tr>
															<tr><td>Nombre del Madre</td><td><input type="text" name="madre" value="'.$datosAl["madre"].'"></td><td></td></tr>
															<tr><td>Domicilio del Madre</td><td><input type="text" name="DomMa" value="'.$datosAl["dom_madre"].'"></td><td></td></tr>
															<tr><td>En caso de emergencia llamar a </td><td><input type="text" name="emerg" value="'.$datosAl["nombre_emergecia"].'"></td><td></td></tr>
															<tr><td>Domicilio de Emergencia</td><td><input type="text" name="domEme" value="'.$datosAl["domicilio_emergencia"].'"></td><td></td></tr>
															<tr><td>Telefono de Emergencia</td><td><input type="text" name="telEme" value="'.$datosAl["tel_emergencia"].'"></td><td></td></tr>
															<tr><td>Tipo de Sangre</td><td><input type="text" name="tipSan" value="'.$datosAl["tipo_sangre"].'"></td><td></td></tr>
															<tr><td>No de Seguro</td><td><input type="text" name="imss" value="'.$datosAl["imss"].'"></td><td></td></tr>
															<tr><td>Bachillerato </td><td><input type="text" name="bachi" value="'.$datosAl["bachillerato"].'" disabled></td><td></td></tr>
															<tr><td>Fecha de Ingreso</td><td><input type="date" name="inside" value="'.$datosAl["fecha_ingreso"].'" disabled></td><td></td></tr>
															<tr>
																<td>Carrera </td>
																<td>
																	<select id="carrera'.$datosAl['id_alumno'].'" name="carrera" disabled>
																		<option value="Lincenciatura en Educacion Preescolar">Lincenciatura en Educacion Presscolar</option>
																		<option value="Lincenciatura en Educacion Primaria">Lincenciatura en Educacion Primaria</option>
																	</select>
																	<script>
																		var opciones = $("#carrera'.$datosAl['id_alumno'].'").find("option");
																		opciones.each(function(){
																			if($(this).val()=="'.$datosAl['carrera'].'"){
																				$(this).prop("selected",true);
																				return false;
																			}
																		});
																	</script>
																	
																</td>
																<td></td>
															</tr>';		
															if($datosAl["beca"]=="0"){
																echo '<tr><td>¿Tiene Beca?</td><td><input type="radio" id="rN"  onclick="$(\'#nB'.$datosAl['id_alumno'].'\').hide()" value="0" checked name="beca" ><label for="rN">No</label><br><input type="radio" onclick="$(\'#nB'.$datosAl['id_alumno'].'\').show()" name="beca" id="rS" value="1"><label for="rS">Si</lable></td><td></td></tr>';
															}
															else{
																echo '<tr style="display:none"><td>¿Tiene Beca?</td><td><input type="radio" id="rN"  onclick="$(\'#nB'.$datosAl['id_alumno'].'\').hide()" value="0" checked name="beca" ><label for="rN">No</label><br><input type="radio" onclick="$(\'#nB'.$datosAl['id_alumno'].'\').show()" name="beca" id="rS" value="1"><label for="rS">Si</lable></td><td></td></tr>';
																echo'
																<script>
																	$("#nB'.$datosAl['id_alumno'].'").show();
																</script>
																';
															}
															echo'
															<tr id="nB'.$datosAl['id_alumno'].'" style="display:none"><td>Nombre de la beca</td><td><input type="text" name="nombreBeca" value="'.$datosAl['nombreBeca'].'" /></td><td></td></tr>
															
															<tr><td>Notas</td><td><textarea rows="4" cols="40" name="notas">'.$datosAl["notas"].'</textarea></td><td></td></tr>
															
														</table>
														<img src="imagenes/alumnos/'.$imagenTmp1.'" style="position:absolute;top:50px;right:85px;width:25%;border:2px solid grey;border-radius:5px" onclick="$(this).next().next().trigger(\'click\')"/><br/>
														<center><button id="btnce">Actualizar</button></center>									
													</form>';
				}
					

					echo'</div>
							
						<script>
								$(function() {
								    $( "#dialog-message" ).dialog({
									    modal: true,
									    width:"80%",
									    height:600
									});
								});
						</script>';
			}
			
			
		}
		if($_SESSION["Permisos_Eneaware"][11]!="000"){
			include('conexion.php');
			$accion = $_POST["option"];	
			if($accion=="contra"){
				echo '<table id="Contra" style="width:100%;">';
				
				$alumnos = mysqli_query($conexion, "SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre, matricula,carrera,status,id_alumno,curp FROM Alumnos WHERE nombre LIKE '%".$_POST["mati"]."%' OR apellidoP LIKE '%".$_POST["mati"]."%' OR apellidoM LIKE '%".$_POST["mati"]."%'  OR matricula='".$_POST["mati"]."' ;");
				while($datos = mysqli_fetch_array($alumnos)){
					echo'<tr class="activasA">
						<td>

						<div nombre="'.strtolower($datos["nombre"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
						<b><font color="#191970" weight="bold">'.$datos["matricula"].'</font>, '.$datos["nombre"].'</b>							
						<div id="resPer'.$datos["id_alumno"].'" style="display:none">
							<form destino="resultadoRegistro" action="accionesSAI.php" style="display:inline-block">
								<input type="hidden" name="option" value="recetear">
								<input type="hidden" name="cu" value="'.$datos["curp"].'"/>
								<input type="hidden" name="id" value="'.$datos["id_alumno"].'"/>
								<br>¿Estas seguro que deseas recetear la contraseña a: <font color="#191970" weight="bold">'.$datos["nombre"].'</font>?
								<button >Si, estoy seguro</button>									
							</form>
							<button style="display:inline-block" onclick="$(this).parent().toggle(\'drop\')">No</button>
														
						</div>';
																
						if ($datos["status"]==1) {
							echo'<img src="imagenes/repeat.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#resPer'.$datos["id_alumno"].'\').toggle(\'drop\')">';
						} else {}


				echo'</div>
				</td>
					</tr>';

				}
				echo '</table>

					<script>
						$("#Contra").tablePagination({});
						$.expr[":"].Contains = function(x, y, z){
						return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
						};
					</script>';
			}
			if($accion=="AsigDoceP"){

				echo '

					<form destino="resultado" method="post" action="segi.php" style="display:inline-block">
						<input type="hidden" name="option" value="AsigDoceM">
						
						<div id="resultado"></div>
						<button>Seguiente</button><br>
					</form>

				';

			}

			
		}

	}	

	function CalculaEdad( $fecha ) {
    	list($Y,$m,$d) = explode("-",$fecha);
    	return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}
?>

