<?php

require 'db_config.php';

$where = '';

if (isset($_GET['id'])) {
    // Retrieve the 'id' parameter value
    $id = $_GET['id'];

    $where = 'WHERE orders.id =' . $id . ' ';
}

$sqlTotal = "SELECT 
            orders.id AS order_id, customers.name AS customer_name,
            customers.cpf, products.name AS product_name,
            customers.id as customer_id, products.id as product_id,
            orders.total_price AS price
             FROM orders
             INNER JOIN customers ON orders.customer_id = customers.id
             INNER JOIN products ON orders.product_id = products.id ". $where;

$result = mysqli_query($mysqli, $sqlTotal);

if ($result) {
    // Initialize an array to store the data
    $data['orders'] = array();

    // Fetch rows from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Append each row to the data array
        $data['orders'][] = $row;
    }

    // Close the result set
    mysqli_free_result($result);

} else {
    // Handle the case where the query fails
    $data['error'] = mysqli_error($mysqli);

    // Return an error response, for example
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode($data);
}

// Return the data as JSON response
header('Content-Type: application/json');
echo json_encode($data);


// Close the database connection when you're done
mysqli_close($mysqli);



?>