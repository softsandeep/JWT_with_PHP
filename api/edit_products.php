<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); 
// generate json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT; 
// files needed to connect to database
include_once '../config/database.php';
include_once 'class/product.php'; 
// get database connection
$database = new Database();
$db = $database->getConnection(); 
// instantiate product object
$product = new Product($db); 
// get posted data
$data = json_decode(file_get_contents("php://input"));

// set product property values
$product->id       = $data->id;
$product->name     = $data->name;
$product->size     = $data->size;
$product->prize    = $data->prize;
$product->category = $data->category;
$product->img      = $data->img;

if($product->editProduct()){
	// generate json web token
	$token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array( 
           "id" => $data->id,          
           "name" => $data->name,
           "size" => $data->size,
           "prize" => $data->prize,
           "category" => $data->category,
           "img" => $data->img
       )
    ); 
    // set response code
    http_response_code(200); 
    // generate jwt and set response code
    $jwt = JWT::encode($token, $key);
    // if jwt is not empty
	if($jwt){	 
	    // if decode succeed, show product details
	    try {	 
	        // decode jwt
	        $decoded = JWT::decode($jwt, $key, array('HS256'));	
	        echo json_encode(
            array(
                "message" => "Product updated successfully.",
                "jwt" => $jwt
            )
        );  
	    }	 
	    catch (Exception $e){ 
			    // set response code
			    http_response_code(401);			 
			    // show error message
			    echo json_encode(array(
			        "message" => "Access denied.",
			        "error" => $e->getMessage()
			    ));
			}
  	}
    } else{ 
        // set response code
        http_response_code(400); 
       echo json_encode(array("message" => "Sorry, unable to update product!"));
}
?>