<?php
/*
 * Created By: Akash K. Fulari
 * On Date: 11-03-2024
 */
?>


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

        <div id="successMessage">

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

        <?php if (in_array('createPlacement', $user_permission) && $userGroup != "Student"): ?>
          <a href="<?php echo base_url('jobs/create') ?>" class="btn btn-primary">Add Job</a>
          <br /> <br />
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <div style="display:flex;align-items:center:justify-content:space-between;">
              <h3 class="box-title" style="width:50%"> Job Details</h3>
              <div style="display:flex;align-items:center;justify-content:end;width:50%;gap:10px">
                <button class="btn btn-sm btn-primary" onclick="exportAsExcel('manageTable')">Export as Excel</button>
                <select class="form-control" onchange="reloadWithFilter(this.value)" style="width:300px">
                  <option value="all">All</option>
                  <option value="-1">Rejected</option>
                  <option value="0">Pending</option>
                  <option value="1">Selected</option>
                  <option value="2">Joined</option>
                </select>
              </div>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped table-responsive display nowrap">
              <thead>
                <tr>
                  <!--<th>Sr. No</th>-->
                  <th>Job Id</th>
                  <!--<th>Student Id</th>-->
                  <th>Student Name</th>
                  <th>Email ID</th>
                  <th>Phone Number</th>
                  <th>Company Name</th>
                  <!--<th>Job Role</th>-->
                  <!--<th>Qualification</th>-->
                  <th>Resume</th>
                  <th>Marksheet</th>
                  <th>Adhar Card</th>
                  <th>Leaving Certificate</th>
                  <th>Action</th>
                  <th>Status</th>
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

<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function () {

    $("#mainOrdersNav").addClass('active');
    $("#manageOrdersNav").addClass('active');

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      responsive: true,
      'ajax': base_url + 'jobs/fetchJobsDataByJobId/<?php echo $job['id'] ?>',
      scrollY: true,
autoWidth: false,
      "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

  });

  function exportAsExcel(table) {
    tableToExcel(table, "tableToExcel");
  }

  function reloadWithFilter(statusType) {
    if (statusType == "all")
      manageTable.ajax.url(base_url + 'jobs/fetchJobsDataByJobId/<?php echo $job['id'] ?>').load();
    else
      manageTable.ajax.url(base_url + 'jobs/fetchJobsDataByIdAndStatus/<?php echo $job['id'] ?>/' + statusType).load();
  }

  setTimeout(function () {
    $("#successMessage").fadeTo(100, 0).slideUp(300,
      function () {
        $(this).remove();
      });
  }, 3000); 
</script>