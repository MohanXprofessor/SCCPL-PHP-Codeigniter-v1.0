/*
* Created By: Akash K. Fulari
* On Date: 08-03-2024
*/


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Placements</small>
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
            <h3 class="box-title">Manage Jobs</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <table id="manageTable" class="table table-bordered table-striped responsive display nowrap table-hover">
              <thead>
                <tr>
                  <!--<th>Sr.No</th>-->
                  <!--<th>Job Id</th>-->
                  <th>Job Title</th>
                  <!--<th>Address </th>-->
                  <th>Company Name</th>
                  <th>Project</th>
                  <!--<th>Job Description</th>-->
                  <th>Job Possition</th>
                  <th>Qualification</th>
                  <th>Deadline</th>
                  <th>No.of Vacencies</th>
                  <th>No.of Shortlisted</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>

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
<!-- /.content-wrapper -->

<? php// if(in_array('createPlacement', $user_permission)):  ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Order</h4>
      </div>

      <form role="form" action="<?php echo base_url('jobs/remove') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<? php// endif;  ?>

<div class="modal fade" tabindex="-1" role="dialog" id="sendMailModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Send mail to <span id="companyNameModelLbl"></span></h4>
      </div>
      <div class="modal-body">
        <form role="form" action="<?php echo base_url('jobs/sendMailTo') ?>" method="post" id="sendMailForm"
          enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">Full Name</label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span>
                  </span>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                    required="required" />
                </div>
              </div>
              <div class="form-group">
                <label for="compEmail">
                  Email Address</label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                  </span>
                  <input type="email" class="form-control" id="compEmail" name="email" placeholder="Enter email"
                    required="required" readonly />
                </div>
              </div>
              <div class="form-group">
                <label for="subject">Subject</label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-font"></span>
                  </span>
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter Subject"
                    required="required" />
                </div>
              </div>
              <div class="form-group">
                <label for="attachement">Attachment</label>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-upload"></span>
                  </span>
                  <input type="file" class="form-control" name="attachement" id="attachement" required="required" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">
                  Message</label>
                <textarea name="message" id="message" class="form-control" rows="12" cols="25" required="required"
                  placeholder="Message"></textarea>
              </div>
            </div>
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
                Send Message</button>
            </div>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function () {

    $("#mainOrdersNav").addClass('active');
    $("#manageOrdersNav").addClass('active');

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'jobs/fetchJobsData',
      scrollY: true,
autoWidth: false,
      "scrollX": true,
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

  });

  function mailSend(name, email) {
    $("#companyNameModelLbl").html(name);
    $("#compEmail").val(email);
  }
  // remove functions 
  function removeFunc(id) {
    if (id) {
      $("#removeForm").on('submit', function () {

        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: { id: id },
          dataType: 'json',
          success: function (response) {

            manageTable.ajax.reload(null, false);

            if (response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                '</div>');

              // hide the modal
              $("#removeModal").modal('hide');

            } else {

              $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }
          }
        });

        return false;
      });
    }
  }

</script>

<script type="text/javascript">
  setTimeout(function () {
    $("#successMessage").fadeTo(100, 0).slideUp(300,
      function () {
        $(this).remove();
      });
  }, 3000); 
</script>