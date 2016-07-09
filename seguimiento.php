
<script src="js/jquery.tablePagination.js" ></script>
<style>
	#Mod {
	    border-collapse: collapse;
	    width: 100%;
	}

	#Mod th, #Mod td {
	    text-align: left;
	    padding: 8px;
	}

	#Mod tr:nth-child(odd){background-color: #D9D9D9}

	#Mod th {
	    background: -webkit-linear-gradient(top, rgba(206,219,233,1) 0%,rgba(170,197,222,1) 0%,rgba(58,139,194,1) 50%,rgba(97,153,199,1) 50%,rgba(58,132,195,1) 50%,rgba(38,85,139,1) 100%);
	    color: white;
	    text-align: center;
	}

	#Mod tr:hover {background-color: #00b7ea}

</style>
<?php
session_start();
include ('conexion.php');
echo'
	<div id="gral" style="overflow:auto;height:100%">
		<h1>Seguimiento Academico <font color="#191970" weight="bold">Institucional</font> ( SA<font color="#191970" weight="bold">I</font> )</h1>
			
		<button class="tab seleccionado" style="border-bottom:none;" mostrar="Registro" >General</button>
		<button class="tab " style="border-bottom:none;" mostrar="Agsi_mati">Reportes SAI</button>
		<button class="tab " style="border-bottom:none;" mostrar="Sai" permiso="A">Panel de Control</button>';
			
	   echo'<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">

				<div id="Registro" class="tabCont">
					<h2>General</h2>
				
						
				</div>	

				<div id="Agsi_mati" class="tabCont" style="display:none">
					<h2>Reportes SAI</h2>

					<div nombre="KA" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Generar Kardez</b>						
							<div id="KA" style="display:none">
								<hr></hr>
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#KA\').toggle(\'drop\')">
					</div>

					<div nombre="COS" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Generar Constancia de Estudios</b>						
							<div id="COS" style="display:none">
								<hr></hr>

								<form destino="gral" action="constancia.php" style="display:inline-block">
									<input type="hidden" name="option" value="cal">
									Matricula : <input id="matricula" type="text" name="matricula" required> 
									<button>Generar</button>
								</form>

								<div nombre="hcs" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
								<b>Ver historial de constancias</b>	';		
								$alumnos = mysqli_query($conexion, "SELECT * FROM Constancias ORDER BY id_constancia DESC ;");
								


								echo'<div id="hcs" style="display:none">
									<hr></hr>
									<table id="Mod">
										<tr><th>No.</th>
										<th>Alumn@</th>
										<th>Constancia no:</th>
										<th>Fecha</th>
										<th>Hora</th></tr>';

										while($datosAl = mysqli_fetch_array($alumnos)){

											$alumnos2 = mysqli_query($conexion, "SELECT * FROM Alumnos WHERE id_alumno= ".$datosAl['id_alumno']." ;");
				
												while($datosAl2 = mysqli_fetch_array($alumnos2)){

													$nombre=$datosAl2["apellidoP"].' '.$datosAl2["apellidoM"].' '.$datosAl2["nombre"];

												}

											echo "<tr class='Mod'><td>".$datosAl["id_constancia"]."</td>
											<td>".$nombre."</td>
											<td>".$datosAl["no_constancia"]."/".$datosAl["periodo"]."</td>
											<td>".$datosAl["fecha"]."</td>
											<td>".$datosAl["hora"]."</td></tr>";
										}

								echo'</table>
								<script>
									$("#Mod").tablePagination({});
									$.expr[":"].Contains = function(x, y, z){
									return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
									};
								</script>
									
								</div>
					<img src="imagenes/ver.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#hcs\').toggle(\'drop\')">
					</div>
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#COS\').toggle(\'drop\')">
					</div>

					<div nombre="JUS" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Generar Justificantes</b>						
							<div id="JUS" style="display:none">
								<hr></hr>
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#JUS\').toggle(\'drop\')">
					</div>

					<div nombre="ViewX" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Ver Planes de Estudios</b>						
							<div id="ViewX" style="display:none">
								<hr></hr>
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#ViewX\').toggle(\'drop\')">
					</div>
					<br><br>
						
				</div>	

			<div id="Sai" class="tabCont" permiso="A" style="display:none" permiso="A">
				<h2>Ajustes:</h2>

					<div nombre="cal" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Crear Nuevo Semestre</b>						
							<div id="cal" style="display:none">
								<hr></hr>

								<form destino="resultadoRegistro" action="accionesSAI.php" style="display:inline-block">
									<input type="hidden" name="option" value="sem">
									Ciclo: <input name="ciclo" type="text"  placeholder="Enero - Julio 2016" required />
									Periodo: <select  name="tipo" required>
												<option value="A">Periodo A</option>
												<option value="B">Periodo B</option>
											</select>
									<button>Asignar</button>
								</form>
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#cal\').toggle(\'drop\')">
					</div>
					<div nombre="cal" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Agsinar tiempo de Evalucion</b>						
							<div id="cal" style="display:none">
								<hr></hr>

								<form destino="resultadoRegistro" action="accionesSAI.php" style="display:inline-block">
									<input type="hidden" name="option" value="cal">
									Activar desde : <input type="date" name="de" required> 
									Hasta :	<input type="date" name="a" required>  
									Como : <select  name="tipo" required>
												<option value="1">Periodo Ordinario</option>
												<option value="5">Periodo Extraordinario</option>
												<option value="6">Periodo de Recaptura</option>
												<option value="2">1er Periodo de Regularizacion</option>
												<option value="3">2do Periodo de Regularizacion</option>
												<option value="4">3er Periodo de Regularizacion</option>
											</select>
										<button>Activar</button>
								</form>
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#cal\').toggle(\'drop\')">
					</div>

					<div nombre="PE" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Agregar Plan de Estudios</b>						
							<div id="PE" style="display:none">
								<hr></hr>

								<form destino="resultadoRegistro" action="accionesSAI.php" style="display:inline-block">
									<input type="hidden" name="option" value="plan">
									<table>
									<tr><td>Nombre:</td><td><input name="nombre" type="text"  placeholder="nombre del plan de estudios" required /></td></tr>
									<tr><td>Año:</td><td> <input name="ano" type="text"  placeholder="Año del plan de estudios" required /> </td></tr>
									<tr><td>Carrera:</td><td> <select  name="carrera">
													<option value="Lincenciatura en Educacion Preescolar">Lincenciatura en Educacion Presscolar</option>
													<option value="Lincenciatura en Educacion Primaria">Lincenciatura en Educacion Primaria</option>
												</select></td></tr>
									</table>
									<center><button >Agregar</button></center>
								</form><br><br>
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#PE\').toggle(\'drop\')">
					</div>

					<div nombre="asi" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Agregar Asignaturas</b>						
							<div id="asi" style="display:none">
								<hr></hr>

								<form destino="resultadoRegistro" action="accionesSAI.php" style="display:inline-block">
								<input type="hidden" name="option" value="asig">
								<table>
									<tr><td>Clave:</td><td><input name="clave" type="text"  placeholder="clave de la Asignatura" required /></td></tr>
									<tr><td>Asignatura:</td><td> <input name="asig" type="text"  placeholder="nombre de la Asignatura" required /> </td></tr>
									<tr><td>Semestre:</td><td>
										<select  name="semestre">
											<option value="1">1ro</option>
											<option value="2">2do</option>
											<option value="3">3ro</option>
											<option value="4">4to</option>
											<option value="5">5to</option>
											<option value="6">6to</option>
											<option value="7">7mo</option>
											<option value="8">8vo</option>
										</select></td>
									<tr><td>Carrera:</td><td> <select  name="carrera">
													<option value="Lincenciatura en Educacion Preescolar">Lincenciatura en Educacion Presscolar</option>
													<option value="Lincenciatura en Educacion Primaria">Lincenciatura en Educacion Primaria</option>
												</select></td></tr>
									<tr><td>Plan de Estudios:</td>
									<td> ';
									$pro= mysqli_query($conexion,"SELECT * FROM Planes_estudios WHERE status=1;");
									$numpro = mysqli_num_rows($pro);
									echo"<select name='plan' required ><option value='na'>Eliga el plan de estudios</option>";
									if($numpro>0){
										for($x=0;$x<$numpro;$x++){
										$datospro = mysqli_fetch_array($pro);
										echo"<option value='".$datospro["id_plan"]."'>". $datospro["nombre"]." - ". $datospro["carrera"]."</option>";
										}
									}
									echo'</select></td>
									</table><br>
									</td></tr>
									</table>
									<center><button >Agregar</button></center>
								</form>
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#asi\').toggle(\'drop\')">
					</div>

					<div nombre="Asifnar" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Asignar Asignaturas a Docentes</b>						
							<div id="Asifnar" style="display:none">
								<hr></hr>
								<form destino="Asifnar" action="segi.php" style="display:inline-block">
									<input type="hidden" name="option" value="doce">
									<table>
										<tr>
											<td>Plan de Estudios:</td><td>';
											$pro= mysqli_query($conexion,"SELECT * FROM Planes_estudios WHERE status=1;");
											$numpro = mysqli_num_rows($pro);
											echo"<select name='plan' required ><option value='0'>Eliga el plan de estudios...</option>
											";
											if($numpro>0){
												for($x=0;$x<$numpro;$x++){
												$datospro = mysqli_fetch_array($pro);
												echo"<option value='".$datospro["id_plan"]."'>". $datospro["nombre"]." - ". $datospro["carrera"]."</option>";
												}
											}
											echo'</select></td>
											<td>Semestre:</td><td>
											<select  name="semestre">
												<option value="1">1ro</option>
												<option value="2">2do</option>
												<option value="3">3ro</option>
												<option value="4">4to</option>
												<option value="5">5to</option>
												<option value="6">6to</option>
												<option value="7">7mo</option>
												<option value="8">8vo</option>
											</select></td>
										</tr>
									</table><br>
									<center><button>Siguiente</button></center><br>
								</form>
								<div id= "resultados"></div>					
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#Asifnar\').toggle(\'drop\')">
					</div>

					<div nombre="hora" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Crear Horarios</b>						
							<div id="hora" style="display:none">
								<hr></hr>

								
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#hora\').toggle(\'drop\')">
					</div>

					<div nombre="BPE" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Dar de baja Plan de estudios</b>						
							<div id="BPE" style="display:none">
								<hr></hr>

								<font color="red" weight="bold">*Aviso:</font>
								<b>Al dar de baja el plan de estudios automaticamente las asignaturas ligadas a este plan
								seran dadas de baja automaticamente.</b><br><br>

								<form destino="resultadoRegistro" action="accionesSAI.php" style="display:inline-block">
									<input type="hidden" name="option" value="bajaPln">';

									$pro= mysqli_query($conexion,"SELECT * FROM Planes_estudios;");
									$numpro = mysqli_num_rows($pro);
									echo"<select name='plan' required ><option value='na'>Eliga el plan de estudios</option>";
									if($numpro>0){
										for($x=0;$x<$numpro;$x++){
											$datospro = mysqli_fetch_array($pro);
											echo"<option value='".$datospro["id_plan"]."'>". $datospro["nombre"]." - ". $datospro["carrera"]."</option>";
										}
									}
									echo'</select> <button>Dar de baja</button>
								</form>
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#BPE\').toggle(\'drop\')">
					</div>

					<div nombre="BA" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Dar de baja Asignatura</b>						
							<div id="BA" style="display:none">
								<hr></hr>

								<form destino="resultadoRegistro" action="accionesSAI.php" style="display:inline-block">
									<input type="hidden" name="option" value="bajaAsig">';

									$pro= mysqli_query($conexion,"SELECT * FROM Materias WHERE status=1;");
									$numpro = mysqli_num_rows($pro);
									echo"<select name='materia' required ><option value='na'>Eliga la Asignatura</option>";
									if($numpro>0){
										for($x=0;$x<$numpro;$x++){
											$datospro = mysqli_fetch_array($pro);
											echo"<option value='".$datospro["id_materia"]."'>". $datospro["clave"]." - ". $datospro["materia"]." ( ". $datospro["carrera"].")</option>";
										}
									}
									echo'</select> <button>Dar de baja</button>

								</form>
								
							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#BA\').toggle(\'drop\')">
					</div>

					<div nombre="Contrasenas" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
							<b>Resetear Contraseñas</b>						
							<div id="Contrasenas" style="display:none">
								<hr></hr>
								<form destino="verConsultaCo" action="busqueda.php" style="display:inline-block">
									<input type="hidden" name="option" value="contra">
									Buscar: <input type="search" size="47" placeholder="por: Matricula, Apellido Paterno, Apellido Materno y Nombre" name="mati" required /> 
									<button ><img src="imagenes/search.png"></button>
								</form><br><br>
								<div id="verConsultaCo"></div>
								<br><br>

							</div>
					<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#Contrasenas\').toggle(\'drop\')">
					</div>
					<br><br>

			</div>
		</div>

	</div>
';
	if(substr($_SESSION["Permisos_Eneaware"][11],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
		}
		if(substr($_SESSION["Permisos_Eneaware"][11],1,1)=="0"){
			echo "<script>$('#principalInner [permiso=D]').remove()</script>";
		}
		if(substr($_SESSION["Permisos_Eneaware"][11],2,1)=="0"){
			echo "
				<script>
					$('#principalInner form[permiso=M] input').prop('disabled', true);
					$('#principalInner form[permiso=M] select').prop('disabled', true);
					$('#principalInner form[permiso=M] button').remove();
				</script>";
		}
    
?>
<script>
	$(function(){
		$("#sai").tabs();
		$("#alumnos").tabs();
		$("#tabs3").tabs();
	});
	
</script>