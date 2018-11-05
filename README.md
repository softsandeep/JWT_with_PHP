# JWT_with_PHP
Add,Edit,Delete,Search API with JWT in core php

-------------------------------------------------
All API's successfully verified by POSTMAN tool.
Authentication:JWT authentication with OAuth.
Refrence: https://jwt.io/

Add API:http://localhost/modestreet/api/add_products.php
Json post:
{   
    "name" : "jeans",
    "size" : "36",
    "prize" : "1200",
    "category" : "Cloth",
    "img" : "Paste your image bash64 encoded text"
}

Edit API:http://localhost/modestreet/api/edit_products.php
Json post:
{   
    "id" : "1",
    "name" : "jeans",
    "size" : "36",
    "prize" : "1200",
    "category" : "Cloth",
    "img" : "Paste your image bash64 encoded text"
}


List API:http://localhost/modestreet/api/list_products.php
Json post:NULL


Delete API:http://localhost/modestreet/api/delete.php
Json post:
{
    "id" : "11"
}

Search API: http://localhost/modestreet/api/search.php
Json post:
{
    "name" : "jeans"    
}
