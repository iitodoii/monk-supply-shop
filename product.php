<?php include '_header.php' ?>


<!-- Content Wrapper. Contains page content -->
<?php
include '_con.php';
$id = $_GET['id']; //ดึงค่า id (รหัสสินค้า) มาจาก url

$sql = "SELECT * FROM tbl_product WHERE id = $id";
$result = $conn->query($sql);

?>
<div class="content-wrapper" style="margin-top:5vh;margin-bottom:5vh">

  <!-- Main content -->
  <div class="content p-4">

    <section class="container mt-4 mb-4">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { //นำข้อมูลที่ได้มาวนซ้ำเพื่อแสดงผล
      ?>
          <!-- Default box -->
          <div class="card card-solid">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="col-12">
                    <img src="<?php echo $row["img"] ?>" class="product-image" alt="Product Image">
                    <!-- แสดงผลรูปภาพจาก url ในฐานข้อมูล -->
                  </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                  <h1 class="my-3"><?php echo $row["name"] ?></h1>
                  <!-- ชื่อของสินค้า -->
                  <hr>

                  <div class="bg-gray py-2 px-3 mt-4">
                    <h2 class="mb-0">
                      ราคา <?php echo $row["price"] ?> บาท
                      <!-- ราคาของสินค้า -->
                    </h2>

                  </div>
                  <div class="row mt-2">
                    <div class="col-3">
                      <h5>การจัดส่ง : </h5>
                    </div>
                    <div class="col-9">
                      <p><i class="fas fa-truck"></i> จัดส่งทั่วประเทศ</p>
                    </div>
                    <div class="col-3">
                      <h5>จำนวน : </h5>
                    </div>
                    <div class="col-9">
                      <!-- ข้อมูลทั้งหมดที่จะส่งไปยังตะกร้าสินค้า  -->
                      <!-- รหัสสินค้า -->
                      <input type="text" id="product_id" name="product_id" class="form-control w-25 d-none" value='<?php echo $row["id"] ?>'>
                      <!-- ชื่อสินค้า -->
                      <input type="text" id="product_name" name="product_name" class="form-control w-25 d-none" value='<?php echo $row["name"] ?>'>
                      <!-- ราคาสินค้า -->
                      <input type="text" id="product_price" name="product_price" class="form-control d-none" value='<?php echo $row["price"] ?>'>
                      <!-- รูปภาพของสินค้า -->
                      <input type="text" id="product_img" name="product_img" class="form-control w-25 d-none" value='<?php echo $row["img"] ?>'>
                      <div class="input-group mb-3" style="width:30%">
                        <div class="input-group-prepend">
                          <!-- ปุ่มลดจำนวน -->
                          <button class="btn btn-outline-danger" type="button" onclick="decrease()">-</button>
                        </div>
                        <!-- จำนวนสินค้าที่ต้องการสั่งซื้อ -->
                        <input type="text" id="product_qty" name="product_qty" class="form-control text-center" value="1">
                        <div class="input-group-append">
                          <!-- ปุ่มเพิ่มจำนวน -->
                          <button class="btn btn-outline-success" type="button" onclick="increase()">+</button>
                        </div>
                      </div>
                      <!-- จำนวนสินค้าในคลัง -->
                      <p>มีสินค้าทั้งหมด <?php echo $row["qty"] . " " . $row["unit"] ?></p>
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="btn btn-info btn-lg btn-flat" id="add-item">
                      <i class="fas fa-cart-plus fa-lg mr-2"></i>
                      เพิ่มไปยังรถเข็น
                    </div>
                  </div>

                </div>
              </div>
              <div class="row mt-4">
                <nav class="w-100">
                  <div class="nav nav-tabs" id="product-tab" role="tablist">
                    <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">รายละเอียดสินค้า</a>
                  </div>
                </nav>
                <div class="tab-content p-3" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"><?php echo nl2br($row["description"]) ?></div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
      <?php  }
      } else {
        echo "0 results";
      }
      $conn->close();
      ?>
    </section>


  </div>
  <!-- /.content -->
</div>
<script type="text/javascript">
  $(document).ready(function() {
    //ถ้าปุ่มเพิ่มสินค้าโดนคลิก
    $('#add-item').click(function() {

      $.ajax({
        url: '_addCart.php',
        type: 'POST',
        data: {
          //รับค่าจากหน้าจอแล้วส่งไปยังหน้า _addCart.php
          product_id: $('#product_id').val(),
          product_name: $('#product_name').val(),
          product_qty: $('#product_qty').val(),
          product_price: $('#product_price').val(),
          product_img: $('#product_img').val()
        },
        success: function(msg) {
          swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'เพิ่มสินค้าลงตระกร้าเรียบร้อย',
            showConfirmButton: false,
            timer: 2000
          })
        },
        failure: function(msg) {
          swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'เพิ่มสินค้าไม่สำเร็จ',
            showConfirmButton: false,
            timer: 2000
          })
        }
      });
    });
  });
</script>
<?php include '_footer.php' ?>