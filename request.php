<?php
$db_conx = mysqli_connect("", "", "", "");
    // Evaluate the connection
    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit();
    }
    
    if($_GET['data'] == "values") {

    // Get current
    $sql = mysqli_query($db_conx,"SELECT * FROM climate WHERE `key`='4781e8063e7d2' ORDER BY id DESC LIMIT 1");
    while($row = mysqli_fetch_array($sql))
    {
    $values_time  = $row["timestamp"];
    $values_temp  = $row["temperature"];
    $values_humi  = $row["humidity"];
    $values_count = $row["id"];
    }
    
    // Get yesterday
    $sql = mysqli_query($db_conx,"SELECT *, MIN(temperature) as ymintemp, MIN(humidity) as yminhumi, MAX(temperature) as ymaxtemp, MAX(humidity) as ymaxhumi, AVG(temperature) as yavgtemp, AVG(humidity) as yavghumi FROM climate WHERE `key`='4781e8063e7d2' AND DATE(timestamp) = CURDATE() -1  ORDER BY id DESC");
    while($row = mysqli_fetch_array($sql))
    {
    $values_ymintemp  = $row["ymintemp"];
    $values_yminhumi  = $row["yminhumi"];
    $values_ymaxtemp  = $row["ymaxtemp"];
    $values_ymaxhumi  = $row["ymaxhumi"];
    $values_yavgtemp  = $row["yavgtemp"];
    $values_yavghumi  = $row["yavghumi"];
    }

    // Get today
    $sql = mysqli_query($db_conx,"SELECT *, MIN(temperature) as tmintemp, MIN(humidity) as tminhumi, MAX(temperature) as tmaxtemp, MAX(humidity) as tmaxhumi, AVG(temperature) as tavgtemp, AVG(humidity) as tavghumi FROM climate WHERE `key`='4781e8063e7d2' AND DATE(timestamp) = CURDATE() ORDER BY id DESC");
    while($row = mysqli_fetch_array($sql))
    {
    $values_tmintemp  = $row["tmintemp"];
    $values_tminhumi  = $row["tminhumi"];
    $values_tmaxtemp  = $row["tmaxtemp"];
    $values_tmaxhumi  = $row["tmaxhumi"];
    $values_tavgtemp  = $row["tavgtemp"];
    $values_tavghumi  = $row["tavghumi"];
    }

    // Get average 
    $sql = mysqli_query($db_conx,"SELECT *, MIN(temperature) as amintemp, MIN(humidity) as aminhumi, MAX(temperature) as amaxtemp, MAX(humidity) as amaxhumi, AVG(temperature) as aavgtemp, AVG(humidity) as aavghumi FROM climate WHERE `key`='4781e8063e7d2' ORDER BY id DESC");
    while($row = mysqli_fetch_array($sql))
    {
    $values_amintemp  = $row["amintemp"];
    $values_aminhumi  = $row["aminhumi"];
    $values_amaxtemp  = $row["amaxtemp"];
    $values_amaxhumi  = $row["amaxhumi"];
    $values_aavgtemp  = $row["aavgtemp"];
    $values_aavghumi  = $row["aavghumi"];
    }

  
     // Current Temp NCL 
     $jsonfile = file_get_contents('https://api.openweathermap.org/data/2.5/weather?id=2641673&units=metric&appid=84af5cec6f1a99bc2e18da9392fb552a');
     $jsondata = json_decode($jsonfile);
 
 
     $api_temp = $jsondata->main->temp;
     $api_humidity = $jsondata->main->humidity;
     $api_mintemp = $jsondata->main->temp_min;
     $api_maxtemp = $jsondata->main->temp_max;
     $api_desc = $jsondata->weather[0]->description;



$data = array(
"timestamp"   => strftime("%H:%M:%S &bull; %d/%m/%Y", strtotime($values_time)),
"temperature" => round($values_temp, 2),
"humidity"    => round($values_humi, 2),
"value"       => $values_count,

"api_temp" => $api_temp,
"api_humi" => $api_humidity,
"api_min"  => $api_mintemp,
"api_max"  => $api_maxtemp,
"api_desc" => ucfirst($api_desc),

"ymintemp"    => round($values_ymintemp, 2),
"yminhumi"    => round($values_yminhumi, 2),
"ymaxtemp"    => round($values_ymaxtemp, 2),
"ymaxhumi"    => round($values_ymaxhumi, 2),
"yavgtemp"    => round($values_yavgtemp, 2),
"yavghumi"    => round($values_yavghumi, 2),

"tmintemp"    => round($values_tmintemp, 2),
"tminhumi"    => round($values_tminhumi, 2),
"tmaxtemp"    => round($values_tmaxtemp, 2),
"tmaxhumi"    => round($values_tmaxhumi, 2),
"tavgtemp"    => round($values_tavgtemp, 2),
"tavghumi"    => round($values_tavghumi, 2),

"amintemp"    => round($values_amintemp, 2),
"aminhumi"    => round($values_aminhumi, 2),
"amaxtemp"    => round($values_amaxtemp, 2),
"amaxhumi"    => round($values_amaxhumi, 2),
"aavgtemp"    => round($values_aavgtemp, 2),
"aavghumi"    => round($values_aavghumi, 2),
);
echo json_encode($data);
exit();

} else if($_GET['data'] == "temp") {

header('Content-Type: application/json');
$query = sprintf("SELECT timestamp, ROUND(temperature, 2) as temperature, ROUND(humidity, 2) as humidity FROM climate WHERE DATE(timestamp) = CURDATE() AND climate.id mod 20 = 0 AND `key`='4781e8063e7d2' ORDER BY id");
$result = $db_conx->query($query);

$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

$result->close();
$db_conx->close();

print json_encode($data);

}
?>