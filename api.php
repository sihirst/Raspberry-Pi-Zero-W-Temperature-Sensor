<?php

$db_conx = mysqli_connect("", "", "", "");
    // Evaluate the connection
    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit();
    }

$t = $_GET['t'];
$h = $_GET['h'];
$k = $_GET['k'];

date_default_timezone_set('Europe/London');
$time_stamp  = date('Y-m-d H:i:s');

if($k) {


    $sql = mysqli_query($db_conx,"INSERT INTO climate (`key`, `temperature`, `humidity`, `timestamp`)
         VALUES ('$k','$t','$h','$time_stamp')") or die(mysqli_error($db_conx));



$json->response = "success";
$json->timestamp = $time_stamp;
echo json_encode($json);

} else {

    $json->response = "failure";
    $json->timestamp = $time_stamp;
    echo json_encode($json);

}
?>
