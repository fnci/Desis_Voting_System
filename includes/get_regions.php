<?php
function get_regions()
{
    try {
        // Import Credentials
        require 'database.php';
        // SQL Query to fetch regions and order them alphabetically
        $sql = "SELECT * FROM regiones ORDER BY nombre;";
        // Make query
        $query = mysqli_query($db, $sql);
        return $query;
        /*         // Close connection
        $result = mysqli_close($db);
        echo $result; */
    } catch (\Throwable $th) {
        var_dump($th);
    }
}
get_regions();
