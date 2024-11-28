<?php

$sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
$query = $this->db->query($sql, array(1));
$branch = $query->result_array();

?>

<style>
  .myBox {
    display: flex;
    align-items: center;
    justify-content: between;
    gap: 10px;
  }

  .myBox>div {
    width: 100%;
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Batch Master</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Batch Master</li>
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
            <h3 class="box-title">Edit Batches</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('batch/update') ?>" method="post">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="myBox">
                <div class="form-group" hidden>
                  <label for="product_name">Batch ID:</label>
                  <input type="text" class="form-control" id="product_name" name="batch_id"
                    placeholder="Enter product name" value="<?php echo $data['batch_id']; ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label for="price">Batch Code:</label>
                  <input type="text" class="form-control" id="price" name="batch_name"
                    value="<?php echo $data['batch_name']; ?>" autocomplete="off" />
                </div>
              </div>
              <div class="myBox">
                <div class="form-group">
                  <label for="price">Batch Time:</label>
                  <input type="time" class="form-control" id="price" name="batch_time"
                    value="<?php echo $data['batch_time']; ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label for="price">Batch Start:</label>
                  <input type="date" class="form-control" id="price" name="batch_start"
                    value="<?php echo $data['batch_start']; ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label for="price">Batch End:</label>
                  <input type="date" class="form-control" id="price" name="batch_end"
                    value="<?php echo $data['batch_end']; ?>" autocomplete="off" />
                </div>
              </div>
              <div class="myBox">
                  
                <div class="form-group">
                  <label for="gross_amount">Project :</label> &nbsp;
                  <select name="project_id" type="text" class="form-control" id="projectCombo" required
                    onchange='loadCourses(this, "#coursesAppender")'>
                    <option>Select Project</option>
                    <?php
                    foreach ($branch as $v) { ?>
                      <option value="<?php echo $v['id']; ?>">
                        <?php echo $v['name']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="company_name">Course :</label>
                  <select name="course_id" type="text" id="coursesAppender" class="form-control" required>
                  </select>
                </div>


                <div class="form-group">
                  <label for="price">Location:</label>
                  <input type="text" class="form-control" id="price" name="location"
                    value="<?php echo $data['location']; ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label for="price">Progress(In %):</label>
                  <input type="number" class="form-control" min="1" max="100" id="price" name="progress"
                    value="<?php echo $data['progress']; ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label for="price">Status:</label>
                  <select name="status" class="form-control" readonly disabled>
                    <option value="0" <?php echo (($data['progress'] < 100) ? "selected" : ""); ?>>In Progress</option>
                    <option value="1" <?php echo (($data['progress'] == 100) ? "selected" : ""); ?>>Completed</option>
                  </select>
                </div>
              </div>

              <div class="box-header">
                <h3 class="box-title">Update Subjects</h3>
              </div>
              <?php
              $bid = $data['id'];

              // Fetch the subject and faculty data for the provided 'bid'
              $sql = "SELECT s.id,s.subject, s.faculty_id, u.id as user_id, u.firstname as faculty_name
              FROM subjectnew s
              JOIN users u ON s.faculty_id = u.id
              WHERE s.bid  = ? order by id desc";
              $query = $this->db->query($sql, array($bid));
              $data1 = $query->result_array();




              // Iterate through each subject and faculty data
              foreach ($data1 as $v) {
                echo '<div class="row" id="subjectElementParent">';
                echo '<div class="col-md-5 form-group" id="subjectElement">';

                // Subject input field
                echo "<label for='store'>Subject Title</label>";
                echo '<input type="hidden" class="form-control" name="subject_id[]" value="' . $v['id'] . '" hidden>';
                echo '<input type="text" class="form-control" name="subject_name[]" value="' . $v['subject'] . '">';

                echo '</div>';


                echo '<div class="col-md-5 form-group" id="facultyElement">';

                // Faculty dropdown
                echo "<label for='store'>Faculty Id</label>";
                echo '<select class="form-control" id="availability" name="faculty_id[]" required>';

                // Iterate through the list of users to create options for the select element
                $users_query = $this->db->query("SELECT users.id,users.firstname FROM users join user_group on users.id=user_group.user_id WHERE group_id = 19");
                $user_data = $users_query->result_array();

                foreach ($user_data as $user) {
                  $selected = ($user['id'] == $v['faculty_id']) ? 'selected' : '';
                  echo '<option value="' . $user['id'] . '" ' . $selected . '>';
                  echo $user['firstname'];
                  echo '</option>';
                }

                echo '</select>';

                echo '</div>';
                echo '</div>';
              }
              ?>

              <div class="box-header">
                <h3 class="box-title">Add New Subjects</h3>
              </div>
              <div class="container-fluid">
                <div class="row" id="subjectElementParent">
                  <div class="col-md-5 form-group" id="subjectElement">
                    <label for="store">Subject Title</label>
                    <input type="text" placeholder="" class="form-control" name="new_subject[]">
                  </div>
                  <div class="col-md-5 form-group" id="facultyElement">
                    <label for="store">Faculty Id</label>
                    <select class="form-control" id="availability" name="new_faculty_id[]" required>
                      <?php
                      $sql = "SELECT users.id,users.firstname FROM users join user_group on users.id=user_group.user_id WHERE group_id = 19";
                      $query = $this->db->query($sql);
                      $counseller_details = $query->result_array();
                      foreach ($counseller_details as $v) {
                        ?>
                        <option value="<?php echo $v['id']; ?>">
                          <?php echo $v['firstname']; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    <a onclick="addField()" class="btn btn-success">Add New</a>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <a href="<?php echo base_url('batch/') ?>" class="btn btn-warning">Back</a>
        </div>
        </form>
        <!-- /.box-body -->
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

  $(document).ready(function () {
    loadCourses($("#projectCombo"), "#coursesAppender");
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainProductNav").addClass('active');
    $("#manageProductNav").addClass('active');

    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
      'onclick="alert(\'Call your custom code here.\')">' +
      '<i class="glyphicon glyphicon-tag"></i>' +
      '</button>';
    $("#product_image").fileinput({
      overwriteInitial: true,
      maxFileSize: 1500,
      showClose: false,
      showCaption: false,
      browseLabel: '',
      removeLabel: '',
      browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
      removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
      removeTitle: 'Cancel or reset changes',
      elErrorContainer: '#kv-avatar-errors-1',
      msgErrorClass: 'alert alert-block alert-danger',
      // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
      layoutTemplates: { main2: '{preview} ' + btnCust + ' {remove} {browse}' },
      allowedFileExtensions: ["jpg", "png", "gif"]
    });

  });
    
  /*
   * Created By: Akash K. Fulari
   * On Date: 08-05-2024
   */
  function loadCourses(me, ele) {
    $.ajax({
      url: "<?php echo base_url('enquiry/loadCoursesByProjectId/') ?>" + me.value,
      type: "get",
      data: {},
      dataType: "json",
      success: function (res) {
        if (res.status) {
          $(ele).html(res.message);
        } else {
          $(ele).html("<option>Please select course!</option>");
        }
      }
    });
  }
</script>