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

        <div id="message">
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


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Placement Information</h3>
          </div>
          <form role="form" action="<?php base_url('placement/update') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="gross_amount">
                  <h4>Branch</h4>
                </label> &nbsp;
                <select name="branch_id" type="text" style="height:30px;" required>
                  <?php $branch_id = $_SESSION['branch_id'];
                  if ($branch_id == 2) { ?>
                    <option value="2" selected>KHARADI</option>
                    <?php //} elseif($branch_id == '1'){ ?>
                    <!--<option value="1" selected>SHIVAJINAGAR</option>-->
                  <?php } else { ?>
                    <option value="1" selected>SHIVAJINAGAR</option>
                    <option value="2">KHARADI</option>
                  <?php } ?>
                </select>
                <div>

                  <div class="form-group">
                    <label for="gross_amount">
                      <h4>Educational Branch</h4>
                    </label> &nbsp;
                    <select name="branch" type="text" style="height:30px;" required>
                      <option value="Civil" <?php if ($order_data['order']['branch'] == 'Civil') { ?> selected<?php } ?>>
                        Civil</option>
                      <option value="Mechanical" <?php if ($order_data['order']['branch'] == 'Mechanical') { ?>
                          selected<?php } ?>>Mechanical</option>
                      <option value="Electrical" <?php if ($order_data['order']['branch'] == 'Electrical') { ?>
                          selected<?php } ?>>Electrical</option>
                      <option value="SAP" <?php if ($order_data['order']['branch'] == 'SAP') { ?> selected<?php } ?>>SAP
                      </option>
                      <option value="DigitalMarketing" <?php if ($order_data['order']['branch'] == 'DigitalMarketing') { ?>
                          selected<?php } ?>>Digital Marketing</option>

                    </select>
                    <div>



                      <div class="form-group">
                        <label for="company_name">Name</label>
                        <input type="text" class="form-control" id="student_name" name="student_name"
                          value="<?php echo $order_data['order']['student_name'] ?>" autocomplete="off">
                      </div>

                      <div class="form-group">
                        <label for="service_charge_value">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                          value="<?php echo $order_data['order']['address'] ?>" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="vat_charge_value">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile_number" name="mobile"
                          value="<?php echo $order_data['order']['mobile'] ?>" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="address">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                          value="<?php echo $order_data['order']['email'] ?>" autocomplete="off">
                      </div>

                      <div class="form-group">
                        <label for="gross_amount">Education Qualification : </label> &nbsp; &nbsp;
                        <input type="radio" id="qualification" name="qualification" <?php echo ($order_data['order']['qualification'] == "Diploma in ") ? 'checked' : '' ?> value="Diploma in "
                          required>Diploma in &nbsp;
                        <input type="radio" id="qualification" name="qualification" <?php echo ($order_data['order']['qualification'] == 'B.E.') ? 'checked' : '' ?> value="B.E."
                          autocomplete="off" required>B.E. &nbsp;
                        <input type="radio" id="qualification" name="qualification" <?php echo ($order_data['order']['qualification'] == 'M.Tech') ? 'checked' : '' ?> value="M.Tech"
                          autocomplete="off" required>M.Tech &nbsp;
                        <input type="radio" id="qualification" name="qualification" <?php echo ($order_data['order']['qualification'] == 'Dip+BE') ? 'checked' : '' ?> value="Other"
                          autocomplete="off" required>Diploma+BE &nbsp;
                        <input type="radio" id="qualification" name="qualification" <?php echo ($order_data['order']['qualification'] == 'Other') ? 'checked' : '' ?> value="Other"
                          autocomplete="off" required>Other &nbsp;


                      </div>
                      <div class="form-group">
                        <label for="phone">College Name</label>
                        <input type="text" class="form-control" id="college" name="college"
                          value="<?php echo $order_data['order']['college_name'] ?>" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="country">10%</label>
                        <input type="text" class="form-control" id="10th" name="ten"
                          value="<?php echo $order_data['order']['10th'] ?>" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="country">12%</label>
                        <input type="text" class="form-control" id="twelwa" name="twl"
                          value="<?php echo $order_data['order']['12th'] ?>" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="country">Graduate %</label>
                        <input type="text" class="form-control" id="graduate" name="graduate"
                          value="<?php echo $order_data['order']['graduate'] ?>" autocomplete="off">
                      </div>
                      <!--<div class="form-group">-->
                      <!--  <label for="country">Gender</label>  <br>             -->

                      <!--    <input type="radio" id="gender" name="gender" value="<?php echo $order_data['order']['gender'] ?>" checked><?php echo $order_data['order']['gender'] ?><br>-->
                      <!--    <input type="radio" id="d1" name="gender" value="Male"> Male<br>-->
                      <!--    <input type="radio" id="d2" name="gender" value="Female"> Female<br>-->
                      <!--    <input type="radio" name="gender" value="Other"> Other-->

                      <!--</div>-->

                      <div class="form-group">
                        <label for="country">Gender</label> <br>

                        <input type="radio" id="d1" name="gender" <?php echo ($order_data['order']['gender'] == 'Male') ? 'checked' : '' ?> value="Male"> Male<br>
                        <input type="radio" id="d2" name="gender" <?php echo ($order_data['order']['gender'] == 'Female') ? 'checked' : '' ?> value="Female"> Female<br>
                        <input type="radio" name="gender" <?php echo ($order_data['order']['gender'] == 'Other') ? 'checked' : '' ?> value="Other"> Other

                      </div>

                      <div class="form-group">
                        <label for="country">Applied Company Name</label>
                        <input type="text" class="form-control" id="company" name="company" placeholder="Company Name"
                          value="<?php echo $order_data['order']['company_applied'] ?>" autocomplete="off">
                      </div>
                      <div class="form-group">

                        <label for="country">Resume</label>
                        <input type="file" class="form-control" id="file" name="file_name" autocomplete="off">
                      </div>
                      <!-- <a href="<?php //echo $order_data['order']['file'] ?>" download> S</a> -->
                      <div class="form-group">
                        <label for="country">Marksheet</label>
                        <input type="file" class="form-control" id="ssc" name="ssc" autocomplete="off">
                      </div>

                      <div class="form-group">
                        <label for="country">Leaving Certificate</label>
                        <input type="file" class="form-control" id="lc" name="lc" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="country">Cast Certificate</label>
                        <input type="file" class="form-control" id="cast" name="cast" autocomplete="off">
                      </div>
                    </div>
                  </div>


                  <!-- /.box-body -->

                  <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Save">
                    <a href="<?php echo base_url('dashboard/') ?>" class="btn btn-warning">Back</a>

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


<script type="text/javascript">
  setTimeout(function () {
    $("#message").fadeTo(100, 0).slideUp(300,
      function () {
        $(this).remove();
      });
  }, 3000);




</script>