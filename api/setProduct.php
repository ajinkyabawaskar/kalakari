<?php
// API to work only on GET method, so unauthorising rest of the methods
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        setProducts();
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
function setProducts() {
    $product_id = randomProductId();
    
}

function randomProductId() {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
    $nums = '0123456789';
    return "KS-".substr(str_shuffle($chars), 0, 4)."-".substr(str_shuffle($nums), 0, 5)."-".substr(str_shuffle($chars), 0, 2);
}