<?php
    session_start();
    //include("conexion.php");
    //include_once('funciones.php');
?>


    
	
	<div style="padding-left:20px;">
		<h1>Administración del personal ENEA</h1>
        <ul class="nav nav-tabs">
          <li class="active" permiso="A"><a data-toggle="tab" href="#registrarPer" >Registrar Personal</a></li>
          <li><a data-toggle="tab" href="#modificarPer">Ver y Modificar</a></li>
          <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
        </ul>
        <!--
		<button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="registrarPer">Registrar personal</button>
		<button class="tab" style="border-bottom:none;" mostrar="modificarPer">Ver / Modificar informacion del personal</button>
		<button class="tab" style="border-bottom:none;" mostrar="DatosDir">Datos Direct@r</button>
		<button class="tab" style="border-bottom:none;" mostrar="documentosPer">Documentos digitales</button>
		<button class="tab" style="border-bottom:none;" mostrar="restaurarPer"  >Restaurar personal</button> -->
		
		<div style="height:100%;background:rgba(255,255,255,0.65);border-left:1px solid rgba(0,0,0,0.2);">
			<div id="registrarPer" class="tabCont" permiso="A">
				<h2>Registro del  personal</h2>
				<form destino="resultadoRegistro" action="accionesPersonal.php" role="form" class="form-horizontal">
				
					<img style="cursor:pointer;position:fixed;top:150px;right:5%;border-radius:4px;border:2px solid grey;width:15%" src="imagenes/user.gif" onclick="$(this).next().next().trigger(\'click\')">
					<br>
					<input type="file" style="display:none" nombre="foto" accept=".jpg, .gif, .png">
					<input type="hidden" name="nuevos_reg" id="nuevos_reg" value="1">
					<input type="hidden" name="accion" value="registrar">
                   
                    <div class="form-group">
                        <label  class="control-label col-xs-2">Apellido Paterno</label>
                        <div class='col-xs-5'>
                            <input type="text" class="form-control" placeholder="Ejemplo: Rodriguez" name="apP" size="25" required title="Este campo debe completarse" autofocus>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="control-label col-xs-2">Apellido Materno</label>
                        <div class='col-xs-5'>
                            <input type="text" class="form-control"   placeholder="Ejemplo: Hernandez" name="apM" size="25" required title="Este campo debe completarse">
                        </div>
                    </div>
                     <div class="form-group">
                        <label  class="control-label col-xs-2">Nombre</label>
                        <div class='col-xs-5'>
                           <input type="text" placeholder="Ejemplo: Thomas" class="form-control" name="nombre" size="25" required title="Este campo debe completarse">
                        </div>
                    </div>
                     <div class="form-group">
                        <label  class="control-label col-xs-2">Nombramiento</label>
                        <div class='col-xs-3'>
                            <select name="nombramiento" class="form-control" required>
				                <option>selecciona...</option>
								<option value="base">Base</option>
								<option value="interino">Iterino</option>
				            </select>
                        </div>
                    </div>
                     <div class="form-group">
                        <label  class="control-label col-xs-2">Funcion</label>
                        <div class='col-xs-3'>
                            <select name="funcion" class="form-control" required>
                                <option>Selecciona...</option>
                                <option value="administrativo">Administrativo</option>
                                <option value="directivo">Directivo</option>
                                <option value="docente">Docente</option>
                                <option value="apoyo">Personal de Apoyo</option>
				            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label col-xs-2">Turno</label>
                        <div class='col-xs-3'>
                            <select name="turno" class="form-control" required title="Selecciona el turno">
								<option value="">Selecciona</option>
								<option value="matutino">Matutino</option>
								<option value="vespertino">Vespertino</option>
								<option value="vespertino/matutino">Matutino y Vespertino</option>
								<option value="nocturno">Nocturno</option>
							</select>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="control-label col-xs-2">Genero:</label>
                        <div class="col-xs-2">
                            <label class="radio-inline">
                                <input type="radio" value="H" name="sexo" id="sexRPh" checked> Maculino
                            </label>
                        </div>
                        <div class="col-xs-2">
                            <label class="radio-inline">
                               <input type="radio" value="M" name="sexo" id="sexRPm"> Femenino
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label col-xs-2">Estado Civil</label>
                        <div class='col-xs-3'>
                            <select name="estadoC" class="form-control"  required title="Selecciona el estado civil">
                                <option value="">Selecciona</option>
                                <option value="soltero">Soltero / Soltera</option>
                                <option value="casado">Casado / Casada</option>
                                <option value="divorciado">Divorciado / Divorciada</option>
                                <option value="viudo">Viudo / Viuda</option>
				            </select>
                        </div>
                    </div>
                     <div class="form-group">
                        <label  class="control-label col-xs-2">RFC</label>
                        <div class='col-xs-5'>
                          <input type="text"  class="form-control" placeholder="Ejemplo: VECJ880326 XXX" name="rfc" size="25">
                        </div>
                    </div>
                     <div class="form-group">
                        <label  class="control-label col-xs-2">Curp</label>
                        <div class='col-xs-5'>
                           <input type="text" class="form-control" placeholder="Ejemplo: CXGA91116HDFSRL08" name="curp" size="28">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label col-xs-2">Colonia</label>
                        <div class='col-xs-5'>
                           <input type="text" class="form-control" placeholder="Ejemplo: Centro" name="localidad" size="30">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label col-xs-2">Municipio</label>
                        <div class='col-xs-5'>
                          <input type="text"  class="form-control" placeholder="Ejemplo: Arandas" name="municipio" size="30">
                        </div>
                    </div>
                      <div class="form-group">
                        <label  class="control-label col-xs-2">Domicilio</label>
                        <div class='col-xs-5'>
                           <input type="text" class="form-control" placeholder="Ejemplo: Arboleras 256" name="domicilio" size="30">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label col-xs-2">Telefono</label>
                        <div class='col-xs-5'>
                           <input type="text" class="form-control" placeholder="Ejemplo: 3481055555" name="tel" size="25">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label col-xs-2">Email</label>
                        <div class='col-xs-5'>
                          <input type="email" class="form-control" placeholder="Ejemplo: ThomasR@hotmail.com" name="email" size="30" title="Debe ser un email real">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label col-xs-2">Fecha de Nacimiento</label>
                        <div class='col-xs-5'>
                          <input type="date" class="form-control" name="fechaN">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label col-xs-2">Ingreso a la ENEA</label>
                        <div class='col-xs-5'>
                            <input type="date" class="form-control" name="fechaIE">
                        </div>
                    </div>
                     <div class="form-group">
                        <label  class="control-label col-xs-2">Ingreso a la SEP</label>
                        <div class='col-xs-5'>
                             <input type="date" class="form-control" name="fechaIS">
                        </div>
                    </div>
                     <div class="form-group">
                        <label  class="control-label col-xs-2">Nivel de estudios</label>
                        <div class='col-xs-3'>
                            <select name="grado" class="form-control" required title="Selecciona el grado de estudios" onchange="if($(this).find('option:selected').data('activo')==1){$('.datosEsc').show();}else{$('.datosEsc').hide();}">
                                <option value="">Selecciona</option>
                                <option value="preparatoria">Preparatoria</option>
                                <option data-activo="1" value="licenciatura">Licenciatura</option>
                                <option data-activo="1" value="Pasante_maestria">Pasante de Maestria</option>
                                <option data-activo="1" value="maestria">Maestria</option>
                                <option data-activo="1" value="Pasante_doctorado">Pasante de Doctorado</option>
                                <option data-activo="1" value="doctorado">Doctorado</option>									
				            </select>
                        </div>
                    </div>
                    <hr>
                        <label style="position:relative; left:10%;"> Datos de Estudio</label>
                        <div class="form-group">
                            <label class="control-label col-xs-2">Escuela</label>
                            <div  class='col-xs-3'>
                                <input type="text" class="form-control" placeholder="Ejemplo: ENEA" name="escuela1" size="40">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-xs-2">Carrera</label>
                            <div  class='col-xs-3'>
                                <input type="text" class="form-control" placeholder="Educacion Infantil" name="carrera1" size="40">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-2">Cedula Profesional</label>
                            <div  class='col-xs-3'>
                                <input type="text" class="form-control" placeholder="6783192" name="cedula1" size="40">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-xs-2">Acta de Examen</label>
                            <div  class='col-xs-3'>
                                <input type="text" class="form-control" placeholder="Ejemplo: MAESTRIA 02 0121" name="actaEx1" size="40">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-2">Fecha de Titulacion</label>
                            <div  class='col-xs-3'>
                                <input type="date" class="form-control" name="fechaTi1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-2">Tema de Titulacion</label>
                            <div class='col-xs-3'>
                                <input type="text" class="form-control" placeholder="Ejemplo: Programación cognitiva" name="temaTi1" >
                            </div>
                        </div>
                    <hr/>
					<div class="form-group">
                        <label class="control-label col-xs-2">Actualmente Estudia</label>
                        <div class="col-xs-2">
                            <label class="radio-inline">
                               <input onclick="$(\'.filaBeca\').hide();$(\'#nombreEscuela\').hide();" type="radio" value="0" name="estudio" id="estudioRP1" checked>No
                            </label>
                        </div>
                        <div class="col-xs-2">
                            <label class="radio-inline">
                              <input onclick="$(\'.filaBeca\').show();$(\'#nombreEscuela\').show();"type="radio" value="1" name="estudio" id="estudioRP2">Si
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-2" >Nombre de la Escuela</label>
                    </div>
					<table class="table">
						<tr class="datosEsc" style="display:none" ><td colspan="3" style="border-bottom:1px solid gray;padding-bottom:15px;"></td><td></td><td></td></tr>
						<tr><td>¿Actualmente estudia? </td>
							<td>
								<input onclick="$(\'.filaBeca\').hide();$(\'#nombreEscuela\').hide();" type="radio" value="0" name="estudio" id="estudioRP1" checked><label for="estudioRP1">No estudia</label><br>
								<input onclick="$(\'.filaBeca\').show();$(\'#nombreEscuela\').show();"type="radio" value="1" name="estudio" id="estudioRP2"><label for="estudioRP2">Si estudia</label>
						</td><td></td></tr>
						<tr class="filaBeca" id="nombreEscuela" style="display:none;"><td>Nombre de la escuela</td><td><input type="text" name="escuela_estudia"></td><td></td></tr>
						<tr class="filaBeca" style="display: none">
							<td >¿Cuenta con beca? </td>
							<td>
								<input type="radio" onclick="$(\'#nombreBeca\').show()" value="1" name="beca" id="becaRP1"><label for="becaRP1">Si tiene beca</label><br>
								<input type="radio" onclick="$(\'#nombreBeca\').hide()" value="0" name="beca" id="becaRP2" checked><label for="becaRP2">No tiene beca</label>
							</td>
							<td></td>
						</tr>
						<tr id="nombreBeca" style="display:none;"><td>¿Cual?</td><td><input type="text" name="tipo_beca" ></td><td></td></tr>
						<tr>
							<td>¿Tiene otro trabajo?</td>
							<td><input onclick="$(\'#another_job\').hide();" type="radio" value="0" name="otroJob" id="otroJRP1" checked><label for="otroJRP1">No tiene otro trabajo</label>
							<br><input onclick="$(\'#another_job\').show();"type="radio" value="1" name="otroJob" id="otroJRP2"><label for="otroJRP2">Si tiene otro trabajo</label>
							</td>
							<td></td>
						</tr>
						<tr id="another_job" style="display:none"><td>Especifique cual</td><td><input type="text" name="otro_trabajo" ></td><td></td></tr>
						<tr><td>¿Actualmente labora en la ENEA?</td><td><input type="radio" value="1" name="actual" id="actualRP1" checked><label for="actualRP1">Si labora actualmente</label><br><input type="radio" value="0" name="actual" id="actualRP2"><label for="actualRP2">No labora actualmente</label></td><td></td></tr>
						<tr>
                            <td>Acceso al sistema</td>
                            <td><input type="checkbox" name="acceso" id="accesoRP" onclick="if($(this).is(\':checked\')){$(this).next().text(\'(Si tendra acceso)\');$(\'.accesoInv\').show()}else{$(this).next().text(\'(No tendra acceso)\');$(\'.accesoInv\').hide()}"><label for="accesoRP">(No tendra acceso)</label></td><td>
                            </td>
                        </tr>
						<tr class="accesoInv" style="display:none" ><td>Usuario: </td><td><input type="text" placeholder="Ejemplo: usuario2014" name="usuario" size="25"></td><td></td></tr>
						<tr class="accesoInv" style="display:none"><td>Contraseña: </td><td><input type="password" placeholder="Ejemplo: contraseña dificil" name="pass" size="25"></td><td></td></tr>
						<tr class="accesoInv" style="display:none"><td>Repetir contraseña: </td><td><input type="password" placeholder="Escribe la misma contraseña" name="pass2" size="25"></td><td></td></tr>
						<tr class="accesoInv" style="display:none"><td>Tipo de usuario</td><td>
							<select name="tipoUsuario" title="Selecciona un tipo de usuario predeterminado">
								<option value="">Selecciona</option>
								<option value="minimo">Permisos minimos</option>
								<option value="medios">Medios</option>
								<option value="maximos">Maximos</option>
							</select>
						</td><td></td></tr>
						<tr class="accesoInv" style="display:none"><td>Permisos: </td><td>Selecciona los permisos para el usuario en el sistema<br><br></td><td></td></tr>
						<tr class="accesoInv" style="display:none">
							<td style="vertical-align:text-top;border-top:1px solid grey">Recusros humanos </td>
							<td>
								<div class="tablaPermisos">
									<b><b>Personal</b>
									<input type="checkbox" value="1" name="pos1">Agregar
									<input type="checkbox" value="1" name="pos2">Deshabilitar
									<input type="checkbox" value="1" name="pos3">Modificar
                                </div>
								<div class="tablaPermisos">
									<br/><b>Claves</b><hr></hr>
									<input type="checkbox" value="1" name="pos5">Agregar
									<input type="checkbox" value="1" name="pos6">Deshabilitar
									<input type="checkbox" value="1" name="pos7">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Comisiones</b><hr></hr>
									<input type="checkbox" value="1" name="pos9">Agregar
									<input type="checkbox" value="1" name="pos10">Deshabilitar
									<input type="checkbox" value="1" name="pos11">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Viaticos</b><hr></hr>
									<input type="checkbox" value="1" name="pos13">Agregar
									<input type="checkbox" value="1" name="pos14">Deshabilitar
									<input type="checkbox" value="1" name="pos15">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Reportes</b><hr></hr>
									<input type="checkbox" value="1" name="pos17">Ver Reportes
									<!--<input type="checkbox" value="1" name="pos18">Modifi
									<input type="checkbox" value="1" name="pos19">Deshabilitar-->
								</div>
								<div class="tablaPermisos">
									<br/><b>Horarios</b><hr></hr>
									<input type="checkbox" value="1" name="pos21">Agregar
									<input type="checkbox" value="1" name="pos22">Deshabilitar
									<input type="checkbox" value="1" name="pos23">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Insidencias</b><hr></hr>
									<input type="checkbox" value="1" name="pos25">Agregar
									<input type="checkbox" value="1" name="pos26">Deshabilitar
									<input type="checkbox" value="1" name="pos27">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Licencias</b><hr></hr>
									<input type="checkbox" value="1" name="pos29">Agregar
									<input type="checkbox" value="1" name="pos30">Deshabilitar
									<input type="checkbox" value="1" name="pos31">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Propuestas</b><hr></hr>
									<input type="checkbox" value="1" name="pos33">Agregar
									<input type="checkbox" value="1" name="pos34">Deshabilitar
									<input type="checkbox" value="1" name="pos35">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Prestadores de servicios</b><hr></hr>
									<input type="checkbox" value="1" name="pos37">Agregar
									<input type="checkbox" value="1" name="pos38">Deshabilitar
									<input type="checkbox" value="1" name="pos39">Modificar
								</div>
							</td>
						</tr>
						<tr class="accesoInv" style="display:none">
							<td style="vertical-align:text-top;border-top:1px solid grey">Control escolar </td>
							<td>
								<div class="tablaPermisos">
									<br/><b>Alumnos</b><hr></hr>
									<input type="checkbox" value="1" name="pos41">Agregar
									<input type="checkbox" value="1" name="pos42">Deshabilitar
									<input type="checkbox" value="1" name="pos43">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Seguimiento Academico</b><hr></hr>
									<input type="checkbox" value="1" name="pos45">Agregar
									<input type="checkbox" value="1" name="pos46">Deshabilitar
									<input type="checkbox" value="1" name="pos47">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Encuestas para alumnos</b><hr></hr>
									<input type="checkbox" value="1" name="pos49">Agregar
									<input type="checkbox" value="1" name="pos50">Deshabilitar
									<input type="checkbox" value="1" name="pos51">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Lugares Practicantes</b><hr></hr>
									<input type="checkbox" value="1" name="pos53">Agregar
									<input type="checkbox" value="1" name="pos54">Deshabilitar
									<input type="checkbox" value="1" name="pos55">Modificar
								</div>
							</td>
						</tr>
						<tr class="accesoInv" style="display:none">
							<td style="vertical-align:text-top;border-top:1px solid grey">Finanzas </td>
							<td>
								<div class="tablaPermisos">
									<br/><b>Proyectos profen</b><hr></hr>
									<input type="checkbox" value="1" name="pos73">Agregar
									<input type="checkbox" value="1" name="pos74">Deshabilitar
									<input type="checkbox" value="1" name="pos75">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Acciones profen</b><hr></hr>
									<input type="checkbox" value="1" name="pos57">Agregar
									<input type="checkbox" value="1" name="pos58">Deshabilitar
									<input type="checkbox" value="1" name="pos59">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Cuentas</b><hr></hr>
									<input type="checkbox" value="1" name="pos61">Agregar
									<input type="checkbox" value="1" name="pos62">Deshabilitar
									<input type="checkbox" value="1" name="pos63">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Traspasos (transacciones)</b><hr></hr>
									<input type="checkbox" value="1" name="pos65">Agregar
									<input type="checkbox" value="1" name="pos66">Deshabilitar
									<input type="checkbox" value="1" name="pos67">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Pagos </b><hr></hr>
									<input type="checkbox" value="1" name="pos69">Agregar
									<input type="checkbox" value="1" name="pos70">Deshabilitar
									<input type="checkbox" value="1" name="pos71">Modificar
								</div>
							</td>
						</tr>
						<tr class="accesoInv" style="display:none">
							<td style="vertical-align:text-top;border-top:1px solid grey">Proveedores </td>
							<td>
								<div class="tablaPermisos">
									<br/><b>Agregar proveedores</b>
									<input type="checkbox" value="1" name="pos77">Agregar
									<input type="checkbox" value="1" name="pos78">Deshabilitar
									<input type="checkbox" value="1" name="pos79">Modificar
								</div>
							</td>
						</tr>
						<tr class="accesoInv" style="display:none">
							<td style="vertical-align:text-top;border-top:1px solid grey">Inventarios </td>
							<td>
								<div class="tablaPermisos">
									<br/><b>Categorias </b><hr></hr>
									<input type="checkbox" value="1" name="pos81">Agregar
									<input type="checkbox" value="1" name="pos82">Deshabilitar
									<input type="checkbox" value="1" name="pos83">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Articulos </b>
									<hr></hr>
									<input type="checkbox" value="1" name="pos85">Agregar
									<input type="checkbox" value="1" name="pos86">Deshabilitar
									<input type="checkbox" value="1" name="pos87">Modificar
								</div>
							</td>
						</tr>
						<tr class="accesoInv" style="display:none">
							<td style="vertical-align:text-top;border-top:1px solid grey">SAI Docentes </td>
							<td>
								<div class="tablaPermisos">
									<br/><b>Subir calificaciones </b><hr></hr>
									<input type="checkbox" value="1" name="pos89">Agregar
									<input type="checkbox" value="1" name="pos90">Deshabilitar
									<input type="checkbox" value="1" name="pos91">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Horarios </b>
									<hr></hr>
									<input type="checkbox" value="1" name="pos93">Agregar
									<input type="checkbox" value="1" name="pos94">Deshabilitar
									<input type="checkbox" value="1" name="pos95">Modificar
								</div>
								<div class="tablaPermisos">
									<br/><b>Agsinaturas </b>
									<hr></hr>
									<input type="checkbox" value="1" name="pos97">Agregar
									<input type="checkbox" value="1" name="pos98">Deshabilitar
									<input type="checkbox" value="1" name="pos99">Modificar
								</div>
							</td>
						</tr>
						<tr class="accesoInv" style="display:none">
							<td style="vertical-align:text-top;border-top:1px solid grey">Configuracion del Sistema </td>
							<td>
								<div class="tablaPermisos">
									<br/><b>backup </b><hr></hr>
									<input type="checkbox" value="1" name="pos101">Agregar
									<input type="checkbox" value="1" name="pos102">Deshabilitar
									<input type="checkbox" value="1" name="pos103">Modificar
								</div>
							</td>
						</tr>
						<tr class="accesoInv" style="display:none">
							<td style="vertical-align:text-top;border-top:1px solid grey">Recepcion </td>
							<td>
								<div class="tablaPermisos">
									<br/><b>backup </b><hr></hr>
									<input type="checkbox" value="1" name="pos105">Agregar
									<input type="checkbox" value="1" name="pos106">Deshabilitar
									<input type="checkbox" value="1" name="pos107">Modificar
								</div>
							</td>
						</tr>
					</table>
					<center><button>Guardar</button></center>
				</form>
			</div>
    </div>

           
