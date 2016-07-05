<script src="js/jquery.tablePagination.js" ></script>
<script src="js/jquery-ui.js"></script>
<script src="js/printThis.js"></script>
<?php
	session_start();
	include("conexion.php");
	echo '
	<div style="overflow:auto;height:100%">
		<meta charset="utf-8">
		<h1>Administración del comisiones del personal</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="registrarComision">Registrar comisiones</button>
		<button class="tab" style="border-bottom:none;" mostrar="modificarComision">Ver comisiones del personal</button>
		<button class="tab" style="border-bottom:none;" mostrar="restaurarComision">Restaurar comisiones de personal</button>
		<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			<div id="registrarComision" class="tabCont" permiso="A">
				<h2>Registrar comisiones</h2>
				<form action="accionesComision.php"  destino="resultadoRegistro" style="width:95%;">
					<input type="hidden" name="accion" value="registro"> 
					<input type="hidden" name="notas" id="notasCom">
					<div style="font-family:Arial;margin:auto;padding:2cm;background:white;width:17.5cm;border:1px solid grey; height:24cm">';
						$comision = mysqli_query($conexion, "SELECT MAX(id_comision) FROM Comisiones");
						$arrCom = mysqli_fetch_row($comision);
						mysqli_free_result($comision);
						echo '
						<div style="width:100%;text-align:right">Comisión No: '.($arrCom[0]+1).'</div><br>
						Selecicona personal: 
						<select>';
							$personal = mysqli_query($conexion, "SELECT * FROM Usuarios WHERE status=1");
							while($datosU = mysqli_fetch_assoc($personal)) {								
								echo '<option nombramiento="'.$datosU["funcion"].'" value="'.$datosU["id_usuario"].'">'.$datosU["apellidoP"].' '.$datosU["apellidoM"].' '.$datosU["nombre"]."</option>";
							}
							mysqli_free_result($personal);
						echo';
						</select>
						<button onclick="agregarUCom($(this));return false">Agregar</button>
						<div style="padding:5px"></div>
						<div contenteditable id="encabezadoCom" style="font-weight:bold;text-align:width:100%; border:1px dashed grey;"></div>
						<b>PRESENTE.-</b><br><br>
						Fecha de inicio <input type="date" name="fecha_inicio" required onchange="$(\'#fechaICom\').text($(this).val())">
						Fecha de finalizacion <input type="date" name="fecha_fin" required onchange="$(\'#fechaFCom\').text($(this).val())">
						<div contenteditable id="contCom" style="width:100%;text-align:justify;border:1px dashed grey;line-height:150%">
							
							
　　　　					La que suscribe, Directora de la Escuela Normal para Educadoras de Arandas, 
							le <b>comisiona</b> asistir a _<b style="color:blue">{ACTIVIDAD}</b>_ con el fin de _<b style="color:blue">{PPROPOSITO}</b>_, que habrá de celebrarse 
							las fecha <span id="fechaICom">_<b style="color:blue">{FECHA DE INICIO}</b>_</span>  al <span id="fechaFCom">_<b style="color:blue">{FECHA DE FINALIZACION}</b>_</span> en el horario _<b style="color:blue">{HORARIO}</b>_
							en _<b style="color:blue">{LUGAR}</b>_, el nombre 
							de la sede se confirmará en los próximos días, es importante que asistan con _<b style="color:blue">{ARTICULOS}</b>_.<br><br>
							
