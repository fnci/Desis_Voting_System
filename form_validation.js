// Regular expression to validate an email address
const emailPattern =
  /^(?:[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;

// Function to format the RUT
function formatRutWithDots(rut) {
  var formattedRut = ""; // Variable to store the formatted RUT
  var index = 0; // Counter variable to keep track of the position in the RUT
  for (var i = rut.length - 1; i >= 0; i--) {
    // Loop through the RUT string from right to left
    formattedRut = rut.charAt(i) + formattedRut; // Add the current character to the formatted RUT
    index++; // Increment the index counter
    if (index % 3 === 0 && i !== 0) {
      // Check if it's time to add a dot (every 3 characters except for the last group)
      formattedRut = "." + formattedRut; // Add a dot to the formatted RUT
    }
  }
  return formattedRut; // Return the formatted RUT
}

// Function to validate and format the RUT field
function validateRut(rut) {
  rut = rut.replace(/[.-]/g, "").toUpperCase(); // Remove dots and dashes, and convert to uppercase

  if (rut === "") {
    // If the RUT is empty, return true (valid)
    return true;
  }

  var body = rut.slice(0, -1); // Get the body of the RUT (without the verification digit)
  var dv = rut.slice(-1); // Get the verification digit

  var sum = 0; // Initialize the sum for the validation algorithm
  var multiplier = 2; // Initialize the multiplier for the validation algorithm
  for (var i = body.length - 1; i >= 0; i--) {
    // Loop through the body of the RUT from right to left
    sum += parseInt(body.charAt(i)) * multiplier; // Add the product of the digit and the multiplier to the sum
    if (multiplier < 7)
      multiplier++; // Increment the multiplier, except when it reaches 7, then reset to 2
    else multiplier = 2;
  }
  var expectedDV = 11 - (sum % 11); // Calculate the expected verification digit
  if (expectedDV === 11)
    expectedDV = 0; // If the expected digit is 11, set it to 0
  else if (expectedDV === 10) expectedDV = "K"; // If the expected digit is 10, set it to 'K'

  if (dv != expectedDV) {
    // If the calculated verification digit does not match the provided one, return false
    return false;
  }

  var formattedRut = formatRutWithDots(body) + "-" + dv; // Format the RUT with dots and dash
  document.getElementById("rut").value = formattedRut; // Set the formatted RUT in the input field with ID "rut"

  return true; // Return true if the RUT is valid
}

// Function to validate the email field
function validateEmail(email) {
  return emailPattern.test(email); // Use a regular expression pattern to test if the email is valid
}

// Function to check if at least two checkboxes for "Cómo se enteró de nosotros?" are selected
function areAtLeastTwoOptionsSelected(comoSeEnteroInputs) {
  return comoSeEnteroInputs.length < 2; // Return true if less than 2 checkboxes are selected, indicating an error
}

// Function to validate the form before submission
function validateForm() {
  // Get references to form input elements
  var nombreInput = document.getElementById("nombre-apellido");
  var aliasInput = document.getElementById("alias");
  var rutInput = document.getElementById("rut");
  var rut = rutInput.value.trim();
  var emailInput = document.getElementById("email");
  var comoSeEnteroInputs = document.querySelectorAll(
    'input[name="como_se_entero[]"]:checked'
  );

  var errorMessages = []; // Initialize an array to store error messages

  // Validate Nombre y Apellido field
  if (nombreInput.value.trim() === "") {
    errorMessages.push("Nombre y Apellido es obligatorio.");
  }

  // Validate Alias field
  if (aliasInput.value.trim().length < 5) {
    errorMessages.push("Alias debe tener al menos 5 caracteres.");
  }

  // Validate RUT field
  if (rut === "") {
    errorMessages.push("RUT es obligatorio.");
  } else {
    if (!validateRut(rut)) {
      errorMessages.push("El RUT ingresado es inválido.");
    }
  }

  // Validate Email field
  if (emailInput.value.trim() === "") {
    errorMessages.push("Email es obligatorio.");
  } else if (!validateEmail(emailInput.value.trim())) {
    errorMessages.push("Email tiene un formato inválido.");
  }

  // Validate "Cómo se enteró de nosotros?" checkboxes
  if (areAtLeastTwoOptionsSelected(comoSeEnteroInputs)) {
    errorMessages.push(
      "Seleccionar al menos dos opciones en ¿Cómo se enteró de nosotros? es obligatorio."
    );
  }

  // If there are any error messages, display them in an alert
  if (errorMessages.length > 0) {
    alert(
      "Por favor complete todos los campos correctamente:\n" +
        errorMessages.join("\n")
    );
    return false; // Prevent form submission if there are errors
  }

  return true; // Allow form submission if there are no errors
}

// Function to check if all form fields are empty
function isFormEmpty(
  nombreInput,
  aliasInput,
  rutInput,
  emailInput,
  comoSeEnteroInputs
) {
  return (
    nombreInput.value.trim() === "" && // Check if the name field is empty
    aliasInput.value.trim() === "" && // Check if the alias field is empty
    rutInput.value.trim() === "" && // Check if the RUT field is empty
    emailInput.value.trim() === "" && // Check if the email field is empty
    comoSeEnteroInputs.length === 0 // Check if no checkboxes are selected for "Cómo se enteró de nosotros?"
  );
}
