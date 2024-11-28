<?php
/*
*
* Author: Akash K Fulari
* Contact-mail: akashfulari31@gmail.com
* Description: ________________your_description_here_________________
* Created: 2024-03-30 15:03:39
 Last Modification Date: 2024-04-22 14:31:50
*
**/
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage
            <small>Staff Attendance</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Staff Attendance</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="successMessage">
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
                </div>

                <?php if (in_array('createUser', $user_permission)): ?>
                    <div style="display:flex;align-items:center;justify-content:flex-start;gap:7px;margin-bottom:20px">
                        <a href="<?php echo base_url('users/create') ?>" class="btn btn-primary">Add Staff</a>
                    </div>
                <?php endif; ?>
                <div>

                    <div class="box">
                        <div class="box-header">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                                <h3 class="box-title">Staff List</h3>
                                <a data-toggle="modal" data-target="#addBulkAttendanceModal" class="btn btn-info"><i
                                        class="fa fa-calendar-plus-o" style="padding-right:5px"></i> Bulk Attendance</a>
                            </div>
                            <!-- /.box-header -->
                        </div>
                        <div class="box-body table-responsive">
                            <style>
                            </style>
                            <table id="manageTable"
                                class="table table-bordered table-striped responsive display nowrap table-hover">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
?>
<style>
    .myBox {
        display: flex;
        align-items: center;
        justify-content: between;
        gap: 10px;
    }

    .myBox>div {
        width: 100%;
    }
</style>

