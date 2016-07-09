<script src="js/jquery.tablePagination.js" ></script>
<script src="js/jquery-ui.js"></script>
<script src="js/printThis.js"></script>
<?php
	session_start();
	include("conexion.php");
	include("conversor.php");
	echo '

	<div style="overflow:auto;height:100%">
		<h1>Administración de viaticos</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="registrarViaticos">Registrar viaticos</button>
		<button class="tab" style="border-bottom:none;" mostrar="modificarViaticos">Ver / Modificar viaticos</button>
		<button class="tab" style="border-bottom:none;" mostrar="restaurarViaticos">Restaurar viaticos</button>
		<div style="background:rgba(255,255,255,0.6);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			<div id="registrarViaticos" class="tabCont" permiso="A">
				<h2>Registrar viaticos</h2>
				
				<form action="accionesViaticos.php" destino="resultadoRegistro">
					<input type="hidden" name="accion" value="registro">
					<table style="width:95%;">
						<tr>
							<td style="width:166px">Selecciona la comision</td>
							<td style="text-align:left">
								<select name="id_comision" id="idComViaticos" required>
									<option value="">Selecciona</option>';
									$comisiones = mysqli_query($conexion, "SELECT * FROM Comisiones WHERE status=1");
									while($datosCom = mysqli_fetch_assoc($comisiones)){
										echo '<option idsU="'.$datosCom["ids_usuarios"].'" value='.$datosCom["id_comision"].'>#'.$datosCom["id_comision"].'</option>';
									}
									mysqli_free_result($comisiones);
								echo'
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<div id="tablaUComViaticos">								
								</div>
							</td>
						</tr>
					</table>						
					<center><button onclick="funcion();setTimeout(function(){$(this).parents().submit();},2000);">Guardar</button></center>
				</form>
			</div>
			<div id="modificarViaticos" style="display:none;" class="tabCont">
				<h2>Modificar viaticos</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus id="name" padre="Viatico" placeholder="Buscar por numero">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>

				<table id="Viatico" style="width:100%;">

					
				';
					$sql="SELECT DISTINCT num_comision FROM Viaticos WHERE status=1";
					
					$numCom2 = mysqli_query($conexion,$sql);
					$num_result = @mysqli_num_rows($numCom2);	

					$cant=1;
					while($num= mysqli_fetch_assoc($numCom2)){
						$personal="";
						echo'
						<tr class="Viatico">
							<td>
								<span class="Viatico_nombre" style="display:none">'.$num['num_comision'].'</span>
								<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">

									Viatico de la Comision # '.$num['num_comision'].'
									<div id="verV'.$num["num_comision"].'" style="display:none">';
										$viaticos = mysqli_query($conexion,"SELECT * FROM Viaticos INNER JOIN Detalle_viaticos ON Detalle_viaticos.id_viatico = Viaticos.id_viatico WHERE Viaticos.num_comision=".$num['num_comision']." AND status=1");
										$numV=1;
										$personal="";
										while($datosV = mysqli_fetch_array($viaticos)){
											$usuarios = mysqli_query($conexion,"SELECT nombre,rfc FROM Usuarios WHERE id_usuario = '".$datosV[3]."' ");
											$data = mysqli_fetch_assoc($usuarios);
											mysqli_free_result($usuarios);
											echo'
											<input type="hidden" name="id_viatico" value="'.$datosV['id_viatico'].'">
											
									 <button onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();"><img src="imagenes/print.png"/></button>
											

											<div class="imprimir" style="font-family:Arial;margin:auto;padding:0.5cm;background:white;width:25cm;height:27cm;border:1px solid grey;">
												<img src="imagenes/sej.png" style="position:absolute;width:128px;z-index:3">
												<span style="position:relative;top:0;font-size:10pt">
													<b style="position:relative;left:30%;top:0%;">GOBIERNO DEL ESTADO DE JALISCO</b><span style="position:relative;left:50%">'.$_SESSION['Nombre_Usuario_Eneaware'].' '.$datosV['id_viatico'].'</span><br/>
													<b style="position:relative;left:20%;">SECRETARIA DE PLANEACION ADMININISTRACION Y FINANZAS</b><br/>
													<b style="position:relative;left:35%;top:0%;">RECIBO DE VIATICOS</b>	
													<div style="position:relative;top:3%;left:75%;"><span style="font-size:11pt;"><b>BUENO POR</b>$ </span><input type="text" size="10" name="totalDV" value="'.$datosV['total'].'" style="border-bottom:1px solid black;border-top:none;border-right:none;border-left:none;"class="presio"/></div>							
													
												</span>
											
												<table style="font-size:10pt" width="98%">
													<tr ><td  colspan="3" class="encabezado"  style="border:5px solid gray; text-align:center;">DATOS GENERALES</td></tr>
													<tr>
														<td><b>DEPENDENCIA</b></td>
														<td style="border-bottom:1px solid black">SECRETARIA DE EDUCACION DEL ESTADO DE JALISCO</td>
													</tr>
													<tr>
														<td><b>DIRECCION</b></td>
														<td style="border-bottom:1px solid black">CORDINACION DE FORMACION Y ACTUALIZACION DOCENTE</td>
													</tr>
													<tr>
														<td><b>DEPARTAMENTO</b></td>
														<td style="border-bottom:1px solid black">DIRECCION GENERAL DE EDUCACION NORMAL/ESC NOMRAL PARA EDUCADORES DE ARANDAS</td>
													</tr>
													<tr>
														<td colspan="2" width="32px"><b>NOMBRE Y CATEGORIA DEL SERVIDOR PUBLICO</b>: <span  style="border-bottom:1px solid black">'.$data["nombre"].'</span> <b>RFC: </b><span style="border-bottom:1px solid black">'.$data['rfc'].'</span></td>
														
													</tr>
												</table>
												'.$datosV[5].'
												'.$datosV[9].'								
												<table cellspacing="0" border="0" id="firmas" style="font-size:10pt" width="98%">
						                                    <tr>
						                                        <td align="left"><b>RECIBIO</b></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><b>AUTORIZO</b></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><b>Vo.Bo</b></td>
						                                    </tr>
						                                    <tr>
						                                        <td align="left"><br></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><br></td>
						                                    </tr>
						                                    <tr>
						                                        <td align="left"><font size="1">COMISIONADO</font></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1">JEFE INMEDIATO</font></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1">COORD DE FORMACION Y ACTUALIZACION DOCENTE</font></td>
						                                    </tr>
						                                    <tr>
						                                        <td align="left">'.$data['nombre'].'</td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1">MTRO VICTOR MANUEL DE LA TORRE ESPINOSA</font></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1"><br></font></td>
						                                    </tr>
						                                    <tr>
						                                        <td align="left">'.$data['rfc'].'</td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1">DIRECTOR GENERAL DE EDUCACION NORMAL</font></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1">DR TEODOMIRO PELAYO GOMEZ</td>
						                                    </tr>
						                                
						                        </table>			                        
												<br></br>
												<br></br>
												<small contenteditable="false">Nota:</small><br><span contenteditable class="nota'.$numV.''.$num['num_comision'].'" > Viajo en Comision con</span>
											</div>';
											
											$personal.=$data['nombre'].',';
										
											$numV++;
										}	

								echo'							
									</div>
									<img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(\'#verV'.$num['num_comision'].'\').toggle();">
									<img src="imagenes/bin.png" permiso="D" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(this).next().toggle();">
									<form action="accionesViaticos.php" destino="resultadoRegistro" style="display:none">
										<input type="hidden" name="accion" value="deshabilitar">
										<input type="hidden" name="id_comision" value="'.$num['num_comision'].'"/>
										<input type="hidden" name="cantidad" value="'.$numV.'">
										Estas Seguro que deseas Desahabilitar este Viatico
										<button>Si,Desahabilitar</button>
										<button onclick="$(this).parent().toggle();return false;">No</button>
									</form>
									<script>
										var notas='.($numV-1).';
										var cant = '.$cant.';
										personaljs = "'.$personal.'".split(",");
										personaljs.pop();
										
											for (x=0; x <=notas ; x++) { 	
												personaljs.splice(x,1);		
												$(".nota"+(x+1)+cant).append(" "+personaljs+" ");				
												personaljs = "'.$personal.'".split(",");
												personaljs.pop();
											}								
									</script>
								</div>
							</td>
						</tr>';
						$cant++;
					}

				echo'
				</table>
				<script>
					$("#Viatico").tablePagination({});
					$.expr[":"].Contains = function(x, y, z){
					    return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
					};
				</script>

				<div style="border-bottom:1px solid rgba(0,0,0,0.2);width:95%;padding-left:20px;"></div>';
				
				echo'	
				<br>			
			</div>
			<div id="restaurarViaticos" style="display:none;" class="tabCont">
				<h2>Restaurar viaticos</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus id="name" padre="restaurar" placeholder="Buscar por numero">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				<div style="border-bottom:1px solid rgba(0,0,0,0.2);width:95%;padding-left:20px;"></div>
				<table id="restaurar" style="width:100%">';
				$sql="SELECT DISTINCT num_comision FROM Viaticos WHERE status=0";
					
					$numCom2 = mysqli_query($conexion,$sql);
					$num_result = @mysqli_num_rows($numCom2);	

					$cant=1;
					while($num= @mysqli_fetch_assoc($numCom2)){
						$personal="";
						echo'
						<tr class="restaurar">
							<td>
								<span class="restaurar_nombre" style="display:none">'.$num['num_comision'].'</span>
								<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">

									Viatico de la Comision # '.$num['num_comision'].'
									<div id="resV'.$num["num_comision"].'" style="display:none">';
										$viaticos = mysqli_query($conexion,"SELECT * FROM Viaticos INNER JOIN Detalle_viaticos ON Detalle_viaticos.id_viatico = Viaticos.id_viatico WHERE Viaticos.num_comision=".$num['num_comision']." AND status=0");
										$numV=1;
										$personal="";
										while($datosV = mysqli_fetch_array($viaticos)){
											$usuarios = mysqli_query($conexion,"SELECT nombre,rfc FROM Usuarios WHERE id_usuario = '".$datosV[3]."' ");
											$data = mysqli_fetch_assoc($usuarios);
											mysqli_free_result($usuarios);
											echo'
											<input type="hidden" name="id_viatico" value="'.$datosV['id_viatico'].'">
											 <button onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();"><img src="imagenes/print.png"/></button>
											<div style="font-family:Arial;margin:auto;padding:0.5cm;background:white;height:29.8cm;border:1px solid grey;">
												<img src="imagenes/sej.png" style="position:absolute;width:128px;z-index:3">
												<span style="position:relative;top:0;font-size:10pt">
													<b style="position:relative;left:30%;top:0%;">GOBIERNO DEL ESTADO DE JALISCO</b><span style="position:relative;left:50%">'.$_SESSION['Nombre_Usuario_Eneaware'].' '.$datosV['id_viatico'].'</span><br/>
													<b style="position:relative;left:20%;">SECRETARIA DE PLANEACION ADMININISTRACION Y FINANZAS</b><br/>
													<b style="position:relative;left:35%;top:0%;">RECIBO DE VIATICOS</b>	
													<div style="position:relative;top:3%;left:75%;"><span style="font-size:11pt;"><b>BUENO POR</b>$ </span><input type="text" size="10" name="totalDV" value="'.$datosV['total'].'" style="border-bottom:1px solid black;border-top:none;border-right:none;border-left:none;"class="presio"/></div>							
													
												</span>
											
												<table style="font-size:10pt" width="98%">
													<tr bgcolor="gray" style="color:white;"><td colspan="3" style="text-align:center">DATOS GENERALES</td></tr>
													<tr>
														<td><b>DEPENDENCIA</b></td>
														<td style="border-bottom:1px solid black">SECRETARIA DE EDUCACION DEL ESTADO DE JALISCO</td>
													</tr>
													<tr>
														<td><b>DIRECCION</b></td>
														<td style="border-bottom:1px solid black">CORDINACION DE FORMACION Y ACTUALIZACION DOCENTE</td>
													</tr>
													<tr>
														<td><b>DEPARTAMENTO</b></td>
														<td style="border-bottom:1px solid black">DIRECCION GENERAL DE EDUCACION NORMAL/ESC NOMRAL PARA EDUCADORES DE ARANDAS</td>
													</tr>
													<tr>
														<td colspan="2" width="32px"><b>NOMBRE Y CATEGORIA DEL SERVIDOR PUBLICO</b>: <span  style="border-bottom:1px solid black">'.$data["nombre"].'</span> <b>RFC: </b><span style="border-bottom:1px solid black">'.$data['rfc'].'</span></td>
														
													</tr>
												</table>
												'.$datosV[5].'
												'.$datosV[9].'								
												<table cellspacing="0" border="0" id="firmas" style="font-size:10pt" width="98%">
						                                    <tr>
						                                        <td align="left"><b>RECIBIO</b></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><b>AUTORIZO</b></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><b>Vo.Bo</b></td>
						                                    </tr>
						                                    <tr>
						                                        <td align="left"><br></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><br></td>
						                                    </tr>
						                                    <tr>
						                                        <td align="left"><font size="1">COMISIONADO</font></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1">JEFE INMEDIATO</font></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1">COORD DE FORMACION Y ACTUALIZACION DOCENTE</font></td>
						                                    </tr>
						                                    <tr>
						                                        <td align="left">'.$data['nombre'].'</td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1">MTRO VICTOR MANUEL DE LA TORRE ESPINOSA</font></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1"><br></font></td>
						                                    </tr>
						                                    <tr>
						                                        <td align="left">'.$data['rfc'].'</td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1">DIRECTOR GENERAL DE EDUCACION NORMAL</font></td>
						                                        <td align="left"><br></td>
						                                        <td align="left"><font size="1">DR TEODOMIRO PELAYO GOMEZ</td>
						                                    </tr>
						                                
						                        </table>			                        
												<br></br>
												<br></br>
												<small contenteditable="false">Nota:</small><br><span contenteditable class="nota'.$numV.''.$num['num_comision'].'" > Viajo en Comision con</span>
											</div>';
											
											$personal.=$data['nombre'].',';
										
											$numV++;
										}	

								echo'							
									</div>
									<img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(\'#resV'.$num['num_comision'].'\').toggle();">
									<img src="imagenes/checkmark.png" permiso="D" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(this).next().toggle();">
									<form action="accionesViaticos.php" destino="resultadoRegistro" style="display:none">
										<input type="hidden" name="accion" value="restaurar">
										<input type="hidden" name="id_comision" value="'.$num['num_comision'].'"/>
										Estas Seguro que deseas Habilitar este Viatico
										<button>Si,Habilitar</button>
										<button onclick="$(this).parent().toggle();return false;">No</button>
									</form>
									<script>
										var notas='.($numV-1).';
										var cant = '.$cant.';
										personaljs = "'.$personal.'".split(",");
										personaljs.pop();
										
											for (x=0; x <=notas ; x++) { 	
												personaljs.splice(x,1);		
												$(".nota"+(x+1)+cant).append(" "+personaljs+" ");				
												personaljs = "'.$personal.'".split(",");
												personaljs.pop();
											}								
									</script>
								</div>
							</td>
						</tr>';
						$cant++;
					}
					mysqli_free_result($numCom2);
				
				echo'
				</table>
				<script>
					$("#restaurar").tablePagination({});
					$.expr[":"].Contains = function(x, y, z){
					    return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
					};
				</script>
			</div>
			
		</div>
	</div>
	';
	if(substr($_SESSION["Permisos_Eneaware"][3],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][3],1,1)=="0"){
		echo "<script>$('#principalInner [permiso=D]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][3],2,1)=="0"){
		echo "
			<script>
				$('#principalInner form[permiso=M] input').prop('disabled', true);
				$('#principalInner form[permiso=M] select').prop('disabled', true);
				$('#principalInner form[permiso=M] button').remove();
			</script>";
	}
	mysqli_close($conexion);
?>