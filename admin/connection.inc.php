<?php
session_start();
$con= mysqli_connect("localhost","root","","mandala8sem");


// Defining the path
define('SITE_PATH','http://127.0.0.1/bca8-proj/');

// Server path
define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/bca8-proj');

// Server image path
define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'/media/product/');

// site image path
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/product/')
?> 