<meta charset="utf-8">
<?php

try{

echo $_POST['table'];
header("Pragma: public");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header("Content-Type: application/force-download");
header("Content-Disposition: filename=".$_POST['nombre'].".xls");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Expires: 0");
clearstatcache();
}
catch(Exception $e){
    echo $e->getMessage();
}

?>   


                    
