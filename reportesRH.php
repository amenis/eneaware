<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script>
    $(function(){
        $(".tabs").tabs();
    });

</script>
<?php
session_start();
include('conexion.php');

echo'
<div style="overflow:auto;height:100%;padding-left:20px;">
    <h1>Reportes</h1>
    <button class="tab seleccionado" style="boder-bottom:none;" mostrar="Personal">Personal</button>
    <button class="tab " style="boder-bottom:none;" mostrar="Claves">Claves</button>
    <button class="tab " style="boder-bottom:none;" mostrar="Horarios">Horarios</button>
    <div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
        
        
        <div  class="tabCont" id="Personal" permiso="D">

              <div class="tabs" style="border:none;" >
                                <ul>
                                    <li><a href="#edades">Edades</a></li>
                                    <li><a href="#nivel">Nivel</a></li>
                                    <li><a href="#perso">Personal</a></li>
                                    <li><a href="#nombramiento">Nombramiento</a></li>
                                
                                </ul>
                        
                            
                            <div id="edades" class="clase" style="display:none;">
                                <br><br>
                                <fieldset>
                                    <legend>Busqueda por Edades</legend>
                                    <form  action="accionesPersonal.php" destino="resultados" style="position:relative;top:25%;" method="POST">
                                        <input type="hidden" name="accion" value="edades">
                                            Muestrame a todos los Docentes con las
                                            Edades De<input type="number" min="0" max="100" name="edad">
                                            Hasta <input type="number" min="0" max="100" name="edadH">
                                        <button>Buscar</button>
                                    </form>
                                </fieldset>
                            
                            </div>

                            <div id="nivel" class="clase" style="display:none">
                                <br><br>
                                <fieldset>
                                    <legend>Busqueda por Nivel de Estudio</legend>
                                    <form action="accionesPersonal.php" destino="resultados" style="position:relative;top:25%;">
                                        <input type="hidden" name="accion" value="nivel_estudio">
                                        Muestrame todos los Docentes con el Nivel de Estudio de
                                        <select name="grado" required title="Selecciona el grado de estudios">
                                                <option value="">Selecciona</option>
                                                <option value="preparatoria">Preparatoria</option>
                                                <option value="licenciatura">Licenciatura</option>
                                                <option value="Pasante_maestria">Pasante de Maestria</option>
                                                <option value="maestria">Maestria</option>
                                                <option value="Pasante_doctorado">Pasante de Doctorado</option>
                                                <option value="doctorado">Doctorado</option>                                    
                                        </select>
                                        <button>Buscar</button>
                                    </form>
                                </fieldset>

                            </div>

                            <div id="perso" class="clase" style="display:none">
                                <br><br>
                                    <form action="accionesPersonal.php" destino="resultados" style="position:relative;top:25%;">
                                        <input type="hidden" name="accion" value="status">
                                            Muestrame a todos los Docentes                              
                                        <button>Buscar</button>
                                    </form>
                                
                            </div>
                            <div id="nombramiento" class="clase" style="display:none">
                                <br><br>
                                <fieldset>
                                    <legend>Busqueda por Nombramiento</legend>
                                    <form action="accionesPersonal.php" destino="resultados" style="position:relative;top:25%;">
                                        <input type="hidden" name="accion" value="nombramiento">
                                        Muestrame a todos los Docentes con el Nombramiento de
                                        <select name="nombramiento">
                                            <option>Base</option>
                                            <option>Interino</otion>
                                        </select>
                                        <button>Buscar</button>
                                    </form>
                                </fieldset>
                            </div>

                            <div id="resultados"></div>                 


                </div> 
            </div> 
        <div>
        <div class="tabCont" id="Claves" style="display:none">
            <div class="tabs">
                        <ul>
                            <li><a href="#Puesto">Historial</a></li>
                            <li><a href="#Categoria">Categoria</a></li>
                            <li><a href="#Horas">Horas</a></li>
                            <li><a href="#Estado">Todas</a></li>
                        </ul>
                    
                    
                        
                        <div id="Puesto" class="clase" style="display:none">
                            <br/><br/>
                            <fieldset>
                                <legend>Busqueda por Puesto</legend>
                                <form action="accionesClave.php" destino="resultados">
                                    <input type="hidden" name="accion" value="puesto">
                                   Muestrame el Historial de Claves de 
                                    <select name="idU">';
                                        $usuarios = mysqli_query($conexion,"SELECT id_usuario,CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS  nombre FROM Usuarios WHERE status=1");
                                        while($nombre = mysqli_fetch_array($usuarios)){
                                            echo'<option value="'.$nombre['id_usuario'].'">'.$nombre['nombre'].'</option>';
                                        }
                                    echo' 
                                    </select>
                                    <button class="enviar" >Buscar</button>
                                </form>
                            </fieldset>
                        </div>

                        <div id="Categoria" class="clase" style="display:none">
                            <br/><br/>
                            <fieldset>
                                <lenged>Busqueda por Categoria</lenged>
                                <form action="accionesClave.php" destino="resultados">
                                    <input type="hidden" name="accion" value="categoria">
                                    Muestrame a todos los Docentes con la Categoria
                                    <select name="categoria">
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
                                    <button class="enviar" >Buscar</button>
                                </form>
                            </fieldset>
                        </div>
                        
                        <div id="Horas" class="clase" style="display:none">
                            <br/><br/>
                            <fieldset>
                                <legend>Busqueda por Horas</legend>
                                <form action="accionesClave.php" destino="resultados">
                                    Muestrame todas las claves con 
                                    <input type="hidden" name="accion" value="horas"/>
                                    <input type="number" name="hora" size="15px"/>
                                    Horas
                                    <button class="enviar">Buscar</button>
                                </form>
                            </fieldset>
                        </div>

                        <div class="clase" id="Estado" style="display:none">
                            <br><br>
                                                    
                                <form action="accionesClave.php" destino="resultados">
                                    <input type="hidden" name="accion" value="estado">
                                    Muestrame todas las claves
                                    <button class="enviar" >Buscar</button>
                                </form>
                            
                        </div>
                    </div>
        </div>
        <div style="display:none" class="tabCont" id="Horarios">
            <div class="tabs">
                    <ul>
                        <li><a href="#Docentes">Docente</a></li>
                        <li><a href="#Estado">Todos los Horarios</a></li>
                    </ul>
                    
                        <div id="Docentes" class="clase" style="display:none">
                            <br/><br/>
                            <fieldset>
                                <legend>Busqueda de Horario por Docente</legend>
                                <form action="accionesHorarios.php" destino="resultados">
                                    <input type="hidden" name="accion" value="porDocente">
                                    Muestrame los horarios de
                                    <select name="id_usuario">';
                                        $perso = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre) AS nombre,id_usuario FROM Usuarios WHERE status=1");
                                        while($dataU= @mysqli_fetch_assoc($perso)){
                                            echo'
                                            <option value="'.$dataU['id_usuario'].'">'.$dataU['nombre'].'</option>
                                            ';
                                        }
                                    echo'
                                    </select>
                                    <br/>
                                    <button>Buscar</button>
                                </form>
                            </fieldset>
                        </div>

                        <div id="Estado" class="clase" style="display:none">
                            <br/><br/>
                            
                                <form action="accionesHorarios.php" destino="resultados">
                                    <input type="hidden" name="accion" value="estado">
                                    Muestrame todos los registros 
                                    <button>Buscar</button>
                                </form>
                        
                        </div>
                    </div>
        </div>

    </div>
</div>

';
    if(substr($_SESSION["Permisos_Eneaware"][4],0,1)=="0"){
        echo "<script>$('#principalInner [permiso=A]').remove()</script>";
    }
    if(substr($_SESSION["Permisos_Eneaware"][4],1,1)=="0"){
        echo "<script>$('#principalInner [permiso=D]').remove()</script>";
    }
    if(substr($_SESSION["Permisos_Eneaware"][4],2,1)=="0"){
        echo "
            <script>
                $('#principalInner form[permiso=M] input').prop('disabled', true);
                $('#principalInner form[permiso=M] select').prop('disabled', true);
                $('#principalInner form[permiso=M] button').remove();
            </script>";
    }
?>
