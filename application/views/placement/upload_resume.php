<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Placement</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Placement</li>
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
            <h3 class="box-title"> Placement Information</h3>
          </div>
          <form role="form" action="<?php echo base_url('placement/upload_res'); ?>" method="post"
            enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>


              <div class="form-group">

                <label for="country">Resume</label>

                <input type="file" class="form-control" id="file" name="image" autocomplete="off" required>
                <!-- <input type="hidden" class="form-control"  name="id" value=<?php //echo $id; ?> autocomplete="off"> -->

              </div>



            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <input type="submit" class="btn btn-primary" value="Save">
            </div>
          </form>

          <!-- mark -->
          <form role="form" action="<?php echo base_url('placement/upload_ssc'); ?>" method="post"
            enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>




              <div class="form-group">
                <label for="country">Marksheet</label>
                <input type="file" class="form-control" id="ssc" name="ssc" autocomplete="off" required>
              </div>



            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <input type="submit" class="btn btn-primary" value="Save">
            </div>
          </form>
          <form role="form" action="<?php echo base_url('placement/upload_lc'); ?>" method="post"
            enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>


              <div class="form-group">



                <div class="form-group">
                  <label for="country">Leaving Certificate</label>
                  <input type="file" class="form-control" id="lc" name="lc" autocomplete="off" required>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" class="btn btn-primary" value="Save">
              </div>
          </form>

          <form role="form" action="<?php echo base_url('placement/upload_cast'); ?>" method="post"
            enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>


              <div class="form-group">


                <div class="form-group">
                  <label for="country">Cast Certificate</label>
                  <input type="file" class="form-control" id="cast_cert" name="cast_cert" autocomplete="off" required>
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
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->