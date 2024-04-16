<?php
session_start(); // Start a session
require __DIR__ . '/get_regions.php'; // Include the file that contains the function to get regions
require __DIR__ . '/get_comunas.php'; // Include the file that contains the function to get comunas

$regiones = get_regions(); // Call the function to get the regions and store the result in $regiones
$comunas = get_comunas(); // Call the function to get the comunas and store the result in $comunas

// Function to display a message and then remove it after a specified timeout
function displayAndRemoveMessage($messageElementId, $timeout)
{
  echo <<<HTML
  <script>
    setTimeout(function() {
      var messageElement = document.getElementById('$messageElementId');
      if (messageElement) {
        messageElement.style.display = 'none'; // Hide the message element
        history.replaceState({}, document.title, window.location.pathname); // Remove the message from the URL
      }
    }, $timeout);
  </script>
  HTML;
}

// Check if a success message is set in the URL parameters, if not set it to null
$successMessage = isset($_GET['success']) ? $_GET['success'] : null;

// Display a success message if it exists
function displaySuccessMessage($successMessage)
{
  if ($successMessage) {
    echo <<<HTML
    <div class="success-message" id="success-message">
      {$successMessage}
    </div>
    HTML;
    displayAndRemoveMessage('success-message', 10000); // Display the message for 10 seconds and then remove it
  }
}

// Display an error message if there is an error in the session variable 'voting_error'
function displayErrorMessage()
{
  if (isset($_SESSION['voting_error'])) {
    echo <<<HTML
    <div class="error-message" id="error-message">
    HTML; // Close the heredoc string to continue PHP execution
    if (is_array($_SESSION['voting_error'])) {
      foreach ($_SESSION['voting_error'] as $error) {
        echo htmlspecialchars($error) . "<br>"; // Display each error
      }
    } else {
      echo htmlspecialchars($_SESSION['voting_error']); // Display the error
    }
    echo <<<HTML
    </div>
    HTML; // Close the heredoc string
    displayAndRemoveMessage('error-message', 10000); // Display the error message for 10 seconds and then remove it
    unset($_SESSION['voting_error']); // Clear the session variable to avoid displaying the error again
  }
}

// Display options for regions in a select dropdown
function displayRegionOptions($regiones)
{
  while ($region = mysqli_fetch_assoc($regiones)) {
    echo <<<HTML
    <option value="{$region['id']}">
      {$region['nombre']}
    </option>
    HTML;
  }
}
?>