<?php
    include 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    //Database server link
    $servername = "";
    //Database name
    $dbname = "";
    //Database user
    $username = "";
    //Database user password
    $password = "";

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    function getLastReadings() {
      global $servername, $username, $password, $dbname;
  
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
  
      $sql = "SELECT id, location, reading_time, temperature, humidity, pressure, altitude, co2_ppm, rain, air_quality FROM dataCollect order by reading_time desc limit 1" ;
      if ($result = $conn->query($sql)) {
        return $result->fetch_assoc();
      }
      else {
        return false;
      }
      $conn->close();
    }

    function getAllReadings($limit, $location) {
      global $servername, $username, $password, $dbname;
  
      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
  
      $sql = "SELECT id, location, reading_time, temperature, humidity, pressure, altitude, co2_ppm, rain, air_quality FROM dataCollect WHERE location LIKE '%$location%' order by reading_time desc limit " . $limit;
      if ($result = $conn->query($sql)) {
        return $result;
      }
      else {
        return false;
      }
      $conn->close();
    }
if ($_GET["locations"]){
      $data = $_GET["locations"];
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $location = $_GET["locations"];
}
else {
      $location = " ";
    }
if ($_GET["readingsCount"]){
  $data = $_GET["readingsCount"];
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $readings_count = $_GET["readingsCount"];
}

else {
  $readings_count = 20;
}

$last_reading = getLastReadings();
$last_reading_temp = $last_reading["temperature"];
$last_reading_humi = $last_reading["humidity"];
$last_reading_pres = $last_reading["pressure"];
$last_reading_alti = $last_reading["altitude"];
$last_reading_co2 = $last_reading["co2_ppm"];
$last_reading_humi = $last_reading["humidity"];
$last_reading_rain = $last_reading["rain"];
$last_reading_airq = $last_reading["air_quality"];
$last_reading_time = $last_reading["reading_time"];

$connect = new PDO("mysql:host=[database_link]", "username", "password");

$query = "SELECT * FROM dataCollect ORDER BY id DESC";

$statement = $connect->prepare($query);

$statement->execute();

$result2 = $statement->fetchAll();


if(isset($_POST["export"]))
{
  $fromtime = mysqli_real_escape_string($_POST['searchdatefrom']);
  $totime = mysqli_real_escape_string($_POST['searchdateto']);
  $file = new Spreadsheet();

  $active_sheet = $file->getActiveSheet();

  $active_sheet->setCellValue('A1', 'Location');
  $active_sheet->setCellValue('B1', 'Temperature');
  $active_sheet->setCellValue('C1', 'Humidity');
  $active_sheet->setCellValue('D1', 'Pressure');
  $active_sheet->setCellValue('E1', 'Altitude');
  $active_sheet->setCellValue('F1', 'CO2_PPM');
  $active_sheet->setCellValue('G1', 'Rain');
  $active_sheet->setCellValue('H1', 'Air Quality');
  $active_sheet->setCellValue('I1', 'RecordTime');
  $count = 2;
  $query_export = "SELECT * FROM dataCollect WHERE reading_time BETWEEN '.$fromtime.' AND '.$totime.' ORDER BY id DESC";
  $statement_export = $connect->prepare($query_export);
  $statement_export->execute();
  $result_export = $statement_export->fetchAll();
  $result_export = $result2;
  foreach($result2 as $row)
  {
    $active_sheet->setCellValue('A' . $count, $row["location"]);
    $active_sheet->setCellValue('B' . $count, $row["temperature"]);
    $active_sheet->setCellValue('C' . $count, $row["humidity"]);
    $active_sheet->setCellValue('D' . $count, $row["pressure"]);
    $active_sheet->setCellValue('E' . $count, $row["altitude"]);
    $active_sheet->setCellValue('F' . $count, $row["co2_ppm"]);
    $active_sheet->setCellValue('G' . $count, $row["rain"]);
    $active_sheet->setCellValue('H' . $count, $row["air_quality"]);
    $active_sheet->setCellValue('I' . $count, $row["reading_time"]);

    $count = $count + 1;
  }

  $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, $_POST["file_type"]);

  $file_name = "weatherNodes_database" . '.' . strtolower($_POST["file_type"]);

  $writer->save($file_name);

  header('Content-Type: application/x-www-form-urlencoded');

  header('Content-Transfer-Encoding: Binary');

  header("Content-disposition: attachment; filename=\"".$file_name."\"");

  readfile($file_name);

  unlink($file_name);

  exit;

}
?>

<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Recursive&display=swap" rel="stylesheet">       
    </head>
    <header class="header">
        <h1 style="color: white,">Current Weather Data</h1>
	<h3 style="text-allign: center, color:white">Measure data from multiple location<h3>
        <form method="get">
            <input type="number" name="readingsCount" min="1" placeholder="Number of readings (<?php echo $readings_count; ?>)">
            <select name="locations" class="form-control input-sm ">
                    <option value="" disabled selected hidden><?php echo $location; ?></option>
                    <option value="Nam Tu Liem">Nam Tu Liem</option>
                    <option value="Ba Dinh">Ba Dinh</option>
                    <option value="Cau Giay">Cau Giay</option>
                    <option value=" ">All</option>
                  </select>
            <input type="submit" value="UPDATE">
        </form>
    </header>
