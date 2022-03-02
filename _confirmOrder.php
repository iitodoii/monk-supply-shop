<?php
session_start();
include '_con.php';
//first step is add order_header
$user_id = $_SESSION['user_id'];
$name = $_POST["name"];
$address = $_POST["address"];
$email = $_POST["email"];
$tel = $_POST["tel"];
$total = $_POST["total"];

$sql = "INSERT INTO `order_header`(`user_id`, `order_name`, `order_address`, `order_email`, 
`order_tel`, `order_total`, `order_status`, `track_number`) 
VALUES ('$user_id','$name','$address','$email',
'$tel','$total','1','')";
// $result = $conn->query($sql);

if ($conn->query($sql) === true) {
    echo "New record created successfully";
} else {
    echo "New record not created";
}

//Get Max id of order_header to insert to order_detail
$max = 0;
$sql2 = "SELECT max(id) as max FROM `order_header`";
$result = $conn->query($sql2);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $max = $row['max'];
    }
}

//Add to order_detail
foreach ($_SESSION['cart'] as $key => $value) {
    $sql3 = "INSERT INTO `order_detail`(`order_id`, `product_id`, `product_qty`, `detail_total`) 
    VALUES ('$max','".$value["id"]."','".$value["qty"]."','".$value["qty"]*$value["price"]."')";
    if($conn->query($sql3)===true){
        unset($_SESSION['cart']);
    }else{
        echo "New record not created";
    }
}

?>