<?php

$sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
$query = $this->db->query($sql, array(1));
$branch = $query->result_array();

$sql = "SELECT * FROM batch  ORDER BY id DESC";


$query = $this->db->query($sql);

$row = $query->result_array();
if ($row != null)
  $randomId = "BHID" . $row[0]["id"];
else
  $randomId = "BHID1";



?>

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
            <h3 class="box-title">Create Batch</h3>
          </div>
          <!-- /.box-header -->


          <form role="form" action="<?php base_url('batch/create') ?>" method="post">
            <div class="box-body">
              <input type="hidden" name="id">
              <?php echo validation_errors(); ?>
              <div class="row">
                <div class="form-group col-md-6">
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
                <div class="form-group col-md-6">
                  <label for="company_name">Course :</label>
                  <select name="course_id" type="text" id="coursesAppender" class="form-control" required>
                  </select>
                </div>

                <div class="col-md-4 form-group">
                  <label for="store">Location</label>
                  <input type="text" placeholder="Enter Location" name="location" class="form-control">
                </div>
                <div class="col-md-4 form-group" hidden>
                  <label for="store">Batch ID</label>
                  <input type="text" value="<?php echo $randomId ?>" class="form-control" id="store" name="batch_id"
                    readonly>
                </div>
                <div class="col-md-4 form-group">
                  <label for="product_name">Batch Code</label>
                  <input type="text" class="form-control" id="product_name" name="batch_name"
                    placeholder="Enter Batch Name" autocomplete="off" />
                </div>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-4 form-group">
                      <label for="store">Batch Time</label>
                      <input type="time" placeholder="Enter Time" name="batch_time" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                      <label for="store">Batch Start Date</label>
                      <input type="Date" placeholder="" class="form-control" name="start_date">
                    </div>
                    <div class="col-md-4 form-group">
                      <label for="store">Batch End Date</label>
                      <input type="Date" placeholder="" class="form-control" name="end_date">
                    </div>
                  </div>
                </div>
                <div class="box-header">
                  <h3 class="box-title" style="padding:20px 0;padding-left:10px;">Add Subjects</h3>
                </div>
                <div class="container-fluid">
                  <div class="row" id="subjectElementParent">
                    <div class="col-md-5 form-group" id="subjectElement">
                      <label for="store">Subject Title</label>
                      <input type="text" placeholder="" class="form-control" name="subject[]">
                    </div>
                    <div class="col-md-5 form-group" id="facultyElement">
                      <label for="store">Faculty Id</label>
                      <select class="form-control" id="availability" name="faculty_id[]" required>
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
            <div class="box-footer" style="margin-top:10px">
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
  $(document).ready(function() {
    loadCourses($("#projectCombo"), "#coursesAppender");
    $(".select_group").select2();
    $("#description").wysihtml5();
    $("#mainProductNav").addClass('active');
    $("#addProductNav").addClass('active');
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
      layoutTemplates: {
        main2: '{preview} ' + btnCust + ' {remove} {browse}'
      },
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
      success: function(res) {
        if (res.status) {
          $(ele).html(res.message);
        } else {
          $(ele).html("<option>Please select course!</option>");
        }
      }
    });
  }
</script>

<script>
  function addField() {
    let parent = document.getElementById("subjectElementParent");
    let subEle = document.getElementById("subjectElement").cloneNode(true);
    let fclEle = document.getElementById("facultyElement").cloneNode(true);

    let div = document.createElement("div");
    div.setAttribute("class", "col-md-2");
    let a = document.createElement("a");
    a.setAttribute("class", "btn btn-sm btn-danger");
    a.innerHTML = "Delete";
    a.addEventListener("click", function() {
      subEle.remove();
      fclEle.remove();
      div.remove();
    });
    div.appendChild(a);

    parent.appendChild(subEle);
    parent.appendChild(fclEle);
    parent.appendChild(div);
  }
</script>