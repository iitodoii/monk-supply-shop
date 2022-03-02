<?php include '_header.php' ?>

<!-- Content Wrapper. Contains page content -->
<?php
include '_con.php';
$id = $_GET['id'];
$sql = "SELECT * FROM tbl_product WHERE id = $id";
$result = $conn->query($sql);

?>
<div class="content-wrapper" style="margin-top:5vh;margin-bottom:5vh">

  <!-- Main content -->
  <div class="content p-4">

    <section class="container mt-4 mb-4">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
      ?>
          <!-- Default box -->
          <div class="card card-solid">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="col-12">
                    <img src="<?php echo $row["img"] ?>" class="product-image" alt="Product Image">
                  </div>
                  <!-- <div class="col-12 product-image-thumbs">
            <div class="product-image-thumb active"><img src="dist/img/prod-1.jpg" alt="Product Image"></div>
            <div class="product-image-thumb"><img src="dist/img/prod-2.jpg" alt="Product Image"></div>
            <div class="product-image-thumb"><img src="dist/img/prod-3.jpg" alt="Product Image"></div>
            <div class="product-image-thumb"><img src="dist/img/prod-4.jpg" alt="Product Image"></div>
            <div class="product-image-thumb"><img src="dist/img/prod-5.jpg" alt="Product Image"></div>
          </div> -->
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                  <h1 class="my-3"><?php echo $row["name"] ?></h1>

                  <hr>

                  <div class="bg-gray py-2 px-3 mt-4">
                    <h2 class="mb-0">
                      ราคา <?php echo $row["price"] ?> บาท
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
                      <input type="text" id="product_id" name="product_id" class="form-control w-25 d-none" value='<?php echo $row["id"] ?>'>
                      <input type="text" id="product_name" name="product_name" class="form-control w-25 d-none" value='<?php echo $row["name"] ?>'>
                      <input type="text" id="product_price" name="product_price" class="form-control d-none" value='<?php echo $row["price"] ?>'>
                      <input type="text" id="product_img" name="product_img" class="form-control w-25 d-none" value='<?php echo $row["img"] ?>'>
                      <div class="input-group mb-3" style="width:30%">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-danger" type="button" onclick="decrease()">-</button>
                        </div>
                        <input type="text" id="product_qty" name="product_qty" class="form-control text-center" value="1">
                        <div class="input-group-append">
                          <button class="btn btn-outline-success" type="button" onclick="increase()">+</button>
                        </div>
                      </div>
                      <p>มีสินค้าทั้งหมด <?php echo $row["qty"] . " " . $row["unit"] ?></p>
                    </div>
                  </div>

                  <div class="mt-4">
                    <div class="btn btn-info btn-lg btn-flat" id="add-item">
                      <i class="fas fa-cart-plus fa-lg mr-2"></i>
                      เพิ่มไปยังรถเข็น
                    </div>
                  </div>

                  <div class="mt-4 product-share">
                    <a href="#" class="text-gray">
                      <i class="fab fa-facebook-square fa-2x"></i>
                    </a>
                    <a href="#" class="text-gray">
                      <i class="fab fa-twitter-square fa-2x"></i>
                    </a>
                    <a href="#" class="text-gray">
                      <i class="fas fa-envelope-square fa-2x"></i>
                    </a>
                    <a href="#" class="text-gray">
                      <i class="fas fa-rss-square fa-2x"></i>
                    </a>
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
    $('#add-item').click(function() {

      $.ajax({
        url: '_addCart.php',
        type: 'POST',
        data: {
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

  $('#submit').click(function() {
    $.ajax({
      url: 'send_email.php',
      type: 'POST',
      data: {
        email: 'email@example.com',
        message: 'hello world!'
      },
      success: function(msg) {
        alert('Email Sent');
      }
    });
  });
</script>
<?php include '_footer.php' ?>