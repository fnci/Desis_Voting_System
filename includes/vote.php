<?php
session_start(); // Start a session

require 'database.php'; // Include the database connection file
if (!$db) { // If the database connection fails
  $_SESSION['voting_error'] = 'Error en la conexión'; // Set an error message in the session
  header("Location: /index.php"); // Redirect to index.php
  exit; // Exit the script
}

// Initialize an array to store validation errors
$errors = [];

// Get the form data
$nombre = $_POST['nombre']; // Get the value of 'nombre' from the form
$alias = $_POST['alias']; // Get the value of 'alias' from the form
$rut = $_POST['rut']; // Get the value of 'rut' from the form
$email = $_POST['email']; // Get the value of 'email' from the form
$region = $_POST['region']; // Get the value of 'region' from the form
$comuna = $_POST['comuna']; // Get the value of 'comuna' from the form
$candidato = $_POST['candidato']; // Get the value of 'candidato' from the form

// Initialize $como_se_entero as an empty string
$como_se_entero = '';

// Check if como_se_entero is set and is an array
if (isset($_POST['como_se_entero']) && is_array($_POST['como_se_entero'])) {
  // Convert the array to a comma-separated string
  $como_se_entero = implode(',', $_POST['como_se_entero']);
}

// Check if the email already exists in the database
$emailExists = false; // Initialize $emailExists as false
$stmt = $db->prepare('SELECT COUNT(*) FROM votos WHERE email = ?'); // Prepare a SQL statement to count rows with the given email
$stmt->bind_param('s', $email); // Bind the email parameter to the statement
$stmt->execute(); // Execute the statement
$stmt->bind_result($count); // Bind the result to $count
$stmt->fetch(); // Fetch the result
$stmt->close(); // Close the statement

if ($count > 0) { // If the count is greater than 0
  $emailExists = true; // Set $emailExists to true
  $_SESSION['voting_error'] = "El correo electrónico ya ha sido registrado. No se permite votar más de una vez."; // Set an error message in the session
  header("Location: /index.php"); // Redirect to index.php
  exit; // Exit the script
}

if (empty($nombre)) { // If 'nombre' is empty
  $errors[] = "Nombre y Apellido es obligatorio."; // Add an error message to the $errors array
}

if (empty($alias)) { // If 'alias' is empty
  $errors[] = "Alias es obligatorio."; // Add an error message to the $errors array
}

// Validate RUT using a regular expression
$rutPattern = '/^[0-9]{1,3}(\.[0-9]{3}){0,2}-[0-9kK]{1}$/'; // Define a regular expression pattern for RUT
if (empty($rut)) { // If 'rut' is empty
  $errors[] = "RUT debe tener el formato con puntos y guión, como 12.345.678-9 o 123.456.789-0."; // Add an error message to the $errors array
}


if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { // If 'email' is empty or is not a valid email format
  $errors[] = "Email es obligatorio o tiene un formato inválido."; // Add an error message to the $errors array
}

if (empty($region)) { // If 'region' is empty
  $errors[] = "Región es obligatoria."; // Add an error message to the $errors array
}

if (empty($comuna)) { // If 'comuna' is empty
  $errors[] = "Comuna es obligatoria."; // Add an error message to the $errors array
}

if (empty($candidato)) { // If 'candidato' is empty
  $errors[] = "Candidato es obligatorio."; // Add an error message to the $errors array
}

if (empty($como_se_entero)) { // If 'como_se_entero' is empty
  $errors[] = "Seleccionar al menos una opción en ¿Cómo se enteró de nosotros? es obligatorio."; // Add an error message to the $errors array
}

if (!empty($errors)) { // If there are validation errors
  // Handle validation errors
  $_SESSION['voting_error'] = $errors; // Set the validation errors in the session
  header("Location: /index.php"); // Redirect to index.php
  exit; // Exit the script
} else {
  // Insert the data into the database
  $stmt = $db->prepare('INSERT INTO votos (nombre, alias, rut, email, region, comuna, candidato, como_se_entero) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'); // Prepare a SQL statement to insert data into the database
  $stmt->bind_param('ssssssss', $nombre, $alias, $rut, $email, $region, $comuna, $candidato, $como_se_entero); // Bind the parameters to the statement
  if ($stmt->execute()) { // If the statement is executed successfully
    // Data successfully inserted
    header("Location: /index.php?success=¡Gracias%20por%20votar!"); // Redirect to index.php with a success message
    exit; // Exit the script
  } else {
    $_SESSION['voting_error'] = "Error al guardar los datos en la base de datos."; // Set an error message in the session
    header("Location: /index.php"); // Redirect to index.php
    exit; // Exit the script
  }
}