<body>
    <p>Last reading: <?php echo $last_reading_time; ?></p>
    <section class="content">
    <div class="cards">
      <div class="card">
        <h4>Temperature</h4><p><span class="reading"><span id="temp"><?php echo $last_reading_temp; ?></span> &deg;C</span></p>
      </div>
      <div class="card">
        <h4>Humidity</h4><p><span class="reading"><span id="hum"><?php echo $last_reading_humi; ?></span> &percnt;</span></p>
      </div>
      <div class="card">
        <h4>Pressure</h4><p><span class="reading"><span id="pres"><?php echo $last_reading_pres; ?></span> hPa</span></p>
      </div>
      <div class="card">
        <h4>Altitude</h4><p><span class="reading"><span id="alti"><?php echo $last_reading_alti; ?></span> m</span></p>
      </div>
      <div class="card">
        <h4>CO2</h4><p><span class="reading"><span id="co2"><?php echo $last_reading_co2; ?></span> ppm</span></p>
      </div>
      <div class="card">
        <h4>Rain</h4><p><span class="reading"><span id="rain"><?php echo $last_reading_rain; ?></p>
      </div>
      <div class="card">
        <h4>Air Quality</h4><p><span class="reading"><span id="airq"><?php echo $last_reading_airq; ?></p>
      </div>
    </div>
  </section>
<?php
    echo   '<h2> View Latest ' . $readings_count . ' Readings</h2>
            <h2> Location: ' . $location . '</h2>
            <table cellspacing="5" cellpadding="5" id="tableReadings">
                <tr>
                    <th>ID</th>
                    <th>Location</th>
                    <th>Temperature</th>
                    <th>Humidity</th>
                    <th>Pressure</th>
                    <th>Altitude</th>
                    <th>CO2 PPM</th>
                    <th>Rain</th>
                    <th>Air Quality</th>
                    <th>Timestamp</th>
                </tr>';

    $result = getAllReadings($readings_count, $location);
        if ($result) {
        while ($row = $result->fetch_assoc()) {
            $row_id = $row["id"];
            $row_location = $row["location"];
            $row_temperature = $row["temperature"];
            $row_humidity = $row["humidity"];
            $row_pressure = $row["pressure"];
            $row_altitude = $row["altitude"];
            $row_co2_ppm = $row["co2_ppm"];
            $row_rain = $row["rain"];
            $row_air_quality = $row["air_quality"];
            $row_reading_time = $row["reading_time"];

            echo '<tr>
                    <td>' . $row_id . '</td>
                    <td>' . $row_location . '</td>
                    <td>' . $row_temperature . '</td>
                    <td>' . $row_humidity . '</td>
                    <td>' . $row_pressure . '</td>
                    <td>' . $row_altitude . '</td>
                    <td>' . $row_co2_ppm . '</td>
                    <td>' . $row_rain . '</td>
                    <td>' . $row_air_quality . '</td>
                    <td>' . $row_reading_time . '</td>
                  </tr>';
        }
        echo '</table>';
        $result->free();
    }
?>
       <div class="excel">
          <form action="WeatherApp.php" method="post">

                  <p style="font-size:160%;">Exporting database to file</p>
                  <p>From Time:</p><input type="date" name="searchdatefrom" placeholder="Search From DateTime">
                  <p>To Time:</p><input type="date" name="searchdateto" placeholder="Search To Time">
                  <p>File type:</p>
                <div class="col-md-4">
                  <select name="file_type" class="form-control input-sm">
                    <option value="Xlsx">Xlsx</option>
                    <option value="Xls">Xls</option>
                    <option value="Csv">Csv</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="export" class="btn btn-primary btn-sm" value="Export" />
  </div>

            </form>
          </div>
<!-- <script>
    var temperature = <?php //echo $last_reading_temp; ?>;
    var humidity = <?php //echo $last_reading_humi; ?>;
    setTemperature(temperature);
    setHumidity(humidity);

    function setTemperature(curVal){
    	var minTemp = -5.0;
    	var maxTemp = 38.0;

    	var newVal = scaleValue(curVal, [minTemp, maxTemp], [0, 180]);
    	$('.gauge--1 .semi-circle--mask').attr({
    		style: '-webkit-transform: rotate(' + newVal + 'deg);' +
    		'-moz-transform: rotate(' + newVal + 'deg);' +
    		'transform: rotate(' + newVal + 'deg);'
    	});
    	$("#temp").text(curVal + ' ยบC');
    }

    function setHumidity(curVal){
    	var minHumi = 0;
    	var maxHumi = 100;

    	var newVal = scaleValue(curVal, [minHumi, maxHumi], [0, 180]);
    	$('.gauge--2 .semi-circle--mask').attr({
    		style: '-webkit-transform: rotate(' + newVal + 'deg);' +
    		'-moz-transform: rotate(' + newVal + 'deg);' +
    		'transform: rotate(' + newVal + 'deg);'
    	});
    	$("#humi").text(curVal + ' %');
    }

    function scaleValue(value, from, to) {
        var scale = (to[1] - to[0]) / (from[1] - from[0]);
        var capped = Math.min(from[1], Math.max(from[0], value)) - from[0];
        return ~~(capped * scale + to[0]);
    }
</script> -->
</body>
</html>