<div class="modal fade" tabindex="-1" role="dialog" id="toggleActiveModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span class="holder"></span> Staff</h4>
            </div>

            <form role="form" action="<?php echo base_url('attendance/activate') ?>" method="post" id="removeForm">
                <div class="modal-body">
                    <p>Do you really want to <span class="holder"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="addBulkAttendanceModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Bulk Attendance</h4>
            </div>
            <div class="modal-body">
                <form onsubmit="addBulkAttendance(this);return false;" method="post" id="addBulkAttendanceForm">
                    <div class="myBox">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" id="date"
                                name="date" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="myBox">
                        <div class="form-group">
                            <label for="blk_in_time">In Time</label>
                            <input type="time" class="form-control" id="blk_in_time" name="in_time" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="blk_out_time">Out Time</label>
                            <input type="time" class="form-control" id="blk_out_time" name="out_time"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="blk_duration">Duration</label>
                            <input type="text" class="form-control" id="blk_duration" name="duration"
                                placeholder="Enter Duration" autocomplete="off"
                                onfocus="calculateDuration('#blk_in_time','#blk_out_time','#blk_duration')" readonly>
                        </div>
                    </div>
                    <div class="myBox">
                        <div class="form-group">
                            <label for="late_by">Late By</label>
                            <input type="time" class="form-control" id="late_by" name="late_by" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="early_by">Early By</label>
                            <input type="time" class="form-control" id="early_by" name="early_by" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ot">Over Time</label>
                        <input type="time" class="form-control" id="ot" name="ot" autocomplete="off">
                    </div>
                    <div class="myBox">
                        <div class="form-group">
                            <label for="shift">Shift</label>
                            <select class="form-control" id="shift" name="shift">
                                <option value="0">General Shift</option>
                                <option value="1">Night Shift</option>
                                <option value="2">Day Shift</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="user_ids">Select Staff</label>
                            <style>
                                .full>* {
                                    display: block;
                                }

                                .full>*,
                                .full>*>* {
                                    position: relative;
                                    width: 100% !important;
                                }
                            </style>
                            <div class="full">
                                <select class="form-control select_group" id="user_ids" name="user_ids[]" multiple>
                                    <?php
                                    foreach ($staffs as $v) { ?>
                                        <option value="<?php echo $v['user_id']; ?>">
                                            <?php echo $v['firstname'] . ' ' . $v['lastname']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="addBulkAttendanceForm" class="btn btn-primary">Submit Attendance</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addAttendanceModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Attendance</h4>
            </div>
            <div class="modal-body">
                <form onsubmit="addAttendance(this);return false;" method="post" id="addAttendanceForm">
                    <div class="form-group" hidden>
                        <label for="user_id">User ID</label>
                        <input type="number" class="form-control" id="user_id" name="user_id" autocomplete="off"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" id="date"
                            name="date" autocomplete="off" readonly>
                    </div>
                    <div class="myBox">
                        <div class="form-group">
                            <label for="in_time">In Time</label>
                            <input type="time" class="form-control" id="in_time" name="in_time" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="out_time">Out Time</label>
                            <input type="time" class="form-control" id="out_time" name="out_time" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input type="text" class="form-control" id="duration" name="duration"
                                onfocus="calculateDuration('#in_time','#out_time','#duration')"
                                placeholder="Enter Duration" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="myBox">
                        <div class="form-group">
                            <label for="late_by">Late By</label>
                            <input type="time" class="form-control" id="late_by" name="late_by" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="early_by">Early By</label>
                            <input type="time" class="form-control" id="early_by" name="early_by" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ot">Over Time</label>
                        <input type="time" class="form-control" id="ot" name="ot" autocomplete="off">
                    </div>
                    <div class="myBox">
                        <div class="form-group">
                            <label for="shift">Shift</label>
                            <select class="form-control" id="shift" name="shift">
                                <option value="0">General Shift</option>
                                <option value="1">Night Shift</option>
                                <option value="2">Day Shift</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="0">Absent</option>
                                <option value="1">Present</option>
                                <option value="2">On Leave</option>
                                <option value="3">Holiday</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="addAttendanceForm" class="btn btn-primary">Submit Attendance</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function () {
        $('select[multiple]').multiselect({
            includeSelectAllOption: true,
        });
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'attendance/getStaffData',
            scrollY: true,
autoWidth: false,
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel'
            ]
        });

    });

    function openAddAttendanceModal(id) {
        $("#user_id").val(id);
    }

    function addAttendance(form) {
        $.ajax({
            url: "<?php echo base_url('attendance/addStaffAttendance') ?>",
            type: "post",
            data: $(form).serialize(),
            dataType: "json",
            success: function (res) {
                if (res.status === true) {
                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + res.message +
                        '</div>');
                    // hide the modal
                    $("#addAttendanceModal").modal('hide');
                } else {

                    $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + res.message +
                        '</div>');
                }
            }
        });
    }

    function addBulkAttendance(form) {
        $.ajax({
            url: "<?php echo base_url('attendance/addStaffBulkAttendance') ?>",
            type: "post",
            data: $(form).serialize(),
            dataType: "json",
            success: function (res) {
                if (res.status === true) {
                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + res.message +
                        '</div>');
                    // hide the modal
                    $("#addAttendanceModal").modal('hide');
                } else {

                    $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + res.message +
                        '</div>');
                }
            }
        });
    }

    function toggleActiveFunc(id, status) {
        $(".holder").html(((status == 0) ? "Deactivate" : "Activate"));
        if (id) {
            $("#removeForm").on('submit', function () {

                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: { id: id, status: status },
                    dataType: 'json',
                    success: function (response) {

                        manageTable.ajax.reload(null, false);

                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                '</div>');
                            // hide the modal
                            $("#toggleActiveModal").modal('hide');
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

    function calculateDuration(ele1, ele2, resEle) {
        var startTime = $(ele1).val();
        var endTime = $(ele2).val();
        if (startTime.length > 0 && endTime.length > 0) {
            // Split the time strings into hours and minutes
            var startParts = startTime.split(':');
            var endParts = endTime.split(':');

            // Convert the hours and minutes into seconds
            var startSeconds = (+startParts[0]) * 60 * 60 + (+startParts[1]) * 60;
            var endSeconds = (+endParts[0]) * 60 * 60 + (+endParts[1]) * 60;

            // Calculate the duration in seconds
            var durationSeconds = endSeconds - startSeconds;

            // Convert the duration to hours, minutes, and seconds
            var hours = Math.floor(durationSeconds / 3600);
            var minutes = Math.floor((durationSeconds % 3600) / 60);
            var seconds = durationSeconds % 60;

            var paddedHours = String(Math.abs(hours)).padStart(2, '0');
            var paddedMinutes = String(Math.abs(minutes)).padStart(2, '0');
            var paddedSeconds = String(Math.abs(seconds)).padStart(2, '0');

            $(resEle).val(paddedHours + ':' + paddedMinutes + ':' + paddedSeconds);
        }
    }

</script>