<?php
    include '_con.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    session_start();
    $sql = "SELECT * FROM tbl_user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["level"] = $row["level"];
            $_SESSION["img"] = $row["img"];
        }
        if($_SESSION["level"] == "user"){
            echo '<script type="text/JavaScript"> alert("Login สำเร็จ");window.location.href="index.php"</script>';
        }else if($_SESSION["level"] == "admin"){
            echo '<script type="text/JavaScript"> alert("Login สำเร็จ");window.location.href="index_admin.php"</script>';
        }
        
        // header("Location:index.html");
    }else{
        echo '<script type="text/JavaScript"> alert("Username หรือ Password ไม่ถูกต้องกรุณา Login ใหม่อีกครั้ง");window.location.href="login.php";</script>';
        // header("Location:login.php");
    }
    $conn->close();
