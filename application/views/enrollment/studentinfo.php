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
      View Form
      <small>View Enrollment</small>
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
                <label for="company_name">Project</label>
                <select name="project_id" type="text" class="form-control" disabled required>
                  <?php
                  $sql = "SELECT * FROM stores WHERE active  = ? order by id desc";
                  $query = $this->db->query($sql, array(1));
                  $branch = $query->result_array();
                  foreach ($branch as $v) {
                    ?>
                    <option value="<?php echo $v['id']; ?>" <?php echo (($r['project_id'] == $v['id'])?"selected":""); ?>>
                      <?php echo $v['name']; ?>
                    </option>
                  <?php } ?>
                </select>

                <input type="hidden" class="form-control" id="student_name" name="id" value="<?php echo $r['id'] ?>"
                  autocomplete="off" hidden>
              </div>
              <div class="form-group">
                <label for="company_name">Full Name</label>
                <input type="text" class="form-control" id="student_name" name="name" value="<?php echo $r['name'] ?>"
                  autocomplete="off" disabled>
              </div>
              <div class="form-group">
                <label for="company_name">Father Name</label>
                <input type="text" class="form-control" id="student_name" name="father_name"
                  value="<?php echo $r['father_name'] ?>" autocomplete="off" disabled>
              </div>
              <div class="form-group">
                <label for="paid_status">Gender: </label>
                <select class="form-control" id="gender" name="gender" disabled>
                  <option value="0" <?php echo (($r['gender'] == 0) ? "selected" : ""); ?>>Female</option>
                  <option value="1" <?php echo (($r['gender'] == 1) ? "selected" : ""); ?>>Male</option>
                  <option value="2" <?php echo (($r['gender'] == 2) ? "selected" : ""); ?>>Other</option>
                </select>
              </div>
              <div class="form-group">
                <label for="service_charge_value">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $r['address'] ?>"
                  autocomplete="off" disabled>
              </div>
              <div class="form-group">
                <label for="vat_charge_value">Contact Number</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile"
                  value="<?php echo $r['contact']; ?>" disabled>
              </div>
              <div class="form-group">
                <label for="address">Email ID</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $r['email'] ?>"
                  autocomplete="off" disabled>
              </div>
              <div class="form-group">
                <label for="phone">College Name</label>
                <input type="text" class="form-control" id="college" name="college" value="<?php echo $r['college'] ?>"
                  autocomplete="off" disabled>
              </div>
              <div class="form-group">
                <label for="country">10th marks</label>
                <input type="text" id="10th" name="ten" class="form-control" autocomplete="off"
                  value="<?php echo $r['10th']; ?>" disabled> &nbsp;
              </div>
              <div class="form-group">
                <label for="country">12th marks</label>
                <input type="text" id="twelwa" name="twl" class="form-control" autocomplete="off"
                  value="<?php echo $r['12th'] ?>" disabled>&nbsp;
              </div>


              <div class="form-group">
                <label for="country">State</label>
                <input type="text" id="graduate" name="graduate" class="form-control" autocomplete="off"
                  value="<?php echo $r['state']; ?>" disabled> &nbsp;
              </div>



              <div class="form-group">
                <label for="country">Adhar Number</label> <br>

                <input type="text" class="form-control" id="date" name="adhar" value="<?php echo $r['adhar']; ?>"
                  disabled>

              </div>

              <div class="form-group">
                <label for="country">Graduate Marks</label> <br>

                <input type="text" class="form-control" id="graduate" name="graduate"
                  value="<?php echo $r['graduation'] ?>" autocomplete="off" disabled>


              </div>
              <div class="form-group">
                <label for="country">Graduate Passing</label> <br>

                <input type="text" class="form-control" id="graduate" name="graduate_passing"
                  value="<?php echo $r['graduation_passing'] ?>" autocomplete="off" disabled>


              </div>

              <div class="form-group">
                <label for="country">Admission Date</label> <br>

                <input type="text" class="form-control" id="graduate" name="admission"
                  value="<?php echo $r['admission'] ?>" autocomplete="off" disabled>


              </div>
              <div class="form-group">
                <label for="country">Anual Income</label> <br>

                <input type="text" class="form-control" id="graduate" name="annual_income"
                  value="<?php echo $r['annual_income'] ?>" autocomplete="off" disabled>


              </div>
              <div class="form-group">
                <div class="">

                  <?php

                  //   $rpFind = "/home/interfa1/";
                  //   $rpString = "https://";
                
                  //   For sspl.interafce11.in webstie
                    $rpFind = "/home/interface11/sspl_interface11_in/";
                    $rpString = "";
                
                //   $rpFind = "C:/xampp/htdocs/sspl2/";
                //   $rpString = "";
                  if (!empty($r['10th_marksheet']))
                    echo '<a href="' . site_url(str_replace($rpFind, $rpString, $r['10th_marksheet'])) . '"
                    class="btn btn-default" download><i class="fa fa-download"></i> 10th Marksheet</a> &nbsp;&nbsp;';
                  if (!empty($r['12th_marksheet']))
                    echo '<a href="' . site_url(str_replace($rpFind, $rpString, $r['12th_marksheet'])) . '"
                    class="btn btn-default" download><i class="fa fa-download"></i> 12th Marksheet</a> &nbsp;&nbsp;';
                  if (!empty($r['income_certificate']))
                    echo '<a href="' . site_url(str_replace($rpFind, $rpString, $r['income_certificate'])) . '"
                    class="btn btn-default" download><i class="fa fa-download"></i> Income Certificate</a> &nbsp;&nbsp;';
                  if (!empty($r['graduate_certificate']))
                    echo '<a href="' . site_url(str_replace($rpFind, $rpString, $r['graduate_certificate'])) . '"
                    class="btn btn-default" download><i class="fa fa-download"></i> Graduation Certificate</a> &nbsp;&nbsp;';
                  if (!empty($r['adhar_card']))
                    echo '<a href="' . site_url(str_replace($rpFind, $rpString, $r['adhar_card'])) . '"
                    class="btn btn-default" download><i class="fa fa-download"></i> Adhar Card</a> &nbsp;&nbsp;';
                  if (!empty($r['photograph']))
                    echo '<a href="' . site_url(str_replace($rpFind, $rpString, $r['photograph'])) . '"
                    class="btn btn-default" download><i class="fa fa-download"></i> Photograph</a></br>';
                  ?>
                </div>

              </div>



            </div>


            <!-- /.box-body -->

            <div class="box-footer">
              <!-- <button type="submit" class="btn btn-primary">Save Changes</button> -->
              <a href="<?php echo base_url('enrollment/') ?>" class="btn btn-warning">Back</a>

            </div>

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