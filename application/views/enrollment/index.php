<!-- Content Wrapper. Contains page content -->
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
            <h3 class="box-title">Manage Enrollment</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Project</th>
                  <th>Course</th>

                  <th>Edu Qualification</th>
                  <th>Student Name</th>
                  <th>Father Name</th>
                  <th>Mother Name</th>
                  <th>Gender</th>
                  <th>Parent Phone</th>
                  <th>Address </th>
                  <th>Email</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Annual Income</th>
                  <!-- <th>College Name</th>
                <th>Admission</th>
               <th>Anual Income</th>
                <th>Caste</th>
                
                <th>10th Certificate</th>
                <th>12th Certificate</th>
                <th>Graduate Certificate</th>
                <th>Caste Certificate</th>
                <th>Leaving Certificate</th>
                <th>Photograph</th>
                <th>Aadhar Card</th> -->
                  <?php if (in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                    <th>Action</th>
                  <?php endif; ?>
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

<?php if (in_array('deleteOrder', $user_permission)): ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Remove Enrollment</h4>
        </div>

        <form role="form" action="<?php echo base_url('enrollment/remove') ?>" method="post" id="removeForm">
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
<?php endif; ?>

<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Allocate Batch</h4>
      </div>

      <form role="form" action="<?php echo base_url('enrollment/allocate_batch') ?>" method="post" id="createForm">

        <div class="modal-body">

          <div class="form-group">
            <label for="active">Select Batch</label>
            <select class="form-control" type="text" name="batch_id" id="batch_id" required>
              <?php
              $sql = "SELECT id, batch_name FROM batch";
              $query = $this->db->query($sql);
              $batches = $query->result_array();

              foreach ($batches as $batch) {
                ?>
                <option value="<?php echo $batch['id']; ?>">
                  <?php echo $batch['batch_name'] ?>
                </option>
              <?php } ?>

            </select>
          </div>
          <div class="form-group">
            <!-- <label for="enid">ENID</label> -->
            <input type="hidden" name="enid" id="enid" value="<?php //echo $en_data['id'] ?>" class="form-control">
          </div>
          <!-- <div class="form-group">
            <label for="stud_id">Student ID</label>
            <input type="text" name="stud_id" id="stud_id" value="<?php //echo $en_data['id'] ?>" class="form-control">
          </div> -->
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Reset</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>

      </form>


    </div> <!-- /.modal-content -->
  </div> <!-- /.modal-dialog-->
</div>


<!-- <script src="//cdn.datatables.net/2.0.3/js/dataTables.min.js"></script> -->
<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function () {

    $("#mainOrdersNav").addClass('active');
    $("#manageOrdersNav").addClass('active');

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      ajax: {
        contentType: 'application/json',
        type: 'GET',
        url: base_url + 'enrollment/fetchOrdersData',
        dataSrc: 'data'
      },

      order: [],
      scrollY: true,
      autoWidth: false,
      scrollX: true,
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

  });

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
          data: { order_id: id },
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


  function createFunc(id) {
    if (id) {

      $("#enid").val(id);
      $("#createForm").on('submit', function () {
        //event.preventDefault();

        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        // Get data from the form
        var data = {
          enid: form.find("#enid").val(),
          // stud_id: form.find("#stud_id").val(),
          batch_id: form.find("#batch_id").val()
        };

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: data,
          dataType: 'json',
          success: function (response) {

            manageTable.ajax.reload(null, false);

            if (response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                '</div>');

              // hide the modal
              $("#addModal").modal('hide');

            }
            else {
              $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            // Handle server or network errors
            $("#messages").html('<div class="alert alert-danger alert-dismissible" role="alert">' +
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
              '<span aria-hidden="true">&times;</span></button>' +
              '<strong><span class="glyphicon glyphicon-remove-sign"></span></strong> ' +
              'An error occurred: ' + textStatus +
              '</div>');
          }
        });

        return false;
      });
    }

  }




</script>