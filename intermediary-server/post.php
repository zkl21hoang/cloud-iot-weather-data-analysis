<?php include '/var/www/html/intermediary_file_rds.php';

  //API Key
  $api_key_value = "Po1kwuq2tIun";

  $api_key = $location = $temperature = $humidity = $pressure = $altitude = $co2_ppm = $rain = $air_quality =  "";

 if ($_SERVER["REQUEST_METHOD"] == "POST")
 {

    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
      $location = test_input($_POST["location"]);
      $temperature = test_input($_POST["temperature"]);
      $humidity = test_input($_POST["humidity"]);
      $pressure = test_input($_POST["pressure"]);
      $humidity = test_input($_POST["humidity"]);
      $altitude = test_input($_POST["altitude"]);
      $co2_ppm = test_input($_POST["co2_ppm"]);
      $rain = test_input($_POST["rain"]);
      $air_quality = test_input($_POST["air_quality"]);

      $result = insertSQL($location, $temperature, $humidity, $pressure, $altitude, $co2_ppm, $rain, $air_quality);
      echo $result;
    } 
    else {
      echo "Wrong API Key";
    }
  }
  else {
    echo "HTTP Post could not be posted";
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
