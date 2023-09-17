<?php
// My database credentials
$hostname = "localhost";
$username = "root";
$password = "XXXXXXXXXXXXX";
$database = "voting_system";

$db = mysqli_connect($hostname, $username, $password, $database);

/* echo "<pre>";
var_dump($db);
echo "</pre>"; */

if (!$db) {
  echo 'Error en la conexion';
  exit;
}