　　　　					Conociendo el compromiso que le caracteriza para con esta Escuela, le deseo el mejor de los éxitos 
							en la presente comisión, y le solicitó hacer llegar los comprobantes fiscales un día después del término de su comisión.<br><br>　　　　　

							<div style="text-align:center">';
								$director = mysqli_query($conexion,"SELECT * FROM Direccion");
								$datoName = mysqli_fetch_assoc($director);
								mysqli_free_result($director);
								echo'
								ATENTAMENTE<br>
								<b>“'.date("Y").', '.$datoName['frase_celebre'].'”<br>
								Arandas, Jal. '.date("d/m/Y").'
								<b>	<br><br><br>	
								<br>
								DIRECTORA<br>
								'.$datoName['nombre_direc'].'
							</div>
						
						</div>
					</div>
					<center><button onclick="$(\'#notasCom\').val(\'<b>\'+$(\'#encabezadoCom\').html()+\'PRESENTE.-</b><br><br><br>\'+$(\'#contCom\').html())">Guardar</button></center>
				</form>
			</div>
			<div id="modificarComision" style="display:none;" class="tabCont" permiso="M">
				<h2>Ver comisiones</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus id="name" padre="verCom" placeholder="Buscar por numero">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				<div style="border-bottom:1px solid rgba(0,0,0,0.2);width:95%;padding-left:20px;"></div>
					<table id="verCom" style="width:100%">';
						$comisiones = mysqli_query($conexion, "SELECT * FROM Comisiones WHERE status=1");
						while($datosCom = mysqli_fetch_assoc($comisiones)) {
							echo '
							<tr class="verCom">
								<td>
									<span class="verCom_nombre" style="display:none">'.$datosCom["id_comision"].'</span>
									<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">
										# De comision: '.$datosCom["id_comision"].'
										<form action="accionesComision.php" destino="resultadoRegistro" style="display:none" id="desComision'.$datosCom["id_comision"].'">
											<input type="hidden" name="accion" value="deshabilitar">
											<input type="hidden" name="id_comision" value="'.$datosCom["id_comision"].'">
											<button>Si, Cancelar</button><button onclick="$(this).parent().hide(\'drop\');return false">No</button>
										</form>
										<div id="verComision'.$datosCom["id_comision"].'" style="display:none">
											<button onclick="este =$(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();"><img src="imagenes/print.png"/></button>
											<div style="border:1px solid grey;font-weight:normal;font-family:Arial;margin:auto;padding:2cm;background:white;width:18cm; height:24cm">
												<div style="width:100%;text-align:right">Comisión No: '.$datosCom["id_comision"].'</div><br>
												<div style="text-align:justify">'.$datosCom["notas"].'</div>
											</div>
										</div>
										<img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(\'#verComision'.$datosCom["id_comision"].'\').toggle(\'drop\')">
										<img src="imagenes/bin.png" permiso="D" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#desComision'.$datosCom["id_comision"].'\').toggle(\'drop\')">
									</div>
								</td>
							</tr>';
						}
				echo'	
					</table>
					<script>
						$("#verCom").tablePagination({});
						$.expr[":"].Contains = function(x, y, z){
						    return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
						};
					</script>			
			</div>
			<div id="restaurarComision" style="display:none;" class="tabCont">
				<h2>Restaurar comisiones</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus id="name" padre="restaurar" placeholder="Buscar por numero">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				<div style="border-bottom:1px solid rgba(0,0,0,0.2);width:95%;padding-left:20px;"></div>
				<table id="restaurar" width="100%">';
					$comisiones = mysqli_query($conexion, "SELECT * FROM Comisiones WHERE status=0");
					while($datosCom = mysqli_fetch_assoc($comisiones)) {
						echo '
						<tr class="restaurar">
							<td>
								<span class="restaurar_nombre" style="display:none">'.$datosCom["id_comision"].'</span>
								<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">
									# De comision: '.$datosCom["id_comision"].'
									<form action="accionesComision.php" destino="resultadoRegistro" style="display:none" id="resComision'.$datosCom["id_comision"].'">
										<input type="hidden" name="accion" value="restaurar">
										<input type="hidden" name="id_comision" value="'.$datosCom["id_comision"].'">
										Seguro que deseas reactivar?<button>Si, reactivar</button><button onclick="$(this).parent().hide(\'drop\');return false">No</button>
									</form>
									<div id="verComisionD'.$datosCom["id_comision"].'" style="display:none">
										<button onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir</button>
										<div style="border:1px solid grey;font-weight:normal;font-family:Arial;margin:auto;padding:2cm;background:white;width:18cm; height:24cm">
											<div style="width:100%;text-align:right">Comisión No: '.$datosCom["id_comision"].'</div><br>
											<div style="text-align:justify;position:relative">'.$datosCom["notas"].'</div>
										</div>
									</div>
									<img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(\'#verComisionD'.$datosCom["id_comision"].'\').toggle(\'drop\')">
									<img src="imagenes/checkmark.png" permiso="D" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#resComision'.$datosCom["id_comision"].'\').toggle(\'drop\')">
								</div>
							</td>
						</tr>';
					}
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
	if(substr($_SESSION["Permisos_Eneaware"][2],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][2],1,1)=="0"){
		echo "<script>$('#principalInner [permiso=D]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][2],2,1)=="0"){
		echo "
			<script>
				$('#principalInner form[permiso=M] input').prop('disabled', true);
				$('#principalInner form[permiso=M] select').prop('disabled', true);
				$('#principalInner form[permiso=M] button').remove();
			</script>";
	}
	mysqli_close($conexion);
?>