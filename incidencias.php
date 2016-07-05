
<script src="js/jquery.tablePagination.js" ></script>
<script src="js/jquery-ui.js"></script>
<style>
    #tablePagination{
        position:relative;
        left:35%;
    }
</style>

<?php
session_start();
    include("conexion.php");
    echo '
    <div style="overflow:auto;height:100%">
        <h1>Incidencias</h1>
        <button class="tab seleccionado" mostrar="Nueva" permiso="A">Nueva Captura</button>
        <button class="tab" mostrar="Continuar" permiso="A" >Continuar Captura</button>
        <button class="tab" mostrar="imprimir" permiso="A" >Imprimir</button>
        <button class="tab" mostrar="VerInci" permiso="D" >Ver y Modificar Incidencias</button>
        <div id="editar" class="fondoBlanco">
            <div style="position:relative;top:35%;left:15%;background:ghostwhite;width:80%;border-radius:5px;height:160px;border:1px solid black;">
                <div style="position:relative;left:1%;background:gray;border-radius:5px;height:35px; width:98%; text-aling:center;border:1px solid black;"> 
                    <h3 style="color:white">Fila a Editar</h3>
                </div>
               
                <table style="position:relative;left:3%;">
                     <tr style="background:black;color:white;"> 
                        <th style="width:166px;">
                            Maestro:<br/>                       
                        </th>
                        <th style="width:166px;">
                            Fecha:<br/>
                        </th>
                        <th style="width:140px;">
                            Horarios:<br/>
                        </th>
                        <th style="width:130px;">
                            Motivo:<br/>
                        </th>
                        <th style="width:167px;" >
                            Actividad<br/>
                        </th>
                        <th style="width:235px;">
                            Observaciones<br/>
                        </th>
                        <th style="width:100px;">
                            Incidencia
                        </th>
                        <th>
                        </th>
                    </tr>

                </table>
              <form action="accionesIncidencias.php" destino="resultadoRegistro">
                    <input type="hidden" name="accion" value="modificar">
                    <table id="edicionRegistro" style="position:relative;left:3%;">
                    </table>
                    <center onclick="$(\'#editar\').hide();" ><button>Guardar</button></center>
                </form>
            </div>
            <img src="imagenes/cerrar.png" onclick="$(\'#editar\').hide();" style="cursor:pointer;position:fixed;top:3px;right:21px">
        </div>
        
        <div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
            <div id="Nueva" class="tabCont" permiso="A">               
                <div id="nuevaCaptura">
                    <h2>Nueva Captura</h2>
                    <form action="accionesIncidencias.php" destino="nuevaCaptura">
                        <input type="hidden" name="accion" value="new">
                        <table>
                            <tr>
                                <td>Fecha de Incicio</td>
                                <td><input type="date" name="fechaIni" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>Fecha de Final</td>
                                <td><input type="date" name="fechaFinal" required/>
                                </td>
                            </tr>
                        </table>
                       <center> <button>Registrar</button> </center>
                    </form> <br/>
                </div>               
            </div>
            <div id="Continuar" class="tabCont" style="display:none" permiso="A">
                <h2>Continuar Captura</h2>
                <div id="continuacion">
                    <form  action="accionesIncidencias.php" destino="continuacion">
                        <input type="hidden" name="accion" value="continuar">
                        Selecciona el Periodo a Continuar
                        <select id="periodo" name="periodo">
                            <option></option>';
                            $consultaP = mysqli_query($conexion,"SELECT  DISTINCT fecha_inicio,fecha_final FROM Insidencias ");
                            $cant=0;
                            $cantData= mysqli_num_rows($consultaP);
                            
                            while($cant < $cantData){
                                $periodo= mysqli_fetch_array($consultaP);
                               
                                echo'<option value="'.$periodo['fecha_inicio'].'--'.$periodo['fecha_final'].'">'.$periodo['fecha_inicio'].'-'.$periodo['fecha_final'].'</option>';
                                $cant++;
                            }
                echo' 
                        </select>
                        <button id="envia">Continuar</button>
                    </form><br/>
                </div>
            </div>
            
            <div id="imprimir" style="display:none" class="tabCont" permiso="A">
                <h2>Imprimir</h2>    
                <div id="imprimir">
                     <form  action="accionesIncidencias.php" destino="imprimir">
                        <input type="hidden" name="accion" value="imprimir">
                        Selecciona el Periodo a Imprimir
                        <select name="periodo">
                            <option></option>';
                            $consultaP = mysqli_query($conexion,"SELECT  DISTINCT fecha_inicio,fecha_final FROM Insidencias  ");

                            $cant=0;
                            $cantData= mysqli_num_rows($consultaP);
                            while($cant < $cantData){
                                $periodo= mysqli_fetch_array($consultaP);

                                echo'<option value="'.$periodo['fecha_inicio'].'--'.$periodo['fecha_final'].'">'.$periodo['fecha_inicio'].'-'.$periodo['fecha_final'].'</option>';
                                $cant++;
                            }
                echo' 
                        </select>
                        <button>Continuar</button>
                    </form><br/>
                </div>        
            </div>
            <div id="VerInci" style="display:none;" class="tabCont" >
                <h2>Ver y Modificar Incidencias</h2>
                <div id="modifcar">
                     <form  action="accionesIncidencias.php" destino="modifcar">
                        <input type="hidden" name="accion" value="ver">
                        Selecciona el Periodo a Ver
                        <select name="periodo" id="periodoMo">
                            <option></option>';
                            $consultaP = mysqli_query($conexion,"SELECT  DISTINCT fecha_inicio,fecha_final FROM Insidencias  ");
                            $cant=0;
                            $cantData= mysqli_num_rows($consultaP);
                            while($cant < $cantData){
                                $periodo= mysqli_fetch_array($consultaP);
                                $existe = mysqli_query($conexion,"SELECT * FROM Acciones_incidencia WHERE periodo='".$periodo['fecha_inicio']."-".$periodo['fecha_final']."' AND status=1");
                                if($existe){
                                    echo'<option value="'.$periodo['fecha_inicio'].'--'.$periodo['fecha_final'].'">'.$periodo['fecha_inicio'].'-'.$periodo['fecha_final'].'</option>';
                                }
                                else{
                                    
                                    
                                }
                                $cant++;
                            }
                echo' 
                        </select>
                        <button>Continuar</button>
                    </form><br/>
                <div>        
            </div>
        </div>
    </div>
    ';
    if(substr($_SESSION["Permisos_Eneaware"][6],0,1)=="0"){
        echo "<script>$('#principalInner [permiso=A]').remove()</script>";
    }
    if(substr($_SESSION["Permisos_Eneaware"][6],1,1)=="0"){
        echo "<script>$('#principalInner [permiso=D]').remove()</script>";
    }
    if(substr($_SESSION["Permisos_Eneaware"][6],2,1)=="0"){
        echo "
            <script>
                $('#principalInner form[permiso=M] input').prop('disabled', true);
                $('#principalInner form[permiso=M] select').prop('disabled', true);
                $('#principalInner form[permiso=M] button').remove();
            </script>";
    }
    mysqli_close($conexion);
?>