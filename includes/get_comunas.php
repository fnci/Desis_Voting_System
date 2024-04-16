<?php

function get_comunas()
{
    try {
        // Import Credentials
        require 'database.php';

        // Check if a region_id has been sent as a POST parameter
        if (isset($_POST['region_id'])) {
            $regionId = $_POST['region_id'];

            // SQL Query to fetch comunas for the selected region and order them alphabetically
            $sql = "SELECT * FROM comunas WHERE id_region = $regionId ORDER BY nombre;";

            // Make the query
            $query = mysqli_query($db, $sql);

            // Check if the query was successful
            if (!$query) {
                throw new Exception("Query failed: " . mysqli_error($db));
            }

            // Fetch and return results as an associative array
            $comunas = mysqli_fetch_all($query, MYSQLI_ASSOC);

            // Close the database connection
            mysqli_close($db);

            // Encode the results as JSON and send them to the client
            echo json_encode($comunas);
        }
    } catch (\Throwable $th) {
        var_dump($th);
    }
}

// Call the function to retrieve the comunas
get_comunas();
