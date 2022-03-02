<?php
session_start();
$_SESSION["product_id"] = $_POST["product_id"];
$_SESSION["product_name"] = $_POST["product_name"];
$_SESSION["product_qty"] = $_POST["product_qty"];
$_SESSION["product_price"] = $_POST["product_price"];
$_SESSION["product_img"] = $_POST["product_img"];

$isSameId = false;

foreach($_SESSION['cart'] as $key=>$value){
    if($value['id']==$_SESSION["product_id"]){
        $_SESSION['cart'][$key]['qty'] = $value['qty']+$_SESSION['product_qty'];
        $isSameId = true;
        break;
    }
}

if(!$isSameId){
    $_SESSION['cart'][] = array(
        'id' => $_SESSION["product_id"],
        'name' => $_SESSION["product_name"],
        'qty' => $_SESSION["product_qty"],
        'price' => $_SESSION['product_price'],
        'img' => $_SESSION['product_img']
    );
}
?>