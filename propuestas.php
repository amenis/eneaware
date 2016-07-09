<script src="js/jquery.tablePagination.js" ></script>
<script src="js/jquery-ui.js"></script>
<?php
    session_start();
    include("conexion.php");
    require_once('funciones.php');
    echo'
        <script>
            
            function agregrar(){
                $("#notasProp").val("<span style=position:relative;left:80%;top:3%;>"+$("#numero").html()+"</span><br/>"+
                    $("#encabezado").html()+"<br/><br/><br/><br/>"+$("#notas").html());
            }

        </script>

        <div style="overflow:auto;height:100%">
        <h1>Administración de Propuestas</h1>
        <button class="tab seleccionado"  style="border-bottom:none;" permiso="A" mostrar="registrarPropuesta">Registrar Propuesta</button>
        <button class="tab" style="border-bottom:none;" mostrar="modificarProp">Ver Propuestas</button>
        <button class="tab" style="border-bottom:none;" mostrar="restaurarProp">Restaurar Propuestas</button>
        <div style="background:rgba(255,255,255,0.65);border:1px solid rgba(0,0,0,0.2);padding-left:20px;">
            <div id="registrarPropuesta" class="tabCont" permiso="A">
                <h2>Registrar Propuesta</h2>
                <form action="accionesPropuestas.php" destino="resultadoRegistro" style="width:95%">
                    <input type="hidden" name="accion" value="registro"> 
                    <input type="hidden" name="periodo" value="'.date('Y').'/'.(date('Y')+1).'">
                    <input type="hidden" name="fecha" value="'.date('Y-m-d').'">
                    <input type="hidden" name="notas" id="notasProp" >
                    <div style="font-family:Arial;margin:auto;padding:2cm;background:white;width:17.5cm;border:1px solid grey; height:24cm">
                        ';
                        $consulta = mysqli_query($conexion,"SELECT MAX('id_propuesta')");
                        $arrProp = mysqli_fetch_row($consulta);
                        mysqli_free_result($consulta);
                        echo'
                        <div id="numero" style="position:relative;left:80%;top:3%;">No '.($arrProp[0]+1).' -<span contenteditable>{PERIODO}</span></div>
                        <br/><br/>
                        <b>Selecciona al docente</b>
                        <select name="usuario" onchange="$(\'#nombre\').text($(this).find(\'option:selected\').attr(\'nombre\'))">';
                            $docente= mysqli_query($conexion,"SELECT id_usuario,apellidoP,apellidoM,nombre FROM Usuarios WHERE status =1");
                            $cantDo = mysqli_num_rows($docente);
                            $cant=0;
                            while($cant < $cantDo){
                                $data= mysqli_fetch_assoc($docente);
                                echo'
                                <option value="'.$data['id_usuario'].'" nombre="'.$data['apellidoP']." ".$data['apellidoM']." ".$data['nombre'].'">'.$data['apellidoP']." ".$data['apellidoM']." ".$data['nombre'].'</option>
                                ';
                                $cant++;
                            }
                        $Nmes = mes(date("m"));
                        echo'
                        </select>
                        <br/>
                        <div id="encabezado">
                           <span style="position:relative;left:60%"> Guadalajara Jal A '.date('d').' de '.$Nmes.' de '.date('Y').'</span>
                            <br/>
                            <b>
                                <table >
                                    <tr><td>L.E.P. FRANCISCO DE JESÚS AYÓN LÓPEZ</td></tr>
                                    <tr><td>SECRETARIO DE EDUCACIÓN</td></tr>
                                    <tr><td>P r e s e n t e ._</td></tr>
                                    <tr><td style="position:relative;left:60%">At’n<br/>MTRA. VANESSA ISABEL RIVAS DÍAZ DE  SANDI</td></tr>
                                    <tr><td style="position:relative;left:60%">DIRECTORA GENERAL DE PERSONAL </td></tr>
                                    <tr><td style="position:relative;left:60%">RELACIONES LABORALES.</td></tr>
                                    <tr><td style="position:relative;left:60%">P r e s e n t e  . </td></tr>
                                </table>
                            </b>
                        </div>
                        <div id="notas" contenteditable style="position:relative; top:5%;text-align:width:100%; border:1px dashed grey;">
                           
                            Me permito proponer a Usted <span id="nombre" "style="text-decoration:underline;">{DOCENTE}</span> con _<span style="color:blue">{HORAS}</span>_
                            horas de <span style="color:blue">{CATEGORIA}</span> en forma de CONTINUACION DE INTERINATO en sustitución <span style="color:blue">{PERSONAL SUSTITUIDO}</span>
                            con dictamen de Homologación de _<span style="color:blue">{CATEGORIA}</span>_, quién  
                            presentó PRORROGA DE LICENCIA partir del _<span style="color:blue">{FECHA PRORROGA}</span>_. La presente se hace 
                            para que surta efectos a partir del _<span style="color:blue">{FECHA}</span>_. 
                            <br/><br/>
                            <span style="font-size:8pt;">
                                Conforme a lo que establece el artículo 61 fracción XIV, de la Ley de Responsabilidades de los Servidores Públicos 
                                del Estado de Jalisco, los firmantes declaramos, bajo protesta de decir verdad, que no tenemos parentesco alguno por
                                consaguinidad o por afinidad hasta cuarto grado, con la persona propuesta”.
                            </span>
                            <br/><br/>
                            <span>
                                <center><span style="font-size:9pt">Sin otro particular, reitero a Usted mi más distinguida consideración y respeto.
                                <br>ATENTAMENTE</span></center>
                                <br/>
                                <b> "2013, AÑO DE BELISARIO DOMÍNGUEZ Y 190 ANIVERSARIO DEL NACIMIENTO DEL ESTADO LIBRE Y
                                 SOBERANO DE JALISCO"
                            </span>
                            
                            <table style="width:95%;">
                                <tr>
                                    <td style="text-align:center" colspan="2"> Vo. Bo.<br/>   
                                        DIRECTOR GENERAL DE EDUCACIÓN NORMAL
                                        <br>
                                    </td>
                                    <td>
                                    </td>
                                </tr>                                        
                                     <td style="text-align:center" colspan="2">MTRO. VÍCTOR MANUEL DE LA TORRE ESPINOZA</td>
                                     <td></td>
                                </tr>
                                <tr>
                                    <td style="position:relative;left:10%;"><br/>DIRECTORA</td><td style="position:relative;left:10%;"><br/>SECRETARIA GENERAL DE LA <br/> DELEGACIÓN D-II-87  </td>
                                </tr>

                                <tr>
                                    <td style="position:relative;left:10%;">
                                        <br/><br/><br/><br/>
                                        MTRA.  LUZ CELINA RAMÍREZ VARGAS
                                    </td>
                                    <td style="position:relative;left:10%;">
                                        <br/><br/><br/><br/>                                        
                                        LIC. MIRIAM GRISELDA JIMÉNEZ RAMÍREZ
                                    </td>
                                </tr>
                            </table>
                            </b>
                        </div>

                    </div>
                    <center><button onclick="agregrar()">Guardar</button></center>
                </form>
            </div>
            <div id="modificarProp" style="display:none;" class="tabCont">
                <h2>Modificar claves</h2>
                <div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
                    <input type="search" autofocus padre="propuestas" placeholder="Buscar por nombre">
                    <img src="imagenes/search.png" onclick="$(this).prev().trigger(\'search\')">
                </div>
                <table id="propuestas" width="100%;">';
                    $sql= "SELECT * FROM Propuestas WHERE status=1 ";
                    $propuestas = mysqli_query($conexion,$sql);
                    $num = mysqli_num_rows($propuestas);
                    $cant=0;
                                      
                    while($cant < $num){
                        $dataP = @mysqli_fetch_assoc($propuestas);
                        echo'
                        <tr class="propuestas">
                            <td>
                                <span class="propuestas_nombre" style="display:none">'.$dataP['id_propuesta'].'</span>
                                <div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
                                    #num Propuestas '.$dataP['id_propuesta'].'
                                    <div id="prop'.$dataP['id_propuesta'].'" style="display:none">
                                        <button onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();"><img src="imagenes/print.png"/></button>
                                        <div style="border:1px solid grey;font-weight:normal;font-family:Arial;margin:auto;padding:2cm;background:white;width:18cm; height:24cm;">
                                            <div style="text-align:justify">'.$dataP["notas"].'</div>
                                        </div>
                                       
                                    </div>
                                    <img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(\'#prop'.$dataP['id_propuesta'].'\').toggle(\'drop\')"><br/>
                                    <img src="imagenes/bin.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(this).next().next().toggle(\'drop\')"><br/>
                                    <form action="accionesPropuestas.php" destino="resultadoRegistro" style="display:none">
                                        <input type="hidden" name="accion" value="baja">
                                        <input type="hidden" name="id_propuesta" value="'.$dataP['id_propuesta'].'">
                                        Estas Seguro que Desas dar de Baja este Documento
                                        <button>Si</button>
                                        <button onclick="$(this).parent().toggle(\'drop\');return false;">No</button>
                                    </form>
                                </div>
                            </td>
                        </tr>';
                        $cant++;
                    }
                    mysqli_free_result($propuestas);
                              
                        
                echo'
                </table>
                    <script>
                        $("#propuestas").tablePagination({});
                         $.expr[":"].Contains = function(x, y, z){
                            return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
                          };
                                    
                    </script>
                <div style="border-bottom:1px solid rgba(0,0,0,0.2);width:95%;padding-left:20px;"></div>';
                
                echo'   
                            
            </div>
            <div id="restaurarProp" style="display:none;" class="tabCont">
                <h2>Restaurar claves</h2>
                <div style="padding:8px;position:absolute;top:-20px;right:0;" class="buscar">
                    <input type="search" autofocus padre="restore" placeholder="Buscar por nombre">
                    <img src="imagenes/search.png" >
                </div>
                <table id="restore" width="100%">';

                    $sql= "SELECT * FROM Propuestas WHERE status=0 ";
                    $propuestas = mysqli_query($conexion,$sql);
                    $num = mysqli_num_rows($propuestas);
                    $cant=0;
                                      
                    while($cant < $num){
                        $dataP = @mysqli_fetch_assoc($propuestas);
                        echo'
                        <tr class="restore">
                            <td>
                                <span class="restore_nombre" style="display:none">'.$dataP['id_propuesta'].'</span>
                                <div style="position:relative;width:95%;padding:10px;border:1px solid rgba(0,0,0,0.2);">
                                    #num Propuestas '.$dataP['id_propuesta'].'
                                    <div id="prop'.$dataP['id_propuesta'].'" style="display:none">
                                        <button onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();"><img src="imagenes/print.png"/></button>
                                        <div style="border:1px solid grey;font-weight:normal;font-family:Arial;margin:auto;padding:2cm;background:white;width:18cm; height:24cm;">
                                            <div style="text-align:justify">'.$dataP["notas"].'</div>
                                        </div>
                                       
                                    </div>
                                    <img src="imagenes/edit.png" style="position:absolute;top:4px;right:32px;cursor:pointer" onclick="$(\'#prop'.$dataP['id_propuesta'].'\').toggle(\'drop\')"><br/>
                                    <img src="imagenes/checkmark.png" style="position:absolute;top:4px;right:4px;cursor:pointer" onclick="$(this).next().next().toggle(\'drop\')"><br/>
                                    <form action="accionesPropuestas.php" destino="resultadoRegistro" style="display:none">
                                        <input type="hidden" name="accion" value="restaurar">
                                        <input type="hidden" name="id_propuesta" value="'.$dataP['id_propuesta'].'">
                                        Estas Seguro que Desas Restaurar este Documento
                                        <button>Si</button>
                                        <button onclick="$(this).parent().toggle(\'drop\');return false;">No</button>
                                    </form>
                                </div>
                            </td>
                        </tr>';
                        $cant++;
                    }
                    mysqli_free_result($propuestas);
                              
                        
                echo'
                </table>
                    <script>
                        $("#restore").tablePagination({});
                         $.expr[":"].Contains = function(x, y, z){
                            return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
                          };
                                    
                    </script>
             
            </div>
            <script>calcularClave();</script>
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