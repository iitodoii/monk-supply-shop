<!DOCTYPE html>
<html lang="en">

<head> 
    <meta charset="utf-8">
    <link rel="icon" href="dist/img/m.png">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monk Supply Shop</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="dist/css/custom.css">
    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="plugins/toastr/toastr.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"> 
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Thai:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>
<?php 
header("Content-Type: text/html;charset=UTF-8");
session_start();

if (isset($_SESSION["user_id"])) {

} else {
    echo "<script type='text/JavaScript'> alert('กรุณา Login ก่อน {$_SESSION["user_id"]}');window.location.href='index.php';</script>";
}
include '_con.php';

$id = $_SESSION["user_id"];
$sql = "SELECT * FROM tbl_user WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

        <body class="hold-transition layout-top-nav" style="font-family: 'Noto Serif Thai','Fredoka', Serif;">
            <div class="wrapper">

                <!-- Preloader -->
                <div class="preloader flex-column justify-content-center align-items-center">
                    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
                </div>
                <!-- Content Wrapper. Contains page content -->
                <!-- Navbar -->
                <!-- <nav class="main-header navbar navbar-expand-md fixed-top navbar-light" > -->
                <nav class="main-header navbar navbar-expand-md fixed-top navbar-light" style="background-color:#ff9d47;">
                    <div class="container">
                        <a href="home.php" class="navbar-brand">
                            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                            <span class="brand-text text-shadow text-dark">Monk Supply Shop</span>
                        </a>

                        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                            <!-- Left navbar links -->
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a href="home.php" class="nav-link">ร้านค้า</a>
                                </li>
                            </ul>

                        </div>

                        <!-- Right navbar links -->
                        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                            <!-- Notifications Dropdown Menu -->
                            <li class="nav-item">
                                <div>
                                    <a class="nav-link">สวัสดีคุณ <?php echo $row["firstname"] . " " . $row["lastname"] ?></a>
                                </div>

                            </li>
                            <li class="nav-item dropdown-cart">
                                <a class="nav-link" href="summary.php">
                                    <i class="fas fa-shopping-cart"></i>
                                    <?php
                                    if (isset($_SESSION['cart'])) {
                                        $sum = count($_SESSION['cart']);
                                        echo "<span class='badge badge-info navbar-badge'>{$sum}</span>";
                                    } else {
                                        echo "<span class='badge badge-info navbar-badge'>0</span>";
                                    }
                                    ?>

                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                    <span class="dropdown-item dropdown-header">สินค้าทั้งหมด</span>
                                    <div class="dropdown-divider"></div>
                                    <?php
                                    if (isset($_SESSION['cart'])) {
                                        foreach ($_SESSION['cart'] as $key => $value) { //เป็นการวนซ้ำข้อมูลที่อยู่ในตัวแปร Global ในส่วนของตะกร้ามาแสดงผล
                                            echo '<a href="summary.php" class="d-flex justify-content-between  dropdown-item">';
                                            echo "<div><span class='mini-limit-text'><i class='fas fa-shopping-basket mr-2'></i>{$value['name']}</span></div>";
                                            echo "<span class='float-right text-muted text-sm'>{$value['qty']}</span>";
                                            echo "</a>";
                                        }
                                    } else {
                                        echo '<a href="summary.php" class="d-flex justify-content-center  dropdown-item">';
                                        echo "<div><span>ไม่มีรายการสินค้า</span></div>";
                                        echo "</a>";
                                    }

                                    ?>
                                    <div class="dropdown-divider"></div>
                                    <a href="summary.php" class="dropdown-item dropdown-footer">ดูรายการสินค้าทั้งหมด</a>
                                </div>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                                    <i class="fas fa-th-large"></i>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="_logout.php" class="nav-link text-danger"><i class=" nav-icon fas fa-door-open text-danger"></i> ออกจากระบบ</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- /.navbar -->
        <?php  }
} else {
    echo "0 results";
}
$conn->close();
        ?>