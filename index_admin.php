<?php include '_header_admin.php'; ?>
<?php
include '_con.php';
$sql = "SELECT * FROM order_header";
$result = $conn->query($sql);

?>

<!-- Content Wrapper. Contains page content -->
<style type="text/css">
  .swal-title{
    color:'#716add' !important;
    background-color: '#292b2c' !important;
  }
  #swal-title{
    color:'#716add' !important;
    background-color: '#292b2c' !important;
  }
</style>
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid">

      <div class="row">
        <h4 class="mr-4 mt-4">ออเดอร์สินค้าทั้งหมด </h4>
      </div>
      <div class="row">
        <div class="col-12">
          <table id="summary" class="table table-bordered table-hover">
            <thead class="bg-warning">
              <th>รหัสออเดอร์</th>
              <th>ชื่อผู้สั่งซื้อ</th>
              <th>ที่อยู่ในการจัดส่ง</th>
              <th>อีเมล์</th>
              <th>เบอร์โทรศัพท์</th>
              <th>ยอดรวม</th>
              <th>สถานะ</th>
              <th>รายละเอียด</th>
              <th>อัพเดทสถานะ</th>
            </thead>
            <tbody>

              <?php
              $total = 0;
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td> {$row['id']} </td>";
                  echo "<td> {$row['order_name']} </td>";
                  echo "<td> {$row['order_address']} </td>";
                  echo "<td> {$row['order_email']} </td>";
                  echo "<td> {$row['order_tel']} </td>";
                  echo "<td> {$row['order_total']} </td>";
                  // echo "<td> {$value['']} </td>";
                  if ($row["order_status"] == "1") {
                    echo "<td>รอการจัดส่ง</td>";
                    echo "<td class='text-center'><a class='btn btn-success' href='orderDetail.php?order_id={$row['id']}' id='detail'><i class='fas fa-info-circle text-white mr-1'></i> รายละเอียด</a></td>";
                    echo "<td class='text-center'><a class='btn btn-warning text-white' data-toggle='modal' data-target='#updateModal' id='update'><i class='fas fa-wrench text-white mr-1'></i>อัพเดท</a></td>";
                  }else if ($row["order_status"] == "3") {
                    echo "<td>จัดส่งแล้ว</td>";
                    echo "<td class='text-center'><a class='btn btn-success' href='orderDetail.php?order_id={$row['id']}' id='detail'><i class='fas fa-info-circle text-white mr-1'></i> รายละเอียด</a></td>";
                    echo "<td class='text-center'><a class='btn btn-secondary text-white'><i class='fas fa-wrench text-white mr-1'></i>อัพเดท</a></td>";
                  }else{
                    echo "<td class='text-center'><a class='btn btn-success' href='orderDetail.php?order_id={$row['id']}' id='detail'><i class='fas fa-info-circle text-white mr-1'></i> รายละเอียด</a></td>";
                    echo "<td class='text-center'><a class='btn btn-warning text-white' data-toggle='modal' data-target='#updateModal' id='update'><i class='fas fa-wrench text-white mr-1'></i>อัพเดท</a></td>";
                  }
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

<div class="modal fade" id="updateModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">กรุณาใส่เลข Tracking เพื่ออัพเดท</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="order_id" />
        <div class="row">
          <div class="col-4">
            <p>Tracking number</p>
          </div>
          <div class="col-8">
            <input class="form-control" type="text" id="tracking" />
          </div>
        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="updateStatus()" class="btn btn-primary">อัพเดทสถานะ</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- <div class="modal" id="updateModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div> -->
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#summary').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
      "initComplete": function() {
        let api = this.api();
        api.$('td #update').click(function() {
          let order_id = api.row($(this).parent().parent()).data()[0];
          console.log(order_id);
          $('#order_id').val(order_id);
          $('#updateModal').show();
        });
      }
    });

  });

  function updateStatus() {
    Swal.fire({
      title: 'ยืนยันจะอัพเดทสถานะ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'ตกลง',
      cancelButtonText: 'ยกเลิก',
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $.ajax({
          url: '_updateStatus.php',
          type: 'POST',
          data: {
            order_id: $('#order_id').val(),
            tracking: $('#tracking').val()
          },
          success: function(msg) {
            swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: 'อัพเดทสถานะเรียบร้อย',
              color: '#716add',
              showConfirmButton: false,
              timer: 2000
            }).then((result) => {
              location.reload();
            })
          },
          failure: function(msg) {
            swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'error',
              title: 'อัพเดทสถานะไม่สำเร็จ',
              color: '#716add',
              showConfirmButton: false,
              timer: 2000
            })
          }
        });
      }
    })
  }
</script>
<?php include '_footer_admin.php'; ?>