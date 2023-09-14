<?php
function get_regions()
{
    try {
        // Import Credentials
        require 'database.php';
        // SQL Queries
        $sql = "SELECT * FROM regiones;";
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
