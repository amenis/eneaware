<script src="js/jquery.tablePagination.js" ></script>
<script src="js/jquery-ui.js"></script>
<?php
	session_start();
	include("conexion.php");
	echo '
	<div style="overflow:auto;height:100%;padding-left:20px;">
		<h1>Administración del claves del personal</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="registrarClaves">Registrar claves</button>
		<button class="tab"  style="border-bottom:none;" permiso="A" mostrar="recateogorizar">Recategorizar</button>
		<button class="tab" style="border-bottom:none;" mostrar="modificarClaves">Ver / Modificar claves del personal</button>
		<button class="tab" style="border-bottom:none;" mostrar="ClavesCance">Claves Canceladas</button>
		<button class="tab" style="border-bottom:none;" mostrar="ajustes">Ajustes</button>

		<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			<div id="registrarClaves" class="tabCont" permiso="A">
				<h2>Registrar claves</h2>
				<form action="accionesClave.php" destino="resultadoRegistro">
					<input type="hidden" name="accion" value="registro">
					<input disabled type="text" style="text-align:center;position:fixed;right:150px;top:25%;font-size:20pt" id="claveGenerada" placeholder="Clave generada" size="21"> 
					<table>
						<tr>
							<td>Personal</td>
							<td>
								<select name="id_usuario">
								';
								$personal = mysqli_query($conexion, "SELECT * FROM Usuarios WHERE status=1");
								while($datosU = mysqli_fetch_assoc($personal)) {
									echo '<option value="'.$datosU["id_usuario"].'">'.$datosU['apellidoP'].' '.$datosU['apellidoM'].' '.$datosU["nombre"]."</option>";
								}
								mysqli_free_result($personal);
								echo'
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="text" name="puesto" id="puestoClave" value="070419"  readonly/>
							</td>
						</tr>
						<tr>
							<td>Categoria</td>
							<td>
								<select name="categoria" id="categoriaClave">';
									$cate = mysqli_query($conexion,"SELECT * FROM Categorias");
									while($dataCate = mysqli_fetch_assoc($cate)){
										echo'
										<option value="'.$dataCate['codigo'].'">'.$dataCate['descripcion'].'</option>
										';
									}
								echo'
								</select>
							</td>
						</tr>
						<tr>
							<td>Horas</td>
							<td><input type="number" required name="horas" id="horasClave" min="1" max="48" ></td>
						</tr>
						<tr>
							<td>Plaza</td>
							<td><input type="text" required name="plaza" id="plazaClave"></td>
						</tr>
						<tr>
							<td>Fecha de Creacion</td>
							<td><input type="date" name="fecha_inicio"></td>
						</tr>
					</table>
					<center><button>Guardar</button></center>
				</form>
			</div>
			<div id="recateogorizar" class="tabCont" style="display:none">
				<h2>Recategorizar Claves</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus id="name" padre="reca" placeholder="Buscar por nombre">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				<table id="reca" width="100%">';
					
					$PersCa = mysqli_query($conexion, "SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,id_usuario FROM Usuarios WHERE status=1");
					while($daPersCa = mysqli_fetch_assoc($PersCa)){
						echo'
						<tr class="reca">
							<td>
								<span class="reca_nombre" style="display:none" >'.$daPersCa['nombre'].'</span>
								<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">
									<b>'.$daPersCa['nombre'].'</b>
										<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(this).next().toggle(\'drop\')">
									<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none; display:none;">
										<form action="accionesClave.php" destino="resultadoRegistro">
											<input type="hidden" name="idU" value="'.$daPersCa['id_usuario'].'">
											<input type="hidden" name="accion" value="recategorizar">										
											<fieldset style="width:30%;">
												<legend>Selecciona la Nueva Clave</legend>';
												$h = date("Y-m-d");
												$claves = mysqli_query($conexion, "SELECT * FROM Claves WHERE  id_usuario=".$daPersCa["id_usuario"]);
												while($datosC=mysqli_fetch_assoc($claves)) {
													echo $datosC["puesto"].' '.$datosC["categoria"].$datosC["horas"].$datosC["plaza"].'<input type="checkbox" name="id_clave" value="'.$datosC['id_clave'].'"><br/>';
													
												}
										echo'
											</fieldset>
											<fieldset style="position:absolute;left:45%;top:3%;width:30%;">
												<legend>Clave Anterior</legend>';
												$claves = mysqli_query($conexion, "SELECT * FROM Claves WHERE  id_usuario=".$daPersCa["id_usuario"]);
												while($datosC=mysqli_fetch_assoc($claves)) {
													echo $datosC["puesto"].' '.$datosC["categoria"].$datosC["horas"].$datosC["plaza"].'<input type="checkbox" name="clave_ante" value="'.$datosC['id_clave'].'"><br/>';
												}
												
										echo'
											</fieldset>
											<center><button>Guardar</button></center>
										</form>
									</div>
								</div>
							</td>
						</tr>';
					}
					mysqli_free_result($PersCa);
					mysqli_free_result($claves);
				echo'
				</table>
					
			</div>
			<div id="modificarClaves" style="display:none;" class="tabCont">
				<h2>Modificar claves</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus id="name" padre="modCla" placeholder="Buscar por nombre">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				
				<table id="modCla" style="width:100%;">';
					$personal = mysqli_query($conexion, "SELECT * FROM Usuarios WHERE status=1");
					while($datosPer=mysqli_fetch_assoc($personal)) {
						echo'
							<tr class="modCla">
								<td>
									<span class="modCla_nombre" style="display:none">'.$datosPer['apellidoP'].' '.$datosPer['apellidoM'].' '.$datosPer["nombre"].'</span>
									<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">
										<b>'.$datosPer['apellidoP'].' '.$datosPer['apellidoM'].' '.$datosPer["nombre"].'</b>
										<div id="claves'.$datosPer["id_usuario"].'" style="display:none;">
											<div style="border-bottom:1px solid rgba(0,0,0,0.2);width:95%;padding-left:20px;"></div>';
											$claves = mysqli_query($conexion, "SELECT * FROM Claves WHERE status=1 AND id_usuario=".$datosPer["id_usuario"]);
											while($datosC=mysqli_fetch_assoc($claves)) {
												echo '
													<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">
														Clave: '.$datosC["puesto"].$datosC["categoria"].$datosC["horas"].$datosC["plaza"].' <span style="padding-left:20px">Fecha de creacion: '.$datosC["fecha_ingreso"].'</span>								
														<form action="accionesClave.php" destino="resultadoRegistro" id="editarClave'.$datosC["id_clave"].'" style="display:none;" permiso="M">
															<input type="hidden" name="accion" value="modificar"> 
															<input type="hidden" name="id_clave" value="'.$datosC["id_clave"].'">
															<input type="hidden" name="id_usuario" value="'.$datosPer["id_usuario"].'"> 
															<table>
																<tr>
																	<td>Categoria</td>
																	<td>
																		<select name="categoria" id="categoriaClave'.$datosC["id_clave"].'">
																			<option value="27">Titular A</option>
																			<option value="29">Titular B</option>
																			<option value="31">Titular C</option>
																			<option value="23">Asociado A</option>
																			<option value="25">Asociado B</option>
																			<option value="33">Asociado C</option>
																			<option value="71">Director</option>
																			<option value="61">Subdirector administrativo</option>
																			<option value="63">Subdirector de investigacion</option>
																			<option value="JA">Administrativo especializado B</option>
																			<option value="JS">Oficial de servicios B</option>
																			<option value="JS">Oficial de servicios C</option>
																		</select>
																		<script>
																			opciones = $("#categoriaClave'.$datosC["id_clave"].'").find("option");
																			opciones.each(function(){
																				if($(this).val()=="'.$datosC["categoria"].'"){
																					$(this).prop("selected", true);
																					return false;
																				}
																			});
																		</script>
																	</td>
																</tr>
																<tr>
																	<td>Horas</td>
																	<td><input type="text" value="'.$datosC["horas"].'" required name="horas" pattern="[0-9]*" title="solo se permiten numeros"></td>
																</tr>
																<tr>
																	<td>Plaza</td>
																	<td><input type="text" value="'.$datosC["plaza"].'" required name="plaza"></td>
																</tr>
																<tr>
																	<td>Fecha de Creacion</td>
																	<td>'.$datosC["fecha_ingreso"].'</td>
																</tr>
															</table>
															<center><button>Guardar</button></center>
														</form>
														<form action="accionesClave.php" destino="resultadoRegistro" id="desClave'.$datosC["id_clave"].'" style="display:none;" permiso="D">
															<input type="hidden" name="accion" value="deshabilitar"> 
															<input type="hidden" name="id_clave" value="'.$datosC["id_clave"].'">
															Fecha de Cancelacion<input type="date" name="fechaCance"/>
															Estas seguro de Cancelar esta clave? <button>Si, estoy seguro</button><button onclick="$(this).parent().hide(\'drop\');return false">No</button>
														</form>
														<img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(\'#editarClave'.$datosC["id_clave"].'\').toggle(\'drop\')">
														<img src="imagenes/bin.png" permiso="D" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#desClave'.$datosC["id_clave"].'\').toggle(\'drop\')">
													</div>
												';
											}
										mysqli_free_result($claves);
										echo'
										</div>
										<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#claves'.$datosPer["id_usuario"].'\').toggle(\'drop\')">
									</div>
								</td>
							</tr>';
					}
				mysqli_free_result($personal);
				echo'	
				</table>
							
			</div>
			<div id="ClavesCance" style="display:none;" class="tabCont">
				<h2>Claves Canceladas</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus class="name" padre="restaurar" placeholder="Buscar por nombre">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				<table id="restaurar" style="width:100%;">';
					$clavesD = mysqli_query($conexion, "SELECT * FROM Claves WHERE status=0");
					while($datosCD = mysqli_fetch_assoc($clavesD)) {
						$usuarioCD = mysqli_query($conexion, "SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre FROM Usuarios WHERE id_usuario=".$datosCD["id_usuario"]);
						$datosUCD = mysqli_fetch_assoc($usuarioCD);
						mysqli_free_result($usuarioCD);
						echo '
						<tr class="restaurar">
							<td>
							<span class="restaurar_nombre" style="display:none">'.$datosUCD['nombre'].'</span>
							<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
								Clave: '.$datosCD["puesto"].$datosCD["categoria"].$datosCD["horas"].$datosCD["plaza"].'<br/> <span style="padding-left:20px">Personal: '.$datosUCD['nombre'].'</span><span style="padding-left:20px">Fecha de creacion: '.$datosCD["fecha_ingreso"].'</span><span style="padding-left:20px">fecha de cancelacion: '.$datosCD["fecha_cancelacion"].'</span>
								
							</div>
						';
					}
					mysqli_free_result($clavesD);
				echo'
				</table>
				<script>
					$("#restaurar").tablePagination({});
					$.expr[":"].Contains = function(x, y, z){
				       return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
				    };
				</script>	
						
			</div>
			<div id="ajustes" class="tabCont" style="display:none">
				<h2>Ajustes</h2>

					<div style="position:relative;width:40%;padding:10px;border:1px solid rgba(0,0,0,0.2);">						
						<b>Modificar Categoria</b>
						<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#EditC\').toggle(\'drop\')">
						<div id="EditC" style="display:none">
							<form action="accionesClave.php" destino="resultadoRegistro">
								<input type="hidden" value="modificar_cate" name="accion">
								Selecciona la Categoria a Modificar
								<br>
								<select name="idCa" onChange="$(\'#codigo\').val($(this).find(\'option:selected\').attr(\'codigo\')); $(\'#desc\').val($(this).find(\'option:selected\').attr(\'desc\'));$(\'#datos\').show();">
									<option>Selecciona...</option>';
									$cate = mysqli_query($conexion,"SELECT * FROM Categorias");
									while($dataCate = mysqli_fetch_assoc($cate)){
										echo'
										<option value="'.$dataCate['id_categoria'].'" codigo="'.$dataCate['codigo'].'" desc="'.$dataCate['descripcion'].'" >'.$dataCate['descripcion'].'</option>
										';
									}
								echo'
								</select>
								<hr width="95%"></hr>
								<br/>
								<div id="datos" style="display:none">
									<label for="codigo" >Codigo Categoria</label> <input type="text" name="codigo" id="codigo" value><br/>
									<label for="desc" >Categoria</label> <input type="text" name="desc" id="desc" size="35" value>
									<br/>
									<button>Editar</button>
								</div>
							</form>';


						echo'
						</div>
					</div>

					<div style="position:relative;width:40%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
						<b>Nueva Categoria</b>
						<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#NuwC\').toggle(\'drop\')">
													 
						<div id="NuwC" style="display:none">
							<form action="accionesClave.php" destino="resultadoRegistro">
								<input type="hidden" value="new_cate" name="accion">
								<div id="datos" >
									<label for="codigo" >Codigo Categoria</label> <input type="text" name="codigo" id="codigo" value><br/>
									<label for="desc" >Categoria</label> <input type="text" name="desc" id="desc" size="35" value>
									<br/>
									<button>Guardar</button>
								</div>
							</form>
						</div>
					</div><br/>
			</div>
		
		</div>
	</div>
	';
	if(substr($_SESSION["Permisos_Eneaware"][1],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][1],1,1)=="0"){
		echo "<script>$('#principalInner [permiso=D]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][1],2,1)=="0"){
		echo "
			<script>
				$('#principalInner form[permiso=M] input').prop('disabled', true);
				$('#principalInner form[permiso=M] select').prop('disabled', true);
				$('#principalInner form[permiso=M] button').remove();
			</script>";
	}
	mysqli_close($conexion);
?>

<script>
		$("#modCla").tablePagination({});
		$("#restaurar").tablePagination({});
		$("#reca").tablePagination({});
		$.expr[":"].Contains = function(x, y, z){
		    return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
		};
		$(function() {
		    $( "#tabs" ).tabs();
		   
   		});

</script>
