<?php

require '../db_config.php';


$sqlTotal = "SELECT id, name, cpf FROM customers";


$result =  mysqli_query($mysqli,$sqlTotal);

if ($result) {
    // Initialize an array to store the data
    $data = array();

    // Fetch rows from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Append each row to the data array
        $data[] = $row;
    }

    // Close the result set
    mysqli_free_result($result);

    // Return the data as JSON response
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // Handle the case where the query fails
    $data['error'] = mysqli_error($mysqli);

    // Return an error response, for example
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode($data);
}

// Close the database connection when you're done
mysqli_close($mysqli);



?>