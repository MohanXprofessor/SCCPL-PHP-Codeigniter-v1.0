<?php



$sql = "SELECT users.id,users.firstname FROM users join user_group on users.id=user_group.user_id WHERE group_id = 4";
$query = $this->db->query($sql);
$counseller_details = $query->result_array();



?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Enrollment</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Enrollment</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">



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

          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php echo base_url('counseller/report_counseller') ?>" method="post"
            class="form-horizontal">
            <div class="box-body">
              <?php echo validation_errors(); ?>

              <div class="col-md-8 col-xs-12 pull pull-left">

                <div class="col-md-4">
                  <input type="date" name="start_date" id="start_date" class="form-control" />
                </div>

                <div class="col-md-4">
                  <input type="date" name="end_date" id="end_date" class="form-control" />
                </div>

                <div class="form-group">
                  <label for="company_name">Counseller Name</label>
                  <select name="cname" type="text" style="widht:100;height:30;width: 122px;height: 34px;" required>
                    <?php
                    foreach ($counseller_details as $v) {
                      ?>
                      <option value="<?php echo $v['id']; ?>"><?php echo $v['firstname']; ?></option>
                    <?php } ?>
                  </select>

                </div>

                <div class="col-md-4">

                  <button type="submit" class="btn btn-primary">Search</button>

                  <a href="<?php echo base_url('dashboard/') ?>" class="btn btn-warning">Back</a>
                </div>



                <div class="box-footer">




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