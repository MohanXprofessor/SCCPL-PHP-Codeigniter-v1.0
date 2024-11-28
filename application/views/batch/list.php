<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      List Under Batch
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
            <h3 class="box-title">Manage Batches</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">

              <tr>
                <th>Batch ID:</th>
                <td><input type="text" class="form-control" id="organization" name="batch_id"
                    value="<?php echo $data['batch_id'] ?>" autocomplete="off" readonly></td>
              </tr>
              <!-- <tr>
              <th>Student Name:</th>
                <td><input type="text" class="form-control"  id="organization" name="student_name"  value="<?php // echo $data['name']  ?>" autocomplete="off"></td>
              </tr> -->
              <tr>
          </div>
        </div>

        <tr>
          <th>Batch Code</th>
          <td><input type="text" class="form-control" id="organization" name="batch_name"
              value="<?php echo $data['batch_name'] ?>" autocomplete="off" readonly></td>
        </tr>

        <tr>
          <th>Project</th>
          <td><input type="text" class="form-control" id="organization" name="batch_name"
              value="<?php echo $data['project_id'] ?>" autocomplete="off" readonly></td>
        </tr>

        <tr>
          <th>Course</th>
          <td><input type="text" class="form-control" id="organization" name="batch_name"
              value="<?php echo $data['course_id'] ?>" autocomplete="off" readonly></td>
        </tr>
        <tr>
          <th>Batch Start</th>
          <td><input type="text" class="form-control" id="organization" name="batch_start"
              value="<?php echo $data['batch_start'] ?>" autocomplete="off" readonly></td>
        </tr>
        <tr>
          <th>Batch End</th>
          <td><input type="text" class="form-control" id="organization" name="batch_end"
              value="<?php echo $data['batch_end'] ?>" autocomplete="off" readonly></td>
        </tr>
        <tr>
          <th>Batch Time</th>
          <td><input type="text" class="form-control" id="organization" name="batch_time"
              value="<?php echo $data['batch_time'] ?>" autocomplete="off" readonly></td>
        </tr>

        <tr>
          <th>Location</th>
          <td><input type="text" class="form-control" id="organization" name="location"
              value="<?php echo $data['location'] ?>" autocomplete="off" readonly></td>
        </tr>
        </table>
        <div class="box-header">
          <h3 class="box-title">Subjects</h3>
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
          echo '<input type="text" class="form-control" name="subject_name[]" value="' . $v['subject'] . '" readonly>';

          echo '</div>';


          echo '<div class="col-md-5 form-group" id="facultyElement">';

          // Faculty dropdown
          echo "<label for='store'>Faculty Id</label>";
          echo '<select class="form-control" id="availability" name="faculty_id[]" readonly>';

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

        <div class="box-footer">

          <a href="<?php echo base_url('batch') ?>" class="btn btn-warning">Back</a>

        </div>
      </div>
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
</script>