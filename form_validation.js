// Validate RUT format (12.345.678-9 or 12345678-9)
function validateRut(rut) {
  var rutPattern = /^[0-9]{1,3}(\.[0-9]{3}){0,2}-[0-9kK]{1}$/;
  return rutPattern.test(rut);
}
// Function to validate the form before submission
function validateForm() {
  // Get form elements
  var nombreInput = document.getElementById("nombre-apellido");
  var aliasInput = document.getElementById("alias");
  var rutInput = document.getElementById("rut");
  var rut = rutInput.value.trim();
  var emailInput = document.getElementById("email");
  var comoSeEnteroInputs = document.querySelectorAll(
    'input[name="como_se_entero[]"]:checked'
  );

  // Initialize an error message
  var errorMessage = "";

  // Check if all fields are empty
  if (
    nombreInput.value.trim() === "" &&
    aliasInput.value.trim() === "" &&
    rutInput.value.trim() === "" &&
    emailInput.value.trim() === "" &&
    comoSeEnteroInputs.length === 0
  ) {
    alert("Todos los campos son obligatorios.");
    return false; // Prevent form submission
  }

  // Check Nombre y Apellido field.
  if (nombreInput.value.trim() === "") {
    errorMessage += "Nombre y Apellido es obligatorio.\n";
  }

  // Check Alias field (debe tener al menos 5 caracteres).
  if (aliasInput.value.trim().length < 5) {
    errorMessage += "Alias debe tener al menos 5 caracteres.\n";
  }

  // Check if the RUT is valid
  if (!validateRut(rut)) {
    alert("Error: RUT tiene un formato inválido. Debe ser como 12.345.678-9 o 12345678-9.");
    return false; // Prevent form submission
  }

  // Check Email field.
  if (emailInput.value.trim() === "") {
    errorMessage += "Email es obligatorio.\n";
  }

  // Check if at least two checkboxes for "¿Cómo se enteró de nosotros?" are selected
  if (comoSeEnteroInputs.length < 2) {
    alert(
      "Seleccionar al menos dos opciones en ¿Cómo se enteró de nosotros? es obligatorio."
    );
    return false; // Prevent form submission
  }

  // If there are validation errors, display them and prevent form submission.
  if (errorMessage !== "") {
    alert(errorMessage);
    return false; // Prevent form submission
  }

  // If all validations pass, allow the form to submit
  return true;
}
