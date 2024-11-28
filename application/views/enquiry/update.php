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
      <small>Enquiry</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Update Enquiry</li>
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
          <form role="form" method="post">
            <div class="box-body">
              <?php echo validation_errors(); ?>
              <div class="form-group">
                <label for="gross_amount">Project</label> &nbsp;
                <select name="project_id" type="text" class="form-control"
                  onchange='loadCourses(this, "#coursesAppender", "<?php echo $enquiry["course_id"]; ?>")'
                  id="projectCombo" required>
                  <option>Select Project</option>
                  <?php
                  foreach ($branch as $v) { ?>
                    <option value="<?php echo $v['id']; ?>" <?php echo (($enquiry['project_id'] == $v['id']) ? "selected" : ""); ?>>
                      <?php echo $v['name']; ?>
                    </option>
                    <?php
                  } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="company_name">Course</label>
                <select name="course_id" type="text" id="coursesAppender" class="form-control" required>
                </select>
              </div>
              <div class="form-group">
                <label for="company_name">Select Counseller</label>
                <select name="counseller_id" type="text" class="form-control"
                  value="<?php echo $enquiry['counseller_id']; ?>" required>
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
                <label for="company_name">Date:</label>
                <input type="date" name="date"
                  value="<?php echo (new DateTime($enquiry['created_at']))->format('Y-m-d'); ?>" class="form-control"
                  required>
              </div>
              <div class="form-group">
                <label for="company_name">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name"
                  placeholder="Enter Student name" value="<?php echo $enquiry['student_name']; ?>" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="service_charge_value">Student Address</label>
                <input type="text" class="form-control" id="student_address" name="student_address"
                  placeholder="Enter Student asddress " value="<?php echo $enquiry['student_address']; ?>"
                  autocomplete="off">
              </div>
              <div class="form-group">
                <label for="vat_charge_value">Student Mobile Number</label>
                <input type="text" class="form-control" id="student_mobile" name="student_mobile"
                  placeholder="Enter Mobile Number " value="<?php echo $enquiry['student_mobile']; ?>"
                  autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="address">Student Email ID</label>
                <input type="email" class="form-control" value="<?php echo $enquiry['student_email']; ?>"
                  id="student_email" name="student_email" placeholder="Enter email" autocomplete="off">
              </div>
              <div class="form-group col-md-6">
                <label for="company_name">Select Gender:</label>
                <select name="gender" type="text" class="form-control" value="<?php echo $enquiry['gender']; ?>"
                  required>
                  <option value="0">Female</option>
                  <option value="1">Male</option>
                  <option value="2">Other</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="phone">Highest Qualifications</label>
                <input type="text" class="form-control" value="<?php echo $enquiry['qualification']; ?>"
                  id="qualification" name="qualification" placeholder="Enter Qualification" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="phone">Specialization</label>
                <input type="text" class="form-control" value="<?php echo $enquiry['specialization']; ?>"
                  id="specialization" name="specialization" placeholder="Enter Specialization" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="phone">College Name</label>
                <input type="text" class="form-control" value="<?php echo $enquiry['college_name']; ?>"
                  id="college_name" name="college_name" placeholder="Enter College Name" autocomplete="off">
              </div>
              <div class="form-group col-md-6">
                <label for="company_name">Select Status :</label>
                <select class="form-control" id="status" name="status" value="<?php echo $enquiry['status']; ?>"
                  onchange="validateFollowUpDate(this)">
                  <option value="Next-date" slected>Next Followup date</option>
                  <option value="Confirm">Confirm</option>
                  <option value="Ignore">Ignore</option>
                </select>
              </div>
              <div class="form-group col-md-6" id="validateFollowUpDateField">
                <label for="company_name">Next Followup Date:</label>
                <input type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" id="followup_date"
                  name="followup_date" autocomplete="off">
              </div>
              <div class="form-group col-md-6">
                <label for="company_name">Remark:</label>
                <input type="textarea" class="form-control" value="<?php echo $enquiry['remark']; ?>" id="remark"
                  name="remark" autocomplete="off">
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <input type="reset" class="btn btn-danger" value="Reset"> &nbsp; &nbsp;
              <input id="submit" type="submit" class="btn btn-primary" value="Update Enquiry">
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

<script>

  /*
   * Created By: Akash K. Fulari
   * On Date: 04-05-2024
   */
  $(document).ready(function () {
    loadSelectCourses("<?php echo $enquiry['project_id']; ?>", "#coursesAppender", "<?php echo $enquiry['course_id']; ?>");

    validateFollowUpDate(document.getElementById("status"));
  });

  function validateFollowUpDate(ele) {
    document.getElementById("validateFollowUpDateField").style.display = ((ele.value == "Next-date") ? "block" : "none");
  }


  /*
   * Created By: Akash K. Fulari
   * On Date: 04-05-2024
   */
  function loadCourses(me, ele, selectValue) {
    loadSelectCourses(me.value, ele, selectValue);
  }

  function loadSelectCourses(val, ele, selectValue) {
    $.ajax({
      url: "<?php echo base_url('enquiry/loadCoursesByProjectId/') ?>" + val,
      type: "get",
      data: {},
      dataType: "json",
      success: function (res) {
        if (res.status) {
          $(ele).html(res.message);
          if (ele.indexOf(selectValue) > -1)
            $(ele).val(selectValue);
        } else {
          $(ele).html("<option>Please select course!</option>");
        }
      }
    });
  }

</script>