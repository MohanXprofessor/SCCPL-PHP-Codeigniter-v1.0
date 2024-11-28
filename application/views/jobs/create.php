<?php

/*
 * Created By: Akash K. Fulari
 * On Date: 08-03-2024
 */
?>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.9/css/bootstrap-select.css" />
<style>
  .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 100%;
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Jobs</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Jobs</li>
    </ol>
  </section>

  <!-- Main content -->
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
            <h3 class="box-title">Job Information</h3>
          </div>
          <form role="form" action="<?php base_url('jobs/create') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <?php echo validation_errors(); ?>
              <div class="form-group" style="margin-bottom:10px">
                <label for="gross_amount">Project</label>
                <select name="branch_id[]" id="multiSelectBranches" type="text" class="selectpicker form-control"
                  multiple>
                  <?php

                  $sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
                  $query = $this->db->query($sql, array(1));
                  $branch = $query->result_array();

                  foreach ($branch as $v) {
                    ?>
                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name']; ?></option>
                  <?php } ?>
                </select>
                <div>
                  <div class="form-group">
                    <label for="jobId">Job ID</label>
                    <input type="text" class="form-control" id="jobId" name="job_id" placeholder="Enter Job ID">
                  </div>
                  <div class="form-group">
                    <label for="jobTitle">Job Title</label>
                    <input type="text" class="form-control" id="jobTitle" name="job_title"
                      placeholder="Enter Job Title">
                  </div>
                  <div class="form-group">
                    <label for="jobEmail">Compnay E-mail</label>
                    <input type="email" class="form-control" id="jobEmail" name="job_email"
                      placeholder="Enter Company Email">
                  </div>
                  <div class="form-group">
                    <label for="jobRole">Job Role</label>
                    <input type="text" id="jobRole" name="job_possition" placeholder="Enter Job Description name"
                      class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="compName">Company Name</label>
                    <input type="text" class="form-control" id="compName" name="company_name"
                      placeholder="Enter Company Name">
                  </div>
                  <div class="form-group">
                    <label for="jobDesc">Job Description</label>
                    <textarea id="jobDesc" name="job_description" placeholder="Enter Job Description name"
                      class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="jobQulification">Qualifications</label>
                    <input type="text" class="form-control" id="jobQulification" name="qualification"
                      placeholder="Enter Job Description name">
                  </div>
                  <div class="form-group">
                    <label for="submissionDate">Last Submission Date</label>
                    <input type="datetime-local" class="form-control" id="submissionDate" name="submission_date"
                      placeholder="Enter Job Description name">
                  </div>
                  <div class="form-group">
                    <label for="vacencies">No. Of Vacencies</label>
                    <input type="number" class="form-control" id="vacencies" name="vacencies"
                      placeholder="Enter Job Description name">
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="isActive">Is Active</label>
                    <select class="form-select" name="active">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                  </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <input type="submit" class="btn btn-primary" value="Save">
                </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
      </form>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.9/js/bootstrap-select.min.js"></script>
<script>

  $(document).ready(function () {

    $('#multiSelectBranches').selectpicker();

  });
</script>