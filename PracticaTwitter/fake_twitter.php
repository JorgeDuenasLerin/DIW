<?php

$start_in=(isset($_GET['start_in'])?$_GET['start_in']:0);


$nombre_fichero = "json_dump.txt";
$file = fopen($nombre_fichero, "r");
$contenido = fread($file, filesize($nombre_fichero));
fclose($file);

$data = json_decode($contenido);

$splited_data = array();

for($i=$start_in;$i < $start_in + 10; $i++){
    $splited_data[] = $data[$i];
}

echo json_encode($splited_data);

?>