<?php
$sql = "SELECT * FROM batch";
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

        <!-- <?php //if(in_array('createProduct', $user_permission)): ?>
          <a href="<?php //echo base_url('batch/create') ?>" class="btn btn-primary">Add Batches</a>
          <br /> <br />
        <?php //endif; ?> -->

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Batches</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

            <!-- Table to display data -->
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sr No</th>
                  <th>Student Name</th>
                  <th>Batch Name</th>
                  <!-- <th>Batch Id</th> -->
                  <th>Email Id</th>
                  <th>Contact No</th>
                  <th>Project</th>
                  <th>Course</th>
                  <th>Subject</th>
                  <th>Faculty</th>
                  <th>Location</th>
                </tr>
              </thead>
              <tbody id="tableBody">
                <?php
                $s1 = 0;
                // print_r($data);die();
                foreach ($data as $record) {
                  ?>
                  <tr>
                    <td><?php echo ++$s1; ?></td>
                    <td><?php echo $record['student_name']; ?></td>
                    <td><?php echo $record['batch_name']; ?></td>
                    <!-- <td><?php // echo $record['batch_id']; ?></td> -->
                    <td><?php echo $record['email']; ?></td>
                    <td><?php echo $record['contact']; ?></td>
                    <td><?php echo $record['project_name']; ?></td>
                    <td><?php echo $record['course_name']; ?></td>
                    <td><?php echo $record['subject']; ?></td>
                    <td><?php echo $record['faculty']; ?></td>
                    <td><?php echo $record['address']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
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