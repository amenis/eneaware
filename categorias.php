<?php
	include("conexion.php");
	$lugar = mysqli_query($conexion, "SELECT * FROM Lugar WHERE id_lugar = 1");
	$datosL = mysqli_fetch_array($lugar);
	if(file_exists("imagenes/background.png")){
											$imagenTmpl='background.png';
										}
										else{
											if(file_exists("imagenes/background.jpg")){
												$imagenTmpl='background.jpg';
											}
											else{
												if(file_exists("imagenes/background.gif")){
													$imagenTmpl='background.gif';
												}
												else {
													if(file_exists("imagenes/background.svg")){
														$imagenTmpl='background.svg';
													}
													else {
														$imagenTmpl="wallpaper.jpg";
													}
												}
											}
										}
	echo '
	<div style="overflow:auto;height:100%">
		<h1>Administrar categorias</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" mostrar="registrarCat">Registrar categoria</button>
		<button class="tab" style="border-bottom:none;" mostrar="modificarCat">Modificar categorias</button>
		<button class="tab"  style="border-bottom:none;" mostrar="reactivarCat">Reactivar categorias</button><br>
		<div style="background:rgba(255,255,255,0.6);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			<div id="registrarCat" class="tabCont">
				<h2>Registrar categorias</h2>
				<form destino="resultadoRegistro" action="accionesCat.php">
					<input type="hidden" name="accion" value="registrar">
					<table>
						<tr>
							<td style="width:150px">Nombre</td>
							<td><input type="text" name="nombre" placeholder="Ejemplo: Cafeteria" required onkeyup="$(\'#nombreCatPrevio\').text($(this).val())"></td>
						</tr>
						<tr>
							<td>Descripcion</td>
							<td><textarea placeholder="descripcion" name="descripcion" cols="50" rows="6" onkeyup="$(\'#descripcionCatPrevio\').text($(this).val())"></textarea></td>
						</tr>
						<tr>
							<td>Icono</td>
							<td>
								<img src="imagenes/categorias/disable.jpg" onclick="$(this).next().next().trigger(\'click\')" style="border-radius:4px;border:2px solid grey;width:250px"><br>
								<input type="file" accept=".jpg, .png, .gif, .svg" otroPrevio="iconoCatPrevio" nombre="icono"><br><small>Se recomienda una imagen mediana (400px)</small><br><br>
							</td>
						</tr>
						<tr>
							<td>Imagen</td>
							<td>
								<img src="imagenes/categorias/disable.jpg" onclick="$(this).next().next().trigger(\'click\')" style="border-radius:4px;border:2px solid grey;width:250px"><br>
								<input type="file" accept=".jpg, .png, .gif, .svg" otroprevio="imagenCatPrevio" nombre="imagen"><br><small>Se recomienda una imagen mediana (800px)</small><br><br>
							</td>
						</tr>
						<tr>
							<td>Estado</td>
							<td>
								<select name="estado">
									<option value="activo">Activa (accesible)</option>
									<option value="inactivo">Inactiva (inaccesible)</option>
								</select>
							</td>
						</tr>
					</table>
					<center>
						<div style="position:relative">
							<img src="imagenes/tablet.png" style="width:80%">
							<div style="position:absolute;top:13.5%;left:17.5%;width:66%;height:71%;background:white;overflow:hidden">
								<img src="imagenes/'.$imagenTmpl.'" style="position:absolute;top:0;left:0">
								<img src="imagenes/lugarP1.png" style="width:100%;height:8%;position:absolute;top:0;left:0">
								<div style="font-size:11pt;text-align:center;position:absolute;top:9px;left:0;width:100%">Bienvenido a '.$datosL["nombre"].'</div>
								<img src="imagenes/catP1.png" style="position:absolute;top:15%;left:10%;width:80%">
								<span id="nombreCatPrevio" style="font-size:10pt;position:absolute;top:20%;left:14%;color:white"></span>
								<div style="opacity:0.8;border-radius:8px;position:absolute;top:17%;left:41.5%;width:47.5%;height:70%;font-size:10pt;color:white;text-shadow:0 0 5px black,0 0 50px black,0 0 50px black,0 0 25px black,0 0 10px black, 0 0 100px black;overflow:hidden;">
									<img id="imagenCatPrevio">
								</div>
								<div style="border-radius:8px;position:absolute;top:17%;left:41.5%;width:53.5%;height:75.5%;font-size:10pt;color:white;text-shadow:0 0 10px black;overflow-x:hidden;overflow-y:scroll">
									<img style="width:90%" id="iconoCatPrevio"><br>
									<div id="descripcionCatPrevio"></div>
								</div>
								<div style="color:rgba(255,255,255,0.75);padding-top:7px;font-size:10pt">Vista previa</div>
							</div>
						</div> 
						<button class="guardar">Registrar categoria</button>
					</center>
				</form>
			</div>
			<div id="modificarCat" style="display:none;" class="tabCont">
				<h2>Modificar categorias</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" padre="modificarCat" placeholder="Buscar por nombre">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				<div style="border-bottom:1px solid rgba(0,0,0,0.2);width:95%;padding-left:20px;"></div>';
				$categorias = mysqli_query($conexion,"SELECT * FROM Categorias WHERE status='activo' ORDER BY nombre ASC");
				$numCat = mysqli_num_rows($categorias);
				$cat = 0;
				while($cat < $numCat) {
					$datosCat = mysqli_fetch_array($categorias);
					if(file_exists("imagenes/categorias/".$datosCat["id_categoria"].".png")){
						$imagenTmp=$datosCat["id_categoria"].'.png';
					}
					else{
						if(file_exists("imagenes/categorias/".$datosCat["id_categoria"].".jpg")){
							$imagenTmp=$datosCat["id_categoria"].'.jpg';
						}
						else{
							if(file_exists("imagenes/categorias/".$datosCat["id_categoria"].".gif")){
								$imagenTmp=$datosCat["id_categoria"].'.gif';
							}
							else {
								if(file_exists("imagenes/categorias/".$datosCat["id_categoria"].".svg")){
									$imagenTmp=$datosCat["id_categoria"].'.svg';
								}
								else {
									$imagenTmp="disable.jpg";
								}
							}
						}
					}
					if(file_exists("imagenes/iconoCat/".$datosCat["id_categoria"].".png")){
						$iconoTmp=$datosCat["id_categoria"].'.png';
					}
					else{
						if(file_exists("imagenes/iconoCat/".$datosCat["id_categoria"].".jpg")){
							$iconoTmp=$datosCat["id_categoria"].'.jpg';
						}
						else{
							if(file_exists("imagenes/iconoCat/".$datosCat["id_categoria"].".gif")){
								$iconoTmp=$datosCat["id_categoria"].'.gif';
							}
							else {
								if(file_exists("imagenes/iconoCat/".$datosCat["id_categoria"].".svg")){
									$iconoTmp=$datosCat["id_categoria"].'.svg';
								}
								else {
									$iconoTmp="disable.jpg";
								}
							}
						}
					}
					echo '
						<div nombre="'.strtolower($datosCat["nombre"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">
							<b>'.$datosCat["nombre"].'</b>
							<form destino="resultadoRegistro" action="accionesCat.php" id="editarCat'.$datosCat["id_categoria"].'" style="display:none">
								<input type="hidden" name="accion" value="editar">
								<input type="hidden" name="id" value="'.$datosCat["id_categoria"].'">
								<table>
									<tr>
										<td style="width:150px">Nombre</td>
										<td><input type="text" name="nombre" placeholder="Ejemplo: Cafeteria" required value="'.$datosCat["nombre"].'"></td>
									</tr>
									<tr>
										<td>Descripcion</td>
										<td><textarea placeholder="descripcion" name="descripcion" cols="50" rows="6">'.$datosCat["descripcion"].'</textarea></td>
									</tr>
									<tr>
										<td>Icono</td>
										<td><img src="imagenes/iconoCat/'.$iconoTmp.'" style="width:150px;float:left;margin-right:20px"><small></small><input type="file" accept=".jpg, .png, .gif, .svg" nombre="icono"><br><small>Se recomienda una imagen mediana (400px)</small><br><br></td>
									</tr>
									<tr>
										<td>Imagen</td>
										<td><img src="imagenes/categorias/'.$imagenTmp.'" style="width:150px;float:left;margin-right:20px"><small></small><input type="file" accept=".jpg, .png, .gif, .svg" nombre="imagen"><br><small>Se recomienda una imagen mediana (800px)</small><br><br></td>
									</tr>
								</table>
								<center><button class="guardar">Guardar cambios</button></center>
							</form>
							<div id="desCat'.$datosCat["id_categoria"].'" style="display:none">
								<form destino="resultadoRegistro" action="accionesCat.php" style="display:inline-block">
									<input type="hidden" name="accion" value="deshabilitar">
									<input type="hidden" name="id" value="'.$datosCat["id_categoria"].'">
									¿Estas seguro que deseas deshabilitar la categoria <b>'.$datosCat["nombre"].'</b>?
									<button >Si, estoy seguro</button>
								</form>
								<button style="display:inline-block" onclick="$(this).parent().toggle(\'drop\')">No</button>
								<p>Atencion: esta accion desactivara todas las subcategorias y productos/servicios que pertenescan a esta categoria</p>
							</div>
							<img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(\'#editarCat'.$datosCat["id_categoria"].'\').toggle(\'drop\')">
							<img src="imagenes/bin.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#desCat'.$datosCat["id_categoria"].'\').toggle(\'drop\')">
						</div>
					';
					$cat++;	
				}
				echo'
				<div style="height:20px;width:95%;padding-left:20px;"></div>
			</div>	
			<div id="reactivarCat" style="display:none;" class="tabCont">
				<h2>Reactivar categorias</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" padre="reactivarCat" placeholder="Buscar por nombre">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				<div style="border-bottom:1px solid rgba(0,0,0,0.2);width:95%;padding-left:20px;"></div>';
				$categorias = mysqli_query($conexion,"SELECT * FROM Categorias WHERE status='inactivo' ORDER BY nombre ASC");
				$numCat = mysqli_num_rows($categorias);
				$cat = 0;
				while($cat < $numCat) {
					$datosCat = mysqli_fetch_array($categorias);
					echo '
						<div nombre="'.strtolower($datosCat["nombre"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">
							<b>'.$datosCat["nombre"].'</b>							
							<div id="reactCat'.$datosCat["id_categoria"].'" style="display:none">
								<form destino="resultadoRegistro" action="accionesCat.php" style="display:inline-block">
									<input type="hidden" name="accion" value="reactivar">
									<input type="hidden" name="id" value="'.$datosCat["id_categoria"].'">
									¿Estas seguro que deseas reactivar la categoria <b>'.$datosCat["nombre"].'</b>?
									<button >Si, estoy seguro</button>
								</form>
								<button style="display:inline-block" onclick="$(this).parent().toggle(\'drop\')">No</button>
								<p>Atencion: esta accion reactivara todas las subcategorias y productos/servicios que pertenescan a esta categoria</p>
							</div>
							<img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#reactCat'.$datosCat["id_categoria"].'\').toggle(\'drop\')">
						</div>
					';
					$cat++;	
				}
				echo'
				<div style="height:20px;width:95%;padding-left:20px;"></div>
			</div>		
		</div>
	</div>
	';
	mysqli_close($conexion);
?>