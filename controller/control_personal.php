<?php
    include('../model/accionesPersonal.php');
    //error_reporting(E_ALL);
    
   

    if(isset($_POST['action'])){}
    else{
        if($_POST['accion']=="registrar"){
            register();
        }
        if($_POST['accion'] == "modPer"){
            listPers();
        }
    }
   
    
    function register(){
        $acp = new accionesPersonal();
        extract($_POST);
        $permisos="";
        for($x=1;$x<108;$x++){
            if($x%4==0){
                $permisos.=",";
            }
			else {
                if(isset($_POST["pos".$x])){
				$permisos.="1";
                }
                else {
                    $permisos.="0";
                }	
            }
        }
        $formData = array(
                'usuario' => $usuario,
                'pass' => $pass,
                'apP' => $apP,
                'apM' => $apM,
                'nombre' => $nombre,
                'rfc' => $rfc,
                'curp' => $curp,
                'sexo' => $sexo,
                'tel' => $tel,
                'email' => $email,
                'domicilio' => $domicilio,
                'fechaN' => $fechaN,
                'edad'=> CalculaEdad($fechaN),
                'fechaIE' => $fechaIE,
                'grado' => $grado,
                'estudio' => $estudio,
                'escuela_estudia' => $escuela_estudia,
                'beca' => $beca,
                'tipo_beca' => $tipo_beca,
                'loginGranted' => $loginGranted,
                'permisos' => $permisos,
                'nombramiento' => $nombramiento,
                'funcion' => $funcion,
                'tipo_usuario' => $tipoUsuario,
                'turno' => $turno,
                'localidad' => $localidad,
                'municipio' => $municipio,
                'fechaIS' => $fechaIS,
                'otroJob' => $otroJob,
                'Lugar_trabajo' => $Lugar_trabajo,
                'estadoC' =>$estadoC
            );
        $response = $acp->saveEmploys($formData);
        echo $response;
    }
    function CalculaEdad($fecha ) {
        list($Y,$m,$d) = explode("-",$fecha);
        return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
    }
    
    function listPers(){
        $acp = new accionesPersonal();
        $result = $acp->getAllPersonal($_POST['pages']);        
        echo json_encode($result);
    }
?>