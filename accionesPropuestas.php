<?php
    session_start();
     if(isset($_SESSION["Usuario_Eneaware"])){
        if($_SESSION["Permisos_Eneaware"][8]!="000"){
            include('conexion.php');

            if($_POST['accion']=="registro"){
                extract($_POST);
                $insertar = mysqli_query($conexion,"INSERT INTO Propuestas() VALUES(null,'".$usuario."','".$fecha."','".$periodo."','".$notas."',1)");
                if($insertar){
                    echo'
                    Propuesta Registrada
                    <script>  
                        $("[carga=propuestas]").trigger("click");
                    </script>';
                }
                
            } 

            if($_POST['accion']=="baja"){
                extract($_POST);
                $baja = mysqli_query($conexion,"UPDATE Propuestas SET notas=concat('<div style=\"position:absolute;top:45%;left:35%;color:darkred;-webkit-transform:rotate(-45deg);font-size:48pt\">CANCELADA</div>', notas), status=0 WHERE id_propuesta=".$id_propuesta." ");
                if($baja){
                    echo'
                    PROPUESTA CANCELADA
                   <script>  
                        $("[carga=propuestas]").trigger("click");
                        setTimeout(function(){$("[ mostrar=modificarProp ]").trigger("click") });
                   </script>
                    ';
                }
                else{echo mysqli_error($conexion);}
                
            } 
             if($_POST['accion']=="restaurar"){
                extract($_POST);
                $restaurar = mysqli_query($conexion,"UPDATE Propuestas SET notas=replace(notas,'<div style=\"position:absolute;top:45%;left:35%;color:darkred;-webkit-transform:rotate(-45deg);font-size:48pt\">CANCELADA</div>',''),status=1 WHERE id_propuesta=".$id_propuesta." ");
                if($restaurar){
                    echo'
                    PROPUESTA RESTAURADA
                    <script> 
                        $("[carga=propuestas]").trigger("click");
                        setTimeout(function(){$("[ mostrar=restaurarProp ]").trigger("click") });
                    </script>
                    ';
                }
                
            }             
        }
    }
?>