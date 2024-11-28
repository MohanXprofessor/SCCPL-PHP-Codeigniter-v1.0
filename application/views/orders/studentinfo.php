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
            <h3 class="box-title"> Student Information</h3>

          </div>
          <div class="box-body">

            <?php echo validation_errors(); ?>
            <?php foreach ($h as $k => $r) {

              ?>


              <div class="form-group">
                <label for="company_name">Branch</label>
                <input type="text" class="form-control" id="student_name" name="student_name"
                  value="<?php echo $r['branch'] ?>" autocomplete="off" readonly>
              </div>
              <div class="form-group">
                <label for="company_name">Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name"
                  value="<?php echo $r['customer_name'] ?>" autocomplete="off" readonly>
              </div>
              <div class="form-group">
                <label for="company_name">Father Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name"
                  value="<?php echo $r['father_name'] ?>" autocomplete="off" readonly>
              </div>
              <div class="form-group">
                <label for="service_charge_value">Address</label>
                <input type="text" class="form-control" id="address" name="address"
                  value="<?php echo $r['customer_address'] ?>" autocomplete="off" readonly>
              </div>
              <div class="form-group">
                <label for="vat_charge_value">Contact Number</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile"
                  value="<?php echo $r['customer_phone']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="address">Email ID</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $r['customer_gst'] ?>"
                  autocomplete="off" readonly>
              </div>
              <div class="form-group">
                <label for="phone">Work/Study Organization</label>
                <input type="text" class="form-control" id="college" name="college" value="<?php $r['college'] ?>"
                  autocomplete="off" readonly>
              </div>
              <div class="form-group">
                <label for="country">Professional Status</label>
                <input type="radio" id="10th" name="ten" autocomplete="off" checked> &nbsp;
                <?php echo $r['prof_status']; ?>
              </div>
              <div class="form-group">
                <label for="country">Education Qualification</label>
                <input type="radio" id="twelwa" name="twl" autocomplete="off" checked>&nbsp; <?php echo $r['education'] ?>
              </div>


              <div class="form-group">
                <label for="country">Organization</label>
                <input type="radio" id="graduate" name="graduate" autocomplete="off" checked>
                &nbsp;<?php echo $r['organization']; ?>
              </div>



              <div class="form-group">
                <label for="country">Programe Date</label> <br>

                <input type="text" class="form-control" id="date" name="date" value="<?php echo $r['date_time']; ?>"
                  readonly>

              </div>

              <div class="form-group">
                <label for="country">Batch Timing</label> <br>

                <input type="text" class="form-control" id="graduate" name="graduate" value="<?php echo $r['timing'] ?>"
                  autocomplete="off" readonly>


              </div>
              <div class="form-group">
                <label for="country">Declaration :Fee Once Paid will not be returned under any cicumstances</label>

              </div>




            </div>
            <!-- /.box-body -->

            <!-- <div class="box-footer">
              
                <a href="<?php //echo base_url('placement/') ?>" class="btn btn-warning">Back</a>

              </div> -->

          <?php } ?>
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
<div class="content-wrapper ">
  <a href="<?php echo site_url('orders/download_ssc?val=' . $r['customer_gst']) ?>" class="btn btn-default"><i
      class="fa fa-download">Marksheet</i></a> &nbsp;&nbsp;
  <a href="<?php echo site_url('orders/download_lc?val=' . $r['customer_gst']) ?>" class="btn btn-default"><i
      class="fa fa-download"></i>Leaving Certificate</a>&nbsp;&nbsp;
  <a href="<?php echo site_url('orders/download_cast?val=' . $r['customer_gst']) ?>" class="btn btn-default"><i
      class="fa fa-download"></i>Cast Certificate</a> &nbsp; &nbsp;
  <a href="<?php echo site_url('orders/download_res?val=' . $r['customer_gst']) ?>" class="btn btn-default"><i
      class="fa fa-download"></i>Resume</a> </br>
</div>