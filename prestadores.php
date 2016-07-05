<script src="js/jquery.tablePagination.js" ></script>
<script src="js/jquery-ui.js"></script>
<?php
session_start();
include('conexion.php');
	echo '
	<div style="overflow:auto;height:100%">
		<h1>Prestadores de Servicio</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" mostrar="registroPres">Registro de Prestadores </button>
		<button class="tab"  style="border-bottom:none;" mostrar="modificar">Ver/Modificar Registros</button>
		<button class="tab"  style="border-bottom:none;" mostrar="RegBaja">Registros en Baja</button>
		
		<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			<div id="registroPres" class="tabCont">
				<h2>Registrar Prestadores de Servicio</h2>
				<form action="accionesPrestadores.php" destino="resultadoRegistro">
					<input type="hidden" name="accion" value="registrar"/>
					<table>
						<tr><td>Nombre</td><td><input type="text" name="nombre" /></td></tr>
						<tr><td>Telefono</td><td><input type="text" name="telefono"></td></tr>
						<tr><td>Email</td><td><input type="email" name="email"></td></tr>
						<tr><td>Institucion</td><td><input type="text" name="institucion" /></td></tr>
						<tr><td>Fecha de Inicio</td><td><input type="date" name="inicio"/></td></tr>
						<tr><td>Fecha de Termino</td><td><input type="date" name="term"></td></tr>
						<tr><td>Notas</td><td><textArea cols="35" rows="5" name="notas"></textArea></td></tr>
					</table>
					<center><button>Guardar</button></center>
				</form>
			</div>
			<div id="modificar" class="tabCont" style="display:none" >
				<h2>Ver y Modificar Registros</h2>
				<div  style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus padre="modPres" placeholder="Buscar por nombre">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				<table id="modPres" width="100%" >';
					$sql="SELECT * FROM Prestadores_servicios WHERE status=1";
					$cont=0;
					
					$prestadores= mysqli_query($conexion,$sql);
					$num_result = mysqli_num_rows($prestadores);
					

					while($cont < $num_result){
						$prest= mysqli_fetch_array($prestadores);
						echo'
						<tr class="modPres">
							<td>
								<span class="modPres_nombre" style="display:none">'.$prest['nombre'].'</span>
								<div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
									<b>'.$prest['nombre'].'</b>
									<div id="editPres'.$prest['id_prestador'].'" style="display:none">
										<form  action="accionesPrestadores.php" destino="resultadoRegistro">
											<input type="hidden" name="accion" value="modificar"/>
											<input type="hidden" name="id" value="'.$prest['id_prestador'].'"/>
											<table>
												<tr><td>Nombre</td><td><input type="text" name="nombre" value="'.$prest['nombre'].'"/></td></tr>
												<tr><td>Telefono</td><td><input type="text" name="telefono" value="'.$prest['telefono'].'"></td></tr>
												<tr><td>Email</td><td><input type="email" name="email" value="'.$prest['email'].'"/></td></tr>
												<tr><td>Institucion</td><td><input type="text" name="institucion" value="'.$prest['institucion'].'"/></td></tr>
												<tr><td>Fecha de Inicio</td><td><input type="date" name="inicio" value="'.$prest['fecha_inicio'].'"/></td></tr>
												<tr><td>Fecha de Termino</td><td><input type="date" name="term" value="'.$prest['fecha_final'].'"></td></tr>
												<tr><td>Notas</td><td><textArea cols="35" rows="5" name="notas" >'.$prest['notas'].'</textArea></td></tr>
											</table>
											<center><button>Guardar</button></center>
										</form>							
									</div>
									<form id="eli'.$prest['id_prestador'].'" action="accionesPrestadores.php" destino="resultadoRegistro" style="display:none">
										<input type="hidden" name="accion" value="eliminar"/>
										<input type="hidden" name="id" value="'.$prest['id_prestador'].'"/>

										Estas seguro que deseas dar de baja al prestador '.$prest['nombre'].'
										<button>Si</button>
										<button onclick="$(this).parent().toggle(\'drop\');return false" >No</button>
									</form>
									<img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(\'#editPres'.$prest["id_prestador"].'\').toggle(\'drop\')"/>
									<img src="imagenes/bin.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#eli'.$prest["id_prestador"].'\').toggle(\'drop\')"/>

								</div>
							</td>';

						$cont++;
					}
					
					mysqli_free_result($prestadores);
	 							
				
					echo'
					
					 <script>
                        $("#modPres").tablePagination({});
                         $.expr[":"].Contains = function(x, y, z){
                            return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
                          };
                                    
                    </script>
					
				</table>
			</div>
			<div id="RegBaja" class="tabCont" style="display:none">
				<h2>Registros en Baja</h2>
				<div  style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus padre="regBaja1" placeholder="Buscar por nombre">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				<table id="regBaja1" width="100%" >';
					$sql="SELECT * FROM Prestadores_servicios WHERE status=0";
									
					$cont=0;
					$prestadores2 = mysqli_query($conexion,$sql);
					$num_result = mysqli_num_rows($prestadores2);
				

					while($cont < $num_result){
						$prest= mysqli_fetch_array($prestadores2);
						echo'
						<tr class="regBaja1">
							<td>
								<span class="regBaja1_nombre" style="display:none">'.$prest['nombre'].'</span>
								<div  style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
									<b>'.$prest['nombre'].'</b>
									<form id="rest'.$prest['id_prestador'].'" action="accionesPrestadores.php" destino="resultadoRegistro" style="display:none">
										<input type="hidden" name="accion" value="restaurar"/>
										<input type="hidden" name="id" value="'.$prest['id_prestador'].'"/>
										Estas seguro que deseas restaurar al prestador '.$prest['nombre'].'
										<button>Si</button>
										<button onclick="$(this).parent().toggle(\'drop\');return false" >No</button>
									</form>
									<img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#rest'.$prest["id_prestador"].'\').toggle(\'drop\')"/>

								</div>
							</td>
						</tr>';

						$cont++;
					}
				echo'	
				</table>
			</div>
			<script>
                $("#regBaja1").tablePagination({});
                $.expr[":"].Contains = function(x, y, z){
                    return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
                };
                                    
            </script>
		</div>
	</div>
	';
?>