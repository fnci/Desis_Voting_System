addEventListener("DOMContentLoaded", () => {

  // Handle region select change event
  $("#region").change(function () {
    // Retrieve the selected region ID
    var regionId = $(this).val();

    // Send an AJAX request to fetch the comunas data
    $.ajax({
      url: "includes/get_comunas.php",
      type: "POST",
      data: { region_id: regionId },
      dataType: "json",
      success: function (data) {
        // Clear the current options
        $("#comuna").empty();

        // Add the new options
        $.each(data, function (index, value) {
          $("#comuna").append(
            "<option value='" + value.id + "'>" + value.nombre + "</option>"
          );
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(
          "Error fetching comunas data: " + textStatus + " - " + errorThrown
        );
      },
    });
  });

  // Trigger the region change event on page load if a region is pre-selected
  $("#region").trigger("change");

})
