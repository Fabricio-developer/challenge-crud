<?php



require 'db_config.php';



$post = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the JSON data from the request body
  $json_data = file_get_contents("php://input");
  $post = json_decode($json_data, true);

  if (array_key_exists('price', $post)) {
    // Extract the "price" value and clean it
    $priceString = str_replace(',', '.', (str_replace('R$ ', '', $post['price'])));

    // Update the "price" value in the array
    $post['price'] = $priceString;
  }

}

$sql = "INSERT INTO orders (total_price,customer_id,product_id) 



	VALUES ('" . $post['price'] . "','" . $post['customerSelect'] . "','" . $post['productSelect'] . "')";



$result = $mysqli->query($sql);



$sql = "SELECT * FROM orders Order by id desc LIMIT 1";



$result = $mysqli->query($sql);



$data = $result->fetch_assoc();



echo json_encode($data);



?>