<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/printThis.js"></script>

<?php
session_start();
    if(isset($_SESSION["Usuario_Eneaware"])){
        if($_SESSION["Permisos_Eneaware"][22]!="000"){
            include('conexion.php');


            if($_POST['accion']=="guardar"){
                $cont = $_POST["for"];
                $hoy = date("Y-m-d");
                $hora = date("H:i:s");

                if ($_POST["tipo"]==1) {//periodo ordinario
                    foreach($_POST as $nombre_campo => $valor){ 
                        for ($i=1; $i <= $cont ; $i++) { 
                            if($nombre_campo=="CalF_".$i){
                                $respuesta=$valor;
                                $guardar = mysqli_query($conexion,"INSERT INTO Resultados_generales SET id_alumno=".$_POST["id_alumno".$i].", id_materia='".$_POST["materia"]."',cal_final='".$respuesta."',asistencias='".$_POST["Asis_".$i]."', fecha_r1='0000/00/00', cal_r1='0.00', fecha_r2='0000/00/00', cal_r2='0.00', fecha_r3='0000/00/00', cal_r3='0.00',periodo='".$_POST["periodo"]."';");   
                            }
                        }
                    }

                    $comproba = mysqli_query($conexion,"SELECT * FROM Materias WHERE id_materia = ".$_POST["materia"]." ;");
                    while($datos = mysqli_fetch_array($comproba)){

                        $materia=$datos["materia"];
                        $clave=$datos["clave"];
                        $semestre=$datos["semestre"];
                        $carrera=$datos["carrera"];

                    }

                    echo'<br>
                        <button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>
                    
                        <div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:21.59cm;border:1px solid grey; height:27.94cm ">              
                            <img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:15%;left:5%;"/>    
                            <span style="position:relative;left:70%;top:-10px;">'.date("m/d/Y").'<br> <b>Docente:</b> '.$_SESSION["Nombre_Usuario_Eneaware"].'</span>
                            
                            <center><h2>Reporte de Calificaciones</h2><h5>Tipo de evaluacion: Ordinario</h5></center>

                            <p>
                            Por medio del siguiente reporte presento las calificaciones subidas de la agsinatura: <strong> '.$clave.' - '.$materia.' </strong> en el 
                            periodo: <strong> '.$_POST["periodo"].' </strong> para los alumnos del <strong> '.$semestre.'° </strong> semestre de la carrera:
                            <strong> '.$carrera.' </strong> que yo imparto, haciendo constar que las calificaciones ascriptas a este reporte son las que reporte a mis 
                            alumnos en clase.
                            </p>

                            <table  style="width: 100%;">
                                                            
                                <tr>
                                    <th>Matricula</th>
                                    <th>Alumno</th>
                                    <th>Cal. Final</th>
                                    <th>Asistencia</th>                     
                                </tr>';

                                for ($i=1; $i <= $cont ; $i++) { 
                                    $alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE id_alumno=".$_POST["id_alumno".$i]."  ORDER BY apellidoP,apellidoM ASC ");
                                    $datosAl = mysqli_fetch_array($alumno);
                                    echo'
                                    <tr>
                                        <td>'.$datosAl['matricula'].'</td>
                                        <td>'.$datosAl['nombre'].'</td>
                                        <td>'.$_POST["CalF_".$i].'</td>
                                        <td>'.$_POST["Asis_".$i].'</td>                     
                                    </tr>
                                    ';
                                }

                        echo'    </table>
                        <br><br>
                        <div style="position:relative;top:0;right:-355px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma Docente</b></div>
                        <div style="position:relative;top:-85px;right:-595px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma y sello control escolar</b></div>

                        </div><br>
                    ';

                }
                if ($_POST["tipo"]==5) {//periodo extraordinario
                    foreach($_POST as $nombre_campo => $valor){ 
                        for ($i=1; $i <= $cont ; $i++) { 
                            if($nombre_campo=="CalF_".$i){
                                $respuesta=$valor;
                                $guardar = mysqli_query($conexion,"INSERT INTO Resultados_generales SET id_alumno=".$_POST["id_alumno".$i].", id_materia='".$_POST["materia"]."',cal_final='".$respuesta."',asistencias='".$_POST["Asis_".$i]."', fecha_r1='0000/00/00', cal_r1='0.00', fecha_r2='0000/00/00', cal_r2='0.00', fecha_r3='0000/00/00', cal_r3='0.00',periodo='".$_POST["periodo"]."';");   
                            }
                        }
                    }

                    $comproba = mysqli_query($conexion,"SELECT * FROM Materias WHERE id_materia = ".$_POST["materia"]." ;");
                    while($datos = mysqli_fetch_array($comproba)){

                        $materia=$datos["materia"];
                        $clave=$datos["clave"];
                        $semestre=$datos["semestre"];
                        $carrera=$datos["carrera"];

                    }

                    echo'<br>
                        <button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>
                    
                        <div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:21.59cm;border:1px solid grey; height:27.94cm ">              
                            <img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:15%;left:5%;"/>    
                            <span style="position:relative;left:70%;top:-10px;">'.date("m/d/Y").'<br> <b>Docente:</b> '.$_SESSION["Nombre_Usuario_Eneaware"].'</span>
                            
                            <center><h2>Reporte de Calificaciones</h2><h5>Tipo de evaluacion: Extraordinario</h5></center>

                            <p>
                            Por medio del siguiente reporte presento las calificaciones subidas de la agsinatura: <strong> '.$clave.' - '.$materia.' </strong> en el 
                            periodo: <strong> '.$_POST["periodo"].' </strong> para los alumnos del <strong> '.$semestre.'° </strong> semestre de la carrera:
                            <strong> '.$carrera.' </strong> que yo imparto, haciendo constar que las calificaciones ascriptas a este reporte son las que reporte a mis 
                            alumnos en clase.
                            </p>

                            <table  style="width: 100%;">
                                                            
                                <tr>
                                    <th>Matricula</th>
                                    <th>Alumno</th>
                                    <th>Cal. Final</th>
                                    <th>Asistencia</th>                     
                                </tr>';

                                for ($i=1; $i <= $cont ; $i++) { 
                                    $alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE id_alumno=".$_POST["id_alumno".$i]."  ORDER BY apellidoP,apellidoM ASC ");
                                    $datosAl = mysqli_fetch_array($alumno);
                                    echo'
                                    <tr>
                                        <td>'.$datosAl['matricula'].'</td>
                                        <td>'.$datosAl['nombre'].'</td>
                                        <td>'.$_POST["CalF_".$i].'</td>
                                        <td>'.$_POST["Asis_".$i].'</td>                     
                                    </tr>
                                    ';
                                }

                        echo'    </table>
                        <br><br>
                        <div style="position:relative;top:0;right:-355px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma Docente</b></div>
                        <div style="position:relative;top:-85px;right:-595px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma y sello control escolar</b></div>

                        </div><br>
                    ';

                }
                if ($_POST["tipo"]==2) {//1ra reguralizacion
                    foreach($_POST as $nombre_campo => $valor){ 
                        for ($i=1; $i <= $cont ; $i++) { 
                            if($nombre_campo=="CalR".$i){
                                $respuesta=$valor;
                                $guardar = mysqli_query($conexion,"UPDATE Resultados_generales SET fecha_r1='".$_POST["FechaR".$i]."', cal_r1='$respuesta' WHERE id_resultado=".$_POST["id_alumno".$i].";");   
                            }
                        }
                    }

                    $comproba = mysqli_query($conexion,"SELECT * FROM Materias WHERE id_materia = ".$_POST["materia"]." ;");
                    while($datos = mysqli_fetch_array($comproba)){

                        $materia=$datos["materia"];
                        $clave=$datos["clave"];
                        $semestre=$datos["semestre"];
                        $carrera=$datos["carrera"];

                    }

                    echo'<br>
                        <button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>
                    
                        <div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:21.59cm;border:1px solid grey; height:27.94cm ">              
                            <img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:15%;left:5%;"/>    
                            <span style="position:relative;left:70%;top:-10px;">'.date("m/d/Y").'<br> <b>Docente:</b> '.$_SESSION["Nombre_Usuario_Eneaware"].'</span>
                            
                            <center><h2>Reporte de Calificaciones</h2><h5>Tipo de evaluacion: 1ra Regularizacion</h5></center>

                            <p>
                            Por medio del siguiente reporte presento las calificaciones subidas de la agsinatura: <strong> '.$clave.' - '.$materia.' </strong> en el 
                            periodo: <strong> '.$_POST["periodo"].' </strong> para los alumnos del <strong> '.$semestre.'° </strong> semestre de la carrera:
                            <strong> '.$carrera.' </strong> que yo imparto, haciendo constar que las calificaciones ascriptas a este reporte son las que reporte a mis 
                            alumnos en clase.
                            </p>

                            <table  style="width: 100%;">
                                                            
                                <tr>
                                    <th>Matricula</th>
                                    <th>Alumno</th>
                                    <th>Cal. Final</th>
                                    <th>Asistencia</th>   
                                    <th>Fecha</th>
                                    <th>Cal.</th>                     
                                </tr>';

                                for ($i=1; $i <= $cont ; $i++) { 
                                    $alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE id_alumno=".$_POST["alm".$i]."  ORDER BY apellidoP,apellidoM ASC ");
                                    $datosAl = mysqli_fetch_array($alumno);
                                    echo'
                                    <tr>
                                        <td>'.$datosAl['matricula'].'</td>
                                        <td>'.$datosAl['nombre'].'</td>
                                        <td>'.$_POST["calf".$i].'</td>
                                        <td>'.$_POST["asi".$i].'</td>  
                                        <td>'.$_POST["FechaR".$i].'</td>
                                        <td>'.$_POST["CalR".$i].'</td>                     
                                    </tr>
                                    ';
                                }

                        echo'    </table>
                        <br><br>
                        <div style="position:relative;top:0;right:-355px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma Docente</b></div>
                        <div style="position:relative;top:-85px;right:-595px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma y sello control escolar</b></div>

                        </div><br>
                    ';

                }
                if ($_POST["tipo"]==3) {//2da reguralizacion
                    foreach($_POST as $nombre_campo => $valor){ 
                        for ($i=1; $i <= $cont ; $i++) { 
                            if($nombre_campo=="CalR".$i){
                                $respuesta=$valor;
                                $guardar = mysqli_query($conexion,"UPDATE Resultados_generales SET fecha_r2='".$_POST["FechaR".$i]."', cal_r2='$respuesta' WHERE id_resultado=".$_POST["id_alumno".$i].";");   
                            }
                        }
                    }

                    $comproba = mysqli_query($conexion,"SELECT * FROM Materias WHERE id_materia = ".$_POST["materia"]." ;");
                    while($datos = mysqli_fetch_array($comproba)){

                        $materia=$datos["materia"];
                        $clave=$datos["clave"];
                        $semestre=$datos["semestre"];
                        $carrera=$datos["carrera"];

                    }

                    echo'<br>
                        <button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>
                    
                        <div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:21.59cm;border:1px solid grey; height:27.94cm ">              
                            <img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:15%;left:5%;"/>    
                            <span style="position:relative;left:70%;top:-10px;">'.date("m/d/Y").'<br> <b>Docente:</b> '.$_SESSION["Nombre_Usuario_Eneaware"].'</span>
                            
                            <center><h2>Reporte de Calificaciones</h2><h5>Tipo de evaluacion: 2da Regularizacion</h5></center>

                            <p>
                            Por medio del siguiente reporte presento las calificaciones subidas de la agsinatura: <strong> '.$clave.' - '.$materia.' </strong> en el 
                            periodo: <strong> '.$_POST["periodo"].' </strong> para los alumnos del <strong> '.$semestre.'° </strong> semestre de la carrera:
                            <strong> '.$carrera.' </strong> que yo imparto, haciendo constar que las calificaciones ascriptas a este reporte son las que reporte a mis 
                            alumnos en clase.
                            </p>

                            <table  style="width: 100%;">
                                                            
                                <tr>
                                    <th>Matricula</th>
                                    <th>Alumno</th>
                                    <th>Cal. Final</th>
                                    <th>Asistencia</th>
                                    <th>Fecha</th>
                                    <th>Cal.</th>
                                    <th>Fecha</th>
                                    <th>Cal.</th>                    
                                </tr>';

                                for ($i=1; $i <= $cont ; $i++) { 
                                    $alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE id_alumno=".$_POST["alm".$i]."  ORDER BY apellidoP,apellidoM ASC ");
                                    $datosAl = mysqli_fetch_array($alumno);
                                    echo'
                                    <tr>
                                        <td>'.$datosAl['matricula'].'</td>
                                        <td>'.$datosAl['nombre'].'</td>
                                        <td>'.$_POST["calf".$i].'</td>
                                        <td>'.$_POST["asi".$i].'</td>  
                                        <td>'.$_POST["calfr".$i].'</td>
                                        <td>'.$_POST["asir".$i].'</td> 
                                        <td>'.$_POST["FechaR".$i].'</td>
                                        <td>'.$_POST["CalR".$i].'</td>                     
                                    </tr>
                                    ';
                                }

                        echo'    </table>
                        <br><br>
                        <div style="position:relative;top:0;right:-355px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma Docente</b></div>
                        <div style="position:relative;top:-85px;right:-595px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma y sello control escolar</b></div>

                        </div><br>
                    ';

                }
                if ($_POST["tipo"]==4) {//3ra reguralizacion
                    foreach($_POST as $nombre_campo => $valor){ 
                        for ($i=1; $i <= $cont ; $i++) { 
                            if($nombre_campo=="CalR".$i){
                                $respuesta=$valor;
                                $guardar = mysqli_query($conexion,"UPDATE Resultados_generales SET fecha_r3='".$_POST["FechaR".$i]."', cal_r3='$respuesta' WHERE id_resultado=".$_POST["id_alumno".$i].";");   
                            }
                        }
                    }

                    $comproba = mysqli_query($conexion,"SELECT * FROM Materias WHERE id_materia = ".$_POST["materia"]." ;");
                    while($datos = mysqli_fetch_array($comproba)){

                        $materia=$datos["materia"];
                        $clave=$datos["clave"];
                        $semestre=$datos["semestre"];
                        $carrera=$datos["carrera"];

                    }

                    echo'<br>
                        <button style="position:relative;left:45%;top:-1px;" onclick="este = $(this);$(this).next().css({\'border\':\'none\'});setTimeout(function(){este.next().css({\'border\':\'1px solid grey\'});}, 1000);$(this).next().printThis();">Imprimir <img src="imagenes/print.png"/></button>
                    
                        <div  style="font-family:Arial;margin:auto;padding:1cm;background:white;width:21.59cm;border:1px solid grey; height:27.94cm ">              
                            <img src="imagenes/inicio.jpg" width="60px" height="60px" style="z-index:2;position:relative;top:15%;left:5%;"/>    
                            <span style="position:relative;left:70%;top:-10px;">'.date("m/d/Y").'<br> <b>Docente:</b> '.$_SESSION["Nombre_Usuario_Eneaware"].'</span>
                            
                            <center><h2>Reporte de Calificaciones</h2><h5>Tipo de evaluacion: 3ra Regularizacion</h5></center>

                            <p>
                            Por medio del siguiente reporte presento las calificaciones subidas de la agsinatura: <strong> '.$clave.' - '.$materia.' </strong> en el 
                            periodo: <strong> '.$_POST["periodo"].' </strong> para los alumnos del <strong> '.$semestre.'° </strong> semestre de la carrera:
                            <strong> '.$carrera.' </strong> que yo imparto, haciendo constar que las calificaciones ascriptas a este reporte son las que reporte a mis 
                            alumnos en clase.
                            </p>

                            <table  style="width: 100%;">
                                                            
                                <tr>
                                    <th>Matricula</th>
                                    <th>Alumno</th>
                                    <th>Cal. Final</th>
                                    <th>Asistencia</th>
                                    <th>Fecha</th>
                                    <th>Cal.</th>
                                    <th>Fecha</th>
                                    <th>Cal.</th> 
                                    <th>Fecha</th>
                                    <th>Cal.</th>                    
                                </tr>';

                                for ($i=1; $i <= $cont ; $i++) { 
                                    $alumno = mysqli_query($conexion,"SELECT CONCAT(apellidoP,' ',apellidoM,' ',nombre ) AS nombre,matricula,id_alumno FROM Alumnos WHERE id_alumno=".$_POST["alm".$i]."  ORDER BY apellidoP,apellidoM ASC ");
                                    $datosAl = mysqli_fetch_array($alumno);
                                    echo'
                                    <tr>
                                        <td>'.$datosAl['matricula'].'</td>
                                        <td>'.$datosAl['nombre'].'</td>
                                        <td>'.$_POST["calf".$i].'</td>
                                        <td>'.$_POST["asi".$i].'</td>  
                                        <td>'.$_POST["calfr".$i].'</td>
                                        <td>'.$_POST["asir".$i].'</td> 
                                        <td>'.$_POST["calfr2".$i].'</td>
                                        <td>'.$_POST["asir2".$i].'</td> 
                                        <td>'.$_POST["FechaR".$i].'</td>
                                        <td>'.$_POST["CalR".$i].'</td>                     
                                    </tr>
                                    ';
                                }

                        echo'    </table>
                        <br><br>
                        <div style="position:relative;top:0;right:-355px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma Docente</b></div>
                        <div style="position:relative;top:-85px;right:-595px;width:220px;height:80px;border:2px solid gray;border-radius:8px; text-align: center;"><b><br><br><br>Firma y sello control escolar</b></div>

                        </div><br>
                    ';

                }
            	
                

                $guardar = mysqli_query($conexion,"INSERT INTO Detalles_evaluacion SET id_docente=".$_POST["docente"].", id_materia='".$_POST["materia"]."',tipo_evaluacion='".$_POST["tipo"]."',periodo='".$_POST["periodo"]."',fecha='".$hoy."', hora='".$hora."';");   
                echo'<br><br><center><form destino="resultadoRegistro" action="segi.php" style="width:95%">
                    <input type="hidden" name="option" value="fin">
                    <button>Finalizar</button>
                </form></center><br><br>';
               		
        		
        	}

            if($_POST['accion']=="recap"){//recaptura de calificaciones

                $cont = $_POST["for"];
                foreach($_POST as $nombre_campo => $valor){ 
                        for ($i=1; $i <= $cont ; $i++) { 
                            if($nombre_campo=="CalF_".$i){
                                $respuesta=$valor;
                                $guardar = mysqli_query($conexion,"UPDATE Resultados_generales SET cal_final='$respuesta', asistencias='".$_POST["Asis_".$i]."', fecha_r1='".$_POST["fecha_r1".$i]."', cal_r1='".$_POST["cal_r1".$i]."', fecha_r2='".$_POST["fecha_r2".$i]."', cal_r2='".$_POST["cal_r2".$i]."', fecha_r3='".$_POST["fecha_r3".$i]."', cal_r3='".$_POST["cal_r3".$i]."' WHERE id_resultado=".$_POST["id_resultado".$i].";");   
                            }
                        }
                    }

                echo 'Calificaciones recapturadas...
                    <script>
                        $("[carga=subir]").trigger("click");
                        setTimeout(function(){$("[mostrar=modificar]").trigger("click")},1000);
                    </script>
                    ';

            }
           


    	}
    }			
    
    
?>