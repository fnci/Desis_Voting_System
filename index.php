<?php
session_start(); // Start a session
require __DIR__ . '/includes/get_regions.php';
require __DIR__ . '/includes/get_comunas.php';
$regiones = get_regions();
$comunas = get_comunas();
// Check if a success message is set in the URL parameters
$successMessage = isset($_GET['success']) ? $_GET['success'] : null;
// Function to display and remove messages
function displayAndRemoveMessage($messageElementId, $timeout){
  echo <<<HTML
  <script>
    setTimeout(function() {
      var messageElement = document.getElementById('$messageElementId');
      if (messageElement) {
        messageElement.style.display = 'none';
        history.replaceState({}, document.title, window.location.pathname);
      }
    }, $timeout);
  </script>
  HTML;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario Votaciones</title>
  <link rel="stylesheet" href="build/css/app.css">
</head>

<body>
  <?php if ($successMessage) : ?>
    <div class="success-message" id="success-message">
      <?php echo urldecode($successMessage); ?>
    </div>
    <?php displayAndRemoveMessage('success-message', 10000);
    ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['voting_error'])) : ?>
    <div class="error-message" id="error-message">
      <?php
      if (is_array($_SESSION['voting_error'])) {
        foreach ($_SESSION['voting_error'] as $error) {
          echo htmlspecialchars($error) . "<br>";
        }
      } else {
        echo htmlspecialchars($_SESSION['voting_error']);
      }
      ?>
    </div>
    <?php displayAndRemoveMessage('error-message', 10000); // 10 seconds
    unset($_SESSION['voting_error']); // Clear the error message
    ?>
  <?php endif; ?>

  <form action="/includes/vote.php" method="post" class="vote-form" onsubmit="return validateForm();">
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
      <?php
      while ($region = mysqli_fetch_assoc($regiones)) { ?>
        <option value="<?php echo $region['id']; ?>">
          <?php echo $region['nombre']; ?>
        </option>
      <?php } ?>
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

  <script src="form_validation.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {

      // Handle region select change event
      $("#region").change(function() {
        // Retrieve the selected region ID
        var regionId = $(this).val();

        // AJAX request to fetch the comunas data
        $.ajax({
          url: "includes/get_comunas.php",
          type: "POST",
          data: {
            region_id: regionId
          },
          dataType: "json",
          success: function(data) {
            // Clear the current options
            $("#comuna").empty();

            // Add the new options
            $.each(data, function(index, value) {
              $("#comuna").append("<option value='" + value.id + "'>" + value.nombre + "</option>");
            });
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log("Error fetching comunas data: " + textStatus + " - " + errorThrown);
          }
        });
      });

      // Trigger the region change event on page load if a region is pre-selected
      $("#region").trigger("change");
    });
  </script>
</body>

</html>