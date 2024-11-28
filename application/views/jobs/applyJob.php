/*
* Created By: Akash K. Fulari
* On Date: 09-03-2024
*/


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
            <h3 class="box-title">Apply Job</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

            <form role="form" action="<?php echo base_url('jobs/applyJob') . "/" . $job['id'] ?>" method="post"
              id="removeForm" enctype="multipart/form-data">
              <div>
                <?php echo validation_errors(); ?>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="jobId">JobID</label>
                      <input type="text" class="form-control" id="jobId" value="<?php echo $job['job_id']; ?>" disabled
                        readonly>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="jobTitle">Job Title</label>
                      <input type="text" class="form-control" id="jobTitle" value="<?php echo $job['job_title']; ?>"
                        disabled readonly>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="jobRole">Job Role</label>
                      <input type="text" class="form-control" id="jobRole" value="<?php echo $job['job_possition']; ?>"
                        disabled readonly>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="jobDescription">Job Description</label>
                  <input type="text" class="form-control" id="jobDescription"
                    value="<?php echo $job['job_description']; ?>" disabled readonly>
                </div>
                <div class="form-group">
                  <label for="companyName">Comapny Name</label>
                  <input type="text" class="form-control" id="companyName" value="<?php echo $job['company_name']; ?>"
                    disabled readonly>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="jobQulification">Qualifications</label>
                      <input type="text" class="form-control" id="jobQulification"
                        value="<?php echo $job['qualification']; ?>" name="qualification"
                        placeholder="Enter Job Description name" readonly disabled>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="submissionDate">Last Submission Date</label>
                      <input type="datetime-local" class="form-control" id="submissionDate"
                        value="<?php echo $job['submission_date']; ?>" name="submission_date"
                        placeholder="Enter Job Description name" readonly disabled>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="vacencies">No. Of Vacencies</label>
                      <input type="number" class="form-control" id="vacencies"
                        value="<?php echo $job['no_of_vaccancy']; ?>" name="vacencies"
                        placeholder="Enter Job Description name" readonly disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="resume">Resume</label>
                      <input type="file" class="form-control" id="resume" name="resume"
                        placeholder="Select your Resume">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="marksheet">Marksheet</label>
                      <input type="file" class="form-control" id="marksheet" name="marksheet"
                        placeholder="Select your Marksheet">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="adhar_card">Adhar Card</label>
                      <input type="file" class="form-control" id="adhar_card" name="adhar_card"
                        placeholder="Select your Adhar Card">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="leaving_certificate">Leaving Certificate</label>
                      <input type="file" class="form-control" id="leaving_certificate" name="leaving_certificate"
                        placeholder="Select your Leaving Certificate">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Apply Now</button>
              </div>
            </form>

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