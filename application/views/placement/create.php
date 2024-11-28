<?php

$sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
$query = $this->db->query($sql, array(1));
$branch = $query->result_array();

?>


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
          <form role="form" action="<?php base_url('placement/create') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>
              <!-- Added new franchise 3/4/19 -->
              <div class="form-group">
                <label for="gross_amount">
                  <h4>Project</h4>
                </label> &nbsp;
                <select name="branch_id" type="text" style="height:30px;">
                  <?php $branch_id = $_SESSION['branch_id'];
                  if ($branch_id != 2) {
                    foreach ($branch as $v) { ?>
                      <option value="<?php echo $v['id'] ?>"><?php echo $v['name']; ?></option>
                    <?php }
                  } else { ?>
                    <option value="2" selected>KHARADI</option>
                  <?php } ?>
                </select>
                <div>
                  <!--<div class="form-group">-->
                  <!--  <label for="gross_amount">-->
                  <!--    <h4>Educational Branch</h4>-->
                  <!--  </label> &nbsp;-->
                  <!--  <select name="branch" type="text" style="height:30px;">-->

                  <!--    <option value="Civil">Civil</option>-->
                  <!--    <option value="Mechanical">Mechanical</option>-->
                  <!--    <option value="Electrical">Electrical</option>-->
                  <!--    <option value="SAP">SAP</option>-->
                  <!--    <option value="DigitalMarketing">Digital Marketing</option>-->
                  <!--  </select>-->
                  <!--  <div>-->
                      <div class="form-group">
                        <label for="company_name">Name</label>
                        <input type="text" class="form-control" id="student_name" name="student_name"
                          placeholder="Enter Student name" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="service_charge_value">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                          placeholder="Enter Student asddress " autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="vat_charge_value">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile_number" name="mobile"
                          placeholder="Enter Mobile Number %" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="address">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                          autocomplete="off">
                      </div>

                      <div class="form-group">
                        <label for="gross_amount">Education Qualification : </label> &nbsp; &nbsp;

                        <input type="radio" id="prof_status" name="qualification" value="Diploma in "
                          autocomplete="off">Diploma in &nbsp;
                        <input type="radio" id="prof_status" name="qualification" value="B.E." autocomplete="off">B.E.
                        &nbsp;
                        <input type="radio" id="prof_status" name="qualification" value="M.Tech"
                          autocomplete="off">M.Tech &nbsp;
                        <input type="radio" id="qualification" name="qualification" value="Dip+BE"
                          autocomplete="off">Diploma+BE &nbsp;
                        <input type="radio" id="prof_status" name="qualification" value="Other" autocomplete="off"
                          checked>Other &nbsp;

                      </div>
                      <div class="form-group">
                        <label for="phone">College Name</label>
                        <input type="text" class="form-control" id="college" name="college"
                          placeholder="Enter College Name" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="country">10%</label>
                        <input type="text" class="form-control" id="10th" name="ten" placeholder="Enter 10 percent"
                          autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="country">12%</label>
                        <input type="text" class="form-control" id="twelwa" name="twl" placeholder="Enter 12 percent"
                          autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="country">Graduate %</label>
                        <input type="text" class="form-control" id="graduate" name="graduate"
                          placeholder="Enter percent" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="country">Gender</label> <br>

                        <input type="radio" name="gender" value="Male" checked> Male<br>
                        <input type="radio" name="gender" value="Female"> Female<br>
                        <input type="radio" name="gender" value="Other"> Other

                      </div>
                      <div class="form-group">
                        <label for="country">Applied Company Name</label>
                        <input type="text" class="form-control" id="company" name="company" placeholder="Company Name"
                          autocomplete="off">
                      </div>

                      <div class="form-group">
                        <label for="country">Resume</label>
                        <input type="file" class="form-control" id="file" name="file_name" autocomplete="off">
                      </div>
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