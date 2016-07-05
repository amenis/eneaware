<script src="js/jquery.tablePagination.js" ></script>
<script src="js/jquery-ui.js"></script>
<?php
session_start();
	include("conexion.php");
	require_once('funciones.php');
	echo'
		<script>
        
            function cargar(){
                $(\'.nombre\').text($(\'#usuario\').find(\'option:selected\').attr(\'nombre\'));
                $(\'#rfc\').text($(\'#usuario\').find(\'option:selected\').attr(\'rfc\'));
                $(\'#nivel\').text($(\'#usuario\').find(\'option:selected\').attr(\'nivel\'));
                $(\'#sep\').text($(\'#usuario\').find(\'option:selected\').attr(\'sep\')); 
                $(\'#turno\').text($(\'#usuario\').find(\'option:selected\').attr(\'turno\'));
                $(\'#domicilio\').text($(\'#usuario\').find(\'option:selected\').attr(\'domicilio\'));
                $(\'#telefono\').text($(\'#usuario\').find(\'option:selected\').attr(\'telefono\'));
                $(\'#localidad\').text($(\'#usuario\').find(\'option:selected\').attr(\'localidad\'));
                $(\'#municipio\').text($(\'#usuario\').find(\'option:selected\').attr(\'munic\'));
                var ver = $(\'#usuario\').find(\'option:selected\').val();
                $("[name=idClave]").hide();
                 $(\'.\'+ver).show();
                //  $(\'#\'+ver).prop(\'disabled\',false);
                
            }   
            function guardar(){
                var ver = $(\'#usuario\').find(\'option:selected\').val();
                $("[name=idClave]").not("."+ver).remove();
                $(\'#notasLic\').val("<span style=position:relative;left:55%; >"+$("#fecha").html()+"</span>"+"<br></br>"+$("#notas").html());             

            }
        </script>';
        echo'
   	<div style="overflow:auto;height:100%">
		<h1>Administración del Licencias del personal</h1>
		<button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="regLic">Registrar comisiones</button>
		<button class="tab" style="border-bottom:none;" mostrar="verLic">Ver Solicitud de Licencias</button>
		<button class="tab" style="border-bottom:none;" mostrar="verPro">Prorrogas de Licencias</button>
        <button class="tab" style="border-bottom:none" mostrar="restaurar">Restaurar</button>
		<div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
			<div id="regLic" class="tabCont" permiso="A">
				<h2>Registrar comisiones</h2>
				<form action="accionesLicencias.php"  destino="resultadoRegistro" style="width:95%;">
					<input type="hidden" name="accion" value="reg">
                    <input type="hidden" name="fCreacion" value="'.date("Y-m-d").'">
                    <input type="hidden" name="notas" id="notasLic">
					<div style="font-family:Arial;margin:auto;padding:2cm;background:white;width:17.5cm;border:1px solid grey; height:24cm">
						<select name="asunto" style="position:relative; left:76%;" onchange="$(\'#asunto\').text($(this).find(\'option:selected\').attr(\'nombre\'))">
                            <option nombre=""></option>
                            <option nombre="Solicitud de Licencia" >Solicitud de Licencia</option>
                            <option nombre="Prorroga de Licencia" >Prorroga de Licencia</option>
                        </select><br/><br/>';
                        $Nmes = mes(date("m"));
                        echo'
                        <span id="fecha" style="position:relative; left:55%;">Arandas, Jalisco A '.date("d").' de '.$Nmes.' de '.date("Y").'</span><br/><br/>   
                        <b>Selecciona Personal</b>';
                        $User = mysqli_query($conexion,"SELECT * FROM Usuarios WHERE status=1");
                        $cant = mysqli_num_rows($User);
                        $cont=0;
                        echo'
                        <select name="id" id="usuario" onclick="cargar()">
                            <option></option>';
                            while($cont < $cant){
                                $res=mysqli_fetch_array($User);                             
                                echo'<option value="'.$res["id_usuario"].'" nombre="'.$res["nombre"].'" rfc="'.$res['rfc'].'"  nivel="'.$res['fecha_ingreso_enea'].'" sep="'.$res['fecha_ingreso_sep'].'" turno="'.$res['turno'].'"  domicilio="'.$res['domicilio'].'" tel="'.$res['telefono'].'" localidad="'.strtoupper($res['localidad']).'" munic="'.strtoupper($res['municipio']).'">'.$res['nombre'].'</option>';
                                $cont++;
                            }
                        echo'
                        </select>
                        <br/>
                        <b>Selecciona la categoria a Asignar</b>
                        <select name="categoria" id="categoriaClave" onchange="$(\'.categoria\').text(\' \'+$(this).find(\'option:selected\').attr(\'nombre\'))">
                            <option></option>
                            <option value="27" nombre="Titular A" >Titular A</option>
                            <option value="29" nombre="Titular B">Titular B</option>
                            <option value="31" nombre="Titular C">Titular C</option>
                            <option value="23" nombre="Asociado C">Asociado A</option>
                            <option value="25" nombre="Asociado B">Asociado B</option>
                            <option value="33" nombre="Asociado C">Asociado C</option>
                            <option value="71" nombre="Director">Director</option>
                            <option value="61" nombre="Subdirector Administrativo">Subdirector Administrativo</option>
                            <option value="63" nombre="Subdirector de Investigacion">Subdirector de Investigacion</option>
                            <option value="JA" nombre="Administrativo Especializado">Administrativo Especializado B</option>
                            <option value="JS" nombre="Oficial de Servicios B">Oficial de Servicios B</option>
                            <option value="JS" nombre="Oficial de Servicios C">Oficial de Servicios C</option>
                        </select>
                        <br/></br>
                        Fecha de Inicio: <input type="date" name="fInicio" required onchange="$(\'#fInicio\').text($(this).val())"/>
                        Fecha Final: <input type="date" name="fFinal" required onchange="$(\'#Final\').text($(this).val())">
						<div id="notas" contenteditable  style="border:1px dashed grey;">
                            <table>
                                <tr><td>El que suscribe C. LIC. </td><td style="border-bottom:1px solid black"><span ><b class=nombre> </b></span></td></tr>
                                <tr><td>Adscrito (a) a la </td><td style="border-bottom:1px solid black"><span ><b>Escuela Normal para Educadores y Educadoras de Arandas</b><span></td></tr>
                                <tr><td>Se permite solicitar a usted</td><td style="border-bottom:1px solid black"><span ><b id="asunto"></b><b class="categoria"></b></span></td></tr>
                                <tr><td colspan="2" style="border-bottom:1px solid black">En base al Artículo 42 de la LEY PARA LOS SERVIDORES PUBLICOS
                                    DEL ESTADO DE JALISCO Y SUS MUNICIPIOS, a partir del <span ><b id="fInicio">_<b  style="color:blue">{Fecha de Inicio}</b>_</b></span>
                                    al <span ><b id="Final">_<b  style="color:blue">{fecha Final}</b>_</b></span></td>
                                <td></td>
                                </tr>
                                <tr><td colspan="2">Proporciono los siguientes datos:</td><td></td></tr>
                                <tr><td>NOMBRE:</td><td style="border-bottom:1px solid black"><span class=nombre></span></td></tr>
                                <tr><td>FILIACIÓN:</td><td style="border-bottom:1px solid black"><span id="rfc"></span></td>
                                </tr>
                                <tr><td>CLAVE (S):</td>
                                   <td style="border-bottom:1px solid black">';
                                	   $datos=mysqli_query($conexion,"SELECT id_usuario,nombre FROM Usuarios WHERE status=1");
                                        while($usuario=mysqli_fetch_array($datos)){
                                                $clave =mysqli_query($conexion,"SELECT * FROM Claves WHERE id_usuario=".$usuario['id_usuario']);
                                            while($datosC=mysqli_fetch_array($clave)){
                                            echo '
	                                            <span class="'.$usuario['id_usuario'].'" name="idClave" style="display:none" >
	                                                '.$datosC["puesto"].$datosC["categoria"].$datosC["horas"].$datosC["plaza"].',
	                                            </span>
	                                            ';
                                           }
                                        }   
                                            
                                    echo'</td
                               </tr>
                               <tr><td>CATEGORIA</td><td style="border-bottom:1px solid black;border-bottom:1px solid black"><span class="categoria"></span></td></tr>
                                <tr><td>ADSCRIPCIÓN:</td><td style="border-bottom:1px solid black"><span >ESCUELA NORMAL PARA EDUCADORES Y EDUCADORAS DE ARANDAS</span></td></tr>
                                <tr><td>CLAVE DEL C. T.</td><td style="border-bottom:1px solid black">14ENL0010N</td></tr>
                                <tr><td>TURNO</td><td style="border-bottom:1px solid black"><span id="turno"></span></td></tr>
                                <tr><td >LOCALIDAD <span id="localidad" style="font-size:10.5pt;border-bottom:1px solid black"></span></td><td>MUNICIPIO <span id="municipio" style="font-size:10.5pt;border-bottom:1px solid black"></span></td></tr>
                                <tr><td >DOMICILIO PARTICULAR:</td><td style="border-bottom:1px solid black"><span id="domicilio"></span></td></tr>
                                <tr><td>TELEFONO:</td><td style="border-bottom:1px solid black"><span id="telefono"><span></td></tr>
                                <tr><td>FECHA DE INGRESO A LA SEP:</td><td style="border-bottom:1px solid black"><span id="sep"></span></td></tr>
                                <tr><td>FECHA DE INGRESO A LA NIVEL:</td><td style="border-bottom:1px solid black"><span id="nivel"></span></td></tr>
                            </table>
                            Agradezco la fineza de su atención al presente y aprovecho la oportunidad para reiterarle un cordial saludo, las seguridades de mi consideración distinguida.
                            <br/><br/>
                            <center>ATENTAMENTE</center>
                            <br/><br/><br/>
                            <center><span><b class="nombre"></b></span></center>
                        </div>
					</div>
					<center><button onclick="guardar()">Guardar</button></center>
				</form>
			</div>
			<div id="verLic" style="display:none;" class="tabCont" permiso="M">
				<h2>Solicitud de Licencias</h2>
				<div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
					<input type="search" autofocus  id="name" padre="solLic"  placeholder="Buscar por nombre">
					<img src="imagenes/search.png" >
				</div>
				<table id="solLic" width="100%">';			
					$sql = "SELECT * FROM Usuarios WHERE status=1";
					$pers=0;
					$personal = mysqli_query($conexion, $sql);
					$num_result = mysqli_num_rows($personal);
									
						while($pers < $num_result){
							$datosU = @mysqli_fetch_array($personal);
							echo'
                            <tr class="solLic">
                                <td>
                                    <span class="solLic_nombre" style="display:none">'.$datosU['apellidoP'].' '.$datosU['apellidoM'].' '.$datosU['nombre'].'</span>
        							<div nombre="'.strtolower($datosU['nombre']).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
        								'.$datosU['apellidoP'].' '.$datosU['apellidoM'].' '.$datosU['nombre'].'';

        								$solid = mysqli_query($conexion,"SELECT * FROM Licencias WHERE status=1 AND asunto='Solicitud de Licencia' AND id_usuario='".$datosU['id_usuario']."' ");
        								while($lic=@mysqli_fetch_array($solid)){
        									echo'
        									<div class="sol'.$datosU['id_usuario'].'" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none; display:none">
        										'.$lic['asunto'].' '.$lic['fecha_creacion'].'
        										<img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(this).next().toggle(\'drop\')">
        										
        										<div style="display:none">
        											<button onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();"><img src="imagenes/print.png"/></button>
        											<div style="border:1px solid grey;font-weight:normal;font-family:Arial;margin:auto;padding:2cm;background:white;width:18cm; height:24cm;">
        												<div style="width:100%;text-align:right"><b>ASUNTO</b></div><br>
        												<div style="width:100%; text-align:right">'.$lic['asunto'].'</div><br/>
        												<div style="text-align:justify">'.$lic["notas"].'</div>
        											</div>
        										</div>
        										<img src="imagenes/bin.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(this).next().toggle(\'drop\')">
        										<form action="accionesLicencias.php" destino="resultadoRegistro" style="display:none">
        											<input type="hidden" name="accion" value="baja" />
        											<input type="hidden" name="id" value="'.$lic['id_licencias'].'"/>
        											<input type="hidden" name="seccion"  value="verLic"/>
        											Estas Seguro que Deseas Cancelar esta Solicitud 
        											<button>Si</button>
        											<button onclick="$(this).parent().toggle(\'drop\');return false;">No</button>
        										</form>
        									</div>
        									';
        								}
        								echo'
        								<img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'.sol'.$datosU['id_usuario'].'\').toggle(\'drop\')"><br/>
        							</div>
                                </td>
                            </tr>';
							$pers++;
						}
						
						mysqli_free_result($personal);
						
			echo'
				</table>
                <script>
                    $("#solLic").tablePagination({});
                     $.expr[":"].Contains = function(x, y, z){
                        return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
                      };
                                
                </script>
				
			</div>
            <div id="verPro" style="display:none;" class="tabCont" permiso="M">
                <h2>Solicitud de Prorrogas</h2>
                <div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
                    <input type="search" autofocus id="name" padre="ProLic" placeholder="Buscar por nombre">
                    <img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
                </div>
                <table id="ProLic" width="100%">';         
                    $sql = "SELECT * FROM Usuarios WHERE status=1";
                    $personal = mysqli_query($conexion, $sql);
                    $num_result = mysqli_num_rows($personal);
                    $pers=0;
                        
                        while($pers < $num_result){
                            $datosU = @mysqli_fetch_array($personal);
                            echo'
                            <tr class="ProLic">
                                <td>
                                    <span class="ProLic_nombre" style="display:none">'.$datosU['apellidoP'].' '.$datosU['apellidoM'].' '.$datosU['nombre'].'</span>
                                    <div nombre="'.strtolower($datosU['nombre']).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
                                       '.$datosU['apellidoP'].' '.$datosU['apellidoM'].' '.$datosU['nombre'].'';

                                        $solid = mysqli_query($conexion,"SELECT * FROM Licencias WHERE status=1 AND asunto='Prorroga de Licencia' AND id_usuario='".$datosU['id_usuario']."' ");
                                        while($lic=@mysqli_fetch_array($solid)){
                                            echo'
                                            <div class="sol'.$datosU['id_usuario'].'" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none; display:none">
                                                '.$lic['asunto'].' '.$lic['fecha_creacion'].'
                                                <img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(this).next().toggle(\'drop\')">
                                                
                                                <div style="display:none">
                                                    <button onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();"><img src="imagenes/print.png"/></button>
                                                    <div style="border:1px solid grey;font-weight:normal;font-family:Arial;margin:auto;padding:2cm;background:white;width:18cm; height:24cm;">
                                                        <div style="width:100%;text-align:right"><b>ASUNTO</b></div><br>
                                                        <div style="width:100%; text-align:right">'.$lic['asunto'].'</div><br/>
                                                        <div style="text-align:justify">'.$lic["notas"].'</div>
                                                    </div>
                                                </div>
                                                <img src="imagenes/bin.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(this).next().toggle(\'drop\')">
                                                <form action="accionesLicencias.php" destino="resultadoRegistro" style="display:none">
                                                    <input type="hidden" name="accion" value="baja" />
                                                    <input type="hidden" name="id" value="'.$lic['id_licencias'].'"/>
                                                    <input type="hidden" name="seccion"  value="ProLic"/>
                                                    Estas Seguro que Deseas Cancelar esta Solicitud 
                                                    <button>Si</button>
                                                    <button onclick="$(this).parent().toggle(\'drop\');return false;">No</button>
                                                </form>
                                            </div>
                                            ';
                                        }
                                        echo'
                                        <img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'.sol'.$datosU['id_usuario'].'\').toggle(\'drop\')"><br/>
                                    </div>';
                            $pers++;
                        }                                   
                        
                        mysqli_free_result($personal);
                     
            echo'
                </table>
                 <script>
                    $("#ProLic").tablePagination({});
                     $.expr[":"].Contains = function(x, y, z){
                        return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
                      };
                                
                </script>
            </div>  	
			<div id="restaurar" style="display:none;" class="tabCont">
				<h2>Restaurar Licencias</h2>
                 <h2>Solicitud de Licencias</h2>
                <div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
                    <input type="search" autofocus id="name" padre="restore" placeholder="Buscar por nombre">
                    <img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
                </div>
                <table id="restore" width="100%">';         
                    $sql = "SELECT * FROM Usuarios WHERE status=1";
                    $personal = mysqli_query($conexion, $sql);
                    $num_result = mysqli_num_rows($personal);
                    $pers=0;
                        
                        while($pers < $num_result){
                            $datosU = @mysqli_fetch_array($personal);
                            echo'
                            <tr class="restore">
                                <td>
                                    <span class="restore_nombre" style="display:none">'.$datosU['apellidoP'].' '.$datosU['apellidoM'].' '.$datosU['nombre'].'</span>
                                    <div nombre="'.strtolower($datosU['nombre']).'"  tipo="fila" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
                                       '.$datosU['apellidoP'].' '.$datosU['apellidoM'].' '.$datosU['nombre'].'';

                                        $solid = mysqli_query($conexion,"SELECT * FROM Licencias WHERE status=0 AND id_usuario='".$datosU['id_usuario']."' ");
                                        while($lic=@mysqli_fetch_array($solid)){
                                            echo'
                                            <div class="sol'.$datosU['id_usuario'].'" style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);border-top:none; display:none">
                                                '.$lic['asunto'].' '.$lic['fecha_creacion'].'
                                                <img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(this).next().toggle(\'drop\')">
                                                
                                                <div style="display:none">
                                                    <button onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();"><img src="imagenes/print.png"/></button>
                                                    <div style="border:1px solid grey;font-weight:normal;font-family:Arial;margin:auto;padding:2cm;background:white;width:18cm; height:24cm;">
                                                        <div style="width:100%;text-align:right"><b>ASUNTO</b></div><br>
                                                        <div style="width:100%; text-align:right">'.$lic['asunto'].'</div><br/>
                                                        <div style="text-align:justify">'.$lic["notas"].'</div>
                                                    </div>
                                                </div>
                                                <img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(this).next().toggle(\'drop\')">
                                                <form action="accionesLicencias.php" destino="resultadoRegistro" style="display:none">
                                                    <input type="hidden" name="accion" value="restaurar" />
                                                    <input type="hidden" name="id" value="'.$lic['id_licencias'].'"/>
                                                    <input type="hidden" name="seccion"  value="restaurar"/>
                                                    Estas Seguro que Deseas Restaurar esta Solicitud 
                                                    <button>Si</button>
                                                    <button onclick="$(this).parent().toggle(\'drop\');return false;">No</button>
                                                </form>
                                            </div>
                                            ';
                                        }
                                        echo'
                                        <img src="imagenes/plus.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(\'.sol'.$datosU['id_usuario'].'\').toggle(\'drop\')"><br/>
                                    </div>';
                            $pers++;
                        }                                   
                        
                        mysqli_free_result($personal);
                     
            echo'
                </table>
                 <script>
                    $("#restore").tablePagination({});
                     $.expr[":"].Contains = function(x, y, z){
                        return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
                      };
                                
                </script>
					
				<div style="border-bottom:1px solid rgba(0,0,0,0.2);width:95%;padding-left:20px;"></div>
			</div>		
		</div>
	</div>';

	

	if(substr($_SESSION["Permisos_Eneaware"][7],0,1)=="0"){
		echo "<script>$('#principalInner [permiso=A]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][7],1,1)=="0"){
		echo "<script>$('#principalInner [permiso=D]').remove()</script>";
	}
	if(substr($_SESSION["Permisos_Eneaware"][7],2,1)=="0"){
		echo "
			<script>
				$('#principalInner form[permiso=M] input').prop('disabled', true);
				$('#principalInner form[permiso=M] select').prop('disabled', true);
				$('#principalInner form[permiso=M] button').remove();
			</script>";
	}
	mysqli_close($conexion);
?>
	