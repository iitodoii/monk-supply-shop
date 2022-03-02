<?php include '_header_admin.php'; ?>
<?php
include '_con.php';

$sql = "SELECT * from tbl_product";
$result = $conn->query($sql);

?>
<style type="text/css">
    .modal-color {
        color: '#716add' !important;
        background-color: '#292b2c' !important;
    }

    .swal-title {
        color: '#716add' !important;
        background-color: '#292b2c' !important;
    }

    .dataTables_filter {
        width: 50%;
        float: right;
        text-align: right;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <h4 class="mr-4 mt-4">รายละเอียดออเดอร์สินค้า </h4>
            </div>
            <div class="row mb-4">
                <div class="col-4">
                    <label for="url">เพิ่มสินค้า</label>
                    <input type="text" id="url" name="url" class="form-control" placeholder="Url Shoppee" />
                </div>
                <div class="col-2 d-flex align-items-end">
                    <button type="button" class="btn btn-success text-center align-middle" onclick="addItem()">เพิ่ม</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table id="summary" class="table table-bordered table-hover">
                        <thead class="bg-primary">
                            <th>รหัส</th>
                            <th>ชื่อสินค้า</th>
                            <!-- <th>รายละเอียดสินค้า</th> -->
                            <th>รูปภาพ</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>หน่วย</th>
                            <th>อัพเดท</th>
                        </thead>
                        <tbody>

                            <?php
                            $total = 0;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td> {$row['id']} </td>";
                                    echo "<td> {$row['name']} </td>";
                                    // echo "<td class='text-nowrap'> {$row['description']} </td>";
                                    echo "<td> {$row['img']} </td>";
                                    echo "<td> {$row['price']} </td>";
                                    echo "<td> {$row['qty']} </td>";
                                    echo "<td> {$row['unit']} </td>";
                                    echo "<td class='text-center'><a class='btn btn-danger text-white' id='delete'><i class='fas fa-trash text-white mr-1'></i>ลบ</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</div>

<script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "1500",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    $(document).ready(function() {
        var table = $('#summary').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "initComplete": function() {
                let api = this.api();
                api.$('td #delete').click(function() {
                    let prd_id = api.row($(this).parent().parent()).data()[0];
                    console.log(prd_id);
                    $.ajax({
                        url: '_deleteProduct.php',
                        type: 'POST',
                        data: {
                            prd_id:prd_id
                        },
                        success: function(result) {
                            toastr["success"]("ลบสินค้าสำเร็จ!");
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        failure: function(msg) {
                            swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'ลบสินค้าไม่สำเร็จ',
                                color: '#716add',
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }
                    });
                });
            }
        });
    });


    function addItem() {
        $.ajax({
            url: 'http://localhost:8082/getShopeeData',
            type: 'GET',
            data: {
                page: $('#url').val(),
            },
            success: function(result) {
                $.ajax({
                    url: '_addProduct.php',
                    type: 'POST',
                    data: {
                        prd_name: result.product.prd_name,
                        prd_desc: result.product.prd_desc,
                        prd_price: result.product.prd_price,
                        prd_img_url: result.product.prd_img_url,
                        prd_qty: result.product.prd_qty
                    },
                    success: function(result) {
                        toastr["success"]("เพิ่มสินค้าสำเร็จ!");
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    failure: function(msg) {
                        swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'เพิ่มสินค้าไม่สำเร็จ',
                            color: '#716add',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                });
            },
            failure: function(msg) {
                swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'เพิ่มสินค้าไม่สำเร็จ',
                    color: '#716add',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        });
    }
</script>
<?php include '_footer_admin.php'; ?>