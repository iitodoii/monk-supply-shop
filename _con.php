<?php
// $conn = new mysqli("127.0.0.1:3308", "admin", "admin999", "monkshop");
// $conn = new mysqli("184.168.96.211:3306", "root_999", "sheepcow", "monkshop");
$conn = new mysqli("localhost", "root_999", "sheepcow", "mydb");
$conn->set_charset("utf8");
if ($conn->connect_error) {
    // die("Connection failed: " . $conn->connect_error);
    echo "Connection failed";
} else {
    // echo "เชื่อมต่อฐานข้อมูลสำเร็จ";
}
?>


<!-- <?php include 'footer.php';?> -->