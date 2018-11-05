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
$product->name = $data->name;
 
if($product->searchProduct()){
	// generate json web token
	$token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array(           
           "name" => $data->name
       )
    ); 
    // set response code
    http_response_code(200); 
    // generate jwt and set response code
    $jwt = JWT::encode($token, $key);
    // if jwt is not empty
	if($jwt){	 
	    try {	 
	        // decode jwt
	        $decoded = JWT::decode($jwt, $key, array('HS256'));	
	        $data= $product->searchProduct();
	        // encode response data
		    echo json_encode(array("data" => $data, "message" => "Records found successfully.", "jwt" => $jwt)); 
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
	
} 
else{ 
    // set response code
    http_response_code(400); 
   echo json_encode(array("message" => "Records not found!"));
}
?>