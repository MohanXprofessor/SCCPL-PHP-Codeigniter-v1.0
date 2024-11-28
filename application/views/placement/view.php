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
          <div class="box-body">

            <?php echo validation_errors(); ?>


            <div class="form-group">
              <label for="company_name">Branch</label>
              <input type="text" class="form-control" id="location" name="location"
                value="<?php if ($order_data['order']['branch_id'] == 1)
                  echo "SHIVAJINAGAR";
                else
                  echo "WAGHOLI"; ?>"
                autocomplete="off" readonly>
            </div>

            <div class="form-group">
              <label for="company_name">Educational Branch</label>
              <input type="text" class="form-control" id="branch" name="branch"
                value="<?php echo $order_data['order']['branch'] ?>" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="company_name">Name</label>
              <input type="text" class="form-control" id="student_name" name="student_name"
                value="<?php echo $order_data['order']['student_name'] ?>" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="service_charge_value">Address</label>
              <input type="text" class="form-control" id="address" name="address"
                value="<?php echo $order_data['order']['address'] ?>" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="vat_charge_value">Mobile Number</label>
              <input type="text" class="form-control" id="mobile_number" name="mobile"
                value="<?php echo $order_data['order']['mobile'] ?>" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="address">Email</label>
              <input type="email" class="form-control" id="email" name="email"
                value="<?php echo $order_data['order']['email'] ?>" autocomplete="off" readonly>
            </div>
            <!-- // New added qulification 4-11-19 -->
            <div class="form-group">
              <label for="gross_amount">Education Qualification : </label> &nbsp; &nbsp;
              <input type="radio" id="prof_status" name="qualification"
                checked><?php echo $order_data['order']['qualification'] ?> &nbsp; &nbsp;

            </div>
            <div class="form-group">
              <label for="phone">College Name</label>
              <input type="text" class="form-control" id="college" name="college"
                value="<?php echo $order_data['order']['college_name'] ?>" autocomplete="off" readonly>
            </div>
            <!--New added Courses Packages-->
            <div class="form-group">
              <label for="phone">Courses</label>
              <input type="text" class="form-control" id="course" name="course" value="<?php echo $course['course'] ?>"
                autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="phone">Batch</label>
              <input type="text" class="form-control" id="package" name="package"
                value="<?php echo $package['package'] ?>" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="country">10%</label>
              <input type="text" class="form-control" id="10th" name="ten"
                value="<?php echo $order_data['order']['10th'] ?>" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="country">12%</label>
              <input type="text" class="form-control" id="twelwa" name="twl"
                value="<?php echo $order_data['order']['12th'] ?>" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="country">Graduate %</label>
              <input type="text" class="form-control" id="graduate" name="graduate"
                value="<?php echo $order_data['order']['graduate'] ?>" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label for="country">Gender</label> <br>

              <input type="radio" id="gender" name="gender" value="<?php echo $order_data['order']['gender'] ?>"
                checked><?php echo $order_data['order']['gender'] ?><br>

            </div>
            <div class="form-group">
              <label for="country">Applied Company Name</label>
              <input type="text" class="form-control" id="company" name="company" placeholder="Company Name"
                value="<?php echo $order_data['order']['company_applied'] ?>" autocomplete="off" readonly>
            </div>




          </div>
          <!-- /.box-body -->

          <div class="box-footer">

            <a href="<?php echo base_url('dashboard/') ?>" class="btn btn-warning">Back</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo base_url('placement/download_ssc/' . $order_data['order']['id']) ?>"
              class="btn btn-default"><i class="fa fa-download">Marksheet</i></a> &nbsp;&nbsp;
            <a href="<?php echo base_url('placement/download_lc/' . $order_data['order']['id']) ?>"
              class="btn btn-default"><i class="fa fa-download"></i>Leaving Certificate</a>&nbsp;&nbsp;
            <a href="<?php echo base_url('placement/download_cast/' . $order_data['order']['id']) ?>"
              class="btn btn-default"><i class="fa fa-download"></i>Cast Certificate</a>


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