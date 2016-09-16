<?php
    session_start();
    include("../model/accionesPersonal.php");
     $Apersonal = new accionesPersonal();
?>
<div class="container">
      <h2>Personal ENEA</h2>
      <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#registrarPer">Registro</a></li>
            <li><a data-toggle="tab" href="#modificarPer">Ver y modificar</a></li>
            <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
            <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
      </ul>

      <div class="tab-contents">
             <div id="registrarPer" class="tab-pane fade in active" permiso="A" >
                 <h3>Registro del  personal</h3>              
                 <label style="position:relative; left:3%;color:gray;border-bottom:10px"> Datos Personales</label>
                 <form action="../controller/control_personal.php"  role="form" class="form-horizontal personalForms" method="post">

                        <img class="idFoto" src="../imagenes/user.gif" onclick="$(this).next().trigger('click')">
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
                        
                    <div class="datosEsc" style="display:none">
                        
                            <label style="position:relative; left:3%;color:gray;border-bottom:10px"> Datos de Estudio</label>
                           
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
                            <div class="form-group">
                                <label class="control-label col-xs-2">Actualmente Estudia</label>
                                <div class="col-xs-2">
                                    <label class="radio-inline">
                                       <input onclick="$('#filaBeca').hide();$('#nombreEscuela').hide();" type="radio" value="0" name="estudio" id="estudioRP1" checked>No
                                    </label>
                                </div>
                                <div class="col-xs-2">
                                    <label class="radio-inline">
                                      <input onclick="$('#filaBeca').show();$('#nombreEscuela').show();"type="radio" value="1" name="estudio" id="estudioRP2">Si
                                    </label>
                                </div>
                            </div>
                            <div id ="nombreEscuela" class="form-group " style="display:none">
                                <label class="control-label col-xs-2" >Nombre de la Escuela</label>
                                <div class="col-xs-2">
                                    <input class="form-control" type="text" name="escuela_estudia">
                                </div>
                            </div>
                            <div class="form-group" id="filaBeca">
                                <label class="control-label col-xs-2">¿Cuenta con beca?</label>
                                <div class="col-xs-2">
                                    <input type="radio" onclick="$('#nombreBeca').hide()" value="0" name="beca" id="becaRP2" checked>No
                                </div>
                                <div class="col-xs-2">
                                    <input type="radio" onclick="$('#nombreBeca').show()" value="1" name="beca" id="becaRP1">Si
                                </div>
                            </div>
                            <div id="nombreBeca" class="form-group" style="display:none">
                                <label class="control-label col-xs-2">Nombre de la beca</label>
                                <div class="col-xs-2">
                                    <input class="form-control" type="text" name="tipo_beca" >
                                </div>
                            </div>                                                
                    </div>
                     
                        <label style="position:relative; left:3%;color:gray;border-bottom:10px">Datos de Trabajo</label>
                        <div class="form-group">
                            <label class="control-label col-xs-2">¿Tiene otro trabajo?</label>
                            <div class="col-xs-2">
                                <input onclick="$('#another_job').hide();" type="radio" value="0" name="otroJob" id="otroJRP1" checked>No
                            </div>
                            <div class="col-xs-2">
                                <input onclick="$('#another_job').show();"type="radio" value="1" name="otroJob" id="otroJRP2">Si
                            </div>
                        </div>
                        <div id="another_job" style="display:none">
                            <div class="form-group">
                                <label class="control-label col-xs-2">Especifique cual</label>
                                <div class="col-xs-2">
                                    <input class="form-control" type="text" name="Lugar_trabajo" >
                                </div>    
                            </div>                           
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-2">¿Actualmente labora en la ENEA?</label>
                            <div class="col-xs-2">
                                <input type="radio" value="0" name="actual" id="actualRP2" checked>No
                            </div>
                            <div class="col-xs-2">
                                <input type="radio" value="1" name="actual" id="actualRP1" >Si
                            </div>
                        </div>
                    
                       <label style="position:relative; left:3%;color:gray;border-bottom:10px">Sistema</label> 
                       <div class="form-group">
                            <label class="control-label col-xs-2">Acceso al Sistema</label> 
                            <div class="col-xs-2">
                                <input type="radio" name="loginGranted" value="0" onclick="$('#Permisos_sistema').hide()" checked>No
                            </div>   
                            <div class="col-xs-2">
                                <input type="radio" name="loginGranted"  value="1" onclick="$('#Permisos_sistema').show()">Si
                            </div>
                        </div>
                       
                       
                        <div id="Permisos_sistema" style="position:relative; left:10%;display:none;width:65%;">
                            <div class="form-group">
                                <label class="control-label col-xs-2">Usuario</label>
                                <div class="col-xs-5">
                                    <input type="text" class="form-control" placeholder="Ejemplo: usuario2014" name="usuario" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-2">Password</label>
                                <div class="col-xs-5">
                                    <input type="password" class="form-control" placeholder="Ejemplo: contraseña dificil" name="pass" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-2">Repitita contrase&ntilde;a</label>
                                <div class="col-xs-5">
                                    <input type="password" class="form-control" placeholder="Escribe la misma contraseña" name="pass2" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-2">tipo de Usuario</label>
                                <div class="col-xs-4">
                                    <select class="form-control" name="tipoUsuario" title="Selecciona un tipo de usuario predeterminado">
                                        <option value="">Selecciona tipo de usuario</option>
                                        <option value="minimo">Permisos minimos</option>
                                        <option value="medios">Medios</option>
                                        <option value="maximos">Maximos</option>
                                    </select>
                                </div>
                            </div>

                            <table class="table able-hover">
                                <thead>
                                    <tr>
                                        <td style="text-align: center;">RECURSOS HUMANOS</td>
                                        <td>Agregar</td>
                                        <td>Deshabilitar</td>
                                        <td>Modificar</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr>
                                        <td>Personal</td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos1"></td>
								        <td class="col-xs-1"><input type="checkbox" value="1" name="pos2"></td>
								        <td class="col-xs-1"><input type="checkbox" value="1" name="pos3"></td>
                                    </tr>
                                    <tr>
                                        <td>Claves</td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos5"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos6"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos7"></td>                                        
                                    </tr>
                                    <tr>
                                        <td>Comisiones</td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos9"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos10"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos11"></td>
                                    </tr>
                                    <tr>
                                        <td>Viaticos</td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos13"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos14"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos15"></td>
                                    </tr>
                                    <tr>
                                        <td>Horarios</td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos17"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos18"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos19"></td>
                                    </tr>
                                    <tr>
                                        <td>Incidencias</td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos21"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos22"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos23"></td>                                        
                                    </tr>
                                    <tr>
                                        <td>Licencias</td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos25"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos26"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos27"></td>									
                                    </tr>
                                    <tr>
                                        <td>Prestadores de Servicio</td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos29"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos30"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos31"></td>                                     
                                    </tr>
                                    <tr>
                                        <td>Reportes</td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos33"></td>
                                        <td class="col-xs-1"><input type="checkbox" style="display:none" value="1" name="pos34"></td>
                                        <td class="col-xs-1"><input type="checkbox" style="display:none" value="1" name="pos35"></td>                                      
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">Control Escolar</td>
                                        <td>Agregar</td>
                                        <td>Deshabilitar</td>
                                        <td>Modificar</td>
                                    </tr>
                                    <tr>
                                        <td>Alumnos</td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos37"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos38"></td>
                                        <td class="col-xs-1"><input type="checkbox" value="1" name="pos39"></td>                                       
                                    </tr>
                                    <!!-- Proximos permisos a agregar >
                                </tbody>
                            </table>                            
                        </div>
                        <center><button class="btn btn-success">Guardar</button></center>
                </form>                   
            </div>
            <div id="modificarPer" class="tab-pane fade">
                <h3>Ver y modificar Personal</h3>
                <br>
                <di id='modPer'>
                    <?php
                        foreach(  $Personal = $Apersonal->getAllPersonal(0) as $listPer):
                    ?>
                    <ul class="list-group" >
                        <li class="list-group-item">
                            <img src="<?php echo file_exists('../imagenes/personal/'.$listPer['id_usuario'].".jpg") ? '../imagenes/personal/'.$listPer['id_usuario'].".jpg" : '../imagenes/personal/disable.gif '; ?>" class="img-circle" width="32" height="32">  
                            <spam style=" font-size: 20px; position:absolute; left:10%;"><?php echo $listPer['nombre'];?></spam>
                           
                        </li>
                        
                    </ul>
                    <?php
                        endforeach;
                    ?>        
                </di>
            </div>
            <div id="menu2" class="tab-pane fade">
                  <h3>Menu 2</h3>
                  <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
            </div>
            <div id="menu3" class="tab-pane fade">
                  <h3>Menu 3</h3>
                  <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            </div>
      </div>
