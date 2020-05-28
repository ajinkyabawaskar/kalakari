<?php
// API to work only on GET method, so unauthorising rest of the methods
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if ($_POST['fileUpload'] == true) {
            $response_data = uploadFiles();
            response($response_data);
        }
        if ($_POST['fileUpload'] == false) {
            $response_data = setProducts();
            response($response_data);
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

function uploadFiles()
{
    $config = parse_ini_file('../sql/db_config.ini');
    $uploaddir = $config['imageUploadPath'];
    $uploadfile = $uploaddir . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        $uploadResult = true;
        $URL = $uploadfile;
    } else {
        $uploadResult = false;
        $URL = null;
    }
    return compact("uploadResult","URL");
}
function setProducts()
{
    $errors         = array();      // array to hold validation errors
    $data           = array();      // array to pass back data
    // if there are any errors in our errors array, return a success boolean of false
    if (!empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process our form, then return a message

        // DO ALL YOUR FORM PROCESSING HERE
        // THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)

        // show a message of success and provide a true success variable
        $data['success'] = true;
        $data['message'] = 'Success!';
        $data['data'] = $_POST;
    }
    return $data;
}

function randomProductId()
{
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $nums = '0123456789';
    return "KS-" . substr(str_shuffle($chars), 0, 4) . "-" . substr(str_shuffle($nums), 0, 5) . "-" . substr(str_shuffle($chars), 0, 2);
}
