<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); 

// files needed to connect to database
include_once '../config/database.php';
include_once 'class/product.php'; 
// get database connection
$database = new Database();
$db = $database->getConnection(); 
// instantiate product object
$product = new Product($db); 
// get posted data
if($product->listProduct()){	 
	$data= $product->listProduct();
	//echo json_encode($data);exit;
    echo json_encode(array("data" => $data, "message" => "List products successfully.", "status" => http_response_code(200)));
	}else{ 
    // set response code
    http_response_code(400); 
    echo json_encode(array("message" => "Sorry, unable to list products."));
}
?>