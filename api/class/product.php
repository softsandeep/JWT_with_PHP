<?php
// Product class file
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "products"; 
    // object properties
    public $name;
    public $size;
    public $prize;
    public $category;
    public $img; 
    public $id; 
    // constructor
    public function __construct($db){
        $this->conn = $db;
        define('UPLOAD_DIR', 'images/');
    } 
// Add new Product record
function addProduct(){
    
    //Now you can put this image data to your given location.
    $data = str_replace('data:image/png;base64,', '', $this->img);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode($data); // Decode image using base64_decode
    $file = UPLOAD_DIR . uniqid() . '.png';
    $imageName= uniqid() . '.png';
    $success = file_put_contents($file, $data);    
    // Insert query
    $query = "INSERT INTO " . $this->table_name . "
            SET
                product_name = :name,
                product_size = :size,
                product_prize = :prize,
                product_category = :category,
                product_img = :img";
    // prepare the query
    $stmt = $this->conn->prepare($query);   
    // bind the values    
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':size', $this->size);
    $stmt->bindParam(':prize', $this->prize);
    $stmt->bindParam(':category', $this->category);
    $stmt->bindParam(':img', $imageName);
    if($stmt->execute()){
        return true;
    } 
    return false;
} 
 
public function editProduct(){ 
   
   //Now you can put this image data to your given location.
    $data = str_replace('data:image/png;base64,', '', $this->img);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode($data); // Decode image using base64_decode
    $file = UPLOAD_DIR . uniqid() . '.png';
    $imageName= uniqid() . '.png';
    $success = file_put_contents($file, $data); 
    // Update product details through product ID
    $query = "UPDATE " . $this->table_name. "
            SET
                product_name = :name,
                product_size = :size,
                product_prize = :prize,
                product_category = :category,
                product_img = :img
            WHERE product_id = :id"; 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->size=htmlspecialchars(strip_tags($this->size));
    $this->prize=htmlspecialchars(strip_tags($this->prize));
    $this->category=htmlspecialchars(strip_tags($this->category)); 
    $this->img=htmlspecialchars(strip_tags($imageName)); 

    // prepare the query
    $stmt = $this->conn->prepare($query);
    // bind the values 
    $stmt->bindParam(':id', $this->id);      
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':size', $this->size);
    $stmt->bindParam(':prize', $this->prize);
    $stmt->bindParam(':category', $this->category);    
    $stmt->bindParam(':img', $imageName); 
    // execute the query
    if($stmt->execute()){
        return true;
    } 
        return false;
    }

public function listProduct(){ 
   
    $query = "SELECT * FROM " . $this->table_name. " ORDER BY product_id DESC";
    //prepare the query
    $stmt = $this->conn->query($query);     
    // execute the query    
    if($stmt){
        $data= $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } 
        return false;
    }
public function deleteProduct(){ 
    $select = "SELECT product_id FROM " . $this->table_name. " WHERE product_id = :id";
    $stmt = $this->conn->prepare($select);
    $stmt->bindParam(':id', $this->id);
    $stmt->execute();
    $checkData= $stmt->fetchAll(PDO::FETCH_ASSOC);  

    if (count($checkData) >0) {
        $query = "DELETE FROM " . $this->table_name. " WHERE product_id = :id";
        //prepare the query
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        //Execute the query
        if($stmt->execute()){
            return true;
        }         
    }else{
        return false;
        }
    }
public function searchProduct(){ 
    $query = "SELECT * FROM " . $this->table_name. " WHERE product_name = :name ORDER BY product_name DESC";
    //prepare the query
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':name', $this->name);     
    // execute the query    
    if($stmt->execute()){
        $data= $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } 
        return false;
    }   
}