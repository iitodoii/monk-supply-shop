<?php
session_start();
$product_id = $_POST["product_id"];

foreach($_SESSION['cart'] as $key=>$value){
    if($value['id']== $product_id){
        unset($_SESSION['cart'][$key]);
    }
}

?>