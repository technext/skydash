<?php 	

$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "sinventoryphp";
$store_url = "http://localhost/Vappy/";
// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}

define("RFID_WRTIE_FILE", "C:/Users/leelu/OneDrive - Asia Pacific University/Desktop/SharedFolder/what2add.csv");
define("RFID_UPDATE_FILE", "C:/Users/leelu/OneDrive - Asia Pacific University/Desktop/SharedFolder/what2replace.csv");
?>