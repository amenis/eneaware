<?php
	include("conexion.php");
	echo '
	<div style="overflow:auto;height:100%">
		<h1>Administrar productos/servicios</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" mostrar="registrarProd">Registrar producto/servicio</button>
		<button class="tab" style="border-bottom:none;" mostrar="modificarProd">Modificar productos/servicios</button>
		<button class="tab"  style="border-bottom:none;" mostrar="reactivarProd">Reactivar productos/servicios</button><br>
		<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			<div id="registrarProd" class="tabCont">
				<h2>Registrar productos/servicios</h2>
				<form destino="resultadoRegistro" action="accionesProd.php">
					<input type="hidden" name="accion" value="registrar">
					<table>
						<tr>
							<td style="width:150px">Nombre </td>
							<td><input type="text" name="nombre" placeholder="Ejemplo: Espresso" required onkeyup="$(\'#nombreProdPrevio\').text($(this).val())"></td>
						</tr>
						<tr>
							<td>Subcategoria</td>
							<td>
								<select required name="subcategoria" ind="regProdPI" col="regProdPC" onchange="verNombresPrecios($(this));arr = $(this).find(\':selected\').text().split(\'(\');$(\'#nombreSubCatProdPrevio\').text(arr[0]);$(\'#imagenSubProdPrevio\').attr(\'src\', \'imagenes/subcategorias/\'+$(this).find(\':selected\').attr(\'imagen\'))">
									<option value="" ind="precio individual" col="precio colectivo" imagen="wallpaper.jpg">Selecciona</option>';
									$subcategorias = mysqli_query($conexion, "SELECT * FROM Subcategorias WHERE status='activo' ORDER BY nombre ASC");
									$numSubCat = mysqli_num_rows($subcategorias);
									$subcat = 0;
									while($subcat<$numSubCat){
										$datosSubCat=mysqli_fetch_array($subcategorias);
										$categoriaP = mysqli_query($conexion, "SELECT nombre FROM Categorias WHERE id_categoria=".$datosSubCat["id_categoria"]);
										$arrP = mysqli_fetch_array($categoriaP);
										if(file_exists("imagenes/subcategorias/".$datosSubCat["id_subcategoria"].".png")){
											$imagenTmp=$datosSubCat["id_subcategoria"].'.png';
										}
										else{
											if(file_exists("imagenes/subcategorias/".$datosSubCat["id_subcategoria"].".jpg")){
												$imagenTmp=$datosSubCat["id_subcategoria"].'.jpg';
											}
											else{
												if(file_exists("imagenes/subcategorias/".$datosSubCat["id_subcategoria"].".gif")){
													$imagenTmp=$datosSubCat["id_subcategoria"].'.gif';
												}
												else {
													if(file_exists("imagenes/subcategorias/".$datosSubCat["id_subcategoria"].".svg")){
														$imagenTmp=$datosSubCat["id_subcategoria"].'.svg';
													}
													else {
														$imagenTmp="wallpaper.jpg";
													}
												}
											}
										}
										echo '<option imagen="'.$imagenTmp.'" ind="'.$datosSubCat["nombre_precio_ind"].'" col="'.$datosSubCat["nombre_precio_col"].'" value="'.$datosSubCat["id_subcategoria"].'">'.$datosSubCat["nombre"].' ('.$arrP[0].')</option>';
										$subcat++;
										mysqli_free_result($categoriaP);
									}
									mysqli_free_result($subcategorias);
									echo'
								</select>
							</td>
						</tr>
						<tr>
							<td>Precio 1 <div id="regProdPI">(precio individual)</div></td>
							<td><input type="number" step="any" name="ind" placeholder="Ejemplo: 50"></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td>Precio 2 <div id="regProdPC">(nombre colectivo)</div></td>
							<td><input type="number" step="any" name="col" placeholder="Ejemplo: 150">Si el producto solo tiene un precio, deja el precio 2 vacio o en 0</td>
						</tr>
						<tr>
							<td>Imagen</td>
							<td>
								<img src="imagenes/productos/disable.jpg" onclick="$(this).next().next().trigger(\'click\')" style="border-radius:4px;border:2px solid grey;width:250px"><br>
								<input otroPrevio="imagenProdPrevia" onchange="imagenPrevia(\'fileProd\',\'previoProd\')" id="fileProd" type="file" accept=".jpg, .png, .gif, .svg" nombre="imagen"><br><small>Se recomienda una imagen grande (1024px+)</small><br><br>
							</td>
						</tr>
						<tr>
							<td>Descripcion:</td>
							<td><textarea placeholder="Ejemplo: Cafe colombiano" cols="50" rows="5" name="descripcion" onkeyup="$(\'#descripcionProdPrevio\').text($(this).val())"></textarea></td>
						</tr>
						<tr>
							<td>Estado</td>
							<td>
								<select name="estado">
									<option value="activo">Activo (accesible)</option>
									<option value="inactivo">Inactivo (inaccesible)</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Variaciones</td>
							<td>
								<input type="number" id="numeroVar" value="0" style="display:none">
								<table></table>
								<button style="position:relative;padding-left:38px" onclick="$(\'#numeroVar\').val(parseInt($(\'#numeroVar\').val())+1);$(this).prev().append(\'<tr><td>Nombre:</td><td><input type=text name=nombre\'+$(\'#numeroVar\').val()+\' placeholder=Ejemplo:Chocolate></td><td>Descripcion:</td><td><input type=text name=descripcion\'+$(\'#numeroVar\').val()+\' placeholder=Ejemplo:Creado_con_el_mejor_chocolate></td><td><img src=imagenes/bin.png onclick=$(this).parent().parent().remove()></td></tr>\');return false;"><img src="imagenes/plus.png" style="position:absolute;top:5px;left:8px">Agregar variacion</button>
							</td>
						</tr>
					</table>
					<center>
						<div style="position:relative">
							<img src="imagenes/tablet.png" style="width:80%">
							<div style="position:absolute;top:13.5%;left:17.5%;width:66%;height:71%;background:white;overflow:hidden">
								<img id="imagenSubProdPrevio" src="imagenes/subcategorias/wallpaper.jpg" style="position:absolute;top:0;left:0">
								<img src="imagenes/previoSub1.png" style="width:100%;position:absolute;top:0;left:0">
								<img src="imagenes/previoSub2.png" style="width:100%;position:absolute;bottom:0;left:0">
								<span id="nombreSubCatProdPrevio" style="font-size:10pt;position:absolute;top:5px;left:45%;color:black"></span>
								<div style="text-align:left;color:white;font-size:10pt;border-radius:8px;position:absolute;top:10%;left:15%;width:70%;height:80%;background:url(imagenes/diagonales.png) rgba(14,14,14,0.6);overflow:hidden">
									<img id="imagenProdPrevia" style="position:relarive;top:10%;left:10px;width:40%;margin:5%;" src="imagenes/productos/disable.jpg" align="left"><br><b id="nombreProdPrevio">Nombre del producto</b><br><br>
									<span id="descripcionProdPrevio">Descripcion del producto/servicio</span>
									<img src="imagenes/previoSub3.png" style="position:absolute;bottom:0;left:0;width:100%;border-radius:0 0 8px 8px">
								</div>
							</div>
							<div style="position:absolute;bottom:10%;left:48%;color:rgba(255,255,255,0.75);font-size:10pt">Vista previa</div>
						</div> 
						<button class="guardar">Registrar producto/servicio</button>
					</center>
				</form>
			</div>
			<div id="modificarProd" style="display:none;" class="tabCont">
				<h2>Modificar Productos</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" padre="modificarProd" placeholder="Buscar por nombre">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				<div style="border-bottom:1px solid rgba(0,0,0,0.2);width:95%;padding-left:20px;"></div>';
				$productos = mysqli_query($conexion, "SELECT * FROM Productos WHERE status='activo' ORDER BY id_subcategoria ASC, nombre ASC");
				$numProd = mysqli_num_rows($productos);
				$prods = 0;				
				while($prods < $numProd) {
					$datosProd = mysqli_fetch_array($productos);
					$subcatPadre = mysqli_query($conexion,"SELECT * FROM Subcategorias WHERE id_subcategoria=".$datosProd["id_subcategoria"]);
					$datosSCatP = mysqli_fetch_array($subcatPadre);
					if(file_exists("imagenes/productos/".$datosProd["id_producto"].".png")){
						$imagenTmp1=$datosProd["id_producto"].'.png';
					}
					else{
						if(file_exists("imagenes/productos/".$datosProd["id_producto"].".jpg")){
							$imagenTmp1=$datosProd["id_producto"].'.jpg';
						}
						else{
							if(file_exists("imagenes/productos/".$datosProd["id_producto"].".gif")){
								$imagenTmp1=$datosProd["id_producto"].'.gif';
							}
							else {
								if(file_exists("imagenes/productos/".$datosProd["id_producto"].".svg")){
									$imagenTmp1=$datosProd["id_producto"].'.svg';
								}
								else {
									$imagenTmp1="disable.jpg";
								}
							}
						}
					}
					echo '
						<div nombre="'.strtolower($datosProd["nombre"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">
							<div class="guardar" title="modificar subcategoria superior" onclick="foreignTab(\'subCategorias\',\'modificarSubCat\',\'#editarSCat'.$datosProd["id_subcategoria"].'\')" style="padding:10px;position:absolute;top:0;left:0;width:100px;display:inline-block">'.$datosSCatP["nombre"].'</div>
							<b style="position:relative;top:0;left:140px;">'.$datosProd["nombre"].'</b>
							<form destino="resultadoRegistro" action="accionesProd.php" id="editarProd'.$datosProd["id_producto"].'" style="display:none;">
								<input type="hidden" name="accion" value="editar">
								<input type="hidden" name="id" value="'.$datosProd["id_producto"].'">
								<br><br>
								<table>
									<tr>
										<td style="width:150px">Nombre </td>
										<td><input type="text" name="nombre" placeholder="Ejemplo: Espresso" required value="'.$datosProd["nombre"].'"></td>
									</tr>
									<tr>
										<td>Subcategoria</td>
										<td>
											<select required name="subcategoria" ind="regProdPI'.$datosProd["id_producto"].'" col="regProdPC'.$datosProd["id_producto"].'" onchange="verNombresPrecios($(this));">
												<option value="" ind="precio individual" col="precio colectivo">Selecciona</option>';
												$subcategorias = mysqli_query($conexion, "SELECT * FROM Subcategorias WHERE status='activo' ORDER BY nombre ASC");
												$numSubCat = mysqli_num_rows($subcategorias);
												$subcat = 0;
												while($subcat<$numSubCat){
													$datosSubCat=mysqli_fetch_array($subcategorias);
													$categoriaP = mysqli_query($conexion, "SELECT nombre FROM Categorias WHERE id_categoria=".$datosSubCat["id_categoria"]);
													$arrP = mysqli_fetch_array($categoriaP);
													if($datosSubCat["id_subcategoria"]==$datosProd["id_subcategoria"]){
														echo '<option selected ind="'.$datosSubCat["nombre_precio_ind"].'" col="'.$datosSubCat["nombre_precio_col"].'" value="'.$datosSubCat["id_subcategoria"].'">'.$datosSubCat["nombre"].' ('.$arrP[0].')</option>';
													}
													echo '<option imagen="'.$imagenTmp.'" ind="'.$datosSubCat["nombre_precio_ind"].'" col="'.$datosSubCat["nombre_precio_col"].'" value="'.$datosSubCat["id_subcategoria"].'">'.$datosSubCat["nombre"].' ('.$arrP[0].')</option>';
													$subcat++;
													mysqli_free_result($categoriaP);
												}
												mysqli_free_result($subcategorias);
												echo'
											</select>
										</td>
									</tr>
									<tr>
										<td>Precio 1 <div id="regProdPI'.$datosProd["id_producto"].'">(precio '.$datosSCatP["nombre_precio_ind"].')</div></td>
										<td><input type="number" step="any" name="ind" placeholder="Ejemplo: 50" value="'.$datosProd["precio_individual"].'"></td>
									</tr>
									<tr>
										<td></td>
									</tr>';
									if($datosProd["precio_colectivo"]!="0") {
										echo'
										<tr>
											<td>Precio 2 <div id="regProdPC'.$datosProd["id_producto"].'">(nombre '.$datosSCatP["nombre_precio_col"].')</div></td>
											<td><input type="number" step="any" name="col" placeholder="Ejemplo: 150" value="'.$datosProd["precio_colectivo"].'"> Si el producto solo tiene un precio, deja el precio 2 vacio o en 0</td>
										</tr>';
									}
									echo '
									<tr>
										<td>Imagen</td>
										<td>
											<img src="imagenes/productos/'.$imagenTmp1.'" onclick="$(this).next().next().trigger(\'click\')" style="border-radius:4px;border:2px solid grey;width:250px"><br>
											<input otroPrevio="imagenProdPrevia" onchange="imagenPrevia(\'fileProd\',\'previoProd\')" id="fileProd" type="file" accept=".jpg, .png, .gif, .svg" nombre="imagen"><br><small>Se recomienda una imagen grande (1024px+)</small><br><br>
										</td>
									</tr>
									<tr>
										<td>Descripcion:</td>
										<td><textarea placeholder="Ejemplo: Cafe colombiano" cols="50" rows="5" name="descripcion" onkeyup="$(\'#descripcionProdPrevio\').text($(this).val())">'.$datosProd["descripcion"].'</textarea></td>
									</tr>
									<tr>
										<td>Variaciones</td>
										<td>
											<table>';
											$variaciones = mysqli_query($conexion, "SELECT * FROM Variantes WHERE id_producto=".$datosProd["id_producto"]);
											$numV = mysqli_num_rows($variaciones);
											$num = 0;
											$maxSql = mysqli_query($conexion, "SELECT MAX(id_variante) FROM Variantes WHERE id_producto=".$datosProd["id_producto"]);
											$arrMax = mysqli_fetch_array($maxSql);
											echo '<input type="number" id="numeroVar'.$datosProd["id_producto"].'" value="'.$arrMax[0].'" >';
											while($num < $numV) {
												$datosVar = mysqli_fetch_array($variaciones);
												echo '
													<tr>
														<td>Nombre: </td><td><input type="text" name="nombre'.$datosVar["id_variante"].'" value="'.$datosVar["nombre"].'"></td>
														<td>Descripcion: </td><td><input type="text" name="descripcion'.$datosVar["id_variante"].'" value="'.$datosVar["descripcion"].'"></td>
														<td><img src="imagenes/bin.png" onclick="$(this).parent().parent().remove()"> </td>
													</tr>
												';
												$num++;
											}
											echo'
											</table>
											<button style="position:relative;padding-left:38px" onclick="$(\'#numeroVar'.$datosProd["id_producto"].'\').val(parseInt($(\'#numeroVar'.$datosProd["id_producto"].'\').val())+1);$(this).prev().append(\'<tr><td>Nombre:</td><td><input type=text name=nombre\'+$(\'#numeroVar'.$datosProd["id_producto"].'\').val()+\' placeholder=Ejemplo:Chocolate></td><td>Descripcion:</td><td><input type=text name=descripcion\'+$(\'#numeroVar'.$datosProd["id_producto"].'\').val()+\' placeholder=Ejemplo:Creado_con_el_mejor_chocolate></td><td><img src=imagenes/bin.png onclick=$(this).parent().parent().remove()></td></tr>\');return false;"><img src="imagenes/plus.png" style="position:absolute;top:5px;left:8px">Agregar variacion</button>
										</td>
									</tr>
								</table>
								<center><button class="guardar">Guardar cambios</button></center>
							</form>
							<div id="desProd'.$datosProd["id_producto"].'" style="display:none">
								<form destino="resultadoRegistro" action="accionesProd.php" style="display:inline-block">
									<input type="hidden" name="accion" value="deshabilitar">
									<input type="hidden" name="id" value="'.$datosProd["id_producto"].'">
									<br>¿Estas seguro que deseas deshabilitar el producto <b>'.$datosProd["nombre"].'</b>?
									<button >Si, estoy seguro</button>
								</form>
								<button style="display:inline-block" onclick="$(this).parent().toggle(\'drop\')">No</button>
								<p>Atencion: esta accion desactivara todos los productos/servicios que pertenescan a esta subcategoria</p>
							</div>
							<img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(\'#editarProd'.$datosProd["id_producto"].'\').toggle(\'drop\')">
							<img src="imagenes/bin.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#desProd'.$datosProd["id_producto"].'\').toggle(\'drop\')">
						</div>
					';
					$prods++;	
				}
				mysqli_free_result($productos);
				echo'
				<div style="height:20px;width:95%;padding-left:20px;"></div>
			</div>	
			<div id="reactivarProd" style="display:none;" class="tabCont">
				<h2>Reactivar productos / servicios</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" padre="reactivarProd" placeholder="Buscar por nombre">
					<img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
				</div>
				<div style="border-bottom:1px solid rgba(0,0,0,0.2);width:95%;padding-left:20px;"></div>';
				$productos = mysqli_query($conexion, "SELECT * FROM Productos WHERE status='inactivo'");
				$numProd = mysqli_num_rows($productos);
				$prods= 0;
				while($prods < $numProd) {
					$datosProd= mysqli_fetch_array($productos);
					echo '
						<div nombre="'.strtolower($datosProd["nombre"]).'" tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none">
							<b>'.$datosProd["nombre"].'</b>
							<div id="reactProd'.$datosProd["id_producto"].'" style="display:none">
								<form destino="resultadoRegistro" action="accionesProd.php" style="display:inline-block">
									<input type="hidden" name="accion" value="reactivar">
									<input type="hidden" name="id" value="'.$datosProd["id_producto"].'">
									¿Estas seguro que deseas reactivar el producto / servicio <b>'.$datosProd["nombre"].'</b>?
									<button >Si, estoy seguro</button>
								</form>
								<button style="display:inline-block" onclick="$(this).parent().toggle(\'drop\')">No</button>
								<p>Atencion: esta accion reactivara todos los productos/servicios que pertenescan a esta subcategoria</p>
							</div>
							<img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'#reactProd'.$datosProd["id_producto"].'\').toggle(\'drop\')">
						</div>
					';
					$prods++;	
				}
				echo'
				<div style="height:20px;width:95%;padding-left:20px;"></div>
			</div>		
		</div>
	</div>
	';
	mysqli_close($conexion);
?>