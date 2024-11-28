<?php
/*
 *
 * Author: Akash K Fulari
 * Contact-mail: akashfulari31@gmail.com
 * Description: ________________your_description_here_________________
 * Created: 2024-05-09 14:56:26
 Last Modification Date: 2024-05-09 15:08:50
 *
 **/

$sql = "SELECT * FROM stores WHERE active = ?";
$query = $this->db->query($sql, array(1));
$branch = $query->result_array();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Subject</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Subject</li>
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
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif ($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <button class="btn btn-primary" data-toggle="modal" data-target="#addSubjectModal">Add Subject</button>
        <br /> <br />
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Subject</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Project ID</th>
                  <th>Course ID</th>
                  <th>Subject Name</th>
                  <th>Duration in Month</th>
                  <th>Duration in hours</th>
                  <!-- <?php if (in_array('updateSubject', $user_permission) || in_array('deleteStore', $user_permission)): ?>
                  <th>Action</th>
                <?php endif; ?> -->
                  <th> Action</th>
                </tr>
              </thead>
            </table>
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
<?php if (in_array('createStore', $user_permission)): ?>
  <!-- create brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="addSubjectModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Subject</h4>
        </div>
        <form role="form" action="<?php echo base_url('subject/addSubject') ?>" method="post" id="createSubjectForm">
          <div class="modal-body">
            <div class="form-group">
              <label for="company_name">Project</label>
              <select name="project_id" type="text" class="form-control" id="projectCombo" required
                onchange='loadCourses(this, "#coursesAppender")'>
                <option>Select Project</option>
                <?php foreach ($branch as $v) { ?>
                  <option value="<?php echo $v['id']; ?>">
                    <?php echo $v['name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="company_name">Course</label>
              <select name="course_id" id="coursesAppender" type="text" class="form-control" required>
              </select>
            </div>
            <div class="form-group">
              <label for="brand_name">Subject Name</label>
              <input type="text" class="form-control" name="subject_title" placeholder="Enter Subject Name"
                autocomplete="off">
            </div>
            <div class="form-group">
              <label for="brand_name">Duration in Month</label>
              <input type="text" class="form-control" name="duration_in_months" placeholder="Duration in month"
                autocomplete="off">
            </div>
            <div class="form-group">
              <label for="brand_name">Duration in Hours</label>
              <input type="text" class="form-control" name="duration_in_hour" placeholder="Duration in hours"
                autocomplete="off">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endif; ?>
<?php if (in_array('updateStore', $user_permission)): ?>
  <!-- edit brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Subject</h4>
        </div>
        <form role="form" action="<?php echo base_url('subject/updateSubject') ?>" method="post" id="updateSubjectForm">
          <div class="modal-body">
            <div class="form-group" hidden>
              <label for="brand_name">Subject Id</label>
              <input type="text" class="form-control" id="subject_id" readonly name="id" placeholder="Enter Subject Name"
                autocomplete="off">
            </div>
            <div class="form-group">
              <label for="company_name">Project</label>
              <select name="project_id" type="text" class="form-control" id="projectCombo2" required
                onchange='loadCourses(this, "#coursesAppender2")'>
                <option>Select Project</option>
                <?php foreach ($branch as $v) { ?>
                  <option value="<?php echo $v['id']; ?>">
                    <?php echo $v['name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="company_name">Course</label>
              <select name="course_id" id="coursesAppender2" type="text" class="form-control" required>
              </select>
            </div>
            <div class="form-group">
              <label for="brand_name">Subject Name</label>
              <input type="text" class="form-control" id="subject_name" name="subject_title"
                placeholder="Enter Subject Name" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="brand_name">Duration in Month</label>
              <input type="text" class="form-control" id="durationinmonth" name="duration_in_months"
                placeholder="Duration in month" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="brand_name">Duration in Hours</label>
              <input type="text" class="form-control" id="durationinhours" name="duration_in_hour"
                placeholder="Duration in hours" autocomplete="off">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endif; ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeSubjectModal">
  <form role="form" action="<?php echo base_url('subject/removeSubject') ?>" method="post" id="removeSubjectForm">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Remove Subject</h4>
        </div>
        <form role="form">
          <div class="modal-body">
            <p>Do you really want to remove?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Ok</button>
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
  var manageTable;

  $(document).ready(function () {
    loadCourses($("#projectCombo"), "#coursesAppender");
    loadCourses($("#projectCombo2"), "#coursesAppender2");

    $("#subjectNav").addClass('active');

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': 'fetchSubjectData',
      'order': []
    });

    // submit the create from 
    $("#addSubject").unbind('submit').on('submit', function () {
      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(), // /converting the form data into array and sending it to server
        dataType: 'json',
        success: function (response) {

          manageTable.ajax.reload(null, false);

          if (response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
              '</div>');


            // hide the modal
            $("#addSubjectModal").modal('hide');

            // reset the form
            $("#createSubjectForm")[0].reset();
            $("#createSubjectForm .form-group").removeClass('has-error').removeClass('has-success');

          } else {

            if (response.messages instanceof Object) {
              $.each(response.messages, function (index, value) {
                var id = $("#" + index);

                id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');

                id.after(value);

              });
            } else {
              $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }
          }
        }
      });

      return false;
    });


  });

  function editSubject(id) {
    $.ajax({
      url: 'fetchSubjectDataById/' + id,
      type: 'post',
      dataType: 'json',
      success: function (response) {
        $("#subject_id").val(response.id);
        $("#project_id").val(response.project_id);
        $("#course_id").val(response.course_id);
        $("#subject_name").val(response.subject_title);
        $("#durationinhours").val(response.duration_in_hour);
        $("#durationinmonth").val(response.duration_in_months);



        // submit the edit from 
        $("#updateSubjectForm").unbind('submit').bind('submit', function () {
          var form = $(this);

          // remove the text-danger
          $(".text-danger").remove();

          $.ajax({
            url: form.attr('action') + '/' + id,
            type: form.attr('method'),
            data: form.serialize(), // /converting the form data into array and sending it to server
            dataType: 'json',
            success: function (response) {
              manageTable.ajax.reload(null, false);
              if (response.success === true) {
                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                  '</div>');


                // hide the modal
                $("#editModal").modal('hide');
                // reset the form 
                $("#updateSubjectForm .form-group").removeClass('has-error').removeClass('has-success');

              } else {

                if (response.messages instanceof Object) {
                  $.each(response.messages, function (index, value) {
                    var id = $("#" + index);

                    id.closest('.form-group')
                      .removeClass('has-error')
                      .removeClass('has-success')
                      .addClass(value.length > 0 ? 'has-error' : 'has-success');

                    id.after(value);

                  });
                } else {
                  $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                    '</div>');
                }
              }
              // $("#editModal").modal('hide');
            }
          });

          return false;
        });

      }
    });
  }

  function removeSubject(id) {
    if (id) {
      $("#removeSubjectForm").on('submit', function () {

        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: {
            id: id
          },
          dataType: 'json',
          success: function (response) {

            manageTable.ajax.reload(null, false);

            if (response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                '</div>');

              // hide the modal
              $("#removeSubjectModal").modal('hide');

            } else {

              $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }
          }
        });

        return false;
      });
    }
  }


  /*
   * Created By: Akash K. Fulari
   * On Date: 09-05-2024
   */
  function loadCourses(me, ele) {
    $.ajax({
      url: "<?php echo base_url('enquiry/loadCoursesByProjectId/') ?>" + me.value,
      type: "get",
      data: {},
      dataType: "json",
      success: function (res) {
        if (res.status) {
          $(ele).html("<option value=''>Please select course!</option>" + res.message);
        } else {
          $(ele).html("<option value=''>Please select course!</option>");
        }
      }
    });
  }

</script>