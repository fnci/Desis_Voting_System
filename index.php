<?php require_once 'includes/functions.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario Votaciones</title>
  <link rel="stylesheet" href="build/css/app.css">
</head>

<body>
  <?php displaySuccessMessage($successMessage); ?>
  <?php displayErrorMessage(); ?>

  <form action="/includes/vote.php" method="post" id="myForm" class="vote-form" onsubmit="return validateForm();">
    <h2>FORMULARIO DE VOTACIÓN</h2>
    <label for="nombre-apellido" class="form-label">Nombre y Apellido:</label>
    <input type="text" id="nombre-apellido" name="nombre" class="form-input"><br>

    <label for="alias" class="form-label">Alias:</label>
    <input type="text" id="alias" name="alias" class="form-input"><br>

    <label for="rut" class="form-label">Rut:</label>
    <input type="text" id="rut" name="rut" class="form-input"><br>

    <label for="email" class="form-label">Email:</label>
    <input type="email" id="email" name="email" class="form-input"><br>

    <label for="region" class="form-label">Región:</label>
    <select id="region" name="region" class="form-select">
      <?php displayRegionOptions($regiones); ?>
    </select><br>

    <label for="comuna" class="form-label">Comuna:</label>
    <select id="comuna" name="comuna" class="form-select"></select><br>

    <label for="candidato" class="form-label">Candidato:</label>
    <select id="candidato" name="candidato" class="form-select">
      <option value="candidato1">Candidato 1</option>
      <option value="candidato2">Candidato 2</option>
      <option value="candidato3">Candidato 3</option>
    </select><br>
    <div class="form-group">
      <label class="form-label">¿Cómo se enteró de nosotros?</label><br>
      <input type="checkbox" id="web" name="como_se_entero[]" value="web" class="form-checkbox">
      <label for="web" class="form-label-checkbox">Web</label><br>
      <input type="checkbox" id="tv" name="como_se_entero[]" value="tv" class="form-checkbox">
      <label for="tv" class="form-label-checkbox">TV</label><br>
      <input type="checkbox" id="redes_sociales" name="como_se_entero[]" value="redes_sociales" class="form-checkbox">
      <label for="redes_sociales" class="form-label-checkbox">Redes Sociales</label><br>
      <input type="checkbox" id="amigo" name="como_se_entero[]" value="amigo" class="form-checkbox">
      <label for="amigo" class="form-label-checkbox">Amigo</label><br>
    </div>

    <input type="submit" value="Votar" class="form-submit">
  </form>

  <script src="index.js"></script>
  <script src="form_validation.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