</div>
        <!--
		<button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="registrarPer">Registrar personal</button>
		<button class="tab" style="border-bottom:none;" mostrar="modificarPer">Ver / Modificar informacion del personal</button>
		<button class="tab" style="border-bottom:none;" mostrar="DatosDir">Datos Direct@r</button>
		<button class="tab" style="border-bottom:none;" mostrar="documentosPer">Documentos digitales</button>
		<button class="tab" style="border-bottom:none;" mostrar="restaurarPer"  >Restaurar personal</button> -->
		
		
  
    <script>
        (function(){
            
            $(".personalForms").on("submit", function () {
                    var datos = new FormData();
                    inputs = $(this).serialize();
                    entradas = inputs.split("&");
                    for(x=0;x<entradas.length;x++){
                        var temp = entradas[x].split("=");
                        valor= replaceAll(decodeURIComponent(temp[1].toString()), "+", " ");
                        datos.append(temp[0], valor);
                    }		
                    var archivos = $(this).find($("input:file"));
                    archivos.each(function(){  						
                        datos.append($(this).attr("nombre"),this.files[0]);
                    });
                    $.ajax({
                        url:$(this).attr("action"),
                        type:"POST",
                        contentType:false,
                        data:datos,
                        processData:false,
                        cache:false,
                        success: function(data) {
                            $('#formResult').modal('show');
                              $('#messagePersonal').html(data);
                        }
                    });

                    return false;
            });     
            
        }());
       
    </script>
                  
          

           
