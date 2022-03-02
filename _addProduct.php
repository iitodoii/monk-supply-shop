<?php
session_start();
include '_con.php';

$prd_name = $_POST['prd_name'];
$prd_desc = $_POST['prd_desc'];
$prd_price = $_POST['prd_price'];
$prd_img_url = $_POST['prd_img_url'];
$prd_qty = $_POST['prd_qty'];

$sql = "INSERT INTO `tbl_product`(`name`, `description`, `img`, `price`, `qty`, `unit`, `date`) 
VALUES ('$prd_name','$prd_desc','$prd_img_url','$prd_price','$prd_qty','ชิ้น',now())";

if ($conn->query($sql) === true) {
    echo "New record created successfully";
} else {
    echo "New record not created";
}
?>
