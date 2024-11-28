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
      Update
      <small>Screening Test</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Update Screening Test</li>
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
            <h3 class="box-title"> Screening Test </h3>
          </div>
          <form role="form" method="post">
            <div class="box-body">
              <div class="form-group" hidden>
                <label for="company_name">Enquiry Id</label>
                <input type="text" class="form-control" id="enquiryId" name="enquiryId"
                  value="<?php echo $testData['enquiry_id']; ?>" placeholder="Enter Enquiry Id" readonly
                  autocomplete="off">
              </div>
              <div style="display:flex;align-items:center;justify-content:space-between;gap:10px">
                <div style="width:100%">
                  <div class="form-group">
                    <label for="company_name">Aptitude Test Date</label>
                    <input type="date" class="form-control" id="apptitudeTestDate" name="apptitudeTestDate"
                      value="<?php echo $testData['apptitude_test_date']; ?>" autocomplete="off">
                  </div>
                </div>
                <div style="width:100%">
                  <div class="form-group">
                    <label for="company_name">Aptitude Test Marks</label>
                    <input type="number" class="form-control" id="apptitudeTestMarks" name="apptitudeTestMarks"
                      value="<?php echo $testData['apptitude_test_marks']; ?>" placeholder="Enter Aptitude Test Marks"
                      autocomplete="off">
                  </div>
                </div>
              </div>
              <div style="display:flex;align-items:center;justify-content:space-between;gap:10px">
                <div style="width:100%">
                  <div class="form-group">
                    <label for="company_name">Group Discussion Test Date</label>
                    <input type="date" class="form-control" id="gdTestDate" name="gdTestDate"
                      value="<?php echo $testData['gd_date']; ?>" autocomplete="off">
                  </div>
                </div>
                <div style="width:100%">
                  <div class="form-group">
                    <label for="company_name">Group Discussion Test Marks</label>
                    <input type="number" class="form-control" id="gdTestMarks" name="gdTestMarks"
                      value="<?php echo $testData['gd_marks']; ?>" placeholder="Enter Group Discussion Test Marks"
                      autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="company_name">Total Marks</label>
                <input type="number" class="form-control" id="totalMarks" name="totalMarks"
                  placeholder="Enter Group Discussion Test Marks" value="<?php echo $testData['total_result']; ?>"
                  autocomplete="off">
              </div>
              <div class="form-group">
                <label for="company_name">Status</label>
                <select class="form-control" autocomplete="off" id="status" name="status">
                  <option value="1" <?php echo (($testData['status'] == 1) ? "selected" : ""); ?>>Pass</option>
                  <option value="0" <?php echo (($testData['status'] == 0) ? "selected" : ""); ?>>Fail</option>
                </select>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <input type="reset" class="btn btn-danger" value="Reset"> &nbsp; &nbsp;
              <input id="submit" type="submit" class="btn btn-primary" value="Update Screening Test">
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