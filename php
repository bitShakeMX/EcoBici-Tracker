<?php
error_reporting(1);
date_default_timezone_set('America/Mexico_City');

require('conect.php');
$conection = new Conect();

//params
$cardId = isset($_GET['card'])?$_GET['card']:null;
$totalTime = isset($_GET['totaltime'])?$_GET['totaltime']:null;
$totalRevolutions = isset($_GET['revolutions'])?$_GET['revolutions']:null;
$diameter = 49.53;
$linearDistance = 155.603;
$date = date('Y-m-d');
$time = date('H:i:s');
$pi = 3.1416;

$response = array();

//verify if has params
if( !is_null($totalTime) && !is_null($totalRevolutions) && !is_null($cardId)){
  $totalDistance = ($linearDistance * $totalRevolutions) / 100000;
  $revolutionPerHour = $totalRevolutions / ($totalTime/3600);
  $linearVelocity = ((2*$pi*($diameter/2))/100000)*$revolutionPerHour;


  $bici = Rand(150, 0);
  $estacion1 = Rand(150, 0);
  $estacion2 = Rand(150, 0);

  $query = "INSERT INTO `reads` (`id`, `cardId`, `Genero_Usuario`, `Edad_Usuario`,`Bici`,`Ciclo_Estacion_Retiro`,`Fecha_Retiro`,`Hora_Retiro`,`Ciclo_Estacion_Arribo`,`Fecha_Arribo`,`Hora_Arribo`, `Distancia_Total`, `Revoluciones_por_Hora`,
  `Velocidad_Linear`) VALUES ( null, \"$cardId\", \"M\", \"22\", \"$bici\", \"$estacion1\", \"$date\",  \"21:37\", \"$estacion2\", \"$date\", \"$time\", \"$totalDistance\", \"$revolutionPerHour\", \"$linearVelocity\" );";
  $result = $conection->mysqli->query($query);
  if($result){
    $response = array("status"=>200,
                    "message"=>"success",
                    "data"=> array("insertId" => $conection->mysqli->insert_id)
              );
  }else{
    $response = array("status"=>200,
                    "message"=>"error",
                    "data"=> array("insertId" => $conection->mysqli->error)
              );
  }

}else{
  $response = array("status"=>200, "message"=>"error", "data"=> "uncomplete params");
}
echo json_encode($response);
