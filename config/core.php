<?php
// show error reporting
error_reporting(E_ALL); 
// set your default time-zone
date_default_timezone_set('Asia/Manila'); 
// set jwt keys
$key = "5bdf23c837aaa20f28cf3305";
$iss = "https://sandeepdemo.auth0.com";
$aud = "https://sandeepdemo.auth0.com";
$iat = 1356999524;
$nbf = 1357000000;
?>