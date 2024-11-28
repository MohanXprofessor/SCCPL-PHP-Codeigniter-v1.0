<?php

$sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
$query = $this->db->query($sql, array(1));
$branch = $query->result_array();

$sql = "SELECT * FROM brands WHERE active  = ? order by id desc";
$query = $this->db->query($sql, array(1));
$courses = $query->result_array();


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
      <small>Counseller</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Counseller</li>
    </ol>
  </section>
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div id="messages"></div>
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
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Enquiry </h3>
          </div>
          <form role="form" action="<?php base_url('counseller/create') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <?php echo validation_errors(); ?>
              <div class="form-group">
                <label for="gross_amount"> Select Project</label> &nbsp;
                <select name="project_id" type="text" class="form-control" required>
                  <?php $branch_id = $_SESSION['branch_id'];
                  if ($branch_id != 2) {
                    foreach ($branch as $v) { ?>
                      <option value="<?php echo $v['id']; ?>">
                        <?php echo $v['name']; ?>
                      </option>
                    <?php }
                  } else { ?>
                    <option value="2" selected>Capgimini</option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="company_name">Current Date</label>
                <input type="date" class="form-control" id="currentDate" value="<?php echo date('Y-m-d'); ?>"
                  name="currentDate" autocomplete="off" readonly required>
              </div>
              <div class="form-group">
                <label for="company_name">Select Course</label>
                <select name="project_id" type="text" class="form-control" required>
                  <?php
                  foreach ($courses as $v) { ?>
                    <option value="<?php echo $v['id']; ?>">
                      <?php echo $v['name']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="company_name">Counseller Name</label>
                <select name="cname" type="text" class="form-control" required>
                  <?php
                  foreach ($counseller_details as $v) {
                    ?>
                    <option value="<?php echo $v['id']; ?>">
                      <?php echo $v['firstname']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="company_name">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name"
                  placeholder="Enter Student name" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="service_charge_value">Student Address</label>
                <input type="text" class="form-control" id="address" name="address"
                  placeholder="Enter Student asddress " autocomplete="off">
              </div>
              <div class="form-group">
                <label for="vat_charge_value">Student Mobile Number</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile"
                  placeholder="Enter Mobile Number " autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="address">Student Email ID</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                  autocomplete="off">
              </div>
              <div class="form-group">
                <label for="phone">Highest Qualifications</label>
                <input type="text" class="form-control" id="college" name="college" placeholder="Enter Qualification"
                  autocomplete="off">
              </div>
              <div class="form-group">
                <label for="phone">Specialization</label>
                <input type="text" class="form-control" id="college" name="college" placeholder="Enter Specialization"
                  autocomplete="off">
              </div>
              <div class="form-group">
                <label for="phone">College Name</label>
                <input type="text" class="form-control" id="college" name="college" placeholder="Enter College Name"
                  autocomplete="off">
              </div>
              <div class="form-group">
                <label for="company_name">Select Status :</label>
                <select class="form-control" id="status" name="status">
                  <option value="Next-date" slected>Next-FollowUp-date</option>
                  <option value="Confirm">Confirm</option>
                  <option value="Ignore">Ignore</option>
                </select>
              </div>
              <div class="form-group">
                <label for="company_name">Remark</label>
                <input type="textarea" class="form-control" id="remark" name="remark" autocomplete="off">
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <input type="reset" class="btn btn-danger" value="Reset"> &nbsp; &nbsp;
              <input id="submit" type="submit" class="btn btn-primary" value="Save">
              <input id="enroll" type="submit" class="btn btn-primary" value="Confirm">
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
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function () {
    // For select multiple array
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
  }); // /document
</script>