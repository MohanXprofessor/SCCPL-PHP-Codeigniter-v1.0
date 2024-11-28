<?php

$sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
$query = $this->db->query($sql, array(1));
$branch = $query->result_array();

$sql = "SELECT users.id,users.firstname FROM users join user_group on users.id=user_group.user_id WHERE group_id = 4";
$query = $this->db->query($sql);
$counseller_details = $query->result_array();

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Enquiry</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Enquiry</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="message">
          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="submit" onclick="errorSessionDestory();" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php endif; ?>
          <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="submit" onclick="errorSessionDestory();" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>

        </div>





        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Enquiry Information</h3>
          </div>
          <form role="form" action="<?php base_url('counseller/create') ?>" method="post">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="gross_amount">
                  <h4>Branch</h4>
                </label> &nbsp;
                <select name="branch" type="text" class="form-control" required>


                  <?php $branch_id = $_SESSION['branch_id'];
                  if ($branch_id == 2) { ?>
                    <option value="2" <?php if ($order_data['order']['branch_id'] == '2') { ?> selected<?php } ?>>KHARADI
                    </option>
                    <?php //} elseif($branch_id == '1'){ ?>

                  <?php } else { ?>
                    <option value="2" <?php if ($order_data['order']['branch_id'] == '2') { ?>   <?php } ?>>KHARADI</option>
                    <option value="1" <?php if ($order_data['order']['branch_id'] == '1') { ?> selected<?php } ?>>
                      SHIVAJINAGAR</option>
                  <?php } ?>

                </select>
              </div>


              <div class="form-group">
                <label for="company_name">Date</label>
                <input type="date" class="form-control" id="date" name="date"
                  value="<?php echo $order_data['order']['date'] ?>" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="company_name">Counseller Name</label>

                <select name="cname" type="text" class="form-control" required>
                  <?php
                  foreach ($counseller_details as $v) {

                    ?>
                    <option value="<?php echo $v['id']; ?>" <?php if ($order_data['order']['cname'] == $v['id']) { ?>
                        selected<?php } ?>><?php echo $v['firstname']; ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label for="company_name">Name</label>
                <input type="text" class="form-control" id="name" name="student_name"
                  value="<?php echo $order_data['order']['name'] ?>" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="service_charge_value">Address</label>
                <input type="text" class="form-control" id="address" name="address"
                  value="<?php echo $order_data['order']['address'] ?>" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="vat_charge_value">Mobile Number</label>
                <input type="number" class="form-control" id="mobile_number" name="mobile"
                  value="<?php echo $order_data['order']['mobile']; ?>" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="address">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                  value="<?php echo $order_data['order']['email'] ?>" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="phone">College Name</label>
                <input type="text" class="form-control" id="college" name="college"
                  value="<?php echo $order_data['order']['college'] ?>" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="company_name">Status :</label>
                <select class="form-control" id="status" name="status">
                  <option value="Next-date" <?php if ($order_data['order']['status'] == 'Next-date') { ?> selected<?php } ?>>Next-FollowUp-date</option>
                  <option value="Confirm" <?php if ($order_data['order']['status'] == 'Confirm') { ?> selected<?php } ?>>
                    Confirm</option>
                  <option value="Ignore" <?php if ($order_data['order']['status'] == 'Ignore') { ?> selected<?php } ?>>
                    Ignore</option>
                </select>
              </div>

              <div id="fdate_div">
                <div class="form-group">
                  <label for="company_name">Follow Up Date</label>
                  <input type="date" class="form-control" id="date" name="follow_date"
                    value="<?php echo $order_data['order']['follow_date'] ?>" autocomplete="off">
                </div>
              </div>

              <div class="form-group">
                <label for="company_name">Remark</label>
                <input type="textarea" class="form-control" id="remark" name="remark"
                  value="<?php echo $order_data['order']['remark'] ?>" autocomplete="off">
              </div>



              <!-- <a href="<?php //echo $order_data['order']['file'] ?>" download> S</a> -->

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <input id="submit" type="submit" class="btn btn-primary" value="Save">
              <input id="enroll" type="submit" class="btn btn-primary" value="Confirm">

              <a href="<?php echo base_url('dashboard/') ?>" class="btn btn-warning">Back</a>

            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script type="text/javascript">
  setTimeout(function () {
    $("#message").fadeTo(100, 0).slideUp(300,
      function () {
        $(this).remove();
      });
  }, 3000);



  var base_url = "<?php echo base_url(); ?>";
  $(document).ready(function () {
    // For select multiple array
    $('#fdate_div').show();
    $('#enroll').hide();
    $('#status').change(function () {
      if ($('#status').val() == 'Confirm') {
        $('#enroll').show();
        $('#submit').hide();

      } else {
        $('#enroll').hide();
        $('#submit').show();
      }

      if ($('#status').val() == 'Next-date') {
        $('#fdate_div').show();
      }
      else {
        $('#fdate_div').hide();
      }
    });
  });

</script>