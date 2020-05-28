<?php
// API to work only on GET method, so unauthorising rest of the methods
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // check if product_id is provided
        if (@$_GET['product_id'] == null) {
            header("HTTP/1.0 401 Unauthorized");
        } else {
            $product = fetchProductBy($_GET['product_id']);
            response($product);
        }
        break;
    default:
        header("HTTP/1.0 401 Unauthorized");
        break;
}
// An utility function to return JSON data with appropriate headers
function response($response_data)
{
    header('Content-Type: application/json');
    echo json_encode($response_data);
}
function fetchProductBy($product_id)
{
    // validating product_id
    $validator = '/^[KS-]+[a-zA-Z]{4}+[-]+[0-9]{5}+[-]+[a-zA-Z]{2}+$/';
    if (preg_match($validator, $product_id)) {
        // proceed
        require '../sql/connection.php';
        $fetchProductQuery = "SELECT * FROM `inventory` WHERE `product_id` =".db_quote($product_id);
        $fetchedProduct = db_select($fetchProductQuery);
        // if fetchedProduct is empty, product is not found => returning appropriate message
        if($fetchedProduct == array()) {
            $fetchedProduct = "No Product Found";
        }
    } else {
        //invalid product_id
        return "Invalid Product ID";
    }
    return $fetchedProduct;
}
