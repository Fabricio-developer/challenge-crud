<?php
require 'db_config.php';

$put = [];

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Get the JSON data from the request body
    $json_data = file_get_contents("php://input");
    $put = json_decode($json_data, true);

    if (array_key_exists('price', $put)) {
        // Extract the "price" value and clean it
        $priceString = str_replace(',', '.', (str_replace('R$ ', '', $put['price'])));

        // Update the "price" value in the array
        $put['price'] = $priceString;
    }

    // Define the ID of the record you want to update (e.g., based on the 'order_id' field)
    $orderId = $put['order_id']; // Replace 'order_id' with the actual field name

    // Perform the update query
    $sql = "UPDATE orders SET total_price = '" . $put['price'] . "', customer_id = '" . $put['customerSelect'] . "', product_id = '" . $put['productSelect'] . "' WHERE id = " . $orderId;
    echo($sql);
    exit;

    $result = $mysqli->query($sql);

    if ($result) {
        // Update was successful, fetch the updated data
        $sql = "SELECT * FROM orders WHERE id = " . $orderId;
        $result = $mysqli->query($sql);
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        // Handle update failure
        echo json_encode(["error" => "Update failed"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
