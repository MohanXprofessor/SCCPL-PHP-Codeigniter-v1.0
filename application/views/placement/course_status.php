<script>
  function myFunction() {
    window.print();
  }
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Registration
      <small>User</small>
    </h1>
    <ol class="breadcrumb">
      <button onclick="myFunction()"><i class="fa fa-print"></i> </button></li>
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Student</li>
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
            <h3 class="box-title"> Student Course Status</h3>

          </div>
          <!--<form role="form" action="<?php //echo  base_url('placement/course_status_update') ?>" method="post" class="form-horizontal">-->
          <form role="form" action="#" method="post" class="form-horizontal">
            <div class="box-body">


              <?php echo validation_errors(); ?>



              <!-- <div class="col-md-4 col-xs-4 pull pull-left"> -->
              <table class="table table-bordered" id="product_info_table" style="widht:50px;">
                <thead>
                  <tr>
                    <th style="width: 10px">Courses</th>
                    <th style="width: 10px">Status</th>

                  </tr>
                </thead>

                <tbody>

                  <?php foreach ($h as $k => $r) {
                    $package_data = $this->model_orders->getPackage($r['id']);


                    foreach ($package_data as $val) {
                      $course = explode(',', $val['imei']);

                      $course_comp = explode(",", $r['course_completed']);

                      foreach ($course as $row22) {

                        ?>
                        <tr>
                          <td><?php echo $row22; ?></td>
                          <td> <input type="hidden" name="id" value="<?php echo $r['id']; ?>"> <input type="checkbox" readonly
                              name="course_completed[]" value="<?php echo $row22; ?>" <?php if (in_array($row22, $course_comp)) {
                                     echo 'checked';
                                   } ?>></td>

                        </tr>
                      <?php } ?>

                      <!-- //     $pakage=$this->model_orders->getPackagename($val['product_id']);
                        //     foreach($pakage as $val)				
                        //    $package_name=$val['name'];
                         }  
                          ?>           -->

                    <?php }
                  } ?>




                </tbody>
              </table>

              <!-- </div> -->


              <div class="box-footer">



                <!--  <button type="submit" class="btn btn-primary">Save Changes</button>-->
                <a href="<?php echo base_url('dashboard/') ?>" class="btn btn-warning">Back</a>

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