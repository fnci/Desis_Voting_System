<?php
session_start(); // Start a session

require 'database.php';
if (!$db) {
  $_SESSION['voting_error'] = 'Error en la conexión';
  header("Location: /index.php");
  exit;
}

// Initialize an array to store validation errors
$errors = [];

// Get the form data
$nombre = $_POST['nombre'];
$alias = $_POST['alias'];
$rut = $_POST['rut'];
$email = $_POST['email'];
$region = $_POST['region'];
$comuna = $_POST['comuna'];
$candidato = $_POST['candidato'];

// Initialize $como_se_entero as an empty string
$como_se_entero = '';

// Check if como_se_entero is set and is an array
if (isset($_POST['como_se_entero']) && is_array($_POST['como_se_entero'])) {
  // Convert the array to a comma-separated string
  $como_se_entero = implode(',', $_POST['como_se_entero']);
}

// Check if the email already exists in the database
$emailExists = false;
$stmt = $db->prepare('SELECT COUNT(*) FROM votos WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
  $emailExists = true;
  $_SESSION['voting_error'] = "El correo electrónico ya ha sido registrado. No se permite votar más de una vez.";
  header("Location: /index.php"); // Redirect to index.php if there is an error
  exit;
}

if (empty($nombre)) {
  $errors[] = "Nombre y Apellido es obligatorio.";
}

if (empty($alias)) {
  $errors[] = "Alias es obligatorio.";
}

// Validate RUT using a regular expression
$rutPattern = '/^[0-9]{1,3}(\.[0-9]{3}){0,2}-[0-9kK]{1}$/';
if (empty($rut) || !preg_match($rutPattern, $rut)) {
  $errors[] = "RUT debe tener el formato con puntos y guión, como 12.345.678-9 o 123.456.789-0.";
}


if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = "Email es obligatorio o tiene un formato inválido.";
}

if (empty($region)) {
  $errors[] = "Región es obligatoria.";
}

if (empty($comuna)) {
  $errors[] = "Comuna es obligatoria.";
}

if (empty($candidato)) {
  $errors[] = "Candidato es obligatorio.";
}

if (empty($como_se_entero)) {
  $errors[] = "Seleccionar al menos una opción en ¿Cómo se enteró de nosotros? es obligatorio.";
}

if (!empty($errors)) {
  // Handle validation errors
  $_SESSION['voting_error'] = $errors;
  header("Location: /index.php");
  exit;
} else {
  // Insert the data into the database
  $stmt = $db->prepare('INSERT INTO votos (nombre, alias, rut, email, region, comuna, candidato, como_se_entero) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
  $stmt->bind_param('ssssssss', $nombre, $alias, $rut, $email, $region, $comuna, $candidato, $como_se_entero);
  if ($stmt->execute()) {
    // Data successfully inserted
    header("Location: /index.php?success=¡Gracias%20por%20votar!");
    exit;
  } else {
    $_SESSION['voting_error'] = "Error al guardar los datos en la base de datos.";
    header("Location: /index.php");
    exit;
  }
}
