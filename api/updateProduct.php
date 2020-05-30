<?php
// API to work only on GET method, so unauthorising rest of the methods
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $response_data = updateProduct();
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

function updateProduct()
{
    // validating product_id and proceed
    $validator = '/^[KS-]+[a-zA-Z]{4}+[-]+[0-9]{5}+[-]+[a-zA-Z]{2}+$/';
    if (isset($_POST['product_id']) and preg_match($validator, $_POST['product_id'])) {
        require '../sql/connection.php';
        $updateProductQuery = "UPDATE `inventory` SET ";
        $updatedColumns = array();
        $dataError = array();
        $whereProductId = " WHERE `product_id` = " . db_quote($_POST['product_id']);
        if (isset($_POST['product_price'])) {
            $productPrice = intval($_POST['product_price']);
            // check product price
            if ($productPrice > 100 && $productPrice < 10000) {
                array_push($updatedColumns, "`product_price` = " . db_quote($productPrice));
            } else {
                array_push($dataError, "Incorrect input format: product_price");
            }
        }
        if (isset($_POST['product_desc'])) {
            // check product desc
            if (strlen($_POST['product_desc']) < 25) {
                array_push($updatedColumns, "`product_desc` = " . db_quote($_POST['product_desc']));
            } else {
                array_push($dataError, "Incorrect input format: product_desc");
            }
        }
        if (isset($_POST['product_sizes'])) {
            $validSizes = array("XS", "S", "M", "L", "XL");
            if (in_array($_POST['product_sizes'], $validSizes)) {
                array_push($updatedColumns, "`product_sizes` = " . db_quote($_POST['product_sizes']));
            } else {
                array_push($dataError, "Incorrect input format: product_size");
            }
        }
        if (isset($_POST['product_avail'])) {
            // check product availability
            $validAvailability = array("In Stock", "Out Of Stock");
            if (in_array($_POST['product_avail'], $validAvailability)) {
                array_push($updatedColumns, "`product_avail` = " . db_quote($_POST['product_avail']));
            } else {
                array_push($dataError, "Incorrect input format: product_avail");
            }
        }
        if (isset($_POST['product_colors'])) {
            // check product color
            $validator = '/^[a-zA-Z]{3}+[-]+[0-9]{3}+$/';
            if (preg_match($validator, $_POST['product_colors'])) {
                array_push($updatedColumns, "`product_colors` = " . db_quote($_POST['product_colors']));
            } else {
                array_push($dataError, "Incorrect input format: product_color");
            }
        }
        if (isset($_POST['product_image'])) {
            array_push($updatedColumns, "`product_image` = " . db_quote($_POST['product_image']));
        }

        // check for errors 
        if ($dataError == array()) {
            // no error, proceed with submit 
            if ($updatedColumns == array()) {
                // no data sent 
                return "No data sent to update!";
            } else {
                // update DB
                $updateProductQuery = $updateProductQuery . implode(" , ", $updatedColumns) . $whereProductId;
                $isProductUpdated = db_query($updateProductQuery);
                return $isProductUpdated;
            }
        } else {
            // return occurred errors
            return $dataError;
        }
    } else {
        return "Invalid Product ID";
    }
}
