<?php
// API to work only on GET method, so unauthorising rest of the methods
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_FILES['file']['name'])) {
            $response_data = uploadFiles();
            response($response_data);
        } else {
            $response_data = setProduct();
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
    $post = $_POST;
    $errors = array();
    $uploadedFiles = array();
    $extension = array("jpeg", "jpg", "png", "gif");
    $bytes = 1024;
    $KB = 1024;
    $totalBytes = 5 * $bytes * $KB;
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
    return compact("uploadResult", "URL");
}

function setProduct()
{
    require '../sql/connection.php';
    $productId = db_quote(randomProductId());
    $productPrice = intval($_POST['product_price']);
    $productAvail = db_quote($_POST['product_avail']);
    $productColor = ($_POST['product_color']);
    $productDesc = ($_POST['product_desc']);
    $productImages = db_quote(json_encode($_POST['product_images']));

    $dataError = array();

    // check product price
    if ($productPrice < 100 && $productPrice > 10000) {
        array_push($dataError, "Incorrect input format: product_price");
    } else {
        $productPrice = db_quote($productPrice);
    }

    // check product availability
    $validAvailability = array("'In Stock'", "'Out Of Stock'");
    if (!in_array($productAvail, $validAvailability)) {
        array_push($dataError, "Incorrect input format: product_avail");
    }

    // check product color
    $validator = '/^[a-zA-Z]{3}+[-]+[0-9]{3}+$/';
    if (!preg_match($validator, $productColor)) {
        array_push($dataError, "Incorrect input format: product_color");
    } else {
        $productColor = db_quote($productColor);
    }

    // check product desc
    if(strlen($productDesc)> 25 ) {
        array_push($dataError, "Incorrect input format: product_desc");
    } else {
        $productDesc = db_quote($productDesc);
    }

    // TO-DO
    // check if image is an URL

    if ($dataError == array()) {
        $setProductQuery = "INSERT INTO `inventory` (`product_id`, `product_price`, `product_desc`, `product_avail`, `product_colors`, `product_image`) VALUES (" . $productId . " , " . $productPrice . " , " . $productDesc . " , " . $productAvail . " , " . $productColor . " , " . $productImages . ")";
        $ifProductSet = db_query($setProductQuery);
        return compact("ifProductSet", "productId");
    } else {
        // header("HTTP/1.0 500 Internal Server Error");
        return $dataError;
    }
}

function randomProductId()
{
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $nums = '0123456789';
    return "KS-" . substr(str_shuffle($chars), 0, 4) . "-" . substr(str_shuffle($nums), 0, 5) . "-" . substr(str_shuffle($chars), 0, 2);
}
