<?php
// My database credentials
$hostname = "XXXXXXXXXX";
$username = "XXXXXXXXXX";
$password = "XXXXXXXXXX";
$database = "voting_system";

$db = mysqli_connect($hostname, $username, $password, $database);

/* echo "<pre>";
var_dump($db);
echo "</pre>"; */

if (!$db) {
  echo 'Error en la conexion';
  exit;
}
