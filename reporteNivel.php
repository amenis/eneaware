?php
try{
header("Pragma: public");
header("Content-type: application/vnd.ms-excel;");
header("Content-Disposition: filename=ficheroExcel.xls");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Expires: 0");
echo $_POST['table'];
}
catch(Exception $e){
    echo $e->getMessage();
}

?>   
<script>
    window.open("localhost/eneaware/reporteNivel.php");
</script>
