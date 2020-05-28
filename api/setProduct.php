<?php
// API to work only on GET method, so unauthorising rest of the methods
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $response_data = uploadFiles();
        response($response_data);
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

function uploadFiles()
{
    
    $post = $_POST;
    $config = parse_ini_file('../sql/db_config.ini');
    $uploaddir = $config['imageUploadPath'];
    $fp = fopen('../results.json', 'w');
    fwrite($fp, json_encode($post));
    fclose($fp);
    if (isset($_FILES['file']['name'])) {
        $uploadfile = $uploaddir . basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            $uploadResult = true;
            $URL = $uploadfile;
        } else {
            $uploadResult = false;
            $URL = null;
        }

        return compact("uploadResult", "URL");
    } else return $post;
}
function setProducts()
{
    return $_POST;
}

function randomProductId()
{
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $nums = '0123456789';
    return "KS-" . substr(str_shuffle($chars), 0, 4) . "-" . substr(str_shuffle($nums), 0, 5) . "-" . substr(str_shuffle($chars), 0, 2);
}
